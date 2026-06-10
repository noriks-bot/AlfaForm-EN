<script setup lang="ts">
import { computed } from 'vue';
import { __ } from '@wordpress/i18n';

const props = defineProps<{
  type: 'filters' | 'rules';
  closeMigrationNotice: () => void;
}>();

const title = computed(() => {
  return props.type === 'filters' 
    ? __('Filters Successfully Migrated', 'woo-product-feed-pro') 
    : __('Rules Successfully Migrated', 'woo-product-feed-pro');
});

const description = computed(() => {
  return props.type === 'filters'
    ? __('Your existing filters have been automatically migrated to the new enhanced format. The new builder provides improved functionality and better organization of your filter rules.', 'woo-product-feed-pro')
    : __('Your existing rules have been automatically migrated to the new enhanced format. The new builder provides improved functionality and better organization of your rules.', 'woo-product-feed-pro');
});
</script>

<template>
  <div class="adt-tw-bg-yellow-50 adt-tw-border adt-tw-border-blue-200 adt-tw-p-4 adt-tw-rounded-lg adt-tw-relative">
    <div class="adt-tw-flex adt-tw-items-start adt-tw-space-x-3">
      <div class="adt-tw-flex-1">
        <h3 class="adt-tw-text-sm adt-tw-mt-0 adt-tw-font-bold adt-tw-text-yellow-700 adt-tw-flex adt-tw-items-center adt-tw-gap-2">
          <span class="adt-tw-text-lg adt-tw-icon-[lucide--info] adt-tw-text-yellow-700 adt-tw-transition-colors"></span>
          {{ title }}
        </h3>
        <div class="adt-tw-mt-2 adt-tw-text-sm adt-tw-text-yellow-700 adt-tw-whitespace-pre-line">
          {{ description }}
        </div>
      </div>
      <div class="adt-tw-flex-shrink-0">
        <button
          class="adt-tw-bg-transparent adt-tw-border-0 adt-tw-text-yellow-700 hover:adt-tw-text-yellow-600 adt-tw-text-lg adt-tw-cursor-pointer adt-tw-transition-colors"
          :aria-label="__('Close notification', 'woo-product-feed-pro')"
          @click="props.closeMigrationNotice"
        >
          <span class="adt-tw-text-lg adt-tw-icon-[lucide--x] adt-tw-text-yellow-700 adt-tw-transition-colors"></span>
        </button>
      </div>
    </div>
  </div>
</template>