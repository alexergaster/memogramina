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
          :to="{ name: 'account', params: { id: user.id } }"
          active-class="text-black font-bold"
          class="text-gray-600 hover:text-black"
        >
          Account
        </router-link>
        <a
          href="#"
          active-class="text-black font-bold"
          class="text-gray-600 hover:text-black"
          >Messages</a
        >
        <a
          href="#"
          active-class="text-black font-bold"
          class="text-gray-600 hover:text-black"
          >Profile</a
        >
        <button
          class="focus:outline-none"
          v-if="isAuthenticated"
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
import { logout } from '../api'
import { ref } from 'vue'
import { useStore } from 'vuex'

const store = useStore()
const isAuthenticated = ref(store.state.isAuthenticated)

defineProps({
  user: {
    type: Object,
    required: true,
  },
})

const logoutUser = () => {
  logout(localStorage.getItem('token')).then(response => {
    if (response.data.success) {
      localStorage.removeItem('token')
      isAuthenticated.value = false
    }
  })
}
</script>
