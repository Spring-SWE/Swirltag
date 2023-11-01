
<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import DangerAlert from '@/Components/DangerAlert.vue';
import { ref, computed, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useEditor, EditorContent, } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import Link from '@tiptap/extension-link';
import { GifIcon, PhotoIcon, PaperClipIcon, } from '@heroicons/vue/24/solid';
import Mention from '@tiptap/extension-mention';
import Placeholder from '@tiptap/extension-placeholder';
import suggestion from './suggestion.js'

const editor = ref(useEditor({
    content: ``,
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
            }
        }),
        Placeholder.configure({
            emptyEditorClass: 'is-editor-empty',
            placeholder: 'The world is waiting!',
        })
    ],
}));

const clickingAwayFromThread = ref(false);
const confirmingUserDeletion = ref(false);
const errorsWithSubmission = ref(false);

const form = useForm({
    body: editor.value?.getText(),
});

//Such a terrible way to do this, but at this point
//fuck Javascript & everyone who uses it.

watch(
  () => editor.value?.getText(),
  (newValue) => {
    form.body = newValue
    console.log(newValue);
    console.log(form.body);
  }
);

const disabled = computed(() => editor.value?.isEmpty);

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
};

const storeThread = () => {
    form.post(route('store-thread'), {
        preserveScroll: true,
        onSuccess: () => {
            editor.content = '';
            closeModal()
        },
        onError: () => {
            errorsWithSubmission.value = true
        },
        //onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    closeAlert();
    confirmingUserDeletion.value = false;
    editor.value.commands.setContent("");
};

const closeAlert = () => {
    errorsWithSubmission.value = false;
};

const showWarning = () => {
    clickingAwayFromThread.value = true;

};
</script>

<template>
    <PrimaryButton text-size="lg" class="w-10/12" @click="confirmUserDeletion">Post</PrimaryButton>
    <Modal :show="confirmingUserDeletion" @close="closeModal">
        <!-- New Thread form -->

        <div class="flex gap-x-3 px-3 py-3">
            <img class="h-12 w-12 dark:bg-gray-50 rounded-full bg-gray-800" src="https://placewaifu.com/image/40" alt="" />
            <form @submit.prevent="onSubmit" action="#" class="cursorClass relative flex-auto mt-5">
                <div class="rounded-lg pb-16 shadow-sm">

                    <editor-content :editor="editor" class="block w-full resize-y border-0 bg-transparent py-1.5 dark:text-white placeholder:text-gray-400 lg:text-2xl
                        sm:text-sm sm:leading-6 focus:border-transparent focus:ring-0 focus:outline-none" />

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
                    <PrimaryButton text-size="lg" @click="storeThread" :disabled="disabled">Post</PrimaryButton>
                </div>
            </form>
        </div>
        <div v-if="form.errors.body">
            <DangerAlert :show="errorsWithSubmission" @close="closeAlert">{{ form.errors.body }}</DangerAlert>
        </div>
    </Modal>

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
}
</style>
