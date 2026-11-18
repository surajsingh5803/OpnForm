import { createError, getRequestURL, proxyRequest } from 'h3'

// Render injects this host:port from the private API service. The destination
// is never taken from user-supplied headers, query parameters or form data.
export function forwardToLpFormsApi(event, stripApiPrefix = false) {
  const hostport = process.env.LP_FORMS_API_HOSTPORT
  if (!hostport || !/^[a-zA-Z0-9][a-zA-Z0-9.-]*:[0-9]{2,5}$/.test(hostport)) {
    throw createError({ statusCode: 503, statusMessage: 'LP Forms API is not configured' })
  }

  const url = getRequestURL(event)
  const pathname = stripApiPrefix
    ? (url.pathname.replace(/^\/api(?=\/|$)/, '') || '/')
    : url.pathname

  return proxyRequest(event, `http://${hostport}${pathname}${url.search}`)
}
