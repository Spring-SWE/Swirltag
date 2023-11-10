<script setup>
import { ref, onMounted, onUnmounted, watch, defineProps } from 'vue';
import { useIntersectionObserver } from '@vueuse/core';
import axios from 'axios';

const props = defineProps({
  apiEndpoint: String,
  initialData: Array,
  hasMore: String
});

const isLoading = ref(false);
const items = ref(props.initialData);
const lastElement = ref(null);
const hasMore = ref(props.hasMore);
const nextCursor = ref(''); // Add a ref to keep track of the next cursor

const loadMoreItems = async () => {
  if (!hasMore.value || isLoading.value) return;

  isLoading.value = true;

  try {
    const response = await axios.get(props.apiEndpoint, {
      params: { cursor: nextCursor.value } // Use the nextCursor reactive property here
    });

    items.value.push(...response.data.data);
    nextCursor.value = response.data.meta.next_cursor; // Update the nextCursor with the new value from the response
    hasMore.value = !!nextCursor.value; // Update the hasMore value based on the presence of a next cursor
  } catch (error) {
    console.error('Failed to load more items:', error);
  } finally {
    isLoading.value = false;
  }
};

const { stop } = useIntersectionObserver(
  lastElement,
  ([{ isIntersecting }]) => {
    if (isIntersecting) {
      loadMoreItems();
    }
  },
  {
    threshold: 0.5 // Adjust as needed
  }
);

onMounted(() => {
  if (!props.initialData.length && hasMore.value) {
    loadMoreItems();
  }
});

onUnmounted(() => {
  stop();
});

watch(() => props.initialData, (newData) => {
  items.value = newData;
});
</script>

<template>
  <div>
    <slot :items="items" />
    <div v-if="isLoading" class="col-span-12 lg:col-span-8 flex justify-center items-center h-16">
        <span class="loading loading-spinner loading-lg text-primary"></span></div>
    <div ref="lastElement" v-if="hasMore" class="infinite-scroll-trigger"></div>
  </div>
</template>
