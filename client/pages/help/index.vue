<template>
  <div class="min-h-full bg-neutral-50">
    <LpProductHeader title="Help center" section="Support"
      description="Practical guides for creating, publishing and managing LP Forms, with instructions tailored to this self-hosted installation." />
    <main class="mx-auto max-w-6xl px-5 py-9 sm:px-8">
      <div class="rounded-2xl bg-gradient-to-r from-blue-700 to-sky-700 p-6 text-white sm:p-8">
        <h2 class="!text-white text-2xl font-bold">How can we help?</h2>
        <p class="mt-2 text-sm text-blue-100">Search guides, learn how to share forms or find out what is still being configured in staging.</p>
        <div class="relative mt-5 max-w-2xl">
          <UIcon name="i-heroicons-magnifying-glass" class="absolute top-3.5 left-4 size-5 text-neutral-400" />
          <input v-model="query" type="search" aria-label="Search help topics" placeholder="Search by topic, feature or question…"
            class="w-full rounded-xl bg-white py-3 pr-4 pl-12 text-sm text-neutral-950 placeholder-neutral-400 outline-none focus:ring-2 focus:ring-blue-300" />
        </div>
      </div>
      <div class="mt-8 grid gap-7 lg:grid-cols-[220px_minmax(0,1fr)]">
        <aside class="space-y-1">
          <p class="mb-3 px-2 text-xs font-semibold uppercase tracking-wide text-neutral-500">Browse topics</p>
          <button v-for="category in categories" :key="category"
            type="button" @click="selectedCategory = category"
            class="flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-left text-sm font-medium"
            :class="selectedCategory === category ? 'bg-blue-50 text-blue-700' : 'text-neutral-700 hover:bg-neutral-200'">
            {{ category }}
            <span class="text-xs opacity-60">{{ category === 'All topics' ? articles.length : articles.filter(a => a.category === category).length }}</span>
          </button>
          <div class="mt-6 rounded-xl border border-blue-100 bg-blue-50 p-4">
            <h3 class="font-semibold text-blue-950">Need an improvement?</h3>
            <p class="mt-1 text-sm leading-5 text-blue-800">Request a feature or report a product issue.</p>
            <NuxtLink to="/product/feature-requests" class="mt-3 inline-flex text-sm font-semibold text-blue-700">Open feedback board →</NuxtLink>
          </div>
        </aside>
        <section class="min-w-0">
          <div class="mb-4 flex items-center justify-between gap-3">
            <h2 class="text-lg font-bold text-neutral-950">Guides and answers</h2>
            <span class="text-sm text-neutral-500">{{ filteredArticles.length }} articles</span>
          </div>
          <div v-if="!filteredArticles.length" class="rounded-2xl border border-neutral-200 bg-white p-10 text-center">
            <h3 class="font-semibold text-neutral-900">No matching articles</h3>
            <p class="mt-2 text-sm text-neutral-600">Try a shorter search or browse all topics.</p>
            <button class="mt-3 text-sm font-semibold text-blue-600" @click="query = ''; selectedCategory = 'All topics'">Show everything</button>
          </div>
          <div v-else class="space-y-3">
            <details v-for="article in filteredArticles" :key="article.title"
              class="group rounded-2xl border border-neutral-200 bg-white px-5 py-4 open:shadow-sm">
              <summary class="flex cursor-pointer list-none items-start justify-between gap-5">
                <div>
                  <span class="text-xs font-medium text-blue-600">{{ article.category }}</span>
                  <h3 class="mt-1 text-base font-semibold leading-6 text-neutral-950">{{ article.title }}</h3>
                  <p class="mt-1 text-sm text-neutral-500">{{ article.summary }}</p>
                </div>
                <UIcon name="i-heroicons-chevron-down" class="mt-2 size-5 shrink-0 text-neutral-400 transition-transform group-open:rotate-180" />
              </summary>
              <div class="mt-5 border-t border-neutral-100 pt-4">
                <ol class="list-decimal space-y-2 pl-5 text-sm leading-7 text-neutral-700">
                  <li v-for="step in article.steps" :key="step">{{ step }}</li>
                </ol>
                <p v-if="article.note" class="mt-4 rounded-lg bg-amber-50 px-4 py-3 text-sm leading-6 text-amber-900">{{ article.note }}</p>
                <NuxtLink v-if="article.link" :to="article.link.href" class="mt-4 inline-flex font-semibold text-sm text-blue-600">{{ article.link.text }} →</NuxtLink>
              </div>
            </details>
          </div>
        </section>
      </div>
    </main>
  </div>
</template>

