<script setup lang="ts">
import { ref, computed, watch } from 'vue';
import { storeToRefs } from 'pinia';
import { useFiltersStore } from '../../stores/filtersStore';
import FilterGroup from '../groups/FilterGroup.vue';
import GroupDropdown from '../common/GroupDrowdown.vue';
import { __ } from '@wordpress/i18n';
import type { SectionType } from '../../types';

const store = useFiltersStore();
const { filters } = storeToRefs(store);

const props = defineProps<{
  type: SectionType;
}>();

const sectionFilters = computed(() => {
  return filters.value[props.type] || [];
});

// Ensure at least one group exists
watch(sectionFilters, (newFilters) => {
  if (newFilters && newFilters.length === 0) {
    store.addFilterGroup(props.type);
  }
}, { immediate: true });
</script>
<template>
  <div class="adt-filter-section-wrapper adt-tw-border-2 adt-tw-border-dashed adt-tw-border-pink-300 adt-tw-rounded-lg adt-tw-p-3">
    <div class="adt-tw-flex adt-tw-items-center adt-tw-justify-between adt-tw-mb-2" :data-section-type="props.type">
        <div>
            <h2 class="adt-tw-text-base adt-tw-font-semibold adt-tw-text-gray-800 adt-tw-capitalize">
                {{ props.type }}
            </h2>
            <div class="adt-tw-text-xs adt-tw-text-gray-600">{{ __('IF...', 'woo-product-feed-pro') }}</div>
        </div>
        <button 
            type="button"
            class="adt-remove-filter-section adt-tw-bg-transparent adt-tw-border-none adt-tw-cursor-pointer"
            :aria-label="__('Remove section', 'woo-product-feed-pro')"
            @click="store.clearFilterSection(props.type)"
        >
            <span class="adt-tw-icon-[lucide--trash-2] adt-tw-size-4 adt-tw-text-gray-400 adt-tw-transition-colors hover:adt-tw-text-red-500"></span>
        </button>
    </div>
    <div class="adt-filter-section adt-tw-space-y-3" :data-section-type="props.type">
      <template v-for="(item, index) in sectionFilters" :key="item.id || index">
        <FilterGroup :group="item" :groupIndex="index" :section="props.type" />
      </template>
    </div>
    <div class="adt-tw-flex adt-tw-justify-center adt-tw-mt-2">
      <GroupDropdown :section="props.type" />
    </div>
  </div>
</template>

<style scoped lang="scss">
.adt-filter-section {
  // Custom styles if needed
}
</style> 
