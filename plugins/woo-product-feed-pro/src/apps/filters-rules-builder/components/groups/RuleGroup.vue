<script setup lang="ts">
import { useRulesStore } from '../../stores/rulesStore';
import RuleItem from '../items/RuleItem.vue';
import LogicOperator from '../common/LogicOperator.vue';
import type { RuleGroupProps } from '../../types';

const props = defineProps<RuleGroupProps>();
const store = useRulesStore();
</script>

<template>
  <div class="adt-rule-group adt-tw-relative" 
       :class="{ 'adt-logic-operator': props.group.type === 'group_logic' }"
       :data-index="props.groupIndex">
    
    <!-- Group Logic Display -->
    <template v-if="props.group.type === 'group_logic'">
      <div class="adt-tw-flex adt-tw-justify-center adt-tw-my-2">
        <span class="adt-tw-px-2 adt-tw-py-0.5 adt-tw-bg-gray-100 adt-tw-text-gray-600 adt-tw-text-xs adt-tw-font-medium adt-tw-rounded-md">
          {{ ((props.group as any).value || 'and').toUpperCase() }}
        </span>
      </div>
    </template>
    
    <!-- Regular Group -->
    <template v-else>
      <div class="adt-tw-border-2 adt-tw-border-dashed adt-tw-border-blue-300 adt-tw-rounded-lg adt-tw-p-3 adt-tw-transition-all adt-tw-animate-fadeIn">
        <div class="adt-tw-flex adt-tw-justify-end">
          <button 
            type="button"
            class="adt-remove-rule-group adt-tw-p-0 adt-tw-m-0 adt-tw-mb-2 adt-tw-bg-transparent adt-tw-border-none adt-tw-cursor-pointer adt-tw-z-10"
            aria-label="Remove rule group"
            @click="store.removeRuleGroup(props.ruleId, props.group.id)"
          >
            <span class="adt-tw-icon-[lucide--trash-2] adt-tw-size-4 adt-tw-text-gray-400 adt-tw-transition-colors hover:adt-tw-text-red-500"></span>
          </button>
        </div>

        <div class="adt-rule-group-fields adt-tw-space-y-2">
          <template v-for="(field, fieldIndex) in (props.group as any).fields" :key="field.id">
            <template v-if="field.type === 'field'">
              <RuleItem :item="field" :fieldIndex="fieldIndex" :groupId="props.group.id" :ruleId="props.ruleId" :groupIndex="props.groupIndex" />
            </template>
            <template v-if="field.type === 'logic'">
              <LogicOperator :operator="field.data as string" />
            </template>
          </template>
        </div>
        
        <div class="adt-tw-mt-3 adt-tw-flex adt-tw-justify-center">
          <button
            type="button"
            @click="store.addRuleField(props.ruleId, props.group.id)"
            class="adt-add-new-rule adt-tw-border-none adt-tw-cursor-pointer adt-tw-flex adt-tw-items-center adt-tw-px-3 adt-tw-py-1.5 adt-tw-bg-blue-500 adt-tw-text-white adt-tw-rounded-md hover:adt-tw-bg-blue-600 adt-tw-transition-colors adt-tw-text-xs adt-tw-focus-outline-none adt-tw-focus-ring-2 adt-tw-focus-ring-blue-500 adt-tw-focus-ring-offset-1"
          >
            <span class="adt-tw-icon-[lucide--plus-circle] adt-tw-mr-1"></span>
            Add New "AND" Condition
          </button>
        </div>
      </div>
    </template>
  </div>
</template>

<style scoped lang="scss">
.adt-rule-group {
  &:hover {
    @apply adt-tw-border-blue-400 adt-tw-shadow-sm;
  }
}
</style> 
