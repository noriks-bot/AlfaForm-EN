<script setup lang="ts">
import { onMounted } from 'vue';
import { storeToRefs } from 'pinia';
import { useFiltersStore } from '../stores/filtersStore';
import FilterSection from './sections/FilterSection.vue';
import Skeleton from './common/Skeleton.vue';
import MigrationNotice from './common/MigrationNotice.vue';

const store = useFiltersStore();
const { loading, migrationRan } = storeToRefs(store);

onMounted(async () => {
  // Get feed ID from URL parameters
  const urlParams = new URLSearchParams(window.location.search);
  const feedId = urlParams.get('id') || '';

  // Load existing filters.
  await store.loadFilters(feedId);
});

const closeMigrationNotice = () => {
  migrationRan.value = false;
};
</script>

<template>
  <div class="adt-filters-builder adt-tw-max-w-7xl adt-tw-space-y-6">
    <!-- Loading State -->
    <template v-if="loading">
        <Skeleton type="title" width="10%" />
        <Skeleton type="card" :rows="1" :width="['100%']" />
        <Skeleton type="title" width="10%" />
        <Skeleton type="card" :rows="1" :width="['100%']" />
    </template>
    <template v-else>
      <div v-if="migrationRan">
        <MigrationNotice type="filters" :closeMigrationNotice="closeMigrationNotice" />
      </div>
      <FilterSection type="include"/>
      <FilterSection type="exclude"/>
    </template>
  </div>
</template>

<style scoped lang="scss">
.adt-filters-builder {
  // Custom styles if needed
}
</style> 
