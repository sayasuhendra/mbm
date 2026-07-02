#!/usr/bin/env bash

set -Eeuo pipefail

REPO_URL="git@github.com:sayasuhendra/mbm.git"
APP_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
BRANCH="${1:-$(git -C "$APP_DIR" branch --show-current)}"

cd "$APP_DIR"

if [[ ! -d .git ]]; then
    echo "Error: $APP_DIR bukan repository Git."
    exit 1
fi

if [[ -z "$BRANCH" ]]; then
    echo "Error: branch aktif tidak ditemukan. Jalankan: ./update.sh <nama-branch>"
    exit 1
fi

if [[ -n "$(git status --porcelain)" ]]; then
    echo "Error: ada perubahan lokal yang belum di-commit. Commit atau stash terlebih dahulu."
    git status --short
    exit 1
fi

if git remote get-url origin >/dev/null 2>&1; then
    git remote set-url origin "$REPO_URL"
else
    git remote add origin "$REPO_URL"
fi

echo "Memperbarui branch $BRANCH dari $REPO_URL..."
git fetch origin "$BRANCH"
git pull --ff-only origin "$BRANCH"

echo "Mengaktifkan maintenance mode..."
php artisan down --retry=60 || true

restore_application() {
    php artisan up || true
}
trap restore_application EXIT

echo "Menginstal dependency PHP..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

echo "Menjalankan migration..."
php artisan migrate --force

echo "Menginstal dependency dan membangun asset frontend..."
npm ci
npm run build

echo "Menyegarkan cache Laravel..."
php artisan optimize:clear
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache

echo "Merestart worker queue..."
php artisan queue:restart

if command -v caddy >/dev/null 2>&1; then
    echo "Memvalidasi konfigurasi Caddy yang aktif..."
    caddy validate --config /etc/caddy/Caddyfile || {
        echo "Peringatan: validasi Caddy gagal. Aplikasi sudah diperbarui, tetapi konfigurasi Caddy perlu diperiksa."
    }
fi

restore_application
trap - EXIT

echo "Update selesai pada commit $(git rev-parse --short HEAD)."
