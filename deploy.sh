#!/usr/bin/env bash

set -Eeuo pipefail

REPO_URL="${REPO_URL:-git@github.com:sayasuhendra/mbm.git}"
BRANCH="${BRANCH:-main}"
APP_DIR="${APP_DIR:-/var/www/mbmyouth}"
DOMAIN="${DOMAIN:-mbm.dbaik.com}"
PHP_VERSION="${PHP_VERSION:-8.4}"
PHP_FPM_SERVICE="php${PHP_VERSION}-fpm"
PHP_FPM_SOCKET="/run/php/php${PHP_VERSION}-fpm.sock"
DEPLOY_USER="${DEPLOY_USER:-${SUDO_USER:-$USER}}"
WEB_USER="${WEB_USER:-www-data}"

log() {
    printf '\n==> %s\n' "$1"
}

fail() {
    echo "Error: $1" >&2
    exit 1
}

require_command() {
    command -v "$1" >/dev/null 2>&1 || fail "Command '$1' belum tersedia di server."
}

if [[ "$(id -u)" -ne 0 ]]; then
    fail "Jalankan dengan sudo: sudo ./deploy.sh"
fi

for command in git php composer npm caddy systemctl runuser; do
    require_command "$command"
done

if ! php -r 'exit(extension_loaded("pdo_sqlite") ? 0 : 1);'; then
    if command -v apt-get >/dev/null 2>&1; then
        log "Menginstal ekstensi PHP SQLite"
        apt-get update
        DEBIAN_FRONTEND=noninteractive apt-get install -y "php${PHP_VERSION}-sqlite3"
        systemctl restart "$PHP_FPM_SERVICE"
    else
        fail "Ekstensi PHP pdo_sqlite belum tersedia. Instal ekstensi sqlite3 untuk PHP $PHP_VERSION lalu jalankan ulang deploy.sh."
    fi
fi

php -r 'exit(extension_loaded("pdo_sqlite") ? 0 : 1);' || fail "Ekstensi PHP pdo_sqlite tetap tidak tersedia setelah instalasi."

systemctl is-active --quiet "$PHP_FPM_SERVICE" || fail "Service $PHP_FPM_SERVICE tidak aktif."
[[ -S "$PHP_FPM_SOCKET" ]] || fail "Socket PHP-FPM tidak ditemukan: $PHP_FPM_SOCKET"

if [[ -z "${MBM_ADMIN_PASSWORD:-}" ]]; then
    read -r -s -p "Password awal admin: " MBM_ADMIN_PASSWORD
    echo
fi

