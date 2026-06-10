<script setup lang="ts">
interface Props {
  type?: 'text' | 'title' | 'avatar' | 'button' | 'card';
  rows?: number;
  width?: string | string[];
  height?: string;
  className?: string;
}

const props = withDefaults(defineProps<Props>(), {
  type: 'text',
  rows: 1,
  width: '100%',
  height: '1rem',
  className: '',
});

const getWidth = (index: number) => {
  if (Array.isArray(props.width)) {
    return props.width[index] || props.width[props.width.length - 1] || '100%';
  }
  return props.width;
};
</script>

<template>
  <div :class="['adt-skeleton', className]">
    <!-- Text skeleton -->
    <template v-if="type === 'text'">
      <div
        v-for="i in rows"
        :key="i"
        class="adt-tw-bg-gray-200 adt-tw-animate-pulse adt-tw-rounded"
        :style="{
          width: getWidth(i - 1),
          height: height,
          marginBottom: i < rows ? '0.5rem' : '0'
        }"
      ></div>
    </template>

    <!-- Title skeleton -->
    <template v-else-if="type === 'title'">
      <div
        class="adt-tw-bg-gray-200 adt-tw-animate-pulse adt-tw-rounded"
        :style="{
          width: getWidth(0),
          height: '1.5rem'
        }"
      ></div>
    </template>

    <!-- Avatar skeleton -->
    <template v-else-if="type === 'avatar'">
      <div
        class="adt-tw-bg-gray-200 adt-tw-animate-pulse adt-tw-rounded-full"
        :style="{
          width: height,
          height: height
        }"
      ></div>
    </template>

    <!-- Button skeleton -->
    <template v-else-if="type === 'button'">
      <div
        class="adt-tw-bg-gray-200 adt-tw-animate-pulse adt-tw-rounded-md"
        :style="{
          width: getWidth(0),
          height: height || '2rem'
        }"
      ></div>
    </template>

    <!-- Card skeleton -->
    <template v-else-if="type === 'card'">
      <div class="adt-tw-bg-white adt-tw-border adt-tw-border-gray-200 adt-tw-rounded-lg adt-tw-p-4 adt-tw-shadow-sm">
        <div
          class="adt-tw-bg-gray-200 adt-tw-animate-pulse adt-tw-rounded adt-tw-mb-3"
          :style="{
            width: getWidth(0),
            height: '1.25rem'
          }"
        ></div>
        <div
          v-for="i in rows"
          :key="i"
          class="adt-tw-bg-gray-200 adt-tw-animate-pulse adt-tw-rounded adt-tw-mb-2"
          :style="{
            width: getWidth(i),
            height: '1rem'
          }"
        ></div>
      </div>
    </template>
  </div>
</template>

<style scoped>
.adt-skeleton {
  display: block;
}

@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.5;
  }
}

.adt-tw-animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style> 
