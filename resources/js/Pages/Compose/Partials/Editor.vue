<script setup>
import "quill-mention";
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { QuillEditor } from '@vueup/vue-quill';
import { ref, watch } from 'vue';

// Props for initial editor content
const props = defineProps({
    modelValue: String
});

const emits = defineEmits(['update:modelValue', 'editorFocus', 'editorBlur']);
const quillEditorRef = ref(null);
const editorFocused = ref(false);

// Reactive references
const editorContent = ref(props.modelValue);

// Define the editor options
const editorOptions = {
    modules: {
        mention: {
            //Mention settings, allow @ and #
            allowedChars: /^[A-Za-z\sÅÄÖåäö]*$/,
            mentionDenotationChars: ["@", "#"],
            source: async function (searchTerm, renderList, mentionChar) {
                let items = [];
                if (mentionChar === "@") {
                    // Call the function or API to get user mentions
                    items = await fetchUserMentions(searchTerm);
                } else if (mentionChar === "#") {
                    // Call the function or API to get hashtags
                    items = await fetchHashtags(searchTerm);
                }
                renderList(items);
            },
        },
        toolbar: false,
    },
    placeholder: 'The world is waiting!'
};

// Watch for editor content changes and emit an update
watch(editorContent, (newValue) => {
    if (!newValue || newValue === '') {
        clearEditor(); // Call the clearEditor method
    }
    let textContentWithMentions = "";
    newValue.ops.forEach((op) => {
        if (op.insert) {
            if (typeof op.insert === 'string') {
                // This is a regular string, just append it
                textContentWithMentions += op.insert;
            } else if (op.insert.mention) {
                // This is a mention, reconstruct it
                textContentWithMentions += op.insert.mention.denotationChar + op.insert.mention.value;
            }
        }
    });
    emits('update:modelValue', textContentWithMentions);
});

async function fetchUserMentions(searchTerm) {
    const users = [
        { id: 1, value: "Fredrik Sundqvist" },
        { id: 2, value: "Patrik Sjölin" }
    ];
    return users.filter(user => user.value.toLowerCase().includes(searchTerm.toLowerCase()));
}

// Function to fetch hashtags
async function fetchHashtags(searchTerm) {
    try {
        const response = await fetch(`/tags?searchTerm=${encodeURIComponent(searchTerm)}`);

        if (response.ok) {
            const hashtags = await response.json();
            // Transform each tag to have a `value` property instead of `name`
            const transformedTags = hashtags.map(tag => ({
                id: tag.id,
                value: tag.name // Make sure 'value' matches what the mention module expects
            }));
            return transformedTags;
        } else {
            throw new Error('Network response was not ok.');
        }
    } catch (error) {
        console.error('Could not fetch hashtags:', error);
    }
}

const clearEditor = () => {
  if (quillEditorRef.value) {
    const quill = quillEditorRef.value.getQuill();
    if (quill) {
      quill.setText('');
    }
  }
};

const handleFocus = () => {
  editorFocused.value = true;
  emits('editorFocus');
};

const handleBlur = () => {
  editorFocused.value = false;
  // Wait for 3 seconds before emitting the event
  setTimeout(() => {
    emits('editorBlur');
  }, 10000);
};

defineExpose({
  clearEditor
});

</script>


<template>
    <QuillEditor
        class="ql-editor block w-full border-0 bg-transparent py-1.5 dark:text-white placeholder:text-gray-400 sm:text-sm sm:leading-6 focus:ring-0 focus:outline-none"
        id="editor"
        ref="quillEditorRef"
        :options="editorOptions"
        v-model:content="editorContent"
        @focus="handleFocus"
        @blur="handleBlur" />
</template>

<style lang="scss">
.mention {
    border-radius: 0.4rem;
    padding: 0.1rem 0.3rem;
    box-decoration-break: clone;
}

.ql-container {
    position: relative;
    height: auto;
}

.ql-editor::before {
    color: #6B7280 !important;
    /* placeholder */
    left: 0;
}

.ql-editor p {
    font-size: 1.5rem;
    line-height: 1.5;
}

.ql-editor.ql-blank::before {
    font-size: 1.5rem;
    line-height: 1.5;
}

.ql-snow {
    border: none !important;
    overflow: visible !important;
}

/* Sometimes the toolbar has a border */
.ql-toolbar {
    border: none !important;
    border-bottom: none !important;
}

.ql-mention-list-container {
    position: absolute;
    z-index: 1050; // Ensures it is above most other elements. Increase if necessary.
    max-height: 250px; // Controls the maximum height before scrolling
    overflow-y: auto; // Allows scrolling within the popup
    border: 1px solid #d1d5db; // Subtle border color
    background-color: #ffffff; // White background for better readability
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.25); // Adds a more pronounced shadow for depth
    border-radius: 0.375rem; // Slightly rounded corners
    margin-top: 8px; // Adds a little space between the mention trigger and the popup list
    box-sizing: border-box; // Ensures that padding and border are included in the width and height
    width: auto; // Allow the box to size according to its content
}

.ql-mention-list-item {
    list-style-type: none;
    padding: 0.5rem 0.75rem;
    cursor: pointer;
    line-height: 1.5;
    color: #000;

    &:hover,
    &:focus {
        background-color: #f3f4f6; // Highlight color for items on hover/focus
    }
}

.ql-mention-list-item.selected,
.ql-mention-list-item:hover {
    background-color: #f3f4f6;
    /* This is a light grey color, change as desired */
}


/* Custom styling for the scrollbar within the mention list for Webkit browsers */
.ql-mention-list-container::-webkit-scrollbar {
    width: 5px; // Scrollbar width
}

.ql-mention-list-container::-webkit-scrollbar-thumb {
    background: #ccc; // Scrollbar color
    border-radius: 4px; // Rounded scrollbar for aesthetics
}

ql-editor ol,
.ql-editor ul {
    list-style-type: none !important;
    padding: 0 !important;
    border: 1px solid #d1d5db;
    background-color: #ffffff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1),
        0 1px 3px rgba(0, 0, 0, 0.06);
    border-radius: 0.375rem;
    overflow: hidden;
    box-sizing: border-box
}
</style>
