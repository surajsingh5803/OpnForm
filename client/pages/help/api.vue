<template>
  <div class="min-h-full bg-neutral-50">
    <LpProductHeader title="API documentation" section="Developers"
      description="Connect systems to LP Forms using authenticated HTTP endpoints. The routes below are verified against this installation's Laravel API." />
    <main class="mx-auto max-w-6xl px-5 py-9 sm:px-8">
      <div class="rounded-xl border border-amber-200 bg-amber-50 px-5 py-4 text-sm leading-6 text-amber-950">
        <strong>Staging API:</strong> Use test data only. This installation has no production SLA, and external integrations should be verified before use.
      </div>
      <div class="mt-7 grid gap-7 lg:grid-cols-[210px_minmax(0,1fr)]">
        <aside class="space-y-2 text-sm">
          <a v-for="section in sections" :key="section.id" :href="'#' + section.id"
            class="block rounded-lg px-3 py-2 font-medium text-neutral-700 hover:bg-white hover:text-blue-700 hover:no-underline">{{ section.label }}</a>
          <NuxtLink to="/help" class="mt-4 block px-3 text-blue-700">← Help center</NuxtLink>
        </aside>
        <div class="min-w-0 space-y-8">
          <section id="base" class="scroll-mt-10 rounded-2xl border border-neutral-200 bg-white p-6">
            <h2 class="text-xl font-bold text-neutral-950">Base URL</h2>
            <p class="mt-2 text-sm leading-6 text-neutral-600">Use the LP Forms web origin for same-origin API calls. It forwards the <code>/api</code> path to Laravel.</p>
            <div class="mt-4 flex items-center justify-between gap-2 rounded-lg bg-neutral-900 p-4">
              <code class="overflow-x-auto text-sm text-white">{{ baseUrl }}</code>
              <button type="button" @click="copy(baseUrl)" class="shrink-0 text-xs font-medium text-sky-300 hover:text-white">Copy</button>
            </div>
          </section>
          <section id="auth" class="scroll-mt-10 rounded-2xl border border-neutral-200 bg-white p-6">
            <h2 class="text-xl font-bold text-neutral-950">Authentication</h2>
            <ol class="mt-3 list-decimal space-y-2 pl-5 text-sm leading-7 text-neutral-700">
              <li>Sign in to LP Forms and open your profile or user settings.</li>
              <li>Find Access Tokens and create a token with the permissions your integration requires.</li>
              <li>Pass the token in the <strong>Authorization: Bearer</strong> request header.</li>
              <li>Store tokens on a server or secure secrets manager. Never embed a token in a public website, source code or form.</li>
            </ol>
            <p class="mt-4 text-sm text-neutral-600">Token permissions and integration-specific abilities are enforced by the API. A token without sufficient rights may return 401 or 403.</p>
          </section>
          <section id="endpoints" class="scroll-mt-10 rounded-2xl border border-neutral-200 bg-white p-6">
            <h2 class="text-xl font-bold text-neutral-950">Available endpoints</h2>
            <p class="mt-2 text-sm leading-6 text-neutral-600">The following routes exist in the deployed Laravel application. For external integrations, scoped Sanctum API tokens are recommended.</p>
            <div class="mt-4 overflow-x-auto">
              <table class="w-full min-w-[550px] border-collapse text-left text-sm">
                <thead class="border-b border-neutral-200 text-neutral-500">
                  <tr><th class="px-3 py-3">Method</th><th class="px-3 py-3">Path</th><th class="px-3 py-3">Purpose</th></tr>
                </thead>
                <tbody>
                  <tr v-for="endpoint in endpoints" :key="endpoint.path" class="border-b border-neutral-100">
                    <td class="px-3 py-3 font-bold text-blue-700">{{ endpoint.method }}</td>
                    <td class="px-3 py-3 font-mono text-xs text-neutral-800">{{ endpoint.path }}</td>
                    <td class="px-3 py-3 text-neutral-600">{{ endpoint.purpose }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </section>
          <section id="examples" class="scroll-mt-10 rounded-2xl border border-neutral-200 bg-white p-6">
            <h2 class="text-xl font-bold text-neutral-950">Request examples</h2>
            <p class="mt-2 text-sm leading-6 text-neutral-600">Replace YOUR_TOKEN with a real, scoped access token. You can switch to a branded domain once that is configured.</p>
            <div v-for="sample in samples" :key="sample.title" class="mt-5">
              <div class="mb-2 flex items-center justify-between gap-3">
                <h3 class="font-semibold text-neutral-900">{{ sample.title }}</h3>
                <button type="button" class="text-xs font-semibold text-blue-600" @click="copy(sample.command)">Copy</button>
              </div>
              <pre class="overflow-x-auto rounded-xl bg-neutral-950 p-4 text-xs leading-6 text-blue-100"><code>{{ sample.command }}</code></pre>
            </div>
            <p v-if="copied" role="status" class="mt-3 text-sm text-green-700">Copied to clipboard.</p>
          </section>
          <section id="errors" class="scroll-mt-10 rounded-2xl border border-neutral-200 bg-white p-6">
            <h2 class="text-xl font-bold text-neutral-950">Errors and limits</h2>
            <p class="mt-2 text-sm leading-7 text-neutral-700">Typical responses include <strong>401</strong> for invalid authentication, <strong>403</strong> for insufficient permissions, <strong>404</strong> for missing records, <strong>422</strong> for invalid input, and <strong>429</strong> for rate limits. The exact limits vary by route.</p>
            <p class="mt-3 text-sm leading-7 text-neutral-700">When creating a public form integration, validate the entire flow using non-sensitive test submissions before connecting real leads. MCP is currently disabled on this staging deployment.</p>
          </section>
          <section id="support" class="scroll-mt-10 rounded-2xl border border-neutral-200 bg-white p-6">
            <h2 class="text-xl font-bold text-neutral-950">Developer support</h2>
            <p class="mt-2 text-sm leading-7 text-neutral-600">If an endpoint returns an error, include the method, path, timestamp, status code and reproducible steps in a bug report. Never share your access token or sensitive submission payloads.</p>
            <UButton to="/product/feature-requests" color="primary" class="mt-4">Report an API issue</UButton>
          </section>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import LpProductHeader from '~/components/pages/lp-product/LpProductHeader.vue'
definePageMeta({ layout: 'dashboard', middleware: ['auth'] })
useOpnSeoMeta({ title: 'API documentation', description: 'LP Forms developer API', robots: 'noindex, nofollow' })
const baseUrl = 'https://lp-forms-web.onrender.com/api'
const sections = [
  { id: 'base', label: 'Base URL' }, { id: 'auth', label: 'Authentication' },
  { id: 'endpoints', label: 'Endpoints' }, { id: 'examples', label: 'Examples' },
  { id: 'errors', label: 'Errors and limits' }, { id: 'support', label: 'Support' },
]
const endpoints = [
  { method: 'GET', path: '/external/zapier/validate', purpose: 'Validate an external integration token.' },
  { method: 'GET', path: '/external/zapier/workspaces', purpose: 'List accessible workspaces (workspaces-read).' },
  { method: 'GET', path: '/external/zapier/forms', purpose: 'List accessible forms (forms-read).' },
  { method: 'GET', path: '/external/zapier/submissions/recent', purpose: 'Poll recent submissions (requires integration abilities).' },
  { method: 'GET', path: '/settings/tokens/abilities', purpose: 'List permissions available when signed in.' },
]
const samples = [
  { title: 'List accessible forms', command: "curl --request GET 'https://lp-forms-web.onrender.com/api/external/zapier/forms' \\\n  --header 'Authorization: Bearer YOUR_TOKEN' \\\n  --header 'Accept: application/json'" },
  { title: 'List accessible workspaces', command: "curl --request GET 'https://lp-forms-web.onrender.com/api/external/zapier/workspaces' \\\n  --header 'Authorization: Bearer YOUR_TOKEN' \\\n  --header 'Accept: application/json'" },
]
const copied = ref(false)
async function copy(value) {
  if (import.meta.client && navigator.clipboard) {
    try {
      await navigator.clipboard.writeText(value)
      copied.value = true
    } catch {
      copied.value = false
    }
  }
}
</script>
