<script setup lang="ts">
import { computed } from 'vue';
import { useRulesStore } from '../../stores/rulesStore';
import { useValidation } from '../../composables/useValidation';
import { getValidationClasses, getContainerValidationClasses, hasValidationErrors } from '../../helpers/validation';
import type { RuleItemProps } from '../../types';
import AttributeSelect from '../common/AttributeSelect.vue';
import ConditionSelect from '../common/ConditionSelect.vue';
import { __ } from '@wordpress/i18n';
import ValueInput from '../common/ValueInput.vue';

const props = defineProps<RuleItemProps>();
const store = useRulesStore();
const { getFieldErrors } = useValidation('rules');

// Type guard to check if data is an object (field data) vs string (logic data)
const isFieldData = (data: any): data is { condition?: string; value?: string; case_sensitive?: boolean; attribute?: string; action?: string } => {
  return typeof data === 'object' && data !== null;
};

// Computed properties
const showValueInput = computed(() => {
  if (!isFieldData(props.item.data)) return false;
  const condition = props.item.data.condition;
  const noValueConditions = ['is_empty', 'is_not_empty'];
  return condition && !noValueConditions.includes(condition);
});

const showCaseSensitive = computed(() => {
  if (!isFieldData(props.item.data)) return false;
  const condition = props.item.data.condition;
  const noCaseSensitiveConditions = ['is_empty', 'is_not_empty'];
  return condition && !noCaseSensitiveConditions.includes(condition);
});

// Validation
const fieldErrors = computed(() => {
  if (props.item.type === 'logic') return [];
  return getFieldErrors(props.item.id);
});

const hasErrors = computed(() => hasValidationErrors(fieldErrors.value));

const getFieldErrorClasses = (baseClasses: string) => {
  return getValidationClasses(baseClasses, hasErrors.value);
};

const getContainerClasses = () => {
  return getContainerValidationClasses(hasErrors.value);
};

// Methods for updating field data
const updateFieldValue = (value: string) => {
  store.updateRuleFieldData(props.ruleId, props.groupId, props.item.id, { value });
};

const updateFieldCondition = (value: string) => {
  store.updateRuleFieldData(props.ruleId, props.groupId, props.item.id, { condition: value });
};

const updateAttribute = (value: string) => {
  store.updateRuleFieldData(props.ruleId, props.groupId, props.item.id, { attribute: value });
  // Reset the value when attribute changes
  store.updateRuleFieldData(props.ruleId, props.groupId, props.item.id, { value: '' });
};

const updateCaseSensitive = (event: Event) => {
  const target = event.target as HTMLInputElement;
  store.updateRuleFieldData(props.ruleId, props.groupId, props.item.id, { case_sensitive: target.checked });
};
</script>

<template>
  <div class="adt-rule-item" 
       :class="{ 'adt-logic-operator': item.type === 'logic' }"
       :data-index="props.fieldIndex">
    
    <!-- Logic Operator -->
    <template v-if="item.type === 'logic'">
      <div class="adt-tw-flex adt-tw-justify-center adt-tw-my-2">
        <span class="adt-tw-px-2 adt-tw-py-0.5 adt-tw-bg-gray-100 adt-tw-text-gray-600 adt-tw-text-xs adt-tw-font-medium adt-tw-rounded-md">
          {{ (item.data as string).toUpperCase() }}
        </span>
      </div>
    </template>
    
    <!-- Rule Item -->
    <template v-else>
      <div class="adt-tw-bg-white adt-tw-p-3 adt-tw-rounded-md adt-tw-border adt-tw-border-solid adt-tw-transition-all adt-tw-hover-shadow-md adt-tw-relative" 
           :class="getContainerClasses()">      
        
        <!-- Validation Error Banner -->
        <div v-if="hasErrors" class="adt-tw-mb-3 adt-tw-p-2 adt-tw-bg-red-50 adt-tw-border adt-tw-border-red-200 adt-tw-rounded-md">
          <div class="adt-tw-flex adt-tw-items-center adt-tw-text-red-700">
            <span class="adt-tw-icon-[lucide--alert-circle] adt-tw-size-4 adt-tw-mr-2"></span>
            <div class="adt-tw-text-sm">
              <div v-for="error in fieldErrors" :key="error" class="adt-validation-error">
                {{ error }}
              </div>
            </div>
          </div>
        </div>
        
        <div class="adt-tw-grid adt-tw-grid-cols-12 adt-tw-gap-2 adt-tw-items-center adt-rule-grid adt-tw-pt-6 sm:adt-tw-pt-0">
          
          <!-- Attribute Selection -->
          <div class="adt-tw-col-span-12 md:adt-tw-col-span-4 adt-rule-item-attribute-container">
            <AttributeSelect
              v-if="isFieldData(item.data)"
              :model-value="item.data.attribute || ''"
              placeholder="Select attribute"
              store-type="rules"
              :has-error="hasErrors"
              @update:model-value="updateAttribute"
            />
          </div>
          
          <!-- Condition Selection -->
          <div class="adt-tw-col-span-12 sm:adt-tw-col-span-3 adt-rule-condition-container">
            <ConditionSelect
              v-if="isFieldData(item.data)"
              :model-value="item.data.condition || ''"
              placeholder="Select condition"
              select-class="adt-rule-condition-select adt-tw-w-full adt-tw-max-w-full adt-tw-px-2 adt-tw-py-1 adt-tw-border adt-tw-border-gray-300 adt-tw-rounded-md adt-tw-text-sm adt-tw-focus-ring-2 adt-tw-focus-ring-blue-500 adt-tw-focus-border-blue-500 adt-tw-focus-outline-none adt-tw-transition-all"
              store-type="rules"
              @update:model-value="updateFieldCondition"
            />
          </div>
          
          <!-- Value Input -->
          <div class="adt-tw-col-span-10 sm:adt-tw-col-span-4 adt-rule-value-container adt-tw-transition-all">
            <ValueInput
              v-if="isFieldData(item.data) && showValueInput"
              :model-value="typeof item.data.value === 'boolean' ? '' : (item.data.value || '')"
              :placeholder="(item.data.attribute === 'categories' || item.data.attribute === 'raw_categories') ? 'Select category' : 'Enter value'"
              :attribute="item.data.attribute || ''"
              :categories="store.categories"
              :input-class="getFieldErrorClasses('adt-filter-value-input adt-tw-w-full adt-tw-max-w-full adt-tw-px-2 adt-tw-py-1 adt-tw-border adt-tw-border-gray-300 adt-tw-rounded-md adt-tw-text-sm adt-tw-focus-ring-2 adt-tw-focus-ring-blue-500 adt-tw-focus-border-blue-500 adt-tw-focus-outline-none adt-tw-transition-all')"
              @update:model-value="updateFieldValue"
            />
          </div>
          
          <!-- Actions Container -->
          <div class="adt-tw-col-span-2 sm:adt-tw-col-span-1 sm:adt-tw-mt-0 adt-tw-mt-2 adt-tw-flex adt-tw-items-center adt-tw-justify-between adt-tw-space-x-2 adt-rule-actions-container">
            <div class="adt-tw-flex adt-tw-items-center adt-tw-gap-1">
              <div v-if="showCaseSensitive" class="adt-tw-flex adt-tw-items-center adt-tw-gap-1 adt-case-sensitive-container" :title="__('Case Sensitive', 'woo-product-feed-pro')">
                <input
                  v-if="isFieldData(item.data)"
                  type="checkbox"
                  :id="`rule_case_sensitive_${props.fieldIndex}`"
                  :checked="item.data.case_sensitive || false"
                  @change="updateCaseSensitive($event)"
                  class="adt-tw-text-blue-600 adt-tw-rounded adt-tw-border-gray-300 adt-tw-focus-ring-blue-500"
                />
                <label 
                  :for="`rule_case_sensitive_${props.fieldIndex}`"
                  class="adt-tw-text-xs adt-tw-text-gray-600 adt-tw-whitespace-nowrap adt-tw-cursor-pointer"
                >
                  Aa
                </label>
              </div>
            </div>
            <button 
              type="button"
              class="adt-tw-absolute adt-tw-right-2 adt-tw-top-2 sm:adt-tw-static sm:adt-tw-w-auto adt-remove-rule-item adt-tw-bg-transparent adt-tw-border-none adt-tw-cursor-pointer"
              aria-label="Remove rule"
              @click="store.removeRuleField(props.ruleId, props.groupId, props.item.id)"
            >
              <span class="adt-tw-text-base sm:adt-tw-text-sm adt-tw-icon-[lucide--trash-2] adt-tw-text-gray-400 adt-tw-transition-colors hover:adt-tw-text-red-500"></span>
            </button>
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<style lang="scss">
.adt-rule-item-attribute-container {
  .adt-attribute-select-container {
    // Allow the component's own border styling to take precedence
    .vs__search {
      border: none;
      margin-top: 0;
      font-size: 0.875rem;
      line-height: 1.25rem;
      padding: 0 8px;
      
      &:focus {
        margin-top: 0;
        box-shadow: none;
        border: none;
        font-size: 0.875rem;
      }
    }
  }
}
</style> 
