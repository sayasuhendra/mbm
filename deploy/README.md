# Deployment Caddy

Konfigurasi tersedia di `deploy/Caddyfile` untuk domain `mbm.dbaik.com`.

1. Pastikan project berada di `/var/www/mbmyouth`, atau ubah directive `root` sesuai lokasi project di server.
2. Pastikan PHP-FPM tersedia di `/run/php/php8.4-fpm.sock`.
3. Atur environment production:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://mbm.dbaik.com
```

4. Pasang dan aktifkan konfigurasi:

```bash
sudo cp deploy/Caddyfile /etc/caddy/Caddyfile
sudo caddy validate --config /etc/caddy/Caddyfile
sudo systemctl reload caddy
php artisan storage:link
```

Untuk first deployment lengkap, pastikan database PostgreSQL dan user-nya sudah dibuat, kemudian jalankan:

```bash
chmod +x deploy.sh
sudo ./deploy.sh
```

Nilai default-nya adalah domain `mbm.dbaik.com`, path `/var/www/mbmyouth`, branch `main`, dan PostgreSQL database/user `mbmyouth`. Semua dapat dioverride melalui environment variable, misalnya:

```bash
sudo env APP_DIR=/srv/mbm BRANCH=production DB_DATABASE=mbm DB_USERNAME=mbm ./deploy.sh
```

5. Update aplikasi berikutnya:

```bash
./update.sh main
```