[[ ${#MBM_ADMIN_PASSWORD} -ge 12 ]] || fail "Password admin minimal 12 karakter."
export MBM_ADMIN_PASSWORD
export MBM_ADMIN_EMAIL="${MBM_ADMIN_EMAIL:-admin@$DOMAIN}"

log "Menyiapkan source code di $APP_DIR"
if [[ -d "$APP_DIR/.git" ]]; then
    [[ -z "$(runuser -u "$DEPLOY_USER" -- git -C "$APP_DIR" status --porcelain)" ]] || fail "Repository di $APP_DIR memiliki perubahan lokal."
    runuser -u "$DEPLOY_USER" -- git -C "$APP_DIR" remote set-url origin "$REPO_URL"
    runuser -u "$DEPLOY_USER" -- git -C "$APP_DIR" fetch origin "$BRANCH"
    runuser -u "$DEPLOY_USER" -- git -C "$APP_DIR" checkout "$BRANCH"
    runuser -u "$DEPLOY_USER" -- git -C "$APP_DIR" pull --ff-only origin "$BRANCH"
else
    [[ ! -e "$APP_DIR" || -z "$(ls -A "$APP_DIR" 2>/dev/null)" ]] || fail "$APP_DIR sudah ada dan tidak kosong."
    mkdir -p "$APP_DIR"
    chown "$DEPLOY_USER:$WEB_USER" "$APP_DIR"
    runuser -u "$DEPLOY_USER" -- git clone --branch "$BRANCH" --single-branch "$REPO_URL" "$APP_DIR"
fi

cd "$APP_DIR"

if [[ ! -f .env ]]; then
    cp .env.example .env
fi

set_env() {
    local key="$1"
    local value="$2"
    local escaped="${value//\\/\\\\}"
    escaped="${escaped//\"/\\\"}"
    escaped="${escaped//&/\\&}"
    escaped="${escaped//|/\\|}"

    if grep -qE "^${key}=" .env; then
        sed -i "s|^${key}=.*|${key}=\"${escaped}\"|" .env
    else
        printf '%s="%s"\n' "$key" "$escaped" >> .env
    fi
}

log "Mengatur environment production"
set_env APP_ENV production
set_env APP_DEBUG false
set_env APP_URL "https://$DOMAIN"
set_env QUEUE_CONNECTION database
set_env DB_CONNECTION sqlite
set_env DB_DATABASE "$APP_DIR/database/database.sqlite"

mkdir -p database
touch database/database.sqlite

log "Menginstal dependency production"
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
npm ci
npm run build

if grep -q '^APP_KEY=$' .env || ! grep -q '^APP_KEY=' .env; then
    php artisan key:generate --force
fi

log "Menyiapkan database dan data awal"
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link || true

php artisan tinker --execute='$user = App\Models\User::updateOrCreate(["email" => env("MBM_ADMIN_EMAIL")], ["name" => "Administrator", "password" => Illuminate\Support\Facades\Hash::make(env("MBM_ADMIN_PASSWORD"))]); $user->syncPermissions(Spatie\Permission\Models\Permission::all());'

log "Mengatur permission Laravel"
chown -R "$DEPLOY_USER:$WEB_USER" "$APP_DIR"
find storage bootstrap/cache -type d -exec chmod 2775 {} \;
find storage bootstrap/cache -type f -exec chmod 664 {} \;
chmod 2775 database
chmod 664 database/database.sqlite

log "Membuat queue worker systemd"
cat > /etc/systemd/system/mbmyouth-queue.service <<EOF
[Unit]
Description=Baitul Muttaqin Youth Laravel Queue Worker
After=network.target $PHP_FPM_SERVICE.service

[Service]
User=$WEB_USER
Group=$WEB_USER
WorkingDirectory=$APP_DIR
ExecStart=/usr/bin/php $APP_DIR/artisan queue:work --sleep=3 --tries=3 --timeout=120
Restart=always
RestartSec=5

[Install]
WantedBy=multi-user.target
EOF

log "Membuat scheduler systemd"
cat > /etc/systemd/system/mbmyouth-scheduler.service <<EOF
[Unit]
Description=Baitul Muttaqin Youth Laravel Scheduler

[Service]
Type=oneshot
User=$WEB_USER
Group=$WEB_USER
WorkingDirectory=$APP_DIR
ExecStart=/usr/bin/php $APP_DIR/artisan schedule:run
EOF

cat > /etc/systemd/system/mbmyouth-scheduler.timer <<EOF
[Unit]
Description=Run Baitul Muttaqin Youth Scheduler Every Minute

[Timer]
OnCalendar=*-*-* *:*:00
Persistent=true

[Install]
WantedBy=timers.target
EOF

systemctl daemon-reload
systemctl enable --now mbmyouth-queue.service
systemctl enable --now mbmyouth-scheduler.timer

log "Memasang konfigurasi Caddy"
mkdir -p /etc/caddy/sites
sed \
    -e "s|mbm.dbaik.com|$DOMAIN|g" \
    -e "s|/var/www/mbmyouth/public|$APP_DIR/public|g" \
    -e "s|php8.4-fpm.sock|php${PHP_VERSION}-fpm.sock|g" \
    deploy/Caddyfile > /etc/caddy/sites/mbmyouth.caddy

touch /etc/caddy/Caddyfile
if ! grep -qE '^import /etc/caddy/sites/\*\.caddy$' /etc/caddy/Caddyfile; then
    printf '\nimport /etc/caddy/sites/*.caddy\n' >> /etc/caddy/Caddyfile
fi

caddy fmt --overwrite /etc/caddy/sites/mbmyouth.caddy
caddy fmt --overwrite /etc/caddy/Caddyfile
caddy validate --config /etc/caddy/Caddyfile
systemctl reload caddy

log "Mengoptimalkan Laravel"
php artisan optimize:clear
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache
php artisan queue:restart

echo
echo "First deployment selesai."
echo "Website: https://$DOMAIN"
echo "Admin:   https://$DOMAIN/admin"
echo "Email:   $MBM_ADMIN_EMAIL"
