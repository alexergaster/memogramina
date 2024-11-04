<template>
  <div class="bg-gray-100" v-if="user.id">
    <nav-item :user="user" />

    <div class="container mx-auto p-6 mt-20">
      <div class="bg-white shadow-lg rounded-lg p-6">
        <div class="flex items-center">
          <img
            :src="user.image"
            alt="Профіль"
            class="w-24 h-24 rounded-full border-2 border-gray-300 mr-4"
          />
          <div>
            <h1 class="text-2xl font-bold">{{ user.name }}</h1>
            <p class="text-gray-600">{{ user.username }}</p>
            <div class="flex space-x-4 mt-2 items-center">
              <div class="space-x-2">
                <span class="font-semibold">{{ posts.length }}</span>
                <span>постів</span>
              </div>
              <div class="space-x-2">
                <span class="font-semibold">{{ user.followers.length }}</span>
                <span>підписників</span>
              </div>
              <div class="space-x-2">
                <span class="font-semibold">{{ user.following.length }}</span>
                <span>підписок</span>
              </div>
              <div class="space-x-2">
                <button
                  v-if="editingRights"
                  @click="openModal"
                  class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                >
                  Додати пост
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div v-if="posts.length" class="mt-8 grid grid-cols-3 gap-4">
        <post-item v-for="(post, idx) in posts" :key="idx" :post="post" />
      </div>
      <div v-else><h2>No posts 😥</h2></div>
    </div>

    <!-- Modal for add posts -->
    <modal-item :isOpen="isModalOpen" :onClose="closeModal">
      <h1 class="text-center font-bold text-2xl">Add a new Post</h1>
      <form @submit.prevent="handleSubmit" method="POST" class="mt-4 space-y-4">
        <div>
          <label for="image" class="block text-sm font-medium text-gray-600"
            >Image</label
          >
          <input
            @change="handleFileChange"
            type="file"
            name="image"
            required
            class="w-full mt-1 p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          <p v-if="errors.image" class="text-red-500 text-sm">
            {{ errors.image }}
          </p>
        </div>

        <div>
          <label for="caption" class="block text-sm font-medium text-gray-600"
            >Caption</label
          >
          <textarea
            type="caption"
            name="caption"
            v-model="caption"
            rows="5"
            required
            class="w-full mt-1 p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          <p v-if="errors.caption" class="text-red-500 text-sm">
            {{ errors.caption }}
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
import { ref, onMounted, computed } from 'vue'
import { useRoute } from 'vue-router'
import { jwtDecode } from 'jwt-decode'
import { getUser, addPost } from '../api'
import NavItem from '../components/NavItem.vue'
import ModalItem from '../components/ModalItem.vue'
import PostItem from '../components/PostItem.vue'

const user = ref({})
const posts = ref({})
const route = useRoute()
const token = localStorage.getItem('token')
const caption = ref('')
const image = ref(null)
const errors = ref({})

const editingRights = computed(() => {
  return user.value.id ? user.value.id == jwtDecode(token).sub : false
})

const isModalOpen = ref(false)

function openModal() {
  isModalOpen.value = true
}

function closeModal() {
  isModalOpen.value = false
}

const handleFileChange = event => {
  image.value = event.target.files[0]
}

const handleSubmit = () => {
  const formData = new FormData()
  formData.append('image', image.value)
  formData.append('caption', caption.value)
  formData.append('user_id', route.params.id)

  addPost(formData).then(r => {
    if (r.data.success) {
      closeModal()

      user.value.posts.unshift(r.data.post)
    }
  })
}

onMounted(() => {
  const userId = route.params.id

  getUser(userId).then(response => {
    if (response.data.success) {
      user.value = response.data.data.user
      posts.value = response.data.data.posts
    }
  })
})
</script>
