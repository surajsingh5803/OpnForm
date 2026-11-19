<template>
  <div class="min-h-full bg-neutral-50">
    <LpProductHeader title="Feature requests" section="Community"
      description="Suggest improvements and explore requests submitted to this LP Forms installation. Requests are saved in the LP Forms database." />
    <main class="mx-auto max-w-6xl px-5 py-9 sm:px-8">
      <div class="grid gap-7 lg:grid-cols-[1fr_380px]">
        <section class="min-w-0">
          <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
              <h2 class="text-xl font-bold text-neutral-950">Ideas and feedback</h2>
              <p class="mt-1 text-sm text-neutral-500">New requests begin in review. No fake vote counts or imported submissions.</p>
            </div>
            <span v-if="items.length" class="rounded-full bg-blue-50 px-3 py-1 text-sm font-medium text-blue-700">{{ items.length }} requests</span>
          </div>
          <div class="mt-5 flex flex-col gap-3 sm:flex-row">
            <UInput v-model="search" icon="i-heroicons-magnifying-glass" class="flex-1" placeholder="Search ideas" />
            <select v-model="filter" aria-label="Filter requests by status" class="rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm text-neutral-800">
              <option value="all">All statuses</option>
              <option value="review">In review</option>
              <option value="planned">Planned</option>
              <option value="progress">In progress</option>
              <option value="done">Completed</option>
            </select>
          </div>
          <div v-if="pending" class="mt-6 rounded-xl bg-white p-6 text-neutral-500">Loading feature requests…</div>
          <div v-else-if="error" class="mt-6 rounded-xl border border-red-200 bg-white p-6 text-sm text-red-700">
            Could not load requests right now. <button type="button" class="font-semibold underline" @click="refresh()">Retry</button>
          </div>
          <div v-else-if="visibleItems.length === 0" class="mt-6 rounded-2xl border border-dashed border-neutral-300 bg-white p-10 text-center">
            <UIcon name="i-heroicons-light-bulb" class="mx-auto size-9 text-neutral-400" />
            <h3 class="mt-3 font-semibold text-neutral-950">No matching ideas yet</h3>
            <p class="mt-1 text-sm text-neutral-600">Your suggestion can be the first one in this view.</p>
          </div>
          <div v-else class="mt-6 space-y-3">
            <article v-for="item in visibleItems" :key="item.id" class="rounded-2xl border border-neutral-200 bg-white p-5">
              <div class="flex flex-wrap items-center justify-between gap-2">
                <span class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-medium text-neutral-600">{{ categoryLabel(item.category) }}</span>
                <span class="text-xs text-neutral-500">{{ formatDate(item.created_at) }}</span>
              </div>
              <h3 class="mt-3 text-lg font-semibold text-neutral-950">{{ item.title }}</h3>
              <p class="mt-2 whitespace-pre-line text-sm leading-6 text-neutral-600">{{ item.details }}</p>
              <p class="mt-4 inline-flex items-center gap-1.5 text-xs font-semibold text-blue-700">
                <span class="size-2 rounded-full bg-blue-500" /> {{ statusLabel(item.status) }}
              </p>
            </article>
          </div>
        </section>
        <aside>
          <div class="sticky top-5 rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm">
            <div class="flex items-center gap-2">
              <UIcon name="i-heroicons-pencil-square" class="size-6 text-blue-600" />
              <h2 class="text-xl font-bold text-neutral-950">Suggest an idea</h2>
            </div>
            <p class="mt-2 text-sm leading-6 text-neutral-600">Tell us what would make LP Forms more useful. Please avoid including passwords or personal customer data.</p>
            <form class="mt-5 space-y-4" @submit.prevent="submit">
              <div>
                <label for="feedback-title" class="mb-1.5 block text-sm font-semibold text-neutral-800">Title *</label>
                <input id="feedback-title" v-model.trim="draft.title" required minlength="8" maxlength="160" placeholder="What should we improve?"
                  class="w-full rounded-lg border border-neutral-300 px-3 py-2.5 text-sm text-neutral-950 focus:border-blue-500 focus:outline-none" />
              </div>
              <div>
                <label for="feedback-category" class="mb-1.5 block text-sm font-semibold text-neutral-800">Category *</label>
                <select id="feedback-category" v-model="draft.category" required class="w-full rounded-lg border border-neutral-300 bg-white px-3 py-2.5 text-sm text-neutral-900">
                  <option value="feature">New feature</option>
                  <option value="integration">Integration</option>
                  <option value="usability">Ease of use</option>
                  <option value="bug">Bug report</option>
                </select>
              </div>
              <div>
                <label for="feedback-details" class="mb-1.5 block text-sm font-semibold text-neutral-800">Description *</label>
                <textarea id="feedback-details" v-model.trim="draft.details" rows="6" required minlength="20" maxlength="2500"
                  placeholder="What problem are you trying to solve? How would it work?" class="w-full resize-y rounded-lg border border-neutral-300 px-3 py-2.5 text-sm text-neutral-950 focus:border-blue-500 focus:outline-none" />
                <p class="mt-1 text-right text-xs text-neutral-400">{{ draft.details.length }}/2500</p>
              </div>
              <div>
                <label for="feedback-email" class="mb-1.5 block text-sm font-semibold text-neutral-800">Email (optional)</label>
                <input id="feedback-email" v-model.trim="draft.contact_email" type="email" maxlength="255" autocomplete="email"
                  placeholder="For follow-up, never displayed" class="w-full rounded-lg border border-neutral-300 px-3 py-2.5 text-sm text-neutral-950 focus:border-blue-500 focus:outline-none" />
              </div>
              <div aria-hidden="true" class="absolute -left-[9999px]"><label for="lp-feedback-website">Leave empty</label><input id="lp-feedback-website" v-model="draft.website" tabindex="-1" autocomplete="off" /></div>
              <p v-if="success" role="status" class="rounded-lg bg-green-50 p-3 text-sm font-medium text-green-800">Request received and saved. Thanks for helping improve LP Forms!</p>
              <p v-if="submitError" role="alert" class="rounded-lg bg-red-50 p-3 text-sm text-red-700">{{ submitError }}</p>
              <UButton type="submit" color="primary" block :loading="saving" :disabled="saving">Submit feature request</UButton>
            </form>
            <p class="mt-4 text-xs leading-5 text-neutral-500">Requests are public after submission except for the private contact email. This is an early staging inbox; moderation and voting are planned.</p>
          </div>
        </aside>
      </div>
    </main>
  </div>
