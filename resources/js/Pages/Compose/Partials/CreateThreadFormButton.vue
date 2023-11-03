<script setup>
import { ref, computed, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useEditor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import Link from '@tiptap/extension-link';
import Mention from '@tiptap/extension-mention';
import Placeholder from '@tiptap/extension-placeholder';
import suggestion from './suggestion.js';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import DangerAlert from '@/Components/DangerAlert.vue';
import { GifIcon, PhotoIcon, XMarkIcon } from '@heroicons/vue/24/solid';
import axios from 'axios';

// Editor setup
const editor = useEditor({
    content: '',
    extensions: [
        StarterKit,
        suggestion,
        Link,
        Mention.configure({
            HTMLAttributes: {
                class: 'mention',
            },
            matcher: {
                allowSpaces: false,
                startOfLine: false,
            },
            suggestion: {
                items: suggestion.items,
                render: suggestion.render,
            },
        }),
        Placeholder.configure({
            emptyEditorClass: 'is-editor-empty',
            placeholder: 'The world is waiting!',
        }),
    ],
});

// Reactive references
const clickingAwayFromThread = ref(false);
const confirmingUserDeletion = ref(false);
const errorsWithSubmission = ref(false);
const imagePreview = ref(null);
const mediaId = ref(null);

// Form handling
const form = useForm({
    body: editor.value?.getText(),
    files: null,
    media_id: null,
});

watch(
    () => editor.value?.getText(),
    (newValue) => {
        form.body = newValue;
    }
);

// Computed states
const disabled = computed(() => editor.value?.isEmpty);

// Methods
const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
};

const closeModal = () => {
    closeAlert();
    confirmingUserDeletion.value = false;
    editor.value?.commands.setContent('');
    imagePreview.value = null;
};

const closeAlert = () => {
    errorsWithSubmission.value = false;
};

const showWarning = () => {
    clickingAwayFromThread.value = true;
};

// Image handling
function previewFile(event) {
    const file = event.target.files[0];
    if (file) {
        form.files = file; // Update form.files with the selected file
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    imagePreview.value = null;
    form.files = null;
    const fileInput = document.querySelector('#file-upload');
    if (fileInput) {
        fileInput.value = '';
    }
}

//Upload the file
const uploadFile = async () => {
    if (!form.files) {
        return;
    }

    let formData = new FormData();
    formData.append('image', form.files);

    try {
        const response = await axios.post(route('store-media'), formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        if (response.data && response.data.id) {
            mediaId.value = response.data.id;
            // Now you can proceed to post the thread
            storeThread();
        }
    } catch (error) {
        // Handle the error case
        console.error(error);
        errorsWithSubmission.value = true;
    }
};

// Handle post button click
const handlePost = () => {
    if (form.files) {
        uploadFile();
    } else {
        storeThread();
    }
};

// Function to store the thread
const storeThread = () => {
    if (mediaId.value) {
        form.media_id = mediaId.value;
        console.log(form.media_id);
    }

    form.post(route('store-thread'), {
        preserveScroll: true,
        onSuccess: () => {
            editor.value?.commands.setContent('');
            closeModal();
        },
        onError: () => {
            errorsWithSubmission.value = true;
        },
    });
};
</script>

<template>
    <!-- Trigger button for post action -->
    <PrimaryButton text-size="lg" class="w-10/12" @click="confirmUserDeletion">
      Post
    </PrimaryButton>

    <!-- Modal for creating new thread -->
    <Modal :show="confirmingUserDeletion" @close="closeModal">
      <!-- Modal content with max height and flex column layout -->
      <div class="flex flex-col h-full max-h-[65vh]">

        <!-- Scrollable content area for form and image -->
        <div class="overflow-auto px-3 py-3">
          <div class="flex gap-x-3">
            <!-- User avatar -->
            <img class="h-12 w-12 dark:bg-gray-50 rounded-full bg-gray-800"
                 src="https://placewaifu.com/image/40" alt="" />

            <!-- Form for new thread -->
            <form @submit.prevent="onSubmit" action="#" class="flex flex-col flex-auto">
              <div class="rounded-lg shadow-sm">
                <!-- editor content -->
                <editor-content :editor="editor"
                                class="block w-full border-0 bg-transparent py-1.5 dark:text-white placeholder:text-gray-400 lg:text-2xl sm:text-sm sm:leading-6 focus:ring-0 focus:outline-none" />

                <!-- Image preview with close button -->
                    <div class="relative" v-if="imagePreview">
                    <button class="absolute top-0 right-0 mt-2 mr-2 bg-white rounded-full p-1 shadow-lg"
                            @click="removeImage">
                        <XMarkIcon class="h-5 w-5" aria-hidden="true" />
                    </button>
                  <img :src="imagePreview" alt="Image preview" class="rounded-lg mt-4" />
                </div>
              </div>
            </form>
          </div>
        </div>

        <!-- Fixed area with action buttons and file input -->
        <div class="mt-auto bg-white dark:bg-gray-800 p-3">
          <div class="flex justify-between">
            <!-- Attachment and GIF selection buttons -->
            <div class="flex space-x-5">
              <!-- Image upload button -->
              <label for="file-upload"
                     class="flex h-10 w-10 items-center justify-center rounded-full text-gray-400 hover:text-gray-500 cursor-pointer">
                <PhotoIcon class="h-5 w-5" aria-hidden="true" />
                <span class="sr-only">Upload image</span>
              </label>
              <input type="file" id="file-upload" class="hidden" @change="previewFile" />

              <!-- GIF selection button (dummy for now) -->
              <button type="button"
                      class="flex h-10 w-10 items-center justify-center rounded-full text-gray-400 hover:text-gray-500">
                <GifIcon class="h-5 w-5" aria-hidden="true" />
                <span class="sr-only">Select a GIF</span>
              </button>
            </div>

            <!-- Post button -->
            <PrimaryButton text-size="lg" @click="handlePost" :disabled="disabled">
              Post
            </PrimaryButton>
          </div>
        </div>
      </div>

      <!-- Error alert for form submission -->
      <div v-if="form.errors.body">
        <DangerAlert :show="errorsWithSubmission" @close="closeAlert">
          {{ form.errors.body }}
        </DangerAlert>
      </div>
    </Modal>

    <!-- Confirmation modal for navigating away -->
    <Modal :show="clickingAwayFromThread" @close="closeModal">
      bro are u sure?
    </Modal>
  </template>

<style lang="scss">
.tiptap {
    >*+* {
        margin-top: 0.75em;
    }
}

.mention {
    border-radius: 0.4rem;
    padding: 0.1rem 0.3rem;
    box-decoration-break: clone;
}

.tiptap p.is-editor-empty:first-child::before {
    color: #adb5bd;
    content: attr(data-placeholder);
    float: left;
    height: 0;
    pointer-events: none;
}</style>
