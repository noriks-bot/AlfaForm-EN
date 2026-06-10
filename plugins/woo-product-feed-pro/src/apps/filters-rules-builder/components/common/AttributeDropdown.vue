<script setup lang="ts">
import { computed } from 'vue';
import { __ } from '@wordpress/i18n';
import type { AttributeGroup } from '../../types';

interface Props {
  modelValue: string;
  attributes: AttributeGroup;
  placeholder?: string;
}

const props = withDefaults(defineProps<Props>(), {
  placeholder: __('Select attribute', 'woo-product-feed-pro'),
});

const emit = defineEmits<{
  'update:modelValue': [value: string];
}>();

const updateValue = (value: string) => {
  emit('update:modelValue', value);
};

const attributeGroups = computed(() => {
  return Object.entries(props.attributes).map(([groupName, attributes]) => ({
    groupName,
    attributes: Object.entries(attributes).map(([value, label]) => ({ value, label })),
  }));
});
</script>

<template>
  <select
    :value="modelValue"
    @change="updateValue(($event.target as HTMLSelectElement).value)"
    class="adt-tw-w-full adt-tw-px-3 adt-tw-py-2 adt-tw-text-sm adt-tw-border adt-tw-border-gray-300 adt-tw-rounded-md focus:adt-tw-ring-2 focus:adt-tw-ring-blue-500 focus:adt-tw-border-blue-500 adt-tw-outline-none"
  >
    <option value="" disabled>{{ placeholder }}</option>
    <optgroup
      v-for="group in attributeGroups"
      :key="group.groupName"
      :label="group.groupName"
    >
      <option
        v-for="attribute in group.attributes"
        :key="attribute.value"
        :value="attribute.value"
      >
        {{ attribute.label }}
      </option>
    </optgroup>
  </select>
</template>

<style scoped lang="scss">
// Custom styles if needed
</style> 
