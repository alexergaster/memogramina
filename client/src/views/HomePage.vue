<template>
  <div class="bg-gray-100">
    <nav-item :user="user" />
    <!-- Основний контент -->
    <div class="container mx-auto mt-16 flex justify-between pb-4">
      <!-- Сторінка постів -->
      <div class="w-2/3">
        <!-- Пост -->
        <template v-if="posts.length">
          <post-item
            v-for="post in posts"
            :key="post.id"
            :post="post"
            class="bg-white rounded-lg shadow my-4"
          />
        </template>
        <div v-else><h2>No memes 😥</h2></div>
      </div>
      <!-- Бічна панель -->
      <div class="w-1/3 ml-3">
        <!-- Особистий кабінет -->
        <personal-office-item :user="user" />

        <!-- Месенджер -->
        <messenger-item :user="user" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { getPosts, getUserData } from '../api.js'

import PostItem from '../components/PostItem.vue'
import PersonalOfficeItem from '../components/PersonalOfficeItem.vue'
import MessengerItem from '../components/MessengerItem.vue'
import NavItem from '../components/NavItem.vue'

const posts = ref([])
const user = ref({ id: -1 })

onMounted(() => {
  getPosts().then(response => {
    if (response.data.status) {
      posts.value = response.data.data
    }
  })

  getUserData().then(r => {
    if (r.success) {
      user.value = r.user
    }
  })
})
</script>
