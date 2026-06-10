<script setup lang="ts">
import { useFiltersStore } from '../../stores/filtersStore';
import { useRulesStore } from '../../stores/rulesStore';
import { __ } from '@wordpress/i18n';
import type { SectionType } from '../../types';

interface Props {
  section: SectionType | 'rules';
  ruleId?: string; // For when adding groups within a specific rule
}

const props = defineProps<Props>();
const filtersStore = useFiltersStore();
const rulesStore = useRulesStore();

const addGroup = (logicType: 'and' | 'or') => {
  if (props.section === 'rules' && props.ruleId) {
    // Add a new group within the specific rule
    rulesStore.addRuleGroup(props.ruleId, logicType);
  } else if (props.section === 'rules') {
    // Add a new rule (when used in RulesBuilder)
    rulesStore.addRule();
  } else {
    // Add a filter group
    filtersStore.addFilterGroup(props.section, logicType);
  }
};
</script>

<template>
  <div class="adt-group-dropdown adt-tw-relative adt-tw-group">
    <button
      type="button"
      class="adt-tw-border-none adt-tw-cursor-pointer adt-tw-flex adt-tw-items-center adt-tw-px-2 adt-tw-py-1 adt-tw-bg-gray-100 adt-tw-text-gray-700 adt-tw-rounded-md adt-tw-hover-bg-gray-200 adt-tw-transition-colors adt-tw-text-xs adt-tw-group"
    >
      <span class="adt-tw-icon-[lucide--plus-circle] adt-tw-mr-1 adt-tw-size-3"></span>
      {{ __('Add Group', 'woo-product-feed-pro') }}
      <span class="adt-tw-icon-[lucide--chevron-down] adt-tw-ml-1 adt-tw-transition-transform group-hover:adt-tw-rotate-180"></span>
    </button>

    <div v-if="section !== 'rules' || ruleId" class="adt-tw-hidden group-hover:adt-tw-block adt-tw-absolute adt-tw-bottom-full adt-tw-left-0 adt-tw-bg-white adt-tw-rounded-md adt-tw-shadow-lg adt-tw-border adt-tw-border-gray-200 adt-tw-py-1 adt-tw-min-w-[120px]">
      <button
        type="button"
        @click="addGroup('and')"
        class="adt-add-group-and adt-tw-bg-transparent adt-tw-cursor-pointer adt-tw-border-none adt-tw-w-full adt-tw-px-3 adt-tw-py-1.5 adt-tw-text-left adt-tw-text-sm hover:adt-tw-bg-gray-50 adt-tw-text-gray-700"
      >
        {{ __('AND Group', 'woo-product-feed-pro') }}
      </button>
      <button
        type="button"
        @click="addGroup('or')"
        class="adt-add-group-or adt-tw-bg-transparent adt-tw-cursor-pointer adt-tw-border-none adt-tw-w-full adt-tw-px-3 adt-tw-py-1.5 adt-tw-text-left adt-tw-text-sm hover:adt-tw-bg-gray-50 adt-tw-text-gray-700"
      >
        {{ __('OR Group', 'woo-product-feed-pro') }}
      </button>
    </div>
    
    <!-- For rules without ruleId, just add group directly -->
    <div v-else class="adt-tw-hidden group-hover:adt-tw-block adt-tw-absolute adt-tw-bottom-full adt-tw-left-0 adt-tw-bg-white adt-tw-rounded-md adt-tw-shadow-lg adt-tw-border adt-tw-border-gray-200 adt-tw-py-1 adt-tw-min-w-[120px]">
      <button
        type="button"
        @click="addGroup('and')"
        class="adt-add-rule adt-tw-bg-transparent adt-tw-cursor-pointer adt-tw-border-none adt-tw-w-full adt-tw-px-3 adt-tw-py-1.5 adt-tw-text-left adt-tw-text-sm hover:adt-tw-bg-gray-50 adt-tw-text-gray-700"
      >
        {{ __('Add Group', 'woo-product-feed-pro') }}
      </button>
    </div>
  </div>
</template>
