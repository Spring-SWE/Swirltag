<script setup>
import Editor from '@/Pages/Compose/Partials/Editor.vue';
import ImagePreview from './ImagePreview.vue';
import { ref, watch, computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerAlert from '@/Components/DangerAlert.vue';
import { GifIcon, PhotoIcon } from '@heroicons/vue/24/solid';
import axios from 'axios';
const page = usePage().props;

const props = defineProps({
    statusId: {
        type: Number,
    },
});

const emit = defineEmits(['quick-replied']);

// Reactive references
const editorText = ref('');
const editorRef = ref(null);
const errorsWithSubmission = ref(false);
const mediaId = ref(null);
const uploadProgress = ref(0);
const postingDisabled = ref(false);
const imageFile = ref(null);
const imagePreviewSrc = ref(null);
const showPostingBar = ref(false);
const placeholder = ref("Post your reply")

// Form handling
const form = useForm({
    body: '',
    files: null,
    media_id: null,
    status_id: props.statusId,
});

// Methods
const updateEditorContent = (newContent) => {
    editorText.value = newContent;
    form.body = newContent;
};

const postDisabled = () => {
    postingDisabled.value = true;
}

const clearTextarea = () => {
    closeAlert();
    form.reset();
    mediaId.value = null;
    uploadProgress.value = 0;
    postingDisabled.value = false;
    imagePreviewSrc.value = null;
    imageFile.value = null;
    clearEditorInParent();
};

const closeAlert = () => {
    errorsWithSubmission.value = false;
    //user saw error, allow posting again.
    postingDisabled.value = false;
    uploadProgress.value = 0;

};

const clearEditorInParent = () => {
  editorRef.value.clearEditor();
};

function handleFileChange(event) {
  const file = event.target.files[0];
  if (file) {
    imagePreviewSrc.value = URL.createObjectURL(file);
    imageFile.value = file;
  }
}

function removeImage() {
  imagePreviewSrc.value = null;
  // Reset the file input
  const fileInput = document.getElementById('file-upload');
  if (fileInput) {
    fileInput.value = '';
  }
}

// Upload the file
const uploadFile = async () => {
    if (!imageFile.value) {
    return;
    }
    uploadProgress.value = 0;
    postingDisabled.value = true;
    let formData = new FormData();
    formData.append('image', imageFile.value);

    try {
        const response = await axios.post(route('store-media'), formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
            onUploadProgress: (progressEvent) => {
                // Calculate the percentage and update uploadProgress
                uploadProgress.value = parseInt(Math.round((progressEvent.loaded * 100) / progressEvent.total));
            }
        });

        if (response.data && response.data.id) {
            mediaId.value = response.data.id;
            // Now proceed to post the thread
            uploadProgress.value = 0;
            storeComment();
        }
    } catch (error) {
        if (error.response && error.response.status === 422) {
            // Assign the body errors if they exist
            if (error.response.data.errors && error.response.data.errors.image) {
                form.errors.body = error.response.data.errors.image.join(' ');
            }
            // Set a general error message if there's no specific field error message
            else if (error.response.data.message) {
                form.errors.body = error.response.data.message;
            }
            errorsWithSubmission.value = true;
        } else {
            // Handle other types of errors
            console.error('An unexpected error occurred:', error);
            form.errors.body = 'An unexpected error occurred. Please try again.';
            errorsWithSubmission.value = true; // Trigger the error alert
        }
    }

    return {
        uploadProgress,
    };
};

// Handle post button click
const handlePost = () => {
  if (imageFile.value) {
    // If there is an image selected, start the upload process
    uploadFile();
  } else {
    // If not, proceed with the other posting logic
    storeComment();
  }
};

// Function to store the thread
const storeComment = () => {

postDisabled();

if (mediaId.value) {
    form.media_id = mediaId.value;
}

form.post(route(`store-status`), {
    preserveScroll: true,
    onSuccess: () => {
        clearTextarea();
        emit('quick-replied');
    },
    onError: () => {
        errorsWithSubmission.value = true;
    },
});
};

/** needs refactor soon. */
watch(() => form.body, (newBody, oldBody) => {
  if (newBody.length < 2) {
    postDisabled();
  } else {
    postingDisabled.value = false;
  }
}, { immediate: true });

const progressPercentage = computed(() => {
  return (form.body.length / 1000) * 100;
});

