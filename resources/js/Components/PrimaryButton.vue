<script setup>
import { computed } from 'vue';

const props = defineProps({
    textSize: {
        type: String,
        default: 'xs',
    },

    width: {
        type: String,
        default: '',
    },
});

const textSizeClass = computed(() => {
    return {
        xs: 'text-xs',
        sm: 'text-sm',
        textBase: 'text-base',
        lg: 'text-lg',
        xl: 'text-xl',
        '2xl': 'text-2xl',
        '3xl': 'text-3xl',
    }[props.textSize.toString()];
});

const widthSize = computed(() => {
    return {
        xs: 'text-xs',
        sm: 'text-sm',
        textBase: 'text-base',
        lg: 'text-lg',
        xl: 'text-xl',
        '2xl': 'text-2xl',
        '3xl': 'text-3xl',
    }[props.width.toString()];
});

</script>

<template>
    <button
        class="px-3 py-2 font-medium text-white bg-theme-purple rounded-lg hover:bg-theme-purple-dark focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-theme-purple dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        :class="[textSizeClass]"
    >
        <slot />
    </button>
</template>
