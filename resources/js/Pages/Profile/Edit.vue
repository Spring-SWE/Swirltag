<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { defineProps, reactive } from "vue";
import {
   PhotoIcon
} from '@heroicons/vue/24/solid'

const props = defineProps({
  status: {
    type: String,
  },
  userData: {
    type: Object,
  },
});

const form = useForm({
  name: props.userData.name,
  description: props.userData.description,
  website: props.userData.website,
  avatar: null,
  userId: props.userData.id,
});

const data = reactive({
  avatarUrl: props.userData.avatar ? `/storage/${props.userData.avatar}` : null,
});

const handleAvatarUpload = (event) => {
  const file = event.target.files[0];

  if (file) {
   // Create a URL for the selected image and update the avatar URL
   data.avatarUrl = URL.createObjectURL(file);

    // Update the form's avatar property with the selected image file
    form.avatar = file;
  }
};

const submitProfileUpdate = () => {
  form.post("profile-update", {
    preserveScroll: true,
    onError: (error) => {
      console.log(error);
    },
  });
};
</script>

<template>
    <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
      <Head title="Edit Profile" />

      <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
      </div>

      <form @submit.prevent="submitProfileUpdate" class="col-span-12 lg:col-span-8">
      <!-- Avatar Upload Section -->
      <div class="flex items-center justify-center mb-4">
        <div class="avatar relative">
          <label
            class="w-24 h-24 rounded-full ring ring-gray-800 ring-offset-base-50 ring-offset-2 flex items-center justify-center cursor-pointer relative"
            for="avatar"
          >
            <!-- Slightly transparent black background -->
            <div class="bg-black opacity-30 absolute inset-0 rounded-full"></div>

            <!-- Display the uploaded image if available, otherwise use the default avatar -->
            <img :src="data.avatarUrl" class="rounded-full" />

            <!-- Centered icon for changing avatar -->
            <PhotoIcon class="text-gray-400 h-5 w-5 absolute" style="top: 50%; left: 50%; transform: translate(-50%, -50%); opacity: 0.7;" />
          </label>
          <input id="avatar" type="file" class="hidden" @change="handleAvatarUpload" />
        </div>
      </div>


        <div>
          <InputLabel for="name" value="name" />
          <TextInput
            id="name"
            type="text"
            class="mt-1 block w-full"
            v-model="form.name"
            required
            autofocus
            autocomplete="name"
            :modelValue="props.userData.name"
          />
          <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <div class="mt-4">
          <InputLabel for="description" value="description" />
          <textarea
            id="description"
            class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
            v-model="form.description"
            rows="5"
          ></textarea>
          <InputError class="mt-2" :message="form.errors.description" />
        </div>

        <div>
          <InputLabel for="website" value="Website" />
          <TextInput
            id="website"
            type="text"
            class="mt-1 block w-full"
            v-model="form.website"
            required
            autofocus
            autocomplete="website"
            :modelValue="props.userData.website"
          />
          <InputError class="mt-2" :message="form.errors.website" />
        </div>

        <div class="flex items-center justify-end mt-4">
          <PrimaryButton
            @click="submitProfileUpdate"
            type="submit"
            :disabled="form.processing"
            :loading="form.processing"
          >
            Save Changes
          </PrimaryButton>
        </div>
      </form>
      <input id="avatar" type="file" class="hidden" @change="handleAvatarUpload" ref="avatarInput" />
    </div>
  </template>
