<template>
  <div class="bg-gray-100">
    <nav class="bg-white border-b fixed top-0 w-full z-10">
      <div class="container mx-auto flex justify-between items-center py-2">
        <div class="text-2xl font-bold">MemoGrammina</div>
        <div class="flex space-x-4">
          <a href="#" class="text-gray-600 hover:text-black">Home</a>
          <a href="#" class="text-gray-600 hover:text-black">Profile</a>
          <a href="#" class="text-gray-600 hover:text-black">Messages</a>
          <a href="#" class="text-gray-600 hover:text-black">Account</a>
        </div>
      </div>
    </nav>

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
import { getPosts, getUser, refreshToken } from '../api.js'

import PostItem from '../components/PostItem.vue'
import PersonalOfficeItem from '../components/PersonalOfficeItem.vue'
import MessengerItem from '../components/MessengerItem.vue'

const posts = ref([])
const user = ref({})

onMounted(() => {
  getPosts()
    .then(response => {
      posts.value = response.data
    })
    .catch(error => {
      console.error('Error fetching post data:', error)
    })

  getUser(localStorage.getItem('token')).then(response => {
    if (response.status === 401) {
      refreshToken(localStorage.getItem('token')).then(r => {
        if (r.error) {
          user.value.isLoggedIn = false
        } else {
          localStorage.setItem('token', r.token)
          getUser(r.token).then(newResponse => {
            user.value = newResponse.user
            user.value.isLoggedIn = true
          })
        }
      })
    } else {
      user.value = response.user
      user.value.isLoggedIn = true
    }
  })
})
</script>
