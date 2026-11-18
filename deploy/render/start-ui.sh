#!/bin/sh
set -eu

: "${LP_FORMS_API_HOSTPORT:?Render must wire LP_FORMS_API_HOSTPORT from lp-forms-api}"

# Direct SSR requests to Laravel over Render's private network.
# Browser requests use the same-origin /api catch-all proxy.
export NUXT_PRIVATE_API_BASE="http://${LP_FORMS_API_HOSTPORT}"
exec node /app/server/index.mjs
