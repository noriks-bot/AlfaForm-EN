<script setup lang="ts">
import { __ } from '@wordpress/i18n';
import type { ConditionOption } from '../../types';

interface Props {
  modelValue: string;
  conditions: ConditionOption[];
  placeholder?: string;
}

const props = withDefaults(defineProps<Props>(), {
  placeholder: __('Select condition', 'woo-product-feed-pro'),
});

const emit = defineEmits<{
  'update:modelValue': [value: string];
}>();

const updateValue = (value: string) => {
  emit('update:modelValue', value);
};
</script>

<template>
  <select
    :value="modelValue"
    @change="updateValue(($event.target as HTMLSelectElement).value)"
    class="adt-tw-w-full adt-tw-px-3 adt-tw-py-2 adt-tw-text-sm adt-tw-border adt-tw-border-gray-300 adt-tw-rounded-md focus:adt-tw-ring-2 focus:adt-tw-ring-blue-500 focus:adt-tw-border-blue-500 adt-tw-outline-none"
  >
    <option value="" disabled>{{ placeholder }}</option>
    <option
      v-for="condition in conditions"
      :key="condition.value"
      :value="condition.value"
    >
      {{ condition.label }}
    </option>
  </select>
</template>

<style scoped lang="scss">
// Custom styles if needed
</style> 
