<template>
  <div class="adt-condition-select-container">
    <select
      :value="modelValue || defaultValue"
      :class="selectClass"
      @change="onConditionChange"
    >
      <option
        v-for="condition in conditions"
        :key="condition.value"
        :value="condition.value"
      >
        {{ condition.label }}
      </option>
    </select>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useFiltersStore } from '../../stores/filtersStore'
import { useRulesStore } from '../../stores/rulesStore'

interface Props {
  modelValue?: string
  hasError?: boolean
  selectClass?: string
  storeType?: 'filters' | 'rules'
}

interface Emits {
  (e: 'update:modelValue', value: string): void
  (e: 'change', value: string): void
}

const props = withDefaults(defineProps<Props>(), {
  hasError: false,
  selectClass: 'adt-condition-select',
  storeType: 'filters'
})

const emit = defineEmits<Emits>()

const filtersStore = useFiltersStore()
const rulesStore = useRulesStore()

const conditions = computed(() => {
  return props.storeType === 'rules' ? rulesStore.conditions : filtersStore.conditions
})

const defaultValue = computed(() => {
  return conditions.value.length > 0 ? conditions.value[0].value : ''
})

const onConditionChange = (event: Event) => {
  const target = event.target as HTMLSelectElement
  const value = target.value
  emit('update:modelValue', value)
  emit('change', value)
}
</script>

<style scoped>
.adt-condition-select-container {
  position: relative;
}

.adt-condition-select {
  width: 100%;
}

.adt-condition-select-error {
  border-color: #dc3545;
}
</style> 
 