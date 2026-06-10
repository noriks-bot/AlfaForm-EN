<script setup lang="ts">
import { computed, ref, watch, h } from 'vue'
import VueSelect from 'vue-select'
import { useRulesStore } from '../../stores/rulesStore'

interface FieldMappingOption {
  value: string
  label: string
}

interface Props {
  modelValue?: string
  placeholder?: string
  hasError?: boolean
}

interface Emits {
  (e: 'update:modelValue', value: string): void
  (e: 'change', value: string): void
}

const props = withDefaults(defineProps<Props>(), {
  placeholder: 'Select field',
  hasError: false
})

const emit = defineEmits<Emits>()

// Custom OpenIndicator component for dropdown arrow
const OpenIndicator = {
  render: () => h('span', {
    class: 'adt-tw-icon-[lucide--chevron-down]'
  })
}

const rulesStore = useRulesStore()

const selectedField = ref<FieldMappingOption | null>(null)

// Convert store.fieldMapping to vue-select options format
const fieldMappingOptions = computed(() => {
  const options: FieldMappingOption[] = []
    
  for (const key in rulesStore.fieldMapping) {
    const attributeValue = rulesStore.fieldMapping[key].attribute
    options.push({
      value: attributeValue,
      label: attributeValue
    })
  }
  
  return options
})

// Initialize selected field based on modelValue
watch(
  () => props.modelValue,
  (newValue) => {
    if (newValue && fieldMappingOptions.value.length > 0) {
      const found = fieldMappingOptions.value.find(field => field.value === newValue)
      selectedField.value = found || null
    } else {
      selectedField.value = null
    }
  },
  { immediate: true }
)

// Watch for changes in field mapping options to update selection
watch(
  fieldMappingOptions,
  () => {
    if (props.modelValue && fieldMappingOptions.value.length > 0) {
      const found = fieldMappingOptions.value.find(field => field.value === props.modelValue)
      selectedField.value = found || null
    }
  },
  { immediate: true }
)

const onFieldSelected = (option: FieldMappingOption) => {
  if (option) {
    emit('update:modelValue', option.value)
    emit('change', option.value)
  }
}
</script>

<template>
  <div class="adt-field-mapping-select-container">
    <vue-select
      v-model="selectedField"
      :options="fieldMappingOptions"
      :placeholder="placeholder"
      :components="{ OpenIndicator }"
      :clearable="false"
      class="adt-field-mapping-select"
      :class="{ 'adt-field-mapping-select-error': hasError }"
      @option:selected="onFieldSelected"
    >
      <template #option="{ label }">
        <div class="adt-field-mapping-select-option">
          {{ label }}
        </div>
      </template>
    </vue-select>
  </div>
</template>

<style scoped>
.adt-field-mapping-select-container {
  position: relative;
}

.adt-field-mapping-select {
  width: 100%;
}

.adt-field-mapping-select-option {
  padding: 0.25rem 0.5rem;
}

.adt-field-mapping-select-container .adt-field-mapping-select-error :deep(.vs__dropdown-toggle) {
  border-color: #dc3545;
}

/* Vue Select styling to match other form fields */
.adt-field-mapping-select-container :deep(.vs__dropdown-toggle) {
  padding: 0;
  border: 1px solid #d1d5db;
  border-radius: 0.375rem;
  min-height: 1.875rem; /* 30px height to match other inputs */
  height: 1.875rem;
  box-sizing: border-box;
  transition: all 0.15s ease-in-out;
}

.adt-field-mapping-select-container :deep(.vs__dropdown-toggle):focus-within {
  outline: 2px solid transparent;
  box-shadow: 0 0 0 1px #2271b1;
  border-color: #2271b1;
}

.adt-field-mapping-select-container :deep(.vs__selected-options) {
  padding: 0.25rem 0.5rem;
  flex-wrap: nowrap;
  min-height: auto;
}

.adt-field-mapping-select-container :deep(.vs__search) {
  border: none;
  margin: 0;
  padding: 0.25rem 0.5rem;
  font-size: 0.875rem;
  line-height: 1.25rem;
  height: auto;
  min-height: auto;
}

.adt-field-mapping-select-container :deep(.vs__search:focus) {
  margin: 0;
  box-shadow: none;
  border: none;
  outline: none;
}

.adt-field-mapping-select-container :deep(.vs__search::placeholder) {
  color: #9ca3af;
}

.adt-field-mapping-select-container :deep(.vs__actions) {
  padding: 0.125rem 0.25rem;
}

.adt-field-mapping-select-container :deep(.vs__clear) {
  fill: #6b7280;
  width: 1rem;
  height: 1rem;
}

.adt-field-mapping-select-container :deep(.vs__open-indicator) {
  fill: #6b7280;
  width: 1rem;
  height: 1rem;
}

.adt-field-mapping-select-container :deep(.vs__dropdown-menu) {
  border: 1px solid #d1d5db;
  border-radius: 0.375rem;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
  z-index: 1000;
}

.adt-field-mapping-select-container :deep(.vs__dropdown-option) {
  font-size: 0.875rem;
  line-height: 1.25rem;
  padding: 0;
  white-space: normal;
}

.adt-field-mapping-select-container :deep(.vs__dropdown-option--highlight) {
  background-color: #3b82f6;
  color: white;
}

.adt-field-mapping-select-container :deep(.vs__selected) {
  margin: 0;
  padding: 0;
  border: none;
  background-color: transparent;
  color: inherit;
  font-size: 0.875rem;
  line-height: 1.25rem;
}
</style>

