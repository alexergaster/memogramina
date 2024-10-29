<template>
  <nav class="bg-white border-b fixed top-0 w-full z-10">
    <div class="container mx-auto flex justify-between items-center py-2">
      <router-link to="/" class="text-2xl font-bold">MemoGrammina</router-link>
      <div class="flex space-x-4">
        <router-link
          to="/"
          class="text-gray-600 hover:text-black"
          active-class="text-black font-bold"
        >
          Home
        </router-link>
        <router-link
          :to="{ name: 'profile', params: { id: user.id } }"
          active-class="text-black font-bold"
          class="text-gray-600 hover:text-black"
        >
          Profile
        </router-link>
        <a
          href="#"
          active-class="text-black font-bold"
          class="text-gray-600 hover:text-black"
          >Messages</a
        >
        <button
          class="focus:outline-none"
          v-if="user.isLoggedIn"
          @click="logoutUser"
        >
          <img
            src="../assets/images/logout.png"
            alt="Logout"
            class="h-6 w-6 -scale-x-100"
          />
        </button>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { defineEmits } from 'vue'
import { logout } from '../api'

const emit = defineEmits({
  userLogout: {
    type: Boolean,
    required: true,
    default: true,
  },
})
defineProps({
  user: {
    type: Object,
    required: true,
  },
})

const logoutUser = () => {
  logout(localStorage.getItem('token')).then(response => {
    if (response.success) {
      localStorage.removeItem('token')
      emit('userLogout', false)
    }
  })
}
</script>
