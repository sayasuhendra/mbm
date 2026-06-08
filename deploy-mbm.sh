#!/bin/bash

# Configuration
APP_NAME="mbm"
DOMAIN="mbm.dbaik.com"
REPO_URL="https://github.com/sayasuhendra/mbm"
WEB_ROOT="/var/www/$APP_NAME"
PHP_VERSION="8.3"

echo "================================================"
echo "🚀 Deploying $APP_NAME to $DOMAIN"
echo "================================================"

# 1. Update/Clone Repository
if [ -d "$WEB_ROOT" ]; then
    echo "Updating existing repository..."
    cd $WEB_ROOT
    git pull origin main
else
    echo "Cloning repository..."
    sudo mkdir -p /var/www
    sudo chown $USER:$USER /var/www
    cd /var/www
    git clone $REPO_URL $APP_NAME
    cd $APP_NAME
fi

# 2. Setup .env
if [ ! -f ".env" ]; then
    echo "Creating .env file..."
    cp .env.example .env
    
    # Configure SQLite
    sed -i "s/DB_CONNECTION=.*/DB_CONNECTION=sqlite/" .env
    # Remove other DB settings to avoid confusion
    sed -i "/DB_HOST=/d" .env
    sed -i "/DB_PORT=/d" .env
    sed -i "/DB_DATABASE=/d" .env
    sed -i "/DB_USERNAME=/d" .env
    sed -i "/DB_PASSWORD=/d" .env
    
    # Ensure database directory and file exist
    mkdir -p database
    touch database/database.sqlite
    
    echo "DB_CONNECTION=sqlite" >> .env
    echo "APP_URL=http://$DOMAIN" >> .env
fi

# 3. Initial Permissions (Needed before artisan commands can write to logs/cache/db)
echo "Setting initial permissions..."
sudo chown -R $USER:www-data $WEB_ROOT
sudo chmod -R 775 $WEB_ROOT/storage $WEB_ROOT/bootstrap/cache $WEB_ROOT/database
if [ -f "$WEB_ROOT/database/database.sqlite" ]; then
    sudo chmod 664 $WEB_ROOT/database/database.sqlite
fi

# 4. Install Dependencies
echo "Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev

echo "Installing NPM dependencies and building assets..."
npm install
npm run build

# 5. Generate App Key if not set
if ! grep -q "APP_KEY=base64" .env; then
    php artisan key:generate --force
fi

# 6. Run Migrations
echo "Running database migrations..."
php artisan migrate --force

# 7. Optimize Laravel
echo "Optimizing Laravel caches..."
php artisan optimize:clear
php artisan optimize
php artisan view:cache
php artisan event:cache
php artisan filament:cache-components

# 8. Finalize Permissions (Ensures any newly created cache/log files are writable by the web server)
echo "Finalizing permissions..."
sudo find $WEB_ROOT -type f -exec chmod 644 {} \;
sudo find $WEB_ROOT -type d -exec chmod 755 {} \;
sudo chown -R $USER:www-data $WEB_ROOT/storage $WEB_ROOT/bootstrap/cache $WEB_ROOT/database
sudo find $WEB_ROOT/storage $WEB_ROOT/bootstrap/cache $WEB_ROOT/database -type f -exec chmod 664 {} \;
sudo find $WEB_ROOT/storage $WEB_ROOT/bootstrap/cache $WEB_ROOT/database -type d -exec chmod 775 {} \;

# 8. Setup Nginx
NGINX_CONF="/etc/nginx/sites-available/$DOMAIN"
echo "Configuring Nginx..."

sudo bash -c "cat > $NGINX_CONF << 'EOF'
server {
    listen 80;
    listen [::]:80;
    server_name $DOMAIN;
    root $WEB_ROOT/public;
 
    add_header X-Frame-Options \"SAMEORIGIN\";
    add_header X-Content-Type-Options \"nosniff\";
    add_header X-XSS-Protection \"1; mode=block\";
 
    index index.php;
 
    charset utf-8;
 
    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }
 
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
 
    error_page 404 /index.php;
 
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php$PHP_VERSION-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;
    }
 
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
EOF"

sudo ln -sf /etc/nginx/sites-available/$DOMAIN /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx

echo "================================================"
echo "✅ Deployment completed successfully!"
echo "You can access your application at http://$DOMAIN"
echo "Note: You might want to run 'sudo certbot --nginx -d $DOMAIN' to enable HTTPS."
echo "================================================"
