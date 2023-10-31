<template>
    <div
      ref="contentEditable"
      class="block w-full resize-y border-0 bg-transparent py-1.5 dark:text-white placeholder:text-gray-400 lg:text-2xl sm:text-sm sm:leading-6 focus:border-transparent focus:ring-0"
      contenteditable
      @input="updateText"
      @keydown="enterPressed"
    ></div>
  </template>

  <script>
  import { reactive, ref } from 'vue';
  import Twitter from 'twitter-text';
  import debounce from 'lodash.debounce';
  import { createEditor, Transforms, Editor } from 'slate';
import { Slate, Editable, withReact } from 'slate-react';


  export default {
    name: 'ContentEditable',
    props: {
      value: String,
    },
    setup(props, { emit }) {
      const contentEditable = ref('');

      const updateText = (event) => {
        contentEditable.value = event.target.innerText;
        emit('update:modelValue', contentEditable.value);
      };

      const enterPressed = debounce(() => {
  let currentText = contentEditable.value;

  // Convert to string if currentText is not already a string
  if (typeof currentText !== 'string') {
    currentText = String(currentText);
  }

  // Check if the current text contains any links
  const linkRegex = /(https?:\/\/[^\s]+)/g;
  if (!linkRegex.test(currentText)) {
    const newText = Twitter.autoLink(currentText, {
      targetBlank: true, // Open links in a new tab
    });
    contentEditable.value = newText;
    emit('update:modelValue', contentEditable.value);
  }
}, 500);



      return {
        contentEditable,
        updateText,
        enterPressed,
      };
    },
  };
  </script>
