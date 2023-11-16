<script setup>
import { HandThumbUpIcon } from '@heroicons/vue/24/solid'
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    notification: {
        type: Object
    },
});

</script>

<template>
    <ul role="list" class="mt-1 border dark:border-gray-700">
        <Link :href="`status/${notification.status_id}`">
        <li class="p-4 hover:dark:bg-gray-800">
            <div class="flex items-center gap-x-3">
                <!-- Display avatars for like notifications -->
                <template v-if="notification.like_count > 1">
                    <img v-for="(liker, index) in notification.likers" v-if="notification.likers.length < 5" :key="liker.name"
                         class="h-10 w-10 items-center justify-center rounded-full"
                         :src="`/storage/${liker.avatar}`"
                         :alt="`${liker.name}'s Avatar`" />
                </template>

                <template v-if="notification.like_count === 1">
                    <img v-for="(liker, index) in notification.likers" v-if="notification.likers.length < 5" :key="liker.name"
                         class="h-10 w-10 items-center justify-center rounded-full"
                         :src="`/storage/${liker.avatar}`"
                         :alt="`${liker.name}'s Avatar`" />
                </template>

                <!-- Display avatar for a single reply notification -->
                <template v-else-if="notification.type === 'reply'">
                    <img class="h-10 w-10 items-center justify-center rounded-full"
                         :src="notification.replierAvatar || 'https://i.pravatar.cc/40?u=' + notification.replierName"
                         :alt="`${notification.replierName}'s Avatar`" />
                </template>

                <!-- Display text for the notifications -->
                <h3 class="flex-auto truncate text-sm font-semibold leading-6 text-gray-900 dark:text-white">
                    <template v-if="notification.like_count > 1">
                        {{ notification.likers[0].name }} & {{ notification.like_count - 1 }} others liked your post
                    </template>
                    <template v-else-if="notification.like_count === 1">
                        {{ notification.likers[0].name }} liked your post
                    </template>
                    <template v-else-if="notification.type === 'reply'">
                        {{ notification.replierName }} replied to your post
                    </template>
                </h3>
                <time class="flex-none text-xs text-gray-500">{{ notification.created_at_human }}</time>
            </div>

            <div class="flex mt-4 gap-x-2">
                <!-- Icon for like notifications -->
                <template v-if="notification.like_count">
                    <HandThumbUpIcon class="text-green-700 h-5 w-5" />
                    <p class="truncate text-sm text-gray-500 dark:text-white">Liked your Post!</p>
                </template>

                <!-- Icon for reply notifications -->
                <template v-else-if="notification.type === 'reply'">

                    <p class="truncate text-sm text-gray-500 dark:text-white">Replied to your Post!</p>
                </template>
            </div>

            <!-- Display reply body for reply notifications -->
            <div v-if="notification.type === 'reply' && notification.replyBody" class="post-area border dark:border-gray-700 rounded-md p-2 mt-1">
                <p class="text-white">{{ notification.replyBody }}</p>
            </div>
        </li>
    </Link>
    </ul>
</template>
