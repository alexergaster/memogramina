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
        <button class="focus:outline-none" @click="handlerLike(post.id)">
          <p v-if="idLikePost">❤️</p>
          <p v-else>🖤</p>
          Like
        </button>
        <button class="focus:outline-none">💬 Comment</button>
        <!-- <button class="focus:outline-none">🔁 Share</button> -->
      </div>
      <p class="text-gray-500">{{ localPost.likes.length }}</p>
    </div>
    <p class="mt-4">
      <strong>{{ post.user.username }}</strong> {{ post.caption }}
    </p>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { toggleLike } from '../api'
import { jwtDecode } from 'jwt-decode'

const props = defineProps({
  post: {
    type: Object,
    required: true,
  },
})

const userId = ref(jwtDecode(localStorage.getItem('token')).sub)
const localPost = ref({ ...props.post })

const idLikePost = computed(() => {
  return localPost.value.likes.some(item => item['id'] == userId.value)
})

const handlerLike = id => {
  toggleLike(id).then(r => {
    if (r.data.success) {
      r.data.data.message === 'Liked'
        ? localPost.value.likes.push(r.data.data.user)
        : (localPost.value.likes = localPost.value.likes.filter(
            item => item.id !== r.data.data.user.id,
          ))
    }
  })
}
</script>
