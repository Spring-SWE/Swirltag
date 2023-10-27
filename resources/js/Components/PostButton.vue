<template>
    <button
        data-modal-target="popup-modal" data-modal-toggle="popup-modal"
        class="px-3 py-2 text-xs font-medium text-center text-white bg-theme-purple rounded-lg hover:bg-theme-purple-dark focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-theme-purple dark:hover:bg-blue-700 dark:focus:ring-blue-800"
    >
        <slot />
    </button>
</template>
