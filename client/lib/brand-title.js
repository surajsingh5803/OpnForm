// Keep the default identity for upstream-compatible deployments while allowing
// each self-hosted installation to present its own brand in browser titles.
export function formatBrandTitle(titleChunk, brandName = 'OpnForm') {
  const name = typeof brandName === 'string' && brandName.trim()
    ? brandName.trim()
    : 'OpnForm'
  const title = typeof titleChunk === 'string' ? titleChunk.trim() : ''

  return title && title !== name ? `${title} - ${name}` : name
}