<script setup>
import LpProductHeader from '~/components/pages/lp-product/LpProductHeader.vue'
definePageMeta({ layout: 'dashboard', middleware: ['auth'] })
useOpnSeoMeta({ title: 'Help center', description: 'LP Forms user guides and support', robots: 'noindex, nofollow' })
const query = ref('')
const selectedCategory = ref('All topics')
const categories = ['All topics', 'Getting started', 'Build and share', 'Responses', 'Account and integrations', 'Troubleshooting']
const articles = [
  {
    category: 'Getting started', title: 'Create your first form', summary: 'From a blank form to your first question.',
    steps: ['Sign in to your LP Forms workspace.', 'Select Create Form in the sidebar or at the top of Home.', 'Choose a blank form or a template, then add fields and give the form a clear title.', 'Use Preview to check the respondent experience before sharing.'],
    link: { text: 'Open form builder', href: '/forms/create' },
  },
  {
    category: 'Getting started', title: 'Start from a template', summary: 'Adapt an existing layout rather than starting empty.',
    steps: ['Open Templates from your sidebar.', 'Browse the available templates and select one that matches your use case.', 'Copy or use the template, then replace any example questions with your own.', 'Preview before publishing to confirm the questions and settings.'],
    link: { text: 'Browse templates', href: '/templates' },
  },
  {
    category: 'Build and share', title: 'Preview a form before publishing', summary: 'Test the title, fields, layout and thank-you message.',
    steps: ['Open a form in the builder.', 'Switch to Preview to inspect the respondent-facing page.', 'Test required fields, answer choices and the completion screen.', 'Return to the editor and make adjustments if needed.'],
    note: 'Preview is for testing the experience; use a published form link for actual respondent submissions.',
  },
  {
    category: 'Build and share', title: 'Share a published form', summary: 'Send a direct link to respondents.',
    steps: ['Open the form from Home.', 'Go to its Share section.', 'Copy the public form URL and open it in a private browser tab.', 'Share the confirmed link with respondents.'],
    note: 'If the link does not load, confirm the form is published and active before sending it.',
  },
  {
    category: 'Build and share', title: 'Embed a form on a website', summary: 'Use the generated iframe snippet.',
    steps: ['Open the form and go to Share.', 'Copy the embed snippet shown by LP Forms.', 'Paste the snippet into your website’s HTML or embed block.', 'Publish the website page and test the form on desktop and mobile.'],
    note: 'Keep the JavaScript file paths in the generated snippet unchanged because they are part of the working form embed interface.',
  },
  {
    category: 'Build and share', title: 'Customise a form’s appearance', summary: 'Adjust visual presentation and the respondent experience.',
    steps: ['Open the form editor.', 'Select a classic or focused presentation when available.', 'Adjust colours, text, fields and any cover media.', 'Preview the finished design before sharing.'],
  },
  {
    category: 'Responses', title: 'Find submitted responses', summary: 'Review answers in the form workspace.',
    steps: ['Open Home and select the form you want to inspect.', 'Open Submissions in its sidebar.', 'Review the received entries and their field values.', 'Use the available filters or export tools where shown in the interface.'],
    note: 'Staging is not approved for sensitive customer information until backups, durable uploads and a production security review are complete.',
  },
  {
    category: 'Responses', title: 'Test your form safely', summary: 'Check the complete collection flow without real customer data.',
    steps: ['Publish a test form with non-sensitive sample fields.', 'Open its public link in another tab.', 'Submit a clearly labelled test response.', 'Return to Submissions and verify that it appears.'],
    note: 'Use dummy data only on this free-tier staging deployment.',
  },
  {
    category: 'Account and integrations', title: 'Manage your workspace and account', summary: 'Find the settings that control access to forms.',
    steps: ['Use the workspace menu at the top left to open workspace settings.', 'Use the profile menu to access your account settings.', 'Review team members and permissions before inviting others.', 'Keep credentials private and use unique passwords for this installation.'],
  },
  {
    category: 'Account and integrations', title: 'Access the developer API', summary: 'Generate an access token and explore verified routes.',
    steps: ['Open your account settings and locate Access Tokens.', 'Create a token with only the permissions the integration needs.', 'Call the API using an Authorization: Bearer header.', 'Never expose your API token in website JavaScript or a public repository.'],
    link: { text: 'View LP Forms API documentation', href: '/help/api' },
  },
  {
    category: 'Account and integrations', title: 'Email and webhook integrations', summary: 'Understand which services require setup.',
    steps: ['Open your form’s Integrations section.', 'Choose the integration you need and review its configuration requirements.', 'Add provider credentials only in secure settings when the provider is supported.', 'Run a test submission and verify delivery at the destination.'],
    note: 'Outgoing transactional email is not configured on this staging deployment; messages may currently be written to server logs rather than delivered.',
  },
  {
    category: 'Troubleshooting', title: 'A form or preview does not load', summary: 'Check common causes before reporting an issue.',
    steps: ['Refresh the page once or try a private browsing window.', 'Check whether the form is active and whether the link is correct.', 'Retry after a short pause; Render free services can wake from an idle state.', 'If the problem continues, submit a bug report with the page URL and steps to reproduce.'],
    link: { text: 'Report an issue', href: '/product/feature-requests' },
  },
  {
    category: 'Troubleshooting', title: 'Understand the staging limitations', summary: 'What is safe to test before production launch.',
    steps: ['Use test forms and dummy information only.', 'Expect a possible cold start when a free Render instance wakes.', 'Do not rely on local file uploads for persistent customer documents.', 'Plan durable storage, email and a job worker before processing live leads.'],
    link: { text: 'See production-readiness roadmap', href: '/product/roadmap' },
  },
]
const filteredArticles = computed(() => {
  const term = query.value.trim().toLowerCase()
  return articles.filter(article =>
    (selectedCategory.value === 'All topics' || article.category === selectedCategory.value) &&
    (!term || [article.title, article.summary, article.category, ...article.steps].join(' ').toLowerCase().includes(term))
  )
})
</script>
