<template>
  <div class="bg-gray-100">
    <nav-item :user="user" />
    <div class="container mx-auto mt-16 flex justify-between p-4">
      <div class="w-2/3">
        <template v-if="posts.length">
          <post-item v-for="post in posts" :key="post.id" :post="post" />
        </template>
        <div v-else><h2>No memes 😥</h2></div>
      </div>
      <div class="w-1/3 ml-3">
        <personal-office-item :user="user" />
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
