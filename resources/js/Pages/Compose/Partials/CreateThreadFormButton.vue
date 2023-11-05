<script setup>
import { ref, computed, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import DangerAlert from '@/Components/DangerAlert.vue';
import { GifIcon, PhotoIcon, XMarkIcon } from '@heroicons/vue/24/solid';
import axios from 'axios';
import "quill-mention";
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { QuillEditor } from '@vueup/vue-quill'

// Reactive references
const editorContent = ref('');
const quillEditorRef = ref(null);
const quillInstance = ref(null);
const clickingAwayFromThread = ref(false);
const confirmingUserDeletion = ref(false);
const errorsWithSubmission = ref(false);
const imagePreview = ref(null);
const mediaId = ref(null);
const uploadProgress = ref(0);
const postingDisabled = ref(false);

// Form handling
const form = useForm({
    body: '',
    files: null,
    media_id: null,
});

// Define the editor options
const editorOptions = {
    modules: {
        mention: {
            allowedChars: /^[A-Za-z\sÅÄÖåäö]*$/,
            mentionDenotationChars: ["@", "#"],
            source: async function (searchTerm, renderList) {
                // Assuming `suggestPeople` is a function that returns an array of mentions
                const matchedPeople = await suggestPeople(searchTerm);
                renderList(matchedPeople);
            },
        },
        toolbar: false, // disables the toolbar
    },
    placeholder: 'The world is waiting!'
};

async function suggestPeople(searchTerm) {
    const allPeople = [
        {
            id: 1,
            value: "Fredrik Sundqvist"
        },
        {
            id: 2,
            value: "Patrik Sjölin"
        }
    ];
    return allPeople.filter(person => person.value.includes(searchTerm));
}

watch(editorContent, (newValue, oldValue) => {
    // This will run whenever editorContent changes
    quillInstance.value = quillEditorRef.value.getQuill();
    form.body = quillInstance.value.getText();
})

// Methods
const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
};

const postDisabled = () => {
    postingDisabled.value = true;
}

const closeModal = () => {
    closeAlert();
    form.reset();
    confirmingUserDeletion.value = false;
    quillInstance.value?.setText('');
    imagePreview.value = null;
    mediaId.value = null;
    uploadProgress.value = 0;
    postingDisabled.value = false;
};

const closeAlert = () => {
    errorsWithSubmission.value = false;
    //user saw error, allow posting again.
    postingDisabled.value = false;
    uploadProgress.value = 0;

};

const showWarning = () => {
    clickingAwayFromThread.value = true;
};

// Image handling
function previewFile(event) {
    const file = event.target.files[0];
    if (file) {
        // Check if the file type is an image
        if (file.type.startsWith('image/')) {
            form.files = file; // Update form.files with the selected file
            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreview.value = e.target.result; // This will be the image to display
            };
            reader.readAsDataURL(file);
        } else {
            form.files = null; // Reset the files if not an image
            imagePreview.value = null; // Clear any previous image previews
            // Optionally, alert the user that the file is not an image
            alert('Please select an image file.');
        }
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

// Upload the file
const uploadFile = async () => {

    postDisabled();

    if (!form.files) {
        return;
    }

    uploadProgress.value = 0;

    let formData = new FormData();
    formData.append('image', form.files);

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
            storeThread();
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
            // You can set a general error message for unexpected errors
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
    if (form.files) {
        uploadFile();
    } else {
        storeThread();
    }
};

// Function to store the thread
const storeThread = () => {

    postDisabled();

    if (mediaId.value) {
        form.media_id = mediaId.value;
    }

    form.post(route('store-thread'), {
        preserveScroll: true,
        onSuccess: () => {
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
        <div class="flex flex-col h-full min-h-[25vh] max-h-[65vh]">

            <!-- Error alert for form submission -->
            <div v-if="form.errors.body">
                <DangerAlert :show="errorsWithSubmission" @close="closeAlert">
                    {{ form.errors.body }}
                </DangerAlert>
            </div>

            <!-- Progress bar content -->
            <div v-if="form.progress" class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                <div class="h-3 text-center text-white bg-theme-purple" :style="{ width: form.progress.percentage + '%' }">
                </div>
            </div>

            <!-- Scrollable content area for form and image -->
            <div class="overflow-auto px-3 py-3">
                <div class="flex gap-x-3">

                    <!-- User avatar -->
                    <img class="h-12 w-12 dark:bg-gray-50 rounded-full bg-gray-800" src="https://placewaifu.com/image/40"
                        alt="" />

                    <!-- Form for new thread -->
                    <form @submit.prevent="onSubmit" action="#" class="flex flex-col flex-auto">
                        <div class="rounded-lg shadow-sm">

                            <QuillEditor
                                class="ql-editor block w-full border-0 bg-transparent py-1.5 dark:text-white placeholder:text-gray-400 sm:text-sm sm:leading-6 focus:ring-0 focus:outline-none"
                                id="editor"
                                ref="quillEditorRef"
                                :options="editorOptions"
                                v-model:content="editorContent" />


                            <!-- Progress bar Media -->
                            <div v-if="uploadProgress && !errorsWithSubmission"
                                class="p-2 text-sm text-theme-purple rounded-lg bg-blue-50 dark:bg-gray-700 dark:text-blue-400"
                                role="alert">
                                <span class="font-medium">We're processing your media...</span>
                                <div class="h-3 text-center text-white bg-theme-purple"
                                    :style="{ width: uploadProgress + '%' }">
                                </div>
                            </div>

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

                        <div class="mt-1">
                            <span class="text-gray-400 hover:text-gray-500 text-xs">
                                {{ form.body.length }}/320
                            </span>
                        </div>
                    </div>

                    <!-- Post button -->
                    <PrimaryButton text-size="lg" :disabled="postingDisabled" @click="handlePost">
                        Post
                    </PrimaryButton>
                </div>
            </div>
        </div>

    </Modal>

    <!-- Confirmation modal for navigating away -->
    <Modal :show="clickingAwayFromThread" @close="closeModal">
        bro are u sure?
    </Modal>
</template>

<style lang="scss">
.mention {
    border-radius: 0.4rem;
    padding: 0.1rem 0.3rem;
    box-decoration-break: clone;
}

.ql-container {
    height: auto;
}

.ql-editor::before {
    color: #6B7280 !important;
    /* placeholder */
    left: 0;
}

.ql-editor {
    /* Tailwind classes wont work for some reason */
    font-size: 1.5rem;
    line-height: 1.5;
}

.ql-snow {
    border: none !important;
}

/* Sometimes the toolbar has a border */
.ql-toolbar {
    border: none !important;
    border-bottom: none !important;
}


/* Style the mention list container to be fixed relative to the viewport */
.ql-mention-list-container {
    position: fixed;
    z-index: 99999;
    max-height: 200px;
    width: auto;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 1px solid #ccc;
    background-color: #fff;
    border-radius: 4px;
}

/* Style each item in the mention list */
.ql-mention-list-item {
    padding: 10px 15px;
    cursor: pointer;
    line-height: 1.5;
}

/* Highlighted state for mention list items */
.ql-mention-list-item.selected {
    background-color: #f0f0f0;
}

/* Style for list items on hover */
.ql-mention-list-item:hover {
    background-color: #f0f0f0;
}
</style>
