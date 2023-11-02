
<script setup>
import {
    CheckBadgeIcon,
} from '@heroicons/vue/24/solid'
</script>

<template>
    <div
        class="w-full relative bg-white border border-gray-200 rounded-t-lg rounded-l-lg rounded-r-lg round-b-none shadow  dark:bg-gray-800 dark:border-gray-700">
        <div class="bg-theme-purple flex border-b-1 w-full p-0 m-0 border-t-1 rounded-t-lg h-24">
            <img class="rounded-full absolute top-6 left-4 h-24" alt="user image" src="https://placewaifu.com/image/40">
            <div class="username flex mx-auto mt-1">
                <div class="flex-none">
                    <a href="#" class="ml-1 text-3xl decoration-theme-purple dark:text-white font-semibold">
                        Spring
                    </a>
                </div>
                <div class="flex-none">
                    <CheckBadgeIcon class="h-6 w-6 mt-1 text-white" alt="verification badge" />
                </div>

            </div>

        </div>

        <div class="user-profile-info absolute top-32">
            <div class="ml-9 user-info flex"></div>
            <p class="mt-1 p-2 text-white">
                I made this site :)
            </p>
        </div>
        <div class="flex h-80">

        </div>
    </div>
</template>
