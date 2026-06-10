<script setup lang="ts">
import { computed, ref, nextTick } from 'vue';
import { __ } from '@wordpress/i18n';
import { useRulesStore } from '../../stores/rulesStore';
import { useValidation } from '../../composables/useValidation';
import { getValidationClasses, getContainerValidationClasses, hasValidationErrors } from '../../helpers/validation';
import RuleGroup from '../groups/RuleGroup.vue';
import GroupDropdown from '../common/GroupDrowdown.vue';
import AttributeSelect from '../common/AttributeSelect.vue';
import FieldMappingSelect from '../common/FieldMappingSelect.vue';
import RuleAction from '../common/RuleAction.vue';
import { isEliteActive, showEliteUpsellModal } from '@/helpers';

const store = useRulesStore();
const { getFieldErrors } = useValidation('rules');

const props = defineProps<{
  ruleIndex: number;
  rule: any;
}>();

// Force update key for action components
const actionForceUpdateKey = ref<Record<string, number>>({});

// Get the condition groups within this specific rule
const ruleConditions = computed(() => {
  return props.rule.if || [];
});

// Get the actions for this rule
const ruleActions = computed(() => {
  return props.rule.then || [];
});

// Validation for actions
const getActionErrors = (actionId: string) => {
  return getFieldErrors(actionId);
};

const hasActionErrors = (actionId: string) => {
  return hasValidationErrors(getActionErrors(actionId));
};

const getActionErrorClasses = (baseClasses: string, actionId: string) => {
  return getValidationClasses(baseClasses, hasActionErrors(actionId));
};

const getActionContainerClasses = (action: any) => {
  const classes = getContainerValidationClasses(hasActionErrors(action.id));
  
  if ([ 'set_attribute', 'exclude' ].includes(action.action) && !isEliteActive()) {
    return `${classes} adt-disabled-action-container`;
  }

  return classes;
};

// Methods for updating actions
const updateActionAttribute = (actionId: string, value: string) => {
  store.updateRuleAction(props.rule.id, actionId, { attribute: value });
};

const updateActionValue = (actionId: string, value: string) => {
  store.updateRuleAction(props.rule.id, actionId, { value });
};

// Validation helper for numeric input
const isValidNumericValue = (value: string): boolean => {
  if (!value.trim()) return true; // Allow empty values (will be caught by required validation)
  const validNumericPattern = /^-?\d+(\.\d+)?$/;
  return validNumericPattern.test(value.trim());
};

// Get placeholder text based on action type
const getValuePlaceholder = (action: any): string => {
  if (['multiply', 'divide', 'minus', 'plus'].includes(action.action)) {
    return __('Enter numeric value (e.g., 2.5)', 'woo-product-feed-pro');
  }
  return __('Enter value', 'woo-product-feed-pro');
};

const updateAction = (action: any, value: string) => {
  // Map of Elite-only actions to their upsell modal keys
  const eliteOnlyActions: Record<string, string> = {
    'set_attribute': 'rule_action_set_attribute',
    'exclude': 'rule_action_exclude'
  };

  // Check if this is an Elite-only action and Elite is not active
  if (!isEliteActive() && eliteOnlyActions[value]) {
    // Show the upsell modal
    showEliteUpsellModal(eliteOnlyActions[value]);
    
    // Revert to previous value and force UI re-render
    const previousValue = action.action || 'set_value';
    if (previousValue !== value) {
      store.updateRuleAction(props.rule.id, action.id, { action: previousValue });
    }
    
    // Force re-render by incrementing the component key
    actionForceUpdateKey.value[action.id] = (actionForceUpdateKey.value[action.id] || 0) + 1;
    return;
  }

  // Normal action update
  store.updateRuleAction(props.rule.id, action.id, { action: value });
};

const updateActionFind = (actionId: string, value: string) => {
  store.updateRuleAction(props.rule.id, actionId, { find: value });
};

