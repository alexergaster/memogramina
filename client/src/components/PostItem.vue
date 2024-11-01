<template>
  <div class="p-4">
    <!-- Шапка посту -->
    <div class="flex items-center mb-4">
      <img :src="post.user.image" alt="avatar" class="rounded-full h-10 w-10" />
      <div class="ml-4">
        <p class="font-bold">{{ post.user.username }}</p>
        <p class="text-sm text-gray-500">2 hours ago</p>
      </div>
    </div>
    <!-- Зображення посту -->
    <img
      :src="post.image"
      alt="post image"
      class="w-full h-auto object-cover mb-4"
    />
    <!-- Взаємодії -->
    <div class="flex justify-between">
      <div class="flex space-x-4">
        <button class="focus:outline-none">❤️ Like</button>
        <button class="focus:outline-none">💬 Comment</button>
        <!-- <button class="focus:outline-none">🔁 Share</button> -->
      </div>
      <p class="text-gray-500">{{ post.likes.length }}</p>
    </div>
    <p class="mt-4">
      <strong>{{ post.user.username }}</strong> {{ post.caption }}
    </p>
  </div>
</template>

<script setup>
defineProps({
  post: {
    type: Object,
    required: true,
  },
})
</script>
