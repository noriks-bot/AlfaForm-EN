import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import { __ } from '@wordpress/i18n';
import api from '@/api';

// Types specific to Rules
export interface RuleFieldData {
  condition?: string;
  value?: string | number | boolean;
  case_sensitive?: boolean;
  attribute?: string;
}

export interface RuleField {
  id: string;
  type: 'field' | 'logic';
  data: RuleFieldData | string; // string for logic type (e.g., 'and', 'or')
}

export interface RuleGroup {
  id: string;
  type: 'group';
  fields: RuleField[];
}

export interface RuleGroupLogic {
  id: string;
  type: 'group_logic';
  value: 'and' | 'or';
}

export type RuleConditionItem = RuleGroup | RuleGroupLogic;

export interface RuleAction {
  id: string;
  attribute: string;
  action: string;
  value: string | number | boolean;
  find?: string;
}

export interface Rule {
  id: string;
  name?: string;
  if: RuleConditionItem[];
  then: RuleAction[];
}

export interface AttributeGroup {
  [groupName: string]: {
    [attribute: string]: string;
  };
}

export interface FieldMappingItem {
  attribute: string;
  prefix?: string;
  suffix?: string;
  rowCount?: number;
}

export interface FieldMapping {
  [index: string]: FieldMappingItem;
}

export interface ConditionOption {
  value: string;
  label: string;
  group?: string;
}

export interface CategoryOption {
  value: string;
  label: string;
  name: string;
  slug: string;
}

export interface ActionOption {
  value: string;
  label: string;
}

/**
 * Pinia store for managing Rules
 * Handles the rules builder UI state and operations
 */
