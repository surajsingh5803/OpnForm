import { forwardToLpFormsApi } from '~/server/utils/lp-forms-api-proxy.js'

// Specific Nitro API routes (feature-flags, plan-catalog, agent-drafts) are
// handled by their existing, more specific handlers.
export default defineEventHandler((event) => forwardToLpFormsApi(event, true))
