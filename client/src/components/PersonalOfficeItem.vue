<template>
  <!-- Основний вміст профілю -->
  <div class="bg-white rounded-lg shadow p-4 my-4 relative">
    <div class="flex items-center">
      <img src="" alt="avatar" class="rounded-full h-16 w-16" />
      <div class="ml-4">
        <p class="font-bold text-lg">User Name</p>
        <p class="text-gray-500">@username</p>
      </div>
    </div>
    <button class="mt-4 w-full bg-blue-500 text-white py-2 rounded">
      Edit Profile
    </button>

    <div
      v-if="!isUserLoggedIn"
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
defineProps({
  isUserLoggedIn: {
    type: Boolean,
    required: true,
  },
})
</script>
