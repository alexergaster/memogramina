<template>
  <div class="bg-white rounded-lg shadow p-4 relative">
    <h2 class="font-bold mb-2">Messages</h2>
    <div class="space-y-2">
      <div class="flex items-center">
        <img src="" alt="avatar" class="rounded-full h-10 w-10" />
        <div class="ml-4">
          <p class="font-bold">Friend 1</p>
          <p class="text-sm text-gray-500">Last message...</p>
        </div>
      </div>
      <div class="flex items-center">
        <img src="" alt="avatar" class="rounded-full h-10 w-10" />
        <div class="ml-4">
          <p class="font-bold">Friend 2</p>
          <p class="text-sm text-gray-500">Last message...</p>
        </div>
      </div>
      <div class="flex items-center">
        <img src="  " alt="avatar" class="rounded-full h-10 w-10" />
        <div class="ml-4">
          <p class="font-bold">Friend 3</p>
          <p class="text-sm text-gray-500">Last message...</p>
        </div>
      </div>
    </div>
    <button class="mt-4 w-full bg-blue-500 text-white py-2 rounded">
      View All Messages
    </button>

    <div
      v-if="!user.isLoggedIn"
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
  user: {
    type: Object,
    required: true,
  },
})
</script>
