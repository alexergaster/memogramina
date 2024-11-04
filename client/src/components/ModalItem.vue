<template>
  <div
    v-if="isOpen"
    class="fixed z-50 inset-0 flex items-center justify-center bg-black bg-opacity-50"
    @click.self="close"
  >
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-3xl w-full relative">
      <button
        class="absolute top-4 px-4 py-2 bg-blue-500 text-white rounded right-4 hover:text-gray-800"
        @click="close"
      >
        ×
      </button>
      <div class="modal-content max-h-[80vh] overflow-y-auto p-4">
        <slot></slot>
      </div>
    </div>
  </div>
</template>

<script setup>
import { watch } from 'vue'

const props = defineProps({
  isOpen: { type: Boolean, required: true },
  onClose: { type: Function, required: true },
})

function close() {
  if (props.onClose) {
    props.onClose()
  }
}
const disableBodyScroll = () => {
  document.body.classList.add('overflow-hidden')
}

const enableBodyScroll = () => {
  document.body.classList.remove('overflow-hidden')
}

watch(
  () => props.isOpen,
  newVal => {
    if (newVal) {
      disableBodyScroll()
    } else {
      enableBodyScroll()
    }
  },
)
</script>
