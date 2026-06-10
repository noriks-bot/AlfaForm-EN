import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import { __ } from '@wordpress/i18n';
import api from '@/api';

// Types specific to Filters
export interface FilterFieldData {
  condition?: string;
  value?: string | number | boolean;
  case_sensitive?: boolean;
  attribute?: string;
}

export interface FilterField {
  id: string;
  type: 'field' | 'logic';
  data: FilterFieldData | string; // string for logic type (e.g., 'and', 'or')
}

export interface FilterGroup {
  id: string;
  type: 'group';
  fields: FilterField[];
}

export interface FilterGroupLogic {
  id: string;
  type: 'group_logic';
  value: 'and' | 'or';
}

export type FilterItem = FilterGroup | FilterGroupLogic;

export interface FiltersState {
  include: FilterItem[];
  exclude: FilterItem[];
}

export interface AttributeGroup {
  [groupName: string]: {
    [attribute: string]: string;
  };
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

/**
 * Pinia store for managing Filters
 * Handles the filter builder UI state and operations
 */
export const useFiltersStore = defineStore('filters', () => {
  // State
  const loading = ref(false);
  const error = ref<string | null>(null);
  const feedId = ref<string | null>(null);
  const migrationRan = ref(false);

  // Core filters state matching schema
  const filters = ref<FiltersState>({
    include: [],
    exclude: [],
  });

  // Metadata for dropdowns and options
  const attributes = ref<AttributeGroup>({});
  const conditions = ref<ConditionOption[]>([]);
  const categories = ref<CategoryOption[]>([]);

  // Getters
  const hasFilters = computed(() => filters.value.include.length > 0 || filters.value.exclude.length > 0);

  const hasIncludeFilters = computed(() => filters.value.include.length > 0);
  const hasExcludeFilters = computed(() => filters.value.exclude.length > 0);

  const getFilterGroups = computed(
    () => (section: 'include' | 'exclude') =>
      (filters.value[section] || []).filter((item) => item.type === 'group') as FilterGroup[]
  );

  const getFilterGroupLogics = computed(
    () => (section: 'include' | 'exclude') =>
      (filters.value[section] || []).filter((item) => item.type === 'group_logic') as FilterGroupLogic[]
  );

  // Validation state
  const validationErrors = ref<Record<string, string[]>>({});
  const showValidation = ref(false);

  // Validation getters
  const isFormValid = computed(() => {
    // Only validate if showValidation is true
    if (!showValidation.value) {
      return true; // Consider form valid if validation hasn't been triggered yet
    }
    const errors = validateAllFields();
    return Object.keys(errors).length === 0;
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
   * Normalize loaded filters data to ensure proper IDs and structure
   */
  const normalizeFiltersData = (filtersData: any): FiltersState => {
    const normalized: FiltersState = {
      include: [],
      exclude: [],
    };

    // Normalize each section
    ['include', 'exclude'].forEach((section) => {
      if (filtersData[section] && Array.isArray(filtersData[section])) {
        filtersData[section].forEach((item: any, itemIndex: number) => {
          if (item.type === 'group') {
            const normalizedGroup: FilterGroup = {
              id: item.id || `group-${Date.now()}-${itemIndex}`,
              type: 'group',
              fields: [],
            };

            if (item.fields && Array.isArray(item.fields)) {
              item.fields.forEach((field: any, fieldIndex: number) => {
                const normalizedField: FilterField = {
                  id: field.id || `field-${Date.now()}-${fieldIndex}`,
                  type: field.type || 'field',
                  data: field.data || {},
                };

                // Ensure data is an object for field types
                if (normalizedField.type === 'field' && typeof normalizedField.data === 'object') {
                  const fieldData = normalizedField.data as FilterFieldData;

                  // Handle attribute field - ensure it's in data
                  if (field.attribute) {
                    // Move top-level attribute to data for compatibility
                    fieldData.attribute = field.attribute;
                  } else if (!fieldData.attribute && field.data && field.data.attribute) {
                    // Attribute is already in the right place
                    fieldData.attribute = field.data.attribute;
                  }
                }

                normalizedGroup.fields.push(normalizedField);
              });
            }

            (normalized[section as keyof FiltersState] as FilterItem[]).push(normalizedGroup);
          } else if (item.type === 'group_logic') {
            const normalizedLogic: FilterGroupLogic = {
              id: item.id || `group-logic-${Date.now()}-${itemIndex}`,
              type: 'group_logic',
              value: item.value || 'and',
            };

            (normalized[section as keyof FiltersState] as FilterItem[]).push(normalizedLogic);
          }
        });
      }
    });

    return normalized;
  };

  /**
   * Load filters data from API
   */
  const loadFilters = async (id: string) => {
    try {
      loading.value = true;
      error.value = null;
      feedId.value = id;

      // Use 'new' for new feeds that don't have an ID yet
      const apiId = id === 'new' || !id ? 'new' : id;

      const response = await api().get(`adtribes/v1/filters-rules/${apiId}`, {
        params: { type: 'filters' },
      });

      // Load filters data if available from API
      if (response.data.filters) {
        // Normalize the data to ensure proper structure
        const normalizedFilters = normalizeFiltersData(response.data.filters);
        filters.value = normalizedFilters;
      }

      // Load attributes and conditions from the API response
      if (response.data.attributes) {
        attributes.value = response.data.attributes;
      }
      if (response.data.conditions) {
        conditions.value = response.data.conditions;
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
      error.value = err instanceof Error ? err.message : 'Failed to load filters';
      console.error('Error loading filters:', err);
    } finally {
      loading.value = false;
    }
  };

  /**
   * Add a new filter group to a section
   */
  const addFilterGroup = (section: 'include' | 'exclude', logicType: 'and' | 'or' = 'and') => {
    const timestamp = Date.now();

    // Ensure the section exists
    if (!filters.value[section]) {
      filters.value[section] = [];
    }

    // Add group logic if there are existing items
    if (filters.value[section].length > 0) {
      const groupLogic: FilterGroupLogic = {
        id: `group-logic-${timestamp}`,
        type: 'group_logic',
        value: logicType,
      };
      filters.value[section].push(groupLogic);
    }

    // Add the new group with NO fields - let user add fields manually
    const newGroup: FilterGroup = {
      id: `group-${timestamp}`,
      type: 'group',
      fields: [],
    };

    filters.value[section].push(newGroup);

    // Clear validation when user adds new groups
    if (showValidation.value) {
      clearValidationErrors();
    }
  };

  /**
   * Remove a filter group from a section
   * If it's the last group, clear its fields instead of removing it
   */
  const removeFilterGroup = (section: 'include' | 'exclude', groupId: string) => {
    // Ensure the section exists
    if (!filters.value[section]) {
      return;
    }

    const index = filters.value[section].findIndex((item) => item.id === groupId);
    if (index === -1) return;

    // Count how many actual groups (not group_logic) exist in this section
    const groupCount = filters.value[section].filter((item) => item.type === 'group').length;

    // If this is the last group, clear its fields instead of removing it
    if (groupCount === 1) {
      const group = filters.value[section][index] as FilterGroup;
      if (group.type === 'group') {
        // Clear all fields - let user add fields manually
        group.fields = [];
      }
    } else {
      // Remove the group if it's not the last one
      filters.value[section].splice(index, 1);

      // Clean up orphaned group logic
      cleanupGroupLogic(section);
    }

    // Clear validation when user removes groups
    if (showValidation.value) {
      clearValidationErrors();
    }
  };

  /**
   * Add a new field to a filter group
   */
  const addFilterField = (section: 'include' | 'exclude', groupId: string, fieldType: 'field' | 'logic' = 'field') => {
    // Ensure the section exists
    if (!filters.value[section]) {
      return;
    }

    const group = filters.value[section].find((item) => item.id === groupId && item.type === 'group') as FilterGroup;
    if (!group) return;

    const timestamp = Date.now();

    // Add logic operator if there are existing fields and we're adding a field
    if (group.fields.length > 0 && fieldType === 'field') {
      const logicField: FilterField = {
        id: `logic-${timestamp}`,
        type: 'logic',
        data: 'and',
      };
      group.fields.push(logicField);
    }

    // Add the new field
    const newField: FilterField = {
      id: `field-${timestamp}`,
      type: fieldType,
      data:
        fieldType === 'logic'
          ? 'and'
          : {
              condition: 'contains', // Default to contains for new fields
              value: '',
              attribute: '', // Add attribute inside data for field type
            },
    };

    group.fields.push(newField);

    // Clear validation when user adds new fields
    if (showValidation.value) {
      clearValidationErrors();
    }
  };

  /**
   * Remove a field from a filter group
   */
  const removeFilterField = (section: 'include' | 'exclude', groupId: string, fieldId: string) => {
    // Ensure the section exists
    if (!filters.value[section]) {
      return;
    }

    const group = filters.value[section].find((item) => item.id === groupId && item.type === 'group') as FilterGroup;
    if (!group) return;

    const fieldIndex = group.fields.findIndex((field) => field.id === fieldId);
    if (fieldIndex === -1) return;

    // Always remove the field - groups can be empty
    group.fields.splice(fieldIndex, 1);

    // Clean up orphaned logic operators
    cleanupFieldLogic(group);

    // Clear validation when user removes fields
    if (showValidation.value) {
      clearValidationErrors();
    }
  };

  /**
   * Update a filter field's data
   */
  const updateFilterField = (
    section: 'include' | 'exclude',
    groupId: string,
    fieldId: string,
    updates: Partial<FilterField>
  ) => {
    // Ensure the section exists
    if (!filters.value[section]) {
      return;
    }

    const group = filters.value[section].find((item) => item.id === groupId && item.type === 'group') as FilterGroup;
    if (!group) return;

    const field = group.fields.find((f) => f.id === fieldId);
    if (!field) return;

    // Update the field
    Object.assign(field, updates);
  };

  /**
   * Update filter field data specifically
   */
  const updateFilterFieldData = (
    section: 'include' | 'exclude',
    groupId: string,
    fieldId: string,
    dataUpdates: Partial<FilterFieldData>
  ) => {
    // Ensure the section exists
    if (!filters.value[section]) {
      return;
    }

    const group = filters.value[section].find((item) => item.id === groupId && item.type === 'group') as FilterGroup;
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
      console.log('updateFilterFieldData', fieldId);
      if (validationErrors.value[fieldId]) {
        delete validationErrors.value[fieldId];
      }
    }
  };

  /**
   * Clean up orphaned group logic operators
   */
  const cleanupGroupLogic = (section: 'include' | 'exclude') => {
    // Ensure the section exists
    if (!filters.value[section]) {
      return;
    }

    const items = filters.value[section];

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
   * Clean up orphaned field logic operators within a group
   */
  const cleanupFieldLogic = (group: FilterGroup) => {
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
   * Clear all filters
   */
  const clearFilters = () => {
    filters.value = {
      include: [],
      exclude: [],
    };
    // Clear validation when filters are cleared
    clearValidationErrors();
  };

  /**
   * Clear a specific filter section but keep at least one empty group
   */
  const clearFilterSection = (section: 'include' | 'exclude') => {
    // Clear the section
    filters.value[section] = [];

    // Add a default empty group with NO fields - let user add fields manually
    const timestamp = Date.now();
    const defaultGroup: FilterGroup = {
      id: `group-${timestamp}`,
      type: 'group',
      fields: [],
    };

    filters.value[section].push(defaultGroup);

    // Clear validation when section is cleared
    clearValidationErrors();
  };

  /**
   * Reset store to initial state
   */
  const resetStore = () => {
    loading.value = false;
    error.value = null;
    feedId.value = null;
    clearFilters(); // This will also clear validation
    attributes.value = {};
    conditions.value = [];
    categories.value = [];
  };

  // Validation methods
  const validateField = (field: FilterField, section: 'include' | 'exclude', groupId: string): string[] => {
    const errors: string[] = [];

    if (field.type === 'field') {
      const data = field.data as FilterFieldData;

      // Validate attribute (required) - check inside data
      if (!data.attribute || data.attribute.trim() === '') {
        errors.push(__('Attribute is required', 'woo-product-feed-pro'));
      }

      // Validate condition (required)
      if (!data.condition || data.condition.trim() === '') {
        errors.push(__('Condition is required', 'woo-product-feed-pro'));
      }

      // Validate value (required for most conditions)
      const noValueConditions = ['is_empty', 'is_not_empty'];
      if (data.condition && !noValueConditions.includes(data.condition)) {
        if (!data.value || (typeof data.value === 'string' && data.value.trim() === '')) {
          errors.push(__('Value is required for this condition', 'woo-product-feed-pro'));
        }
      }
    }

    return errors;
  };

  const validateGroup = (group: FilterGroup, section: 'include' | 'exclude'): Record<string, string[]> => {
    const errors: Record<string, string[]> = {};

    // Validate each field in the group
    group.fields.forEach((field) => {
      if (field.type === 'field') {
        const fieldErrors = validateField(field, section, group.id);
        if (fieldErrors.length > 0) {
          errors[field.id] = fieldErrors;
        }
      }
    });

    return errors;
  };

  const validateSection = (section: 'include' | 'exclude'): Record<string, string[]> => {
    const errors: Record<string, string[]> = {};

    if (!filters.value[section]) {
      return errors;
    }

    // Validate each group in the section
    filters.value[section].forEach((item) => {
      if (item.type === 'group') {
        const groupErrors = validateGroup(item as FilterGroup, section);
        Object.assign(errors, groupErrors);
      }
    });

    return errors;
  };

  const validateAllFields = (): Record<string, string[]> => {
    const errors: Record<string, string[]> = {};

    // Validate include section
    const includeErrors = validateSection('include');
    Object.assign(errors, includeErrors);

    // Validate exclude section
    const excludeErrors = validateSection('exclude');
    Object.assign(errors, excludeErrors);

    return errors;
  };

  const updateValidationErrors = () => {
    showValidation.value = true;
    validationErrors.value = validateAllFields();
  };

  const clearValidationErrors = () => {
    validationErrors.value = {};
    showValidation.value = false;
  };

  const getFieldValidationKey = (section: 'include' | 'exclude', groupId: string, fieldId: string): string => {
    return `${section}-${groupId}-${fieldId}`;
  };

  return {
    // State
    loading,
    error,
    feedId,
    filters,
    attributes,
    conditions,
    categories,
    migrationRan,

    // Getters
    hasFilters,
    hasIncludeFilters,
    hasExcludeFilters,
    getFilterGroups,
    getFilterGroupLogics,

    // Actions
    loadFilters,
    addFilterGroup,
    removeFilterGroup,
    addFilterField,
    removeFilterField,
    updateFilterField,
    updateFilterFieldData,
    clearFilters,
    clearFilterSection,
    resetStore,

    // Validation
    validationErrors,
    showValidation,
    isFormValid,
    getFieldErrors,
    hasValidationErrors,
    validateField,
    validateGroup,
    validateSection,
    validateAllFields,
    updateValidationErrors,
    clearValidationErrors,
    getFieldValidationKey,
  };
});
