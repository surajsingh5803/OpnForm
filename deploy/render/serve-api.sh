#!/bin/sh
set -eu

: "${APP_URL:?Set APP_URL to the public LP Forms https URL in Render}"
: "${DATABASE_URL:?Set DATABASE_URL from Neon in Render}"
: "${APP_KEY:?Set APP_KEY to a Laravel base64: key in Render}"

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
