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
        <button class="focus:outline-none flex" @click="handlerLike(post.id)">
          <p class="mr-1">{{ localPost.likes.length }}</p>
          <p v-if="idLikePost">❤️ Like</p>
          <p v-else>🖤 Like</p>
        </button>
        <button class="focus:outline-none" @click="openModal">
          💬 Comment
        </button>
        <!-- <button class="focus:outline-none">🔁 Share</button> -->
      </div>
    </div>
    <p class="mt-4">
      <strong>{{ post.user.username }}</strong> {{ post.caption }}
    </p>
    <modal-item :isOpen="isModalOpen" :onClose="closeModal">
      <div class="flex items-center mb-4">
        <img
          :src="post.user.image"
          alt="avatar"
          class="rounded-full h-10 w-10"
        />
        <div class="ml-4">
          <p class="font-bold">{{ post.user.username }}</p>
          <p class="text-sm text-gray-500">2 hours ago</p>
        </div>
      </div>
      <img
        :src="post.image"
        alt="post image"
        class="w-full h-auto object-cover mb-4"
      />
      <div class="flex justify-between">
        <div class="flex space-x-4">
          <button class="focus:outline-none flex" @click="handlerLike(post.id)">
            <p class="mr-1">{{ localPost.likes.length }}</p>
            <p v-if="idLikePost">❤️ Like</p>
            <p v-else>🖤 Like</p>
          </button>
          <button class="focus:outline-none" @click="openModal">
            💬 Comment
          </button>
          <!-- <button class="focus:outline-none">🔁 Share</button> -->
        </div>
      </div>
      <div class="my-6" v-for="(comment, idx) in post.comments" :key="idx">
        <div class="flex items-center mb-2">
          <img
            :src="post.user.image"
            alt="avatar"
            class="rounded-full h-10 w-10 mr-1"
          />
          <strong>{{ comment.user.username }}</strong>
        </div>
        {{ comment.content }}
      </div>

      <form @submit.prevent="handlerComment(post.id)" class="mt-4 space-y-4">
        <div>
          <label for="caption" class="block text-sm font-medium text-gray-600"
            >Caption</label
          >
          <textarea
            name="content"
            v-model="content"
            rows="2"
            required
            class="w-full mt-1 p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          <p v-if="errors.content" class="text-red-500 text-sm">
            {{ errors.content }}
          </p>
        </div>
        <button
          type="submit"
          class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-500 transition duration-300"
        >
          Додати
        </button>
      </form>
    </modal-item>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { toggleLike, addComment } from '../api'
import { jwtDecode } from 'jwt-decode'
import ModalItem from '../components/ModalItem.vue'

const isModalOpen = ref(false)
const errors = ref({})
const content = ref('')

const props = defineProps({
  post: {
    type: Object,
    required: true,
  },
})

const openModal = () => {
  isModalOpen.value = true
}

const closeModal = () => {
  isModalOpen.value = false
}

const userId = ref(jwtDecode(localStorage.getItem('token')).sub)
const localPost = ref({ ...props.post })

const idLikePost = computed(() => {
  return localPost.value.likes.some(item => item['id'] == userId.value)
})

const handlerComment = id => {
  if (content.value.length) {
    addComment(id, { content: content.value }).then(r => {
      if (r.data.success) {
        localPost.value.comments.push(r.data.data)
        content.value = ''
      }
    })
  }
}

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
