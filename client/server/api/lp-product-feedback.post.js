import { createHmac } from 'node:crypto'

// The public browser talks only to Nuxt. Nuxt signs a visitor bucket using
// its private API secret, and Laravel verifies the same installation secret.
export default defineEventHandler(async (event) => {
  const config = useRuntimeConfig()
  if (!config.apiSecret) {
    throw createError({ statusCode: 503, statusMessage: 'Feedback service is not configured' })
  }

  const body = await readBody(event)
  if (!body || typeof body !== 'object' || Array.isArray(body)) {
    throw createError({ statusCode: 400, statusMessage: 'Invalid request' })
  }

  const visitorIP = getRequestIP(event, { xForwardedFor: true })
    || getRequestIP(event) || 'unknown'
  const visitor = createHmac('sha256', config.apiSecret)
    .update(visitorIP)
    .digest('hex')

  setHeader(event, 'cache-control', 'no-store')
  try {
    const response = await $fetch.raw('/lp-product-feedback', {
      method: 'POST',
      baseURL: config.privateApiBase || config.public.apiBase,
      body: {
        title: body.title,
        details: body.details,
        category: body.category,
        contact_email: body.contact_email || null,
        website: body.website || '',
      },
      headers: {
        'x-api-secret': config.apiSecret,
        'x-lp-feedback-visitor': visitor,
        accept: 'application/json',
      },
      retry: 0,
      timeout: 15000,
    })
    setResponseStatus(event, response.status)
    return response._data
  } catch (error) {
    const status = error?.response?.status || 502
    throw createError({
      statusCode: status,
      statusMessage: status === 429
        ? 'You have reached the feedback submission limit. Please try again later.'
        : status === 422
          ? 'Please check the title and description.'
          : 'Unable to save your request at the moment',
    })
  }
})
