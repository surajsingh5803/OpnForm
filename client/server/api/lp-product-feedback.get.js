// Server-only proxy: the Laravel API secret never reaches the browser.
export default defineEventHandler(async (event) => {
  const config = useRuntimeConfig()
  if (!config.apiSecret) {
    throw createError({ statusCode: 503, statusMessage: 'Feedback service is not configured' })
  }
  setHeader(event, 'cache-control', 'no-store')

  try {
    return await $fetch('/lp-product-feedback', {
      baseURL: config.privateApiBase || config.public.apiBase,
      headers: { 'x-api-secret': config.apiSecret, accept: 'application/json' },
      retry: 0,
      timeout: 15000,
    })
  } catch (error) {
    throw createError({
      statusCode: error?.response?.status || 502,
      statusMessage: 'The feedback inbox is temporarily unavailable',
    })
  }
})
