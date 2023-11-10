<script setup>
import { ref, computed, watch } from 'vue';
import InfiniteLoader from '@/Pages/Status/Partials/InfiniteLoader.vue';
import Status from '@/Pages/Status/Partials/Status.vue';
import QuickReply from '@/Pages/Compose/Partials/QuickReply.vue';
import { ArrowLeftIcon } from '@heroicons/vue/24/outline';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
  status: Object,
  replies: Object,
  conversation: Array,
});

const { data: pageData } = usePage();
const localStatuses = ref({
  data: props.replies.data || [],
  meta: props.replies.meta || {},
});

// Watch for changes in the Inertia page props
watch(() => pageData?.value?.props?.replies, (newReplies) => {
  if (newReplies) {
    localStatuses.value.data = newReplies.data;
    localStatuses.value.meta = newReplies.meta;
  }
}, {
  deep: true,
  immediate: true
});

function goBack() {
  history.back();
}

const apiEndpoint = computed(() => localStatuses.value.meta?.path ?? '');


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

    <!-- Conversation -->
    <Status
    class=""
    :conversation="props.conversation"
    :hasBorder="false" />

    <QuickReply
        :statusId="props.status.id"/>

    <!-- Status Replies -->
    <InfiniteLoader :apiEndpoint="apiEndpoint" :initialData="localStatuses.data" :hasMore="localStatuses.meta.next_cursor">
        <template #default="{ items }">
            <Status v-for="status in items" :key="status.id" :statusData="status" :hasBorder="false" />
        </template>
    </InfiniteLoader>
    <div class="h-12"></div> <!-- What the fuck? -->

</template>
