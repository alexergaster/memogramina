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
      <div class="w-2/3" v-if="posts.length">
        <!-- Пост -->
        <div
          v-for="post in posts"
          :key="post.id"
          class="bg-white rounded-lg shadow my-4"
        >
          <div class="p-4">
            <!-- Шапка посту -->
            <div class="flex items-center mb-4">
              <img src="" alt="avatar" class="rounded-full h-10 w-10" />
              <div class="ml-4">
                <p class="font-bold">{{ post.user.username }}</p>
                <p class="text-sm text-gray-500">2 hours ago</p>
              </div>
            </div>
            <!-- Зображення посту -->
            <img
              :src="post.image_path"
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
              <p class="text-gray-500">{{ post.likes }}</p>
            </div>
            <p class="mt-4">
              <strong>{{ post.user.username }}</strong> {{ post.caption }}
            </p>
          </div>
        </div>
      </div>
      <!-- Бічна панель -->
      <div class="w-1/3 ml-3">
        <!-- Особистий кабінет -->
        <div class="bg-white rounded-lg shadow p-4 my-4">
          <div class="flex items-center">
            <img src="" alt="avatar" class="rounded-full h-16 w-16" />
            <div class="ml-4">
              <p class="font-bold text-lg">User Name</p>
              <p class="text-gray-500">@username</p>
            </div>
          </div>
          <button class="mt-4 w-full bg-blue-500 text-white py-2 rounded">
            Edit Profile
          </button>
        </div>

        <!-- Месенджер -->
        <div class="bg-white rounded-lg shadow p-4">
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
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { getUsers } from './api.js'

export default {
  data() {
    return {
      posts: [],
    }
  },

  created() {
    getUsers()
      .then(response => {
        this.posts = response.data
      })
      .catch(error => {
        console.error('Error fetching post data:', error)
      })
  },
}
</script>
