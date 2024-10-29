<template>
  <div class="bg-gray-100">
    <nav-item @userLogout="userLogout" :user="user" />
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
import { getPosts, getUserFromToken, refreshToken } from '../api.js'

import PostItem from '../components/PostItem.vue'
import PersonalOfficeItem from '../components/PersonalOfficeItem.vue'
import MessengerItem from '../components/MessengerItem.vue'
import NavItem from '../components/NavItem.vue'

const UNAUTHORIZED_STATUS = 401
const posts = ref([])
const user = ref({ id: -1 })

const userLogout = data => {
  user.value.isLoggedIn = data
}

const fetchUserWithAuth = async () => {
  const token = localStorage.getItem('token')

  if (!token) {
    user.value.isLoggedIn = false
    return
  }

  let response = await getUserFromToken(token)

  if (response.status === UNAUTHORIZED_STATUS) {
    const newToken = await refreshAuthToken(token)

    if (newToken) {
      response = await getUserFromToken(newToken)
    } else {
      user.value.isLoggedIn = false
      return
    }
  }

  user.value = response.user
  user.value.isLoggedIn = true
}
async function refreshAuthToken(token) {
  const response = await refreshToken(token)

  if (response.error) {
    return null
  }

  localStorage.setItem('token', response.token)

  return response.token
}

onMounted(() => {
  getPosts()
    .then(response => {
      if (response.status) {
        posts.value = response.data
      }
    })
    .catch(error => {
      console.error('Error fetching post data:', error)
    })
  fetchUserWithAuth()
})
</script>
