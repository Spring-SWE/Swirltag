<script setup>
import { HandThumbUpIcon, ChatBubbleBottomCenterIcon } from '@heroicons/vue/24/solid'
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    notification: {
        type: Object,
        required: true
    },
});

// Helper method to determine if the notification is a like
const isLikeNotification = (notification) => {
    return notification.type === 'App\\Notifications\\LikeNotification';
};

// Helper method to determine if the notification is a reply
const isReplyNotification = (notification) => {
    return notification.type === 'App\\Notifications\\ReplyNotification';
};

// Helper method to determine if the notification is a follow
const isFollowNotification = (notification) => {
    return notification.type === 'App\\Notifications\\FollowNotification';
};

console.log(props.notification);

</script>

<template>
    <ul role="list" class="mt-1 border dark:border-gray-700">
        <Link :href="isReplyNotification(notification) ? `status/${notification.data.reply_id}/#${notification.data.reply_id}` : `status/${notification.status_id}`">
            <li class="p-4 hover:dark:bg-gray-800">
                <div class="flex items-center gap-x-3">
                    <!-- Display avatars for like notifications -->
                    <template v-if="isLikeNotification(notification)">
                        <img v-for="(liker, index) in notification.likers" :key="index"
                             class="h-10 w-10 items-center justify-center rounded-full"
                             :src="`/storage/${liker.avatar}`"
                             :alt="`${liker.name}'s Avatar`" />
                    </template>

                    <!-- Display avatar for reply notifications -->
                    <template v-if="isReplyNotification(notification)">
                        <img class="h-10 w-10 items-center justify-center rounded-full"
                             :src="`/storage/${notification.data.replier_avatar}`"
                             :alt="`${notification.data.replier_name}'s Avatar`" />
                    </template>

                    <!-- Display avatar for follow notifications -->
                    <template v-if="isFollowNotification(notification)">
                        <img class="h-10 w-10 items-center justify-center rounded-full"
                             :src="`/storage/${notification.data?.follower_avatar}`"
                             :alt="`${notification.data?.follower_name}'s Avatar`" />
                    </template>

                    <!-- Display text for the notifications -->
                    <h3 class="flex-auto truncate text-sm font-semibold leading-6 text-gray-900 dark:text-white">
                        <template v-if="isLikeNotification(notification) && notification.likers.length > 1">
                            {{ notification.likers[0].name }} & {{ notification.likers.length - 1 }} others
                        </template>
                        <template v-else-if="isLikeNotification(notification) && notification.likers.length === 1">
                            {{ notification.likers[0].name }}
                        </template>
                        <template v-else-if="isReplyNotification(notification)">
                            {{ notification.data.replier_name }}
                            <div class="p-2 whitespace-pre-line overflow-wrap break-words">
                                {{ notification.data.reply_body }}
                            </div>
                        </template>
                        <template v-else-if="isFollowNotification(notification)">
                            {{ notification.data.follower_name }}
                        </template>
                    </h3>

                    <time v-if="notification.created_at_human" class="flex-none text-xs text-gray-500">{{ notification.created_at_human }}</time>
                    <time v-else class="flex-none text-xs text-gray-500">{{ notification.data.created_at_human }}</time>
                </div>

                <div class="flex mt-4 gap-x-2">
                    <!-- Icon for like notifications -->
                    <template v-if="isLikeNotification(notification)">
                        <HandThumbUpIcon class="text-green-700 h-5 w-5" />
                        <p class="truncate text-sm text-gray-500 dark:text-white">Liked your Post!</p>
                    </template>
                    <!-- Icon for reply notifications -->
                    <template v-else-if="isReplyNotification(notification)">
                        <ChatBubbleBottomCenterIcon class="text-theme-purple h-5 w-5" />
                        <p class="truncate text-sm text-gray-500 dark:text-white">Replied to your Post</p>
                    </template>
                    <!-- Icon for follow notifications -->
                    <template v-if="isFollowNotification(notification)">
                        <!-- Replace with your follow icon or text -->
                        <span class="text-blue-500 h-5 w-5">👤</span>
                        <p class="truncate text-sm text-gray-500 dark:text-white">Started following you</p>
                    </template>
                </div>
            </li>
        </Link>
    </ul>
</template>
