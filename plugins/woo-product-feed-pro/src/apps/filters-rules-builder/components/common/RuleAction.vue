<script setup lang="ts">
import { computed } from 'vue'
import { useRulesStore } from '../../stores/rulesStore'

interface Props {
  modelValue?: string
  hasError?: boolean
  selectClass?: string
}

interface Emits {
  (e: 'update:modelValue', value: string): void
  (e: 'change', value: string): void
}

const props = withDefaults(defineProps<Props>(), {
  hasError: false,
  selectClass: 'adt-action-select'
})

const emit = defineEmits<Emits>()

const rulesStore = useRulesStore()

const actions = computed(() => {
  return rulesStore.actions || []
})

const defaultValue = computed(() => {
  return actions.value.length > 0 ? actions.value[0].value : ''
})

const onActionChange = (event: Event) => {
  const target = event.target as HTMLSelectElement
  const value = target.value
  emit('update:modelValue', value)
  emit('change', value)
}
</script>

<template>
  <div class="adt-action-select-container">
    <select
      :value="modelValue || defaultValue"
      :class="selectClass"
      @change="onActionChange"
    >
      <option
        v-for="action in actions"
        :key="action.value"
        :value="action.value"
      >
        {{ action.label }}
      </option>
    </select>
  </div>
</template>

<style scoped>
.adt-action-select-container {
  position: relative;
}

.adt-action-select {
  width: 100%;
}

.adt-action-select-error {
  border-color: #dc3545;
}
</style> 