const removeAction = (actionId: string) => {
  store.removeRuleAction(props.rule.id, actionId);
};

const addAction = () => {
  store.addRuleAction(props.rule.id);
};

// Rule name editing state
const isEditingRuleName = ref(false);
const editingRuleName = ref('');
const ruleNameInput = ref<HTMLInputElement>();

const editRuleName = async () => {
  isEditingRuleName.value = true;
  editingRuleName.value = props.rule.name || `${props.ruleIndex + 1}`;
  await nextTick();
  ruleNameInput.value?.focus();
  ruleNameInput.value?.select();
};

const saveRuleName = () => {
  store.updateRule(props.rule.id, { name: editingRuleName.value });
  isEditingRuleName.value = false;
};

const cancelEditRuleName = () => {
  isEditingRuleName.value = false;
  editingRuleName.value = '';
};
</script>

<template>
  <div class="adt-rule-section-wrapper adt-tw-border-2 adt-tw-border-dashed adt-tw-border-pink-300 adt-tw-rounded-lg adt-tw-p-3">
    <div class="adt-tw-flex adt-tw-items-center adt-tw-justify-between adt-tw-mb-2">
      <div>
        <h2 class="adt-tw-text-base adt-tw-font-semibold adt-tw-text-gray-800 adt-tw-flex adt-tw-items-center adt-tw-gap-2">
          <!-- Display Mode -->
          <template v-if="!isEditingRuleName">
            {{ __('Rule', 'woo-product-feed-pro') }} - 
            <div class="adt-tw-flex adt-tw-items-center adt-tw-gap-2">
              <template v-if="props.rule.name">
                {{ props.rule.name }}
              </template>
              <template v-else>
                {{ props.ruleIndex + 1 }}
              </template>
            </div>
            <span
              class="adt-tw-icon-[lucide--pencil] adt-tw-size-3 adt-tw-text-gray-400 adt-tw-transition-colors hover:adt-tw-text-blue-500 adt-tw-cursor-pointer"
              @click="editRuleName"
              :title="__('Edit rule name', 'woo-product-feed-pro')"
            ></span>
          </template>

          <!-- Editing Mode -->
          <template v-else>
            <div class="adt-tw-flex adt-tw-items-center adt-tw-gap-2">
              <span class="adt-tw-text-gray-600">{{ __('Rule', 'woo-product-feed-pro') }} -</span>
              <input
                v-model="editingRuleName"
                type="text"
                class="adt-tw-px-2 adt-tw-py-1 adt-tw-border adt-tw-border-blue-300 adt-tw-rounded adt-tw-text-sm adt-tw-focus-ring-2 adt-tw-focus-ring-blue-500 adt-tw-focus-border-blue-500 adt-tw-focus-outline-none adt-tw-min-w-0 adt-tw-w-32"
                @keyup.enter="saveRuleName"
                @keyup.escape="cancelEditRuleName"
                @blur="saveRuleName"
                ref="ruleNameInput"
              />
              <span
                class="adt-tw-icon-[lucide--check] adt-tw-size-4 adt-tw-text-green-500 adt-tw-transition-colors hover:adt-tw-text-green-600 adt-tw-cursor-pointer"
                @click="saveRuleName"
                :title="__('Save rule name', 'woo-product-feed-pro')"
              ></span>
              <span
                class="adt-tw-icon-[lucide--x] adt-tw-size-4 adt-tw-text-gray-400 adt-tw-transition-colors hover:adt-tw-text-red-500 adt-tw-cursor-pointer"
                @click="cancelEditRuleName"
                :title="__('Cancel editing', 'woo-product-feed-pro')"
              ></span>
            </div>
          </template>
        </h2>
      </div>
      <button 
        type="button"
        class="adt-remove-rule-section adt-tw-bg-transparent adt-tw-border-none adt-tw-cursor-pointer"
        aria-label="Remove rule"
        @click="store.removeRule(props.rule.id)"
      >
        <span class="adt-tw-icon-[lucide--trash-2] adt-tw-size-4 adt-tw-text-gray-400 adt-tw-transition-colors hover:adt-tw-text-red-500"></span>
      </button>
    </div>

    <!-- IF Section -->
    <div class="adt-tw-mb-4">
      <div class="adt-tw-text-xs adt-tw-font-medium adt-tw-text-gray-600 adt-tw-mb-2">IF...</div>
      <div class="adt-rule-section adt-tw-space-y-3">
        <template v-for="(condition, conditionIndex) in ruleConditions" :key="condition.id || conditionIndex">
          <RuleGroup 
            :group="condition" 
            :groupIndex="conditionIndex" 
            :ruleId="props.rule.id" 
          />
        </template>
      </div>
      <div class="adt-tw-flex adt-tw-justify-center adt-tw-mt-2">
        <GroupDropdown section="rules" :ruleId="props.rule.id" />
      </div>
    </div>

    <!-- THEN Section -->
    <div class="adt-tw-border-t adt-tw-border-gray-200 adt-tw-pt-4">
      <div class="adt-tw-text-xs adt-tw-font-medium adt-tw-text-gray-600 adt-tw-mb-2">THEN...</div>
      <div class="adt-tw-space-y-2">
        <template v-for="action in ruleActions" :key="action.id">
          <div class="adt-tw-bg-white adt-tw-p-3 adt-tw-rounded-md adt-tw-border adt-tw-border-solid adt-tw-transition-all"
               :class="getActionContainerClasses(action)">
            
            <!-- Validation Error Banner -->
            <div v-if="hasActionErrors(action.id)" class="adt-tw-mb-3 adt-tw-p-2 adt-tw-bg-red-50 adt-tw-border adt-tw-border-red-200 adt-tw-rounded-md">
              <div class="adt-tw-flex adt-tw-items-center adt-tw-text-red-700">
                <span class="adt-tw-icon-[lucide--alert-circle] adt-tw-size-4 adt-tw-mr-2"></span>
                <div class="adt-tw-text-sm">
                  <div v-for="error in getActionErrors(action.id)" :key="error" class="adt-validation-error">
                    {{ error }}
                  </div>
                </div>
              </div>
            </div>
            
            <div class="adt-tw-grid adt-tw-grid-cols-12 adt-tw-gap-2 adt-tw-items-start adt-tw-pt-6 sm:adt-tw-pt-0 adt-tw-relative">
              
              <!-- Action Attribute -->
              <div class="adt-tw-col-span-12 md:adt-tw-col-span-4">
                <template v-if="[ 'exclude' ].includes(action.action)">
                  <FieldMappingSelect
                    :model-value="action.attribute || ''"
                    placeholder="Select field to exclude"
                    :has-error="hasActionErrors(action.id)"
                    @update:model-value="updateActionAttribute(action.id, $event)"
                  />
                </template>
                <template v-else>
                  <AttributeSelect
                    :model-value="action.attribute || ''"
                    placeholder="Select attribute"
                    store-type="rules"
                    :is-then-attributes="true"
                    :has-error="hasActionErrors(action.id)"
                    @update:model-value="updateActionAttribute(action.id, $event)"
                  />
                </template>
              </div>

              <!-- Action Action -->
              <div class="adt-tw-col-span-12 sm:adt-tw-col-span-3">
                <RuleAction
                  :key="`action-${action.id}-${actionForceUpdateKey[action.id] || 0}`"
                  :model-value="action.action || 'set_value'"
                  placeholder="Select action"
                  store-type="rules"
                  select-class="adt-rule-action-select adt-tw-w-full adt-tw-max-w-full adt-tw-px-2 adt-tw-py-1 adt-tw-border adt-tw-border-gray-300 adt-tw-rounded-md adt-tw-text-sm adt-tw-focus-ring-2 adt-tw-focus-ring-blue-500 adt-tw-focus-border-blue-500 adt-tw-focus-outline-none adt-tw-transition-all"
                  @update:model-value="updateAction(action, $event)"
                />
              </div>
              
              <!-- Action Value -->
              <div class="adt-tw-col-span-12 sm:adt-tw-col-span-4">
                <template v-if="[ 'set_attribute' ].includes(action.action)">
                  <AttributeSelect
                    :model-value="action.value || ''"
                    placeholder="Select attribute"
                    store-type="rules"
                    :has-error="hasActionErrors(action.id)"
                    @update:model-value="updateActionValue(action.id, $event)"
                  />
                </template>
                <template v-if="!['exclude', 'set_attribute'].includes(action.action)">
                  <div v-if="action.action === 'findreplace'">
                    <input
                      type="text"
                      :value="action.find || ''"
                      :class="getActionErrorClasses('adt-tw-w-full adt-tw-mb-2 adt-tw-px-2 adt-tw-py-1 adt-tw-border adt-tw-border-gray-300 adt-tw-rounded-md adt-tw-text-sm adt-tw-focus-ring-2 adt-tw-focus-ring-blue-500 adt-tw-focus-border-blue-500 adt-tw-focus-outline-none', action.id)"
                      placeholder="Enter find text"
                      @input="updateActionFind(action.id, ($event.target as HTMLInputElement).value)"
                    />
                  </div>
  
                  <input
                    type="text"
                    :value="action.value || ''"
                    :placeholder="getValuePlaceholder(action)"
                    :class="getActionErrorClasses('adt-tw-w-full adt-tw-px-2 adt-tw-py-1 adt-tw-border adt-tw-border-gray-300 adt-tw-rounded-md adt-tw-text-sm adt-tw-focus-ring-2 adt-tw-focus-ring-blue-500 adt-tw-focus-border-blue-500 adt-tw-focus-outline-none', action.id)"
                    @input="updateActionValue(action.id, ($event.target as HTMLInputElement).value)"
                  />
                </template>
              </div>

              <!-- Remove Action Button -->
              <div class="adt-remove-action-button adt-tw-absolute adt-tw-right-0 adt-tw-top-0 adt-tw-col-span-12 sm:adt-tw-col-span-1 sm:adt-tw-mt-1 adt-tw-mt-0 adt-tw-flex adt-tw-justify-end">
                <button 
                  type="button"
                  class="adt-tw-bg-transparent adt-tw-border-none adt-tw-cursor-pointer"
                  aria-label="Remove action"
                  @click="removeAction(action.id)"
                >
                  <span class="adt-tw-text-base sm:adt-tw-text-sm adt-tw-icon-[lucide--trash-2] adt-tw-text-gray-400 adt-tw-transition-colors hover:adt-tw-text-red-500"></span>
                </button>
              </div>
            </div>
          </div>
        </template>
      </div>
      
      <!-- Add Then Button -->
      <div class="adt-tw-flex adt-tw-justify-center adt-tw-mt-2">
        <button
          type="button"
          @click="addAction"
          class="adt-tw-border-none adt-tw-cursor-pointer adt-tw-flex adt-tw-items-center adt-tw-px-3 adt-tw-py-1.5 adt-tw-bg-blue-500 adt-tw-text-white adt-tw-rounded-md hover:adt-tw-bg-blue-600 adt-tw-transition-colors adt-tw-text-xs adt-tw-focus-outline-none adt-tw-focus-ring-2 adt-tw-focus-ring-blue-500 adt-tw-focus-ring-offset-1"
        >
          <span class="adt-tw-icon-[lucide--plus-circle] adt-tw-mr-1"></span>
          Add Then
        </button>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
.adt-disabled-action-container {
  .adt-attribute-select-container,
  .adt-field-mapping-select-container {
    opacity: 0.5;
    pointer-events: none !important;
    background-color: #f0f0f0;

    input.vs__search {
      background-color: #f0f0f0 !important;
    }
  }

}
</style> 
