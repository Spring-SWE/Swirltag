<template>
    <PrimaryButton @click="confirmUserDeletion">Open Modal</PrimaryButton>
    <Modal :show="confirmingUserDeletion" @close="closeModal">
        <!-- New comment form -->
        <div class="flex">
            1
            2
        </div>
        <div class="flex gap-x-3 px-3 py-3">
            <img class="h-12 w-12 dark:bg-gray-50 rounded-full bg-gray-800" src="https://placewaifu.com/image/48" alt="" />
            <form @submit.prevent="onSubmit" action="#" class="cursorClass relative flex-auto mt-5">
                <div class="rounded-lg pb-16 shadow-sm">
                    <label for="comment" class="sr-only">Add your comment</label>
                    <textarea rows="3" name="comment" id="comment"
                        class="block w-full resize-y border-0 bg-transparent py-1.5 dark:text-white placeholder:text-gray-400 lg:text-2xl sm:text-sm sm:leading-6"
                        placeholder="The world is waiting!" />
                </div>

                <div class="absolute inset-x-0 bottom-0 flex justify-between py-2 pl-3 pr-2">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <button type="button"
                                class="-m-2.5 flex h-10 w-10 items-center justify-center rounded-full text-gray-400 hover:text-gray-500">
                                <PaperClipIcon class="h-5 w-5" aria-hidden="true" />
                                <span class="sr-only">Attach a file</span>
                            </button>
                        </div>
                        <div class="flex items-center">
                            <button type="button"
                                class="-m-2.5 flex h-10 w-10 items-center justify-center rounded-full text-gray-400 hover:text-gray-500">
                                <PhotoIcon class="h-5 w-5" aria-hidden="true" />
                                <span class="sr-only">Attach an image</span>
                            </button>
                        </div>
                        <div class="flex items-center">
                            <button type="button"
                                class="-m-2.5 flex h-10 w-10 items-center justify-center rounded-full text-gray-400 hover:text-gray-500">
                                <GifIcon class="h-5 w-5" aria-hidden="true" />
                                <span class="sr-only">Select a GIF</span>
                            </button>
                        </div>
                    </div>
                    <PrimaryButton text-size="lg">Post</PrimaryButton>
                </div>
            </form>
        </div>
    </Modal>

    <Modal :show="clickingAwayFromThread" @close="closeModal">
       bro are u sure?
    </Modal>
</template>

<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import {
    PhotoIcon,
    GifIcon,
    PaperClipIcon,
    XMarkIcon,

} from '@heroicons/vue/20/solid'

const clickingAwayFromThread = ref(false);
const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const showWarning = () => {
    clickingAwayFromThread.value = true;

};


const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

