<template>
  <!-- Основний вміст профілю -->
  <div class="bg-white rounded-lg shadow p-4 my-4 relative">
    <div class="flex items-center">
      <img :src="user.image" alt="avatar" class="rounded-full h-16 w-16" />
      <div class="ml-4">
        <p class="font-bold text-lg">{{ user.name }}</p>
        <p class="text-gray-500">{{ user.username }}</p>
      </div>
    </div>
    <router-link
      :to="{ name: 'account', params: { id: user.id } }"
      class="mt-4 block w-full bg-blue-500 text-white py-2 rounded text-center"
    >
      My Account
    </router-link>
    {{}}
    <div
      v-if="!isAuthenticated"
      class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-50 backdrop-blur-sm rounded-lg"
    >
      <p class="text-black text-lg font-semibold text-center cursor-default">
        Будь ласка,
        <router-link to="/login" class="underline">увійдіть</router-link> в
        систему для доступу до профілю
      </p>
    </div>
  </div>
</template>

<script setup>
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
</script>
