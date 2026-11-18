import { createError, getRequestURL, proxyRequest } from 'h3'

// Render free web services cannot receive traffic over the private network.
// The free-tier deployment uses a fixed public HTTPS API origin, while paid
// private services may continue using their internal host:port.
// Neither destination can be provided by a client request.
function getLpFormsApiOrigin() {
  const publicOrigin = (process.env.LP_FORMS_API_ORIGIN || '').replace(/\/$/, '')
  if (publicOrigin) {
    if (!/^https:\/\/[a-zA-Z0-9][a-zA-Z0-9.-]*(?::443)?$/.test(publicOrigin)) {
      throw createError({ statusCode: 503, statusMessage: 'Invalid LP Forms API origin' })
    }
    return publicOrigin
  }

  const hostport = process.env.LP_FORMS_API_HOSTPORT
  if (!hostport || !/^[a-zA-Z0-9][a-zA-Z0-9.-]*:[0-9]{2,5}$/.test(hostport)) {
    throw createError({ statusCode: 503, statusMessage: 'LP Forms API is not configured' })
  }
  return `http://${hostport}`
}

export function forwardToLpFormsApi(event, stripApiPrefix = false) {
  const url = getRequestURL(event)
  const pathname = stripApiPrefix
    ? (url.pathname.replace(/^\/api(?=\/|$)/, '') || '/')
    : url.pathname

  return proxyRequest(event, `${getLpFormsApiOrigin()}${pathname}${url.search}`)
}
