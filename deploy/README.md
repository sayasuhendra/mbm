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

Untuk first deployment lengkap, jalankan perintah berikut. Pada Debian/Ubuntu, script otomatis memasang paket `php8.4-sqlite3` jika ekstensi `pdo_sqlite` belum tersedia.

```bash
chmod +x deploy.sh
sudo ./deploy.sh
```

Nilai default-nya adalah domain `mbm.dbaik.com`, path `/var/www/mbmyouth`, branch `main`, dan database SQLite di `database/database.sqlite`. Nilai deployment dapat dioverride melalui environment variable, misalnya:

```bash
sudo env APP_DIR=/srv/mbm BRANCH=production ./deploy.sh
```

5. Update aplikasi berikutnya:

```bash
./update.sh main
```