export const useRulesStore = defineStore('rules', () => {
  // State
  const loading = ref(false);
  const error = ref<string | null>(null);
  const feedId = ref<string | null>(null);
  const migrationRan = ref(false);

  // Core rules state matching schema
  const rules = ref<Rule[]>([]);

  // Metadata for dropdowns and options
  const attributes = ref<AttributeGroup>({});
  const thenAttributes = ref<AttributeGroup>({});
  const conditions = ref<ConditionOption[]>([]);
  const actions = ref<ActionOption[]>([]);
  const categories = ref<CategoryOption[]>([]);
  const fieldMapping = ref<FieldMapping>({});

  // Validation state (matching FiltersStore pattern)
  const validationErrors = ref<Record<string, string[]>>({});
  const showValidation = ref(false);

  // Getters
  const hasRules = computed(() => rules.value.length > 0);

  const getRuleById = computed(() => (ruleId: string) => rules.value.find((rule) => rule.id === ruleId));

  const getRuleGroups = computed(() => (ruleId: string) => {
    const rule = getRuleById.value(ruleId);
    return rule ? (rule.if.filter((item) => item.type === 'group') as RuleGroup[]) : [];
  });

  const getRuleGroupLogics = computed(() => (ruleId: string) => {
    const rule = getRuleById.value(ruleId);
    return rule ? (rule.if.filter((item) => item.type === 'group_logic') as RuleGroupLogic[]) : [];
  });

  // Validation getters (matching FiltersStore pattern)
  const isFormValid = computed(() => {
    // Only validate if showValidation is true
    if (!showValidation.value) {
      return true; // Consider form valid if validation hasn't been triggered yet
    }
    const validation = validateAllRules();
    return validation.isValid;
  });

  const getFieldErrors = computed(() => (fieldId: string) => {
    // Only show errors if validation has been triggered
    if (!showValidation.value) {
      return [];
    }
    return validationErrors.value[fieldId] || [];
  });

  const hasValidationErrors = computed(() => {
    // Only show errors if validation has been triggered
    if (!showValidation.value) {
      return false;
    }
    return Object.keys(validationErrors.value).length > 0;
  });

  // Actions

  /**
   * Normalize loaded rules data to ensure proper IDs and structure
   */
  const normalizeRulesData = (rulesData: any): Rule[] => {
    const normalized: Rule[] = [];

    if (rulesData && Array.isArray(rulesData)) {
      rulesData.forEach((rule: any, ruleIndex: number) => {
        const normalizedRule: Rule = {
          id: rule.id || `rule-${Date.now()}-${ruleIndex}`,
          name: rule.name || '',
          if: [],
          then: [],
        };

        // Normalize IF conditions
        if (rule.if && Array.isArray(rule.if)) {
          rule.if.forEach((condition: any, conditionIndex: number) => {
            if (condition.type === 'group') {
              const normalizedGroup: RuleGroup = {
                id: condition.id || `group-${Date.now()}-${conditionIndex}`,
                type: 'group',
                fields: [],
              };

              if (condition.fields && Array.isArray(condition.fields)) {
                condition.fields.forEach((field: any, fieldIndex: number) => {
                  const normalizedField: RuleField = {
                    id: field.id || `field-${Date.now()}-${fieldIndex}`,
                    type: field.type || 'field',
                    data: field.data || (field.type === 'logic' ? 'and' : {}),
                  };

                  normalizedGroup.fields.push(normalizedField);
                });
              }

              normalizedRule.if.push(normalizedGroup);
            } else if (condition.type === 'group_logic') {
              const normalizedLogic: RuleGroupLogic = {
                id: condition.id || `group-logic-${Date.now()}-${conditionIndex}`,
                type: 'group_logic',
                value: condition.value || 'and',
              };

              normalizedRule.if.push(normalizedLogic);
            }
          });
        }

        // Normalize THEN actions
        if (rule.then && Array.isArray(rule.then)) {
          rule.then.forEach((action: any, actionIndex: number) => {
            const normalizedAction: RuleAction = {
              id: action.id || `action-${Date.now()}-${actionIndex}`,
              attribute: action.attribute || '',
              action: action.action || 'set_value',
              value: action.value || '',
              find: action.find || '',
            };

            normalizedRule.then.push(normalizedAction);
          });
        }

        // Ensure each rule always has at least one empty group in the IF condition
        if (normalizedRule.if.length === 0 || normalizedRule.if.filter((item) => item.type === 'group').length === 0) {
          const timestamp = Date.now();
          const defaultGroup: RuleGroup = {
            id: `group-${timestamp}-${ruleIndex}`,
            type: 'group',
            fields: [],
          };
          normalizedRule.if = [defaultGroup];
        }

        normalized.push(normalizedRule);
      });
    }

    return normalized;
  };

  /**
   * Load rules data from API
   */
  const loadRules = async (id: string) => {
    try {
      loading.value = true;
      error.value = null;
      feedId.value = id;

      // Use 'new' for new feeds that don't have an ID yet
      const apiId = id === 'new' || !id ? 'new' : id;

      const response = await api().get(`adtribes/v1/filters-rules/${apiId}`, {
        params: { type: 'rules' },
      });

      // Load and normalize rules data
      if (response.data.rules) {
        rules.value = normalizeRulesData(response.data.rules);
      } else {
        rules.value = [];
      }

      // Ensure at least one rule exists with an empty group
      if (rules.value.length === 0) {
        addRule();
      }

      // Load attributes and conditions from the API response
      if (response.data.attributes) {
        attributes.value = response.data.attributes;
      }
      if (response.data.thenAttributes) {
        thenAttributes.value = response.data.thenAttributes;
      }
      if (response.data.conditions) {
        conditions.value = response.data.conditions;
      }
      if (response.data.actions) {
        actions.value = response.data.actions;
      }
      if (response.data.field_mapping) {
        fieldMapping.value = response.data.field_mapping;
      }

      // Load categories from the API response
      if (response.data.categories && Array.isArray(response.data.categories)) {
        categories.value = response.data.categories;
      } else {
        console.warn('Invalid categories data format received:', response.data.categories);
        categories.value = [];
      }

      if (response.data.migration_ran) {
        migrationRan.value = true;
      }
    } catch (err) {
      error.value = err instanceof Error ? err.message : 'Failed to load rules';
      console.error('Error loading rules:', err);
    } finally {
      loading.value = false;
    }
  };

  /**
   * Add a new rule
   */
  const addRule = () => {
    const timestamp = Date.now();
    const newRule: Rule = {
      id: `rule-${timestamp}`,
      name: '',
      if: [],
      then: [],
    };

    // Add an empty group by default (matching filters behavior)
    const defaultGroup: RuleGroup = {
      id: `group-${timestamp}`,
      type: 'group',
      fields: [],
    };
    newRule.if.push(defaultGroup);

    rules.value.push(newRule);

    // Clear validation when user adds new rules
    if (showValidation.value) {
      clearValidationErrors();
    }
  };

  /**
   * Remove a rule
   * If it's the last rule, clear its contents instead of removing it
   */
  const removeRule = (ruleId: string) => {
    // Count how many rules exist
    const ruleCount = rules.value.length;

    // If this is the last rule, clear its contents instead of removing it
    if (ruleCount === 1) {
      const rule = rules.value.find((r) => r.id === ruleId);
      if (rule) {
        // Clear contents but keep the rule structure
        rule.if = [];
        rule.then = [];

        // Add a default empty group to IF section
        const timestamp = Date.now();
        const defaultGroup: RuleGroup = {
          id: `group-${timestamp}`,
          type: 'group',
          fields: [],
        };
        rule.if.push(defaultGroup);
      }
    } else {
      // Remove the rule if it's not the last one
      rules.value = rules.value.filter((rule) => rule.id !== ruleId);
    }

    // Clear validation when user removes/clears rules
    if (showValidation.value) {
      clearValidationErrors();
    }
  };

  /**
   * Update a rule's properties (e.g., name)
   */
  const updateRule = (ruleId: string, updates: Partial<Rule>) => {
    const rule = getRuleById.value(ruleId);
    if (!rule) return;

    // Update the rule properties
    Object.assign(rule, updates);
  };

  /**
   * Add a new group to a rule's IF section
   */
  const addRuleGroup = (ruleId: string, logicType: 'and' | 'or' = 'and') => {
    const rule = rules.value.find((r) => r.id === ruleId);
    if (!rule) return;

    const timestamp = Date.now();

    // Add group logic if there are existing groups
    if (rule.if.length > 0) {
      const groupLogic: RuleGroupLogic = {
        id: `group-logic-${timestamp}`,
        type: 'group_logic',
        value: logicType,
      };
      rule.if.push(groupLogic);
    }

    // Add the new group with NO fields - let user add fields manually
    const newGroup: RuleGroup = {
      id: `group-${timestamp}`,
      type: 'group',
      fields: [],
    };

    rule.if.push(newGroup);

    // Clear validation when user adds new groups
    if (showValidation.value) {
      clearValidationErrors();
    }
  };

  /**
   * Remove a rule group from a rule's conditions
   * If it's the last group, clear its fields instead of removing it
   */
  const removeRuleGroup = (ruleId: string, groupId: string) => {
    const rule = getRuleById.value(ruleId);
    if (!rule) return;

    const index = rule.if.findIndex((item) => item.id === groupId);
    if (index === -1) return;

    // Count how many actual groups (not group_logic) exist in this rule
    const groupCount = rule.if.filter((item) => item.type === 'group').length;

    // If this is the last group, clear its fields instead of removing it
    if (groupCount === 1) {
      const group = rule.if[index] as RuleGroup;
      if (group.type === 'group') {
        // Clear all fields - let user add fields manually
        group.fields = [];
      }
    } else {
      // Remove the group if it's not the last one
      rule.if.splice(index, 1);

      // Clean up orphaned group logic
      cleanupRuleGroupLogic(rule);
    }

    // Clear validation when user removes groups
    if (showValidation.value) {
      clearValidationErrors();
    }
  };

  /**
   * Add a new field to a rule group
   */
  const addRuleField = (ruleId: string, groupId: string, fieldType: 'field' | 'logic' = 'field') => {
    const rule = rules.value.find((r) => r.id === ruleId);
    if (!rule) return;

    const group = rule.if.find((item) => item.id === groupId && item.type === 'group') as RuleGroup;
    if (!group) return;

    const timestamp = Date.now();

    // Add logic operator if there are existing fields and we're adding a field
    if (group.fields.length > 0 && fieldType === 'field') {
      const logicField: RuleField = {
        id: `logic-${timestamp}`,
        type: 'logic',
        data: 'and',
      };
      group.fields.push(logicField);
    }

    // Add the new field
    const newField: RuleField = {
      id: `field-${timestamp}`,
      type: fieldType,
      data:
        fieldType === 'logic'
          ? 'and'
          : {
              condition: 'contains',
              value: '',
              attribute: '',
            },
    };

    group.fields.push(newField);

    // Clear validation when user adds new fields
    if (showValidation.value) {
      clearValidationErrors();
    }
  };

  /**
   * Remove a field from a rule group
   */
  const removeRuleField = (ruleId: string, groupId: string, fieldId: string) => {
    const rule = getRuleById.value(ruleId);
    if (!rule) return;

    const group = rule.if.find((item) => item.id === groupId && item.type === 'group') as RuleGroup;
    if (!group) return;

    const fieldIndex = group.fields.findIndex((field) => field.id === fieldId);
    if (fieldIndex === -1) return;

    // Remove the field
    group.fields.splice(fieldIndex, 1);

    // Clean up orphaned logic operators
    cleanupRuleFieldLogic(group);
  };

  /**
   * Update a rule field's data
   */
  const updateRuleField = (ruleId: string, groupId: string, fieldId: string, updates: Partial<RuleField>) => {
    const rule = getRuleById.value(ruleId);
    if (!rule) return;

    const group = rule.if.find((item) => item.id === groupId && item.type === 'group') as RuleGroup;
    if (!group) return;

    const field = group.fields.find((f) => f.id === fieldId);
    if (!field) return;

    // Update the field
    Object.assign(field, updates);
  };

  /**
   * Update rule field data specifically
   */
  const updateRuleFieldData = (
    ruleId: string,
    groupId: string,
    fieldId: string,
    dataUpdates: Partial<RuleFieldData>
  ) => {
    const rule = getRuleById.value(ruleId);
    if (!rule) return;

    const group = rule.if.find((item) => item.id === groupId && item.type === 'group') as RuleGroup;
    if (!group) return;

    const field = group.fields.find((f) => f.id === fieldId);
    if (!field || field.type === 'logic') return;

    // Ensure data is an object
    if (typeof field.data !== 'object') {
      field.data = {};
    }

    // Update the field data
    Object.assign(field.data, dataUpdates);

    // Clear validation errors when user starts editing again
    if (showValidation.value) {
      if (validationErrors.value[fieldId]) {
        delete validationErrors.value[fieldId];
      }
    }
  };

  /**
   * Add a new rule action
   */
  const addRuleAction = (ruleId: string) => {
    const rule = getRuleById.value(ruleId);
    if (!rule) return;

    const timestamp = Date.now();

    const newAction: RuleAction = {
      id: `action-${timestamp}`,
      attribute: '',
      action: 'set_value',
      value: '',
      find: '',
    };

    rule.then.push(newAction);

    // Clear validation when user adds new actions
    if (showValidation.value) {
      clearValidationErrors();
    }
  };

  /**
   * Remove a rule action
   * If it's the last action, clear its contents instead of removing it
   */
  const removeRuleAction = (ruleId: string, actionId: string) => {
    const rule = getRuleById.value(ruleId);
    if (!rule) return;

    // Remove the action
    const index = rule.then.findIndex((action) => action.id === actionId);
    if (index !== -1) {
      rule.then.splice(index, 1);
    }

    // Clear validation when user removes/clears actions
    if (showValidation.value) {
      clearValidationErrors();
    }
  };

  /**
   * Update a rule action
   */
  const updateRuleAction = (ruleId: string, actionId: string, updates: Partial<RuleAction>) => {
    const rule = getRuleById.value(ruleId);
    if (!rule) return;

    const action = rule.then.find((a) => a.id === actionId);
    if (!action) return;

    // Update the action
    Object.assign(action, updates);

    // Clear validation errors when user starts editing again
    if (showValidation.value) {
      if (validationErrors.value[actionId]) {
        delete validationErrors.value[actionId];
      }
    }
  };

  /**
   * Clean up orphaned group logic operators in a rule
   */
  const cleanupRuleGroupLogic = (rule: Rule) => {
    const items = rule.if;

    // Remove group logic at the beginning or end
    if (items.length > 0 && items[0].type === 'group_logic') {
      items.shift();
    }
    if (items.length > 0 && items[items.length - 1].type === 'group_logic') {
      items.pop();
    }

    // Remove consecutive group logic operators
    for (let i = items.length - 2; i >= 0; i--) {
      if (items[i].type === 'group_logic' && items[i + 1].type === 'group_logic') {
        items.splice(i, 1);
      }
    }
  };

  /**
   * Clean up orphaned field logic operators within a rule group
   */
  const cleanupRuleFieldLogic = (group: RuleGroup) => {
    const fields = group.fields;

    // Remove logic at the beginning or end
    if (fields.length > 0 && fields[0].type === 'logic') {
      fields.shift();
    }
    if (fields.length > 0 && fields[fields.length - 1].type === 'logic') {
      fields.pop();
    }

    // Remove consecutive logic operators
    for (let i = fields.length - 2; i >= 0; i--) {
      if (fields[i].type === 'logic' && fields[i + 1].type === 'logic') {
        fields.splice(i, 1);
      }
    }
  };

  /**
   * Validate a rule field
   */
  const validateRuleField = (field: RuleField): string[] => {
    const errors: string[] = [];

    if (field.type === 'field' && typeof field.data === 'object') {
      const fieldData = field.data as RuleFieldData;

      // Required field validations
      if (!fieldData.attribute) {
        errors.push(__('Attribute is required', 'woo-product-feed-pro'));
      }
      if (!fieldData.condition) {
        errors.push(__('Condition is required', 'woo-product-feed-pro'));
      }

      // Value validation based on condition
      const noValueConditions = ['is_empty', 'is_not_empty'];
      if (fieldData.condition && !noValueConditions.includes(fieldData.condition)) {
        if (!fieldData.value && fieldData.value !== 0) {
          errors.push(__('Value is required for this condition', 'woo-product-feed-pro'));
        }
      }
    }

    return errors;
  };

  /**
   * Validate a rule group
   */
  const validateRuleGroup = (group: RuleGroup): string[] => {
    const errors: string[] = [];

    // If group has no fields, it's valid (empty initial state)
    if (!group.fields || group.fields.length === 0) {
      return errors; // No errors for empty groups
    }

    // Check if group has any actual field conditions
    const fieldFields = group.fields.filter((field) => field.type === 'field');
    if (fieldFields.length === 0) {
      return errors; // No errors for groups with no actual fields
    }

    // Check if any field has actual data (not just empty placeholders)
    const hasActualData = fieldFields.some((field) => {
      if (field.type === 'field' && typeof field.data === 'object') {
        const fieldData = field.data as RuleFieldData;
        return fieldData.attribute || fieldData.condition || fieldData.value;
      }
      return false;
    });

    // If no actual data, don't validate (allow empty state)
    if (!hasActualData) {
      return errors;
    }

    // Validate each field only if group has actual data
    group.fields.forEach((field) => {
      const fieldErrors = validateRuleField(field);
      errors.push(...fieldErrors);
    });

    return errors;
  };

  /**
   * Validate a complete rule
   */
  const validateRule = (rule: Rule): string[] => {
    const errors: string[] = [];

    // Validate IF conditions
    if (!rule.if || rule.if.length === 0) {
      return errors; // Allow empty if conditions (initial state)
    }

    const conditionGroups = rule.if.filter((item) => item.type === 'group') as RuleGroup[];
    if (conditionGroups.length === 0) {
      return errors; // Allow no condition groups (initial state)
    }

    // Validate each group only if we have actual field data
    conditionGroups.forEach((group) => {
      const groupErrors = validateRuleGroup(group);
      errors.push(...groupErrors);
    });

    rule.then.forEach((action) => {
      // Only validate actions that have some data
      if (!action.attribute) {
        errors.push(__('Action attribute is required', 'woo-product-feed-pro'));
      }

      if (action.action === 'findreplace') {
        if (!action.find) {
          errors.push(__('Action find text is required', 'woo-product-feed-pro'));
        }
      } else if (['multiply', 'divide', 'minus', 'plus'].includes(action.action)) {
        if (!action.value && action.value !== 0) {
          errors.push(__('Action value is required', 'woo-product-feed-pro'));
        } else if (action.value) {
          // Validate numeric value format - only allow numbers with period as decimal separator
          const numericValue = String(action.value).trim();
          const validNumericPattern = /^-?\d+(\.\d+)?$/;

          if (!validNumericPattern.test(numericValue)) {
            if (numericValue.includes(',')) {
              errors.push(
                __(
                  'Invalid decimal format. Use period (.) instead of comma (,) for decimal numbers (e.g., 2.5 instead of 2,5)',
                  'woo-product-feed-pro'
                )
              );
            } else {
              errors.push(
                __(
                  'Invalid numeric value. Only numbers with period (.) as decimal separator are allowed',
                  'woo-product-feed-pro'
                )
              );
            }
          } else {
            // Additional validation for mathematical operations
            const parsedValue = parseFloat(numericValue);
            if (isNaN(parsedValue)) {
              errors.push(__('Invalid numeric value', 'woo-product-feed-pro'));
            } else if (action.action === 'divide' && parsedValue === 0) {
              errors.push(__('Division by zero is not allowed', 'woo-product-feed-pro'));
            }
          }
        }
      }
    });

    return errors;
  };

  /**
   * Validate all rules
   */
  const validateAllRules = (): { isValid: boolean; errors: Record<string, string[]> } => {
    const allErrors: Record<string, string[]> = {};

    rules.value.forEach((rule) => {
      const ruleErrors = validateRule(rule);
      if (ruleErrors.length > 0) {
        allErrors[rule.id] = ruleErrors;
      }
    });

    return {
      isValid: Object.keys(allErrors).length === 0,
      errors: allErrors,
    };
  };

  /**
   * Update validation errors for UI display
   */
  const updateValidationErrors = () => {
    showValidation.value = true;

    // Convert rule-based errors to field-based errors for UI
    const fieldValidationErrors: Record<string, string[]> = {};

    rules.value.forEach((rule) => {
      // Only validate fields that have some data
      rule.if.forEach((conditionItem) => {
        if (conditionItem.type === 'group') {
          const group = conditionItem as RuleGroup;
          group.fields.forEach((field) => {
            if (field.type === 'field' && typeof field.data === 'object') {
              const fieldData = field.data as RuleFieldData;

              // Only validate fields with some data
              if (fieldData.attribute || fieldData.condition || fieldData.value) {
                const fieldErrors = validateRuleField(field);
                if (fieldErrors.length > 0) {
                  fieldValidationErrors[field.id] = fieldErrors;
                }
              }
            }
          });
        }
      });

      // Only validate actions if there are actual field conditions with data
      rule.then.forEach((action) => {
        const actionErrors: string[] = [];
        if (!action.attribute) {
          actionErrors.push(__('Action attribute is required', 'woo-product-feed-pro'));
        }

        if (action.action === 'findreplace') {
          if (!action.find) {
            actionErrors.push(__('Action find text is required', 'woo-product-feed-pro'));
          }
        } else if (['multiply', 'divide', 'minus', 'plus'].includes(action.action)) {
          if (!action.value && action.value !== 0) {
            actionErrors.push(__('Action value is required', 'woo-product-feed-pro'));
          } else if (action.value) {
            // Validate numeric value format - only allow numbers with period as decimal separator
            const numericValue = String(action.value).trim();
            const validNumericPattern = /^-?\d+(\.\d+)?$/;

            if (!validNumericPattern.test(numericValue)) {
              if (numericValue.includes(',')) {
                actionErrors.push(
                  __(
                    'Invalid decimal format. Use period (.) instead of comma (,) for decimal numbers (e.g., 2.5 instead of 2,5)',
                    'woo-product-feed-pro'
                  )
                );
              } else {
                actionErrors.push(
                  __(
                    'Invalid numeric value. Only numbers with period (.) as decimal separator are allowed',
                    'woo-product-feed-pro'
                  )
                );
              }
            } else {
              // Additional validation for mathematical operations
              const parsedValue = parseFloat(numericValue);
              if (isNaN(parsedValue)) {
                actionErrors.push(__('Invalid numeric value', 'woo-product-feed-pro'));
              } else if (action.action === 'divide' && parsedValue === 0) {
                actionErrors.push(__('Division by zero is not allowed', 'woo-product-feed-pro'));
              }
            }
          }
        }

        if (actionErrors.length > 0) {
          fieldValidationErrors[action.id] = actionErrors;
        }
      });
    });

    validationErrors.value = fieldValidationErrors;
  };

  /**
   * Clear validation errors
   */
  const clearValidationErrors = () => {
    validationErrors.value = {};
    showValidation.value = false;
  };

  /**
   * Clear all rules
   */
  const clearRules = () => {
    rules.value = [];

    // Add a default rule with an empty group
    addRule();

    // Clear validation when rules are cleared
    clearValidationErrors();
  };

  /**
   * Reset store to initial state
   */
  const resetStore = () => {
    loading.value = false;
    error.value = null;
    feedId.value = null;
    clearRules(); // This will also clear validation
    attributes.value = {};
    thenAttributes.value = {};
    conditions.value = [];
    actions.value = [];
    categories.value = [];
  };

  return {
    // State
    loading,
    error,
    feedId,
    rules,
    attributes,
    thenAttributes,
    conditions,
    actions,
    fieldMapping,
    categories,
    migrationRan,

    // Getters
    hasRules,
    getRuleById,
    getRuleGroups,
    getRuleGroupLogics,

    // Validation
    isFormValid,
    getFieldErrors,
    hasValidationErrors,

    // Actions
    loadRules,
    addRule,
    removeRule,
    updateRule,
    addRuleGroup,
    removeRuleGroup,
    addRuleField,
    removeRuleField,
    updateRuleField,
    updateRuleFieldData,
    addRuleAction,
    removeRuleAction,
    updateRuleAction,
    clearRules,
    resetStore,

    // Validation
    validateRuleField,
    validateRuleGroup,
    validateRule,
    validateAllRules,
    updateValidationErrors,
    clearValidationErrors,

    // Validation state
    validationErrors,
    showValidation,
  };
});
