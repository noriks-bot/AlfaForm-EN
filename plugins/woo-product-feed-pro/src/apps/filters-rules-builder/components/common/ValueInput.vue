<script setup lang="ts">
import { computed } from 'vue'
import { __ } from '@wordpress/i18n'

interface CategoryOption {
  value: string
  label: string
  name: string
  slug: string
}

interface Props {
  modelValue?: string | number
  placeholder?: string
  hasError?: boolean
  inputClass?: string
  inputType?: string
  attribute?: string
  categories?: CategoryOption[]
}

interface Emits {
  (e: 'update:modelValue', value: string): void
  (e: 'change', value: string): void
}

const props = withDefaults(defineProps<Props>(), {
  placeholder: '',
  hasError: false,
  inputClass: 'adt-value-input',
  inputType: 'text',
  attribute: '',
  categories: () => []
})

const emit = defineEmits<Emits>()

// Computed placeholder with translation fallback
const computedPlaceholder = computed(() => {
  return props.placeholder || __('Enter value', 'woo-product-feed-pro')
})

// Determine if we should show categories dropdown
const showCategoriesDropdown = computed(() => {
  const attr = props.attribute?.toLowerCase() || ''
  return (attr === 'categories' || attr === 'raw_categories') && props.categories && props.categories.length > 0
})

const onValueChange = (event: Event) => {
  const target = event.target as HTMLInputElement
  const value = target.value
  emit('update:modelValue', value)
  emit('change', value)
}
</script>

<template>
  <div class="adt-value-input-container">
    <!-- Categories dropdown when attribute is categories/raw_categories -->
    <select
      v-if="showCategoriesDropdown"
      :value="modelValue"
      :class="`${inputClass} adt-categories-select`"
      @change="onValueChange"
    >
      <option value="">{{ computedPlaceholder }}</option>
      <option
        v-for="category in categories"
        :key="category.value"
        :value="category.value"
      >
        {{ category.label }}
      </option>
    </select>
    
    <!-- Regular input field for other attributes -->
    <input
      v-else
      :type="inputType"
      :value="modelValue"
      :placeholder="computedPlaceholder"
      :class="inputClass"
      @input="onValueChange"
    />
  </div>
</template>


<style scoped>
.adt-value-input-container {
  position: relative;
}

.adt-value-input {
  width: 100%;
}

.adt-value-input-error {
  border-color: #dc3545;
}

.adt-categories-select {
  width: 100%;
  background-color: #fff;
  appearance: none;
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
  background-position: right 0.5rem center;
  background-repeat: no-repeat;
  background-size: 1.5em 1.5em;
  padding-right: 2.5rem;
}
</style> 
 