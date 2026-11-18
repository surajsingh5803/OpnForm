#!/bin/sh
set -eu

if [ -n "${LP_FORMS_API_ORIGIN:-}" ]; then
  # Render free web services cannot receive private-network traffic.
  # Call the API using its public HTTPS endpoint for experimental staging.
  case "$LP_FORMS_API_ORIGIN" in
    https://*) export NUXT_PRIVATE_API_BASE="${LP_FORMS_API_ORIGIN%/}" ;;
    *) echo "LP_FORMS_API_ORIGIN must be an HTTPS URL" >&2; exit 1 ;;
  esac
else
  # Paid private-service path: keep API traffic on Render's private network.
  : "${LP_FORMS_API_HOSTPORT:?Set private hostport or public API origin}"
  export NUXT_PRIVATE_API_BASE="http://${LP_FORMS_API_HOSTPORT}"
fi

# Browser requests remain same-origin at /api and are proxied by Nitro.
exec node /app/server/index.mjs
