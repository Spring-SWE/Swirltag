<script setup>
import { ref, watch } from 'vue';
import axios from 'axios';

// Props
const props = defineProps({
    userId: Number,
    isFollowing: Boolean
});

// Local state
const isCurrentlyFollowing = ref(props.isFollowing);

// Watch for changes in props.isFollowing
watch(() => props.isFollowing, (newValue) => {
    isCurrentlyFollowing.value = newValue;
});

const buttonText = ref(isCurrentlyFollowing.value ? 'Unfollow' : 'Follow');

const handleFollow = async () => {
    try {
        const action = isCurrentlyFollowing.value ? 'unfollow' : 'follow';
        await axios.post(`/${action}/${props.userId}`);
        isCurrentlyFollowing.value = !isCurrentlyFollowing.value;
        buttonText.value = isCurrentlyFollowing.value ? 'Unfollow' : 'Follow';
    } catch (error) {
        console.error('There was an error updating the follow status', error);
    }
};
</script>

<template>
    <button @click="handleFollow" class="text-sm bg-white hover:bg-gray-100 text-gray-600 font-bold py-2 px-5 rounded-full absolute right-4 top-4">
        {{ buttonText }}
    </button>
</template>
