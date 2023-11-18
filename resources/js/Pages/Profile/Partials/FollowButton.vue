<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

// Props
const props = defineProps({
    userId: Number,
});

const isCurrentlyFollowing = ref(false);
const buttonText = ref('Follow');

// Function to check follow status
const checkFollowStatus = async () => {
    try {
        const response = await axios.get(`/check-follow-status/${props.userId}`);
        isCurrentlyFollowing.value = response.data.isFollowing;
        buttonText.value = isCurrentlyFollowing.value ? 'Unfollow' : 'Follow';
    } catch (error) {
        console.error('Error checking follow status', error);
    }
};

// Call checkFollowStatus on component mount
onMounted(checkFollowStatus);

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
