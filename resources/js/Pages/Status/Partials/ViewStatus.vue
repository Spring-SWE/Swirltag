<script setup>
import Status from '@/Pages/Status/Partials/Status.vue'
import QuickReply from '@/Pages/Compose/Partials/QuickReply.vue';
import { ArrowLeftIcon } from '@heroicons/vue/24/outline'

const props = defineProps({

status: {
    type: Object,
},

replies: {
    type: Array
},

conversation: {
    type: Array
}
});

console.log(props.replies);

function goBack() {
  history.back();
}

</script>

<template>
    <div class="flex border-gray-200 dark:border-gray-700 pt-3">
        <div class="arrow-container hover:bg-gray-200 dark:hover:bg-gray-600 hover:rounded-full p-2 cursor-pointer"
             @click="goBack()"
        >
            <ArrowLeftIcon class="h-5 w-5 text-gray-600 dark:text-white" />
        </div>
        <p class="dark:text-white text-theme-purple font-extrabold text-2xl ml-5">
            Post
        </p>
    </div>
    <!-- Statuses -->
    <Status
    class=""
    :conversation="props.conversation"
    :hasBorder="false" />

    <QuickReply
        :statusId="props.status.id"/>

    <!-- Status Replies -->
    <Status v-for="(reply) in props.replies"
        class=""
        :key="reply.id"
        :statusData="reply"
        :hasBorder="false" />

</template>
