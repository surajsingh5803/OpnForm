import { forwardToLpFormsApi } from '~/server/utils/lp-forms-api-proxy.js'

export default defineEventHandler((event) => forwardToLpFormsApi(event))
