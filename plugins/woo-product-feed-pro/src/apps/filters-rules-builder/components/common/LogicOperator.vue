<script setup lang="ts">
interface Props {
  operator: string;
}

defineProps<Props>();
</script>

<template>
  <div class="adt-logic-operator adt-tw-flex adt-tw-justify-center adt-tw-my-4">
    <span class="adt-tw-px-2 adt-tw-py-0.5 adt-tw-bg-gray-100 adt-tw-text-gray-600 adt-tw-text-xs adt-tw-font-medium adt-tw-rounded-md">
      {{ operator.toUpperCase() }}
    </span>
  </div>
</template>

<style scoped lang="scss">
.adt-logic-operator {
  // Custom styles if needed
}
</style> 
