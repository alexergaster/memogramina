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
            <div class="flex space-x-6 mt-2">
              <span class="font-semibold">{{ user.posts.length }}</span>
              <span>постів</span> <span class="font-semibold">500</span>
              <span>підписників</span> <span class="font-semibold">300</span>
              <span>підписок</span>
            </div>
          </div>
        </div>
      </div>

      <button v-if="editingRights">TEST</button>

      <div v-if="user.posts.length" class="mt-8 grid grid-cols-3 gap-4">
        <div
          v-for="(post, idx) in user.posts"
          :key="idx"
          class="bg-white shadow-lg rounded-lg overflow-hidden"
        >
          <img
            :src="post.image"
            alt="Пост 1"
            class="w-full h-64 object-cover"
          />
          <p class="mt-2 text-gray-700 p-2">
            {{ post.caption }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute } from 'vue-router'
import { jwtDecode } from 'jwt-decode'
import { getUser } from '../api'
import NavItem from '../components/NavItem.vue'

const user = ref({})
const route = useRoute()
const token = localStorage.getItem('token')

const editingRights = computed(() => {
  return user.value.id ? user.value.id == jwtDecode(token).sub : false
})

onMounted(() => {
  const userId = route.params.id

  getUser(userId).then(response => {
    if (response.success) {
      user.value = response.data
      user.value.isLoggedIn = token ? true : false
    } else {
      // TODO
    }
  })
})
</script>
