#!/bin/sh
set -eu

: "${APP_URL:?Render must provide the public web URL}"
: "${DATABASE_URL:?Set DATABASE_URL from Neon in Render}"
: "${LP_FORMS_KEY_SEED:?Render must provide a stable generated key seed}"

# Render keeps the seed stable across deploys. Convert it to a Laravel 32-byte key.
export APP_KEY="$(php -r 'echo "base64:".base64_encode(hash("sha256", getenv("LP_FORMS_KEY_SEED"), true));')"

export FRONT_URL="${FRONT_URL:-$APP_URL}"
export PORT="${PORT:-10000}"

# Replace only the port placeholder; keep Nginx variables ($uri, etc.) intact.
envsubst '${PORT}' < /etc/nginx/http.d/lp-forms.conf.template > /etc/nginx/http.d/default.conf
rm -f /etc/nginx/http.d/lp-forms.conf.template
nginx -t

# Upstream Laravel bootstrap runs migrations, initializes keys and starts PHP-FPM.
# PHP-FPM daemonizes, allowing the Nginx process to own the container lifecycle.
/usr/local/bin/opnform-entrypoint php-fpm -D
exec nginx -g 'daemon off;'