const handleEditorFocus = () => {
    showPostingBar.value = true;
};

// const handleEditorBlur = () => {
//   showPostingBar.value = false;
// };
</script>

<template>

        <!-- Quick Reply content with max height and flex column layout -->
        <div class=" border-gray-100 dark:border-gray-700 mt-1">

            <!-- Progress bar content -->
            <div v-if="form.progress" class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                <div class="h-3 text-center text-white bg-theme-purple" :style="{ width: form.progress.percentage + '%' }">
                </div>
            </div>

            <!-- Scrollable content area for form and image -->
            <div class="overflow-auto px-3 py-3">
                <div class="flex gap-x-3">
                    <!-- User avatar -->
                    <div v-if="page.auth?.user?.avatar">
                        <img class="h-12 w-12 dark:bg-gray-50 rounded-full bg-gray-800"
                        :src="`/storage/${page.auth.user.avatar}`"
                        alt="user avatar" />
                    </div>
                    <div v-else>
                        <img class="h-12 w-12 dark:bg-gray-50 rounded-full bg-gray-800"
                        :src="`/storage/media/avatars/usericon.png`"
                         alt="User Avatar"
                        />
                    </div>

                    <!-- Form for new thread -->
                    <form @submit.prevent="onSubmit" action="#" class="flex flex-col flex-auto">
                        <div class="rounded-lg shadow-sm">

                            <!--  Quill Editor -->
                            <Editor ref="editorRef"
                                    v-model="editorText"
                                    @update:modelValue="updateEditorContent"
                                    @editorFocus="handleEditorFocus"
                                    :placeholder="placeholder"/>

                            <!-- Progress bar Media -->
                            <div v-if="uploadProgress && !errorsWithSubmission"
                                class="p-2 text-sm text-theme-purple "
                                role="alert">

                                <div class="h-3 text-center text-white bg-theme-purple"
                                    :style="{ width: uploadProgress + '%' }">
                                </div>
                            </div>

                            <!-- Error alert for form submission -->
                            <div v-if="form.errors.body" class="mt-1 pb-2">
                                <DangerAlert :show="errorsWithSubmission" @close="closeAlert">
                                    {{ form.errors.body }}
                                </DangerAlert>
                            </div>

                            <!-- Alert on too many chacerters-->
                            <DangerAlert :show="progressPercentage >= 100" @close="closeAlert">
                                You cannot post more than 1000 characters.
                            </DangerAlert>

                            <!-- Image preview with close button -->
                           <ImagePreview :imageSource="imagePreviewSrc" @remove="removeImage" />
                        </div>
                    </form>
                </div>
            </div>

            <!-- Fixed area with action buttons and file input -->
            <div class="mt-auto pl-3 pr-3  border-gray-200 dark:border-gray-700 border-b">
                <div class="flex justify-between">
                    <!-- Attachment and GIF selection buttons -->
                    <div class="flex space-x-5" v-if="showPostingBar">
                        <!-- Image upload button -->
                        <label for="file-upload"
                            class="flex h-10 w-10 items-center justify-center rounded-full text-gray-400 hover:text-gray-500 cursor-pointer">
                            <PhotoIcon class="h-5 w-5" aria-hidden="true" />
                            <span class="sr-only">Upload image</span>
                        </label>
                        <input type="file" id="file-upload" class="hidden" @change="handleFileChange" />

                        <!-- GIF selection button (dummy for now) -->
                        <button type="button"
                            class="flex h-10 w-10 items-center justify-center rounded-full text-gray-400 hover:text-gray-500">
                            <GifIcon class="h-5 w-5" aria-hidden="true" />
                            <span class="sr-only">Select a GIF</span>
                        </button>

                        <!-- Radial Progress percent -->
                         <div class="" v-if="progressPercentage > 5">
                            <div class="radial-progress text-theme-purple mt-[5px]"
                            :style="{ '--value': progressPercentage, '--size': '1.5rem', '--thickness': '3px' }"></div>
                        </div>

                    </div>

                    <!-- Post button -->
                    <PrimaryButton text-size="lg"
                    class="mb-2"
                    v-if="showPostingBar"
                    :disabled="postingDisabled"
                    @click="handlePost">
                        Post
                    </PrimaryButton>
                </div>
            </div>
        </div>
</template>

