import { computed, watch } from 'vue';
import { useFiltersStore } from '../stores/filtersStore';
import { useRulesStore } from '../stores/rulesStore';

export function useValidation(storeType: 'filters' | 'rules' = 'filters') {
  const filtersStore = storeType === 'filters' ? useFiltersStore() : null;
  const rulesStore = storeType === 'rules' ? useRulesStore() : null;

  // Get the appropriate store
  const store = filtersStore || rulesStore;

  if (!store) {
    throw new Error('Invalid store type provided to useValidation');
  }

  // Validation state
  const isFormValid = computed(() => {
    if (storeType === 'filters' && filtersStore) {
      return filtersStore.isFormValid;
    }
    if (storeType === 'rules' && rulesStore) {
      return rulesStore.isFormValid;
    }
    return true;
  });

  const hasValidationErrors = computed(() => {
    if (storeType === 'filters' && filtersStore) {
      return filtersStore.hasValidationErrors;
    }
    if (storeType === 'rules' && rulesStore) {
      return rulesStore.hasValidationErrors;
    }
    return false;
  });

  // Validation methods
  const validateForm = () => {
    if (storeType === 'filters' && filtersStore) {
      filtersStore.updateValidationErrors();
    }
    if (storeType === 'rules' && rulesStore) {
      rulesStore.updateValidationErrors();
    }
  };

  const clearValidation = () => {
    if (storeType === 'filters' && filtersStore) {
      filtersStore.clearValidationErrors();
    }
    if (storeType === 'rules' && rulesStore) {
      rulesStore.clearValidationErrors();
    }
  };

  const getFieldErrors = (fieldId: string): string[] => {
    if (storeType === 'filters' && filtersStore) {
      return filtersStore.getFieldErrors(fieldId);
    }
    if (storeType === 'rules' && rulesStore) {
      return rulesStore.getFieldErrors(fieldId);
    }
    return [];
  };

  const validateOnChange = (enable: boolean = true) => {
    if (!enable) return;

    if (storeType === 'filters' && filtersStore) {
      // Watch for changes in filters and auto-validate
      watch(
        () => filtersStore.filters,
        () => {
          filtersStore.updateValidationErrors();
        },
        { deep: true }
      );
    }
    if (storeType === 'rules' && rulesStore) {
      // Watch for changes in rules and auto-validate
      watch(
        () => rulesStore.rules,
        () => {
          rulesStore.updateValidationErrors();
        },
        { deep: true }
      );
    }
  };

  // Form submission prevention
  const preventInvalidSubmission = (event: Event) => {
    validateForm();

    if (!isFormValid.value) {
      event.preventDefault();
      event.stopPropagation();

      // Show validation errors
      console.warn('Form submission prevented due to validation errors');

      // Optionally scroll to first error
      scrollToFirstError();

      return false;
    }

    return true;
  };

  const scrollToFirstError = () => {
    // Find the first element with validation errors
    const firstErrorElement = document.querySelector('.adt-field-error, .adt-validation-error');
    if (firstErrorElement) {
      firstErrorElement.scrollIntoView({
        behavior: 'smooth',
        block: 'center',
      });
    }
  };

  return {
    // State
    isFormValid,
    hasValidationErrors,

    // Methods
    validateForm,
    clearValidation,
    getFieldErrors,
    validateOnChange,
    preventInvalidSubmission,
    scrollToFirstError,
  };
}
