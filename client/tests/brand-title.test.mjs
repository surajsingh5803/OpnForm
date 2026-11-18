import assert from 'node:assert/strict'
import test from 'node:test'
import { formatBrandTitle } from '../lib/brand-title.js'

test('uses the default identity when no custom brand is configured', () => {
  assert.equal(formatBrandTitle('Dashboard'), 'Dashboard - OpnForm')
  assert.equal(formatBrandTitle(), 'OpnForm')
})

test('uses the configured LP Forms identity on browser tabs', () => {
  assert.equal(formatBrandTitle('My forms', 'LP Forms'), 'My forms - LP Forms')
  assert.equal(formatBrandTitle('', 'LP Forms'), 'LP Forms')
})

test('avoids duplicate suffixes and invalid brand values', () => {
  assert.equal(formatBrandTitle('LP Forms', 'LP Forms'), 'LP Forms')
  assert.equal(formatBrandTitle('  Edit form  ', '  LP Forms  '), 'Edit form - LP Forms')
  assert.equal(formatBrandTitle(null, ''), 'OpnForm')
})
