<template>
    <div class="relative" v-if="localImagePreview">
      <!-- Remove image button -->
      <button class="absolute top-0 right-0 mt-2 mr-2 bg-white rounded-full p-1 shadow-lg" @click="removeImage">
        <XMarkIcon class="h-5 w-5" aria-hidden="true" />
      </button>
      <!-- Image preview -->
      <img :src="localImagePreview" alt="Image preview" class="rounded-lg" />
    </div>
  </template>

  <script setup>
  import { ref, defineEmits, watch } from 'vue';
  import { XMarkIcon } from '@heroicons/vue/24/solid';

  const emits = defineEmits(['remove']);

  const props = defineProps({
    imageSource: String
  });

  const localImagePreview = ref(props.imageSource);

  // Watch for external changes to the imageSource prop
  watch(() => props.imageSource, (newVal) => {
    localImagePreview.value = newVal;
  });

  function removeImage() {
    localImagePreview.value = null;
    emits('remove'); // Notify the parent component that the image should be removed
  }
  </script>
