/**
 * Validation helper functions for Filters and Rules components
 * Provides common validation utilities that can be reused across components
 */

/**
 * Generate CSS classes for form fields based on validation state
 */
export const getValidationClasses = (
  baseClasses: string,
  hasErrors: boolean,
  errorClasses: string = 'adt-tw-border-red-500 adt-tw-focus-border-red-500 adt-tw-focus-ring-red-500'
): string => {
  return hasErrors ? `${baseClasses} ${errorClasses}` : baseClasses;
};

/**
 * Generate CSS classes for container elements based on validation state
 */
export const getContainerValidationClasses = (
  hasErrors: boolean,
  errorClasses: string = 'adt-tw-border-red-300 adt-tw-shadow-red-100',
  normalClasses: string = 'adt-tw-border-gray-200 adt-tw-shadow-sm'
): string => {
  return hasErrors ? errorClasses : normalClasses;
};

/**
 * Check if a field has validation errors
 */
export const hasValidationErrors = (errors: string[]): boolean => {
  return errors.length > 0;
};

/**
 * Scroll to the first validation error element
 */
export const scrollToFirstError = (selector: string = '.adt-field-error, .adt-validation-error'): void => {
  const firstErrorElement = document.querySelector(selector);
  if (firstErrorElement) {
    firstErrorElement.scrollIntoView({
      behavior: 'smooth',
      block: 'center',
    });
  }
};
