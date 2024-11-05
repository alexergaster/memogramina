<template>
  <div class="bg-gray-100 min-h-screen flex items-center justify-center">
    <nav-item :user="user" />
    <div class="max-w-lg w-full bg-white p-8 rounded-lg shadow-md">
      <h1 class="text-2xl font-bold text-gray-700 mb-6">Редагування профілю</h1>

      <form @submit.prevent="handlerUpdate">
        <!-- Зображення профілю -->
        <div class="mb-4">
          <label class="block text-gray-600 mb-1">Profile picture</label>
          <div class="flex items-center">
            <img
              :src="image"
              alt="Profile Image"
              class="w-30 h-20 rounded-full border-2 border-gray-300 mr-4"
            />
            <input
              type="file"
              @change="onImageChange"
              class="w-full p-2 border rounded border-gray-300 focus:outline-none"
            />
          </div>
        </div>

        <!-- Ім'я -->
        <div class="mb-4">
          <label for="name" class="block text-gray-600 mb-1">Name</label>
          <input
            type="text"
            id="name"
            v-model="user.name"
            class="w-full p-2 border rounded border-gray-300 focus:outline-none focus:border-blue-500"
            placeholder="Введіть ваше ім'я"
          />
        </div>

        <!-- Юзернейм -->
        <div class="mb-4">
          <label for="username" class="block text-gray-600 mb-1">
            Username
          </label>
          <input
            type="text"
            id="username"
            v-model="user.username"
            class="w-full p-2 border rounded border-gray-300 focus:outline-none focus:border-blue-500"
            placeholder="Введіть ваш юзернейм"
          />
        </div>

        <!-- Електронна адреса -->
        <div class="mb-4">
          <label for="email" class="block text-gray-600 mb-1">
            E-mail address
          </label>
          <input
            type="email"
            id="email"
            v-model="user.email"
            class="w-full p-2 border rounded border-gray-300 focus:outline-none focus:border-blue-500"
            placeholder="example@mail.com"
          />
        </div>

        <!-- Пароль -->
        <div class="mb-4">
          <label for="password" class="block text-gray-600 mb-1">
            New password
          </label>
          <input
            type="password"
            id="password"
            v-model="user.password"
            class="w-full p-2 border rounded border-gray-300 focus:outline-none focus:border-blue-500"
            placeholder="Введіть новий пароль"
          />
        </div>

        <!-- Кнопка збереження -->
        <div class="mt-6">
          <button
            type="submit"
            class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition"
          >
            Зберегти зміни
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import NavItem from '../components/NavItem.vue'
import { ref, onBeforeMount } from 'vue'
import { getUserInfoProfille, updateUser } from '../api'

const user = ref({})
const image = ref(File)

onBeforeMount(() => {
  getUserInfoProfille().then(r => {
    if (r.data.success) {
      user.value = r.data.data
      image.value = r.data.data.image
    }
  })
})

const handlerUpdate = () => {
  console.log(image.value)

  const data = user.value
  console.log(data.username)

  updateUser(data).then(r => {
    console.log(r)
  })
}

const onImageChange = event => {
  const file = event.target.files[0]

  if (file.type === 'image/png') {
    image.value = URL.createObjectURL(file)
    user.value.image = file
  }
}
</script>
