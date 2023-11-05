<script setup>
import { XCircleIcon } from '@heroicons/vue/20/solid'
import { watchEffect } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    closeable: {
        type: Boolean,
        default: true,
    },
});

const emit = defineEmits(['close']);

watchEffect(
    () => props.show,
);

const close = () => {
    if (props.closeable) {
        emit('close');
    }
};

</script>

<template>
    <Transition
      enter-active-class="ease-out duration-300"
      enter-from-class="opacity-0 -translate-y-full"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="ease-in duration-200"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 -translate-y-full"
    >
      <div v-show="show" class="bg-red-50 p-4">
        <div class="flex">
          <div class="flex-shrink-0">
            <XCircleIcon @click="close" class="h-5 w-5 text-red-400 cursor-pointer hover:text-red-300" aria-hidden="true" />
          </div>
          <div class="ml-3">
            <h3 class="text-sm font-medium text-red-800">There were some errors with your submission</h3>
            <div class="mt-2 text-sm text-red-700">
              <ul role="list" class="list-disc space-y-1 pl-5">
                <li>
                  <slot></slot>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </Transition>
  </template>

