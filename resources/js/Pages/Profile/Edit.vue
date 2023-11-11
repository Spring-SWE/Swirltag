<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    username: '',
    about: '',
    website: '',
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
      <Head title="Edit Profile" />

      <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
      </div>

      <!-- Avatar Upload Section -->
      <div class="flex items-center justify-center mb-4">
        <!-- Display the user's current avatar here if available -->
        <div class="avatar">
                <div class="w-24 rounded-full ring ring-gray-800 ring-offset-base-50 ring-offset-2">
                    <img src="https://i.pravatar.cc/150" class="" />
                </div>
            </div>
        <div class="ml-4">
          <label for="avatar" class="cursor-pointer text-blue-500 hover:text-blue-700">
            <input
              id="avatar"
              type="file"
              class="hidden"
              @change="handleAvatarUpload"
            />
            Change Avatar
          </label>
        </div>
      </div>

      <form @submit.prevent="submit" class="col-span-12 lg:col-span-8">
        <div>
          <InputLabel for="username" value="Username" />

          <TextInput
            id="username"
            type="text"
            class="mt-1 block w-full"
            v-model="form.username"
            required
            autofocus
            autocomplete="username"
          />

          <InputError class="mt-2" :message="form.errors.username" />
        </div>

        <div class="mt-4">
          <InputLabel for="about" value="Bio" />

          <textarea
            id="about"
            class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
            v-model="form.about"
            rows="5"
          ></textarea>

          <InputError class="mt-2" :message="form.errors.about" />
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
          />

          <InputError class="mt-2" :message="form.errors.website" />
        </div>

        <div class="flex items-center justify-end mt-4">
          <PrimaryButton
            type="submit"
            :disabled="form.processing"
            :loading="form.processing"
          >
            Save Changes
          </PrimaryButton>
        </div>
      </form>
    </div>
  </template>
