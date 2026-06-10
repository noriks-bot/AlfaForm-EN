<script setup lang="ts">
import { onMounted } from 'vue';
import { storeToRefs } from 'pinia';
import { useRulesStore } from '../stores/rulesStore';
import RuleSection from './sections/RuleSection.vue';
import Skeleton from './common/Skeleton.vue';
import { __ } from '@wordpress/i18n';
import MigrationNotice from './common/MigrationNotice.vue';

const store = useRulesStore();
const { loading, migrationRan } = storeToRefs(store);

onMounted(async () => {
  // Get feed ID from URL parameters
  const urlParams = new URLSearchParams(window.location.search);
  const feedId = urlParams.get('id') || 'new';
  
  // Load existing rules - this will handle both existing feeds and new feeds
  await store.loadRules(feedId);
});

const closeMigrationNotice = () => {
  migrationRan.value = false;
};
</script>

<template>
  <div class="adt-rules-builder adt-tw-max-w-7xl adt-tw-space-y-6">
    <!-- Loading State -->
    <template v-if="loading">
      <Skeleton type="title" width="10%" />
      <Skeleton type="card" :rows="1" :width="['100%']" />
    </template>
    <template v-else>
      <div v-if="migrationRan">
        <MigrationNotice type="rules" :closeMigrationNotice="closeMigrationNotice" />
      </div>
      <template v-for="(rule, ruleIndex) in store.rules" :key="rule.id || ruleIndex">
        <RuleSection :rule="rule" :ruleIndex="ruleIndex" />
      </template>
      <div class="adt-tw-flex adt-tw-justify-center adt-tw-mt-2">
        <button 
          type="button"
          class="adt-add-new-filter adt-tw-border-none adt-tw-cursor-pointer adt-tw-flex adt-tw-items-center adt-tw-px-3 adt-tw-py-1.5 adt-tw-bg-blue-500 adt-tw-text-white adt-tw-rounded-md hover:adt-tw-bg-blue-600 adt-tw-transition-colors adt-tw-text-xs adt-tw-focus-outline-none adt-tw-focus-ring-2 adt-tw-focus-ring-blue-500 adt-tw-focus-ring-offset-1"
          @click="store.addRule()"
        >
          <span class="adt-tw-icon-[lucide--plus-circle] adt-tw-mr-1"></span>
          <!-- translators: Button text to add a new rule in the rules builder -->
          {{ __('Add New Rule', 'woo-product-feed-pro') }}
        </button>
      </div>
    </template>
  </div>
</template>

<style scoped lang="scss">
.adt-rules-builder {
  // Custom styles if needed
}
</style> 
