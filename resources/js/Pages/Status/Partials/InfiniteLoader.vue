<script setup>
import { ref, onMounted, onUnmounted, watch, defineProps } from 'vue';
import { useIntersectionObserver } from '@vueuse/core';
import axios from 'axios';

const props = defineProps({
  apiEndpoint: String,
  initialData: Array,
  hasMore: Boolean
});

const isLoading = ref(false);
const items = ref(props.initialData);
const lastElement = ref(null);
const hasMore = ref(props.hasMore);

const loadMoreItems = async () => {
  if (!hasMore.value || isLoading.value) return;

  isLoading.value = true;

  try {
    const response = await axios.get(props.apiEndpoint, {
      params: { cursor: next_cursor }
    });

    items.value.push(...response.data.data);
    hasMore.value = !!response.data.meta.next_cursor;
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
    <div v-if="isLoading" class="loader">Loading...</div>
    <div ref="lastElement" v-if="hasMore" class="infinite-scroll-trigger"></div>
  </div>
</template>