</template>

<script setup>
import LpProductHeader from '~/components/pages/lp-product/LpProductHeader.vue'
definePageMeta({ layout: 'dashboard', middleware: ['auth'] })
useOpnSeoMeta({ title: 'Feature requests', description: 'LP Forms product feedback', robots: 'noindex, nofollow' })
const search = ref('')
const filter = ref('all')
const draft = reactive({ title: '', category: 'feature', details: '', contact_email: '', website: '' })
const saving = ref(false)
const success = ref(false)
const submitError = ref('')
const { data, pending, error, refresh } = useFetch('/api/lp-product-feedback', {
  server: false,
  default: () => ({ items: [] }),
})
const items = computed(() => Array.isArray(data.value?.items) ? data.value.items : [])
const visibleItems = computed(() => {
  const term = search.value.trim().toLowerCase()
  return items.value.filter(item =>
    (filter.value === 'all' || item.status === filter.value) &&
    (!term || (item.title + ' ' + item.details).toLowerCase().includes(term))
  )
})
function categoryLabel(value) {
  return { feature: 'New feature', integration: 'Integration', usability: 'Ease of use', bug: 'Bug report' }[value] || 'Feedback'
}
function statusLabel(value) {
  return { review: 'In review', planned: 'Planned', progress: 'In progress', done: 'Completed' }[value] || 'In review'
}
function formatDate(value) {
  const date = new Date(value)
  return Number.isNaN(date.getTime()) ? '' : date.toLocaleDateString(undefined, { day: 'numeric', month: 'short', year: 'numeric' })
}
async function submit() {
  if (saving.value) return
  saving.value = true
  success.value = false
  submitError.value = ''
  try {
    await $fetch('/api/lp-product-feedback', { method: 'POST', body: { ...draft } })
    Object.assign(draft, { title: '', category: 'feature', details: '', contact_email: '', website: '' })
    success.value = true
    await refresh()
  } catch (e) {
    submitError.value = e?.data?.statusMessage || 'Your request could not be saved. Please retry.'
  } finally {
    saving.value = false
  }
}
</script>
