<script setup>
import { HandThumbUpIcon } from '@heroicons/vue/24/solid'

const props = defineProps({
    notification: {
        type: Object
    },
});

console.log(props.notification);
</script>

<template>
    <ul role="list" class="mt-1 border dark:border-gray-700">
        <li class="p-4 hover:dark:bg-gray-800">
            <div class="flex items-center gap-x-3">
                <!-- Display avatars for like notifications -->
                <template v-if="notification.like_count">
                    <!-- Show all avatars if there are 4 or fewer, else show only the first 4 -->
                    <img v-for="(liker, index) in notification.likers" v-if="notification.likers.length <= 4 || index < 4" :key="liker.name"
                         class="h-10 w-10 items-center justify-center rounded-full"
                         :src="`/storage/${liker.avatar}` || 'default-avatar-url'"
                         :alt="`${liker.name}'s Avatar`" />
                </template>
                <template v-else>
                    <img class="h-10 w-10 items-center justify-center rounded-full"
                        :src="`/storage/${notification.likedBy.avatar}`" alt="User Avatar" />
                </template>

                <!-- Display text for like notifications -->
                <h3 class="flex-auto truncate text-sm font-semibold leading-6 text-gray-900 dark:text-white">
                    <template v-if="notification.like_count > 1">
                        {{ notification.likers[0].name }} & {{ notification.like_count - 1 }} others
                    </template>
                    <template v-else>
                        {{ notification.likers[0].name }}
                    </template>
                </h3>
                <time class="flex-none text-xs text-gray-500">{{ notification.created_at_human }}</time>
            </div>

            <div class="flex mt-4 gap-x-2">
                <HandThumbUpIcon class="text-green-700 h-5 w-5" />
                <p class="truncate text-sm text-gray-500 dark:text-white">
                    Liked your Post!
                </p>
            </div>

            <div v-if="notification.status_body" class="post-area border dark:border-gray-700 rounded-md p-2 mt-1">
                <p class="text-white">
                    {{ notification.status_body }}
                </p>
            </div>
        </li>
    </ul>
</template>
