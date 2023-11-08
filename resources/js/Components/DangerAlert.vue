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
    <Transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0 -translate-y-full"
        enter-to-class="opacity-100 translate-y-0" leave-active-class="ease-in duration-200"
        leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 -translate-y-full">
        <div class="alert alert-error cursor-pointer" v-show="show">
            <svg xmlns="http://www.w3.org/2000/svg" @click="close" class="stroke-current shrink-0 h-6 w-6" fill="none"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>
                <slot></slot>
            </span>
        </div>

    </Transition>
</template>

