<script setup lang="ts">
/***************************************************************************
 * App Component
 ***************************************************************************
 *
 * This is the main component for the admin app.
 *
 */
import { ref, onMounted, watch, computed } from 'vue';
import { __ } from '@wordpress/i18n';
import { useFiltersStore } from './stores/filtersStore';
import { useRulesStore } from './stores/rulesStore';
import { useValidation } from './composables/useValidation';
import FilterBuilder from './components/FiltersBuilder.vue';
import RuleBuilder from './components/RulesBuilder.vue';

// Get the type from the data-type attribute of the mounted element
const type = ref<string>('');

// Conditionally initialize stores based on type
const filtersStore = computed(() => type.value === 'filters' ? useFiltersStore() : null);
const rulesStore = computed(() => type.value === 'rules' ? useRulesStore() : null);

// Validation composable - initialize with correct type
const validation = computed(() => {
  if (type.value === 'filters' || type.value === 'rules') {
    return useValidation(type.value as 'filters' | 'rules');
  }
  return useValidation(); // fallback to default
});

onMounted(() => {
  const appElement = document.getElementById('filters-rules-builder-app');
  if (appElement) {
    type.value = appElement.getAttribute('data-type') || 'filters';
  }

  // Set up reactive form field updates
  setupReactiveFormUpdates();
  
  // Set up form submission prevention
  setupFormSubmissionPrevention();
});

/**
 * Set up reactive updates to hidden form fields whenever store state changes
 */
const setupReactiveFormUpdates = () => {
  if (type.value === 'filters' && filtersStore.value) {
    // Watch filters store and update hidden field
    watch(
      () => filtersStore.value!.filters,
      (newFilters) => {
        updateFiltersHiddenField(newFilters);
      },
      { deep: true, immediate: true }
    );
    
    // Watch validation state and update submit button
    watch(
      () => filtersStore.value!.hasValidationErrors,
      (hasErrors) => {
        updateSubmitButtonState(!hasErrors);
      }
    );
  } else if (type.value === 'rules' && rulesStore.value) {
    // Watch rules store and update hidden field
    watch(
      () => rulesStore.value!.rules,
      (newRules) => {
        updateRulesHiddenField(newRules);
      },
      { deep: true, immediate: true }
    );
    
    // Watch rules validation state and update submit button
    watch(
      () => rulesStore.value!.hasValidationErrors,
      (hasErrors) => {
        updateSubmitButtonState(!hasErrors);
      }
    );
  }
};

/**
 * Set up form submission prevention for invalid forms
 */
const setupFormSubmissionPrevention = () => {
  // Find the form element
  const form = document.querySelector('form[action*="admin_post_edit_feed_form_process"]');
  
  if (form) {
    // Add event listener to prevent submission if validation fails
    form.addEventListener('submit', (event) => {
      // Trigger validation and prevent submission if validation fails
      const isValid = validation.value.preventInvalidSubmission(event);
      
      if (!isValid) {
        // Show user feedback
        showValidationFeedback();
      }
    });
  } else {
    // Try finding by submit button as fallback
    const submitButtonId = type.value === 'filters' ? 'filters-submit-button' : 'rules-submit-button';
    const submitButton = document.getElementById(submitButtonId);
    
    if (submitButton) {
      const parentForm = submitButton.closest('form');
      
      if (parentForm) {
        parentForm.addEventListener('submit', (event) => {
          const isValid = validation.value.preventInvalidSubmission(event);
          
          if (!isValid) {
            showValidationFeedback();
          }
        });
      }
    }
  }
};

/**
 * Show validation feedback to user
 */
const showValidationFeedback = () => {
  // Create or update a validation message
  let messageElement = document.getElementById('validation-message');
  
  if (!messageElement) {
    messageElement = document.createElement('div');
    messageElement.id = 'validation-message';
    messageElement.className = 'adt-tw-fixed adt-tw-top-4 adt-tw-right-4 adt-tw-bg-red-500 adt-tw-text-white adt-tw-px-4 adt-tw-py-2 adt-tw-rounded-md adt-tw-shadow-lg adt-tw-z-50';
    document.body.appendChild(messageElement);
  }
  
  const message = __('Please fill in all required fields before submitting.', 'woo-product-feed-pro');
  messageElement.innerHTML = `
    <div class="adt-tw-flex adt-tw-items-center">
      <span class="adt-tw-icon-[lucide--alert-circle] adt-tw-size-4 adt-tw-mr-2"></span>
      <span></span>
    </div>
  `;
  const messageSpan = messageElement.querySelector('span:last-child');
  if (messageSpan) {
    messageSpan.textContent = message;
  }
  
  // Auto-hide after 5 seconds
  setTimeout(() => {
    if (messageElement && messageElement.parentNode) {
      messageElement.parentNode.removeChild(messageElement);
    }
  }, 5000);
};

/**
 * Update filters hidden form field
 */
const updateFiltersHiddenField = (filters: any) => {
  const hiddenField = document.getElementById('filters-data-field') as HTMLInputElement;
  if (hiddenField) {
    hiddenField.value = JSON.stringify(filters);
  }
};

/**
 * Update rules hidden form field
 */
const updateRulesHiddenField = (rules: any) => {
  const hiddenField = document.getElementById('rules-data-field') as HTMLInputElement;
  if (hiddenField) {
    hiddenField.value = JSON.stringify(rules);
  }
};

/**
 * Update submit button state based on validation
 */
const updateSubmitButtonState = (isValid: boolean) => {
  const submitButtonId = type.value === 'filters' ? 'filters-submit-button' : 'rules-submit-button';
  const submitButton = document.getElementById(submitButtonId) as HTMLButtonElement;
  const validationStatus = document.getElementById('validation-status');
  
  if (submitButton) {
    if (isValid) {
      submitButton.disabled = false;
      submitButton.classList.remove('adt-tw-opacity-50', 'adt-tw-cursor-not-allowed');
    } else {
      submitButton.disabled = true;
      submitButton.classList.add('adt-tw-opacity-50', 'adt-tw-cursor-not-allowed');
    }
  }
  
  if (validationStatus) {
    if (isValid) {
      validationStatus.classList.add('adt-tw-hidden');
    } else {
      validationStatus.classList.remove('adt-tw-hidden');
    }
  }
};
</script>

<template>
  <template v-if="type === 'filters'">
    <FilterBuilder />
  </template>
  <template v-else-if="type === 'rules'">
    <RuleBuilder />
  </template>
</template>
