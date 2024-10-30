<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div
      class="w-full max-w-md space-y-8 p-6 bg-white shadow-md rounded-lg cursor-default"
    >
      <div id="register">
        <h2 class="text-center text-2xl font-bold text-gray-700">Реєстрація</h2>
        <form @submit.prevent="submitForm" class="mt-4 space-y-4">
          <div>
            <label for="name" class="block text-sm font-medium text-gray-600"
              >Ім'я</label
            >
            <input
              type="text"
              name="name"
              v-model="name"
              required
              class="w-full mt-1 p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>
          <div>
            <label
              for="username"
              class="block text-sm font-medium text-gray-600"
              >Псевдонім</label
            >
            <input
              type="text"
              name="username"
              v-model="username"
              required
              class="w-full mt-1 p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>
          <div>
            <label for="email" class="block text-sm font-medium text-gray-600"
              >Електронна пошта</label
            >
            <input
              type="email"
              name="email"
              v-model="email"
              required
              class="w-full mt-1 p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <p v-if="errors.email" class="text-red-500 text-sm">
              {{ errors.email }}
            </p>
          </div>
          <div>
            <label
              for="password"
              class="block text-sm font-medium text-gray-600"
              >Пароль</label
            >
            <input
              type="password"
              name="password"
              v-model="password"
              required
              class="w-full mt-1 p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <p v-if="errors.password" class="text-red-500 text-sm">
              {{ errors.password }}
            </p>
          </div>
          <div>
            <label
              for="password_confirmation"
              class="block text-sm font-medium text-gray-600"
              >Підтвердження паролю</label
            >
            <input
              type="password"
              name="password_confirmation"
              v-model="passwordConfirmation"
              required
              class="w-full mt-1 p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <p v-if="errors.passwordConfirmation" class="text-red-500 text-sm">
              {{ errors.passwordConfirmation }}
            </p>
          </div>
          <div v-if="errors.length" class="text-red-500">
            <p v-for="(error, index) in errors" :key="index">{{ error }}</p>
          </div>

          <button
            type="submit"
            class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition duration-300"
          >
            Зареєструватися
          </button>
          <p class="text-center text-sm text-gray-500 mt-4">
            Вже є акаунт?
            <router-link to="/login" class="text-blue-500 hover:underline"
              >Увійти</router-link
            >
          </p>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import { registrationUser } from '../api'
import { useRouter } from 'vue-router'

export default {
  name: 'RegisterPage',
  setup() {
    const router = useRouter()
    const name = ref('')
    const username = ref('')
    const email = ref('')
    const password = ref('')
    const passwordConfirmation = ref('')
    const errors = ref({})

    const validateForm = () => {
      errors.value = {}

      if (!password.value) {
        errors.value.password = "Пароль обов'язковий"
      } else if (password.value.length < 6) {
        errors.value.password = 'Пароль повинен бути не менше 6 символів'
      }

      if (password.value !== passwordConfirmation.value) {
        errors.value.passwordConfirmation = 'Паролі не співпадають'
      }
    }

    const submitForm = () => {
      validateForm()
      if (Object.keys(errors.value).length === 0) {
        const registrationData = {
          name: name.value,
          username: username.value,
          email: email.value,
          password: password.value,
          password_confirmation: passwordConfirmation.value,
        }

        registrationUser(registrationData).then(response => {
          if (!response.data.success) {
            Object.entries(response.data.errors).forEach(([key, value]) => {
              errors.value[key] = value[0]
            })
            return
          }

          localStorage.setItem('token', response.data.token)
          router.push('/')
        })
      }
    }

    return {
      name,
      username,
      email,
      password,
      passwordConfirmation,
      errors,
      submitForm,
    }
  },
}
</script>
