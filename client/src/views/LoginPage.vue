<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div
      class="w-full max-w-md space-y-8 p-6 bg-white shadow-md rounded-lg cursor-default"
    >
      <!-- Форма авторизації -->
      <div id="login">
        <h2 class="text-center text-2xl font-bold text-gray-700">
          Авторизація
        </h2>
        <form @submit.prevent="submitForm" method="POST" class="mt-4 space-y-4">
          <!-- Електронна пошта -->
          <div>
            <label
              for="login-email"
              class="block text-sm font-medium text-gray-600"
              >Електронна пошта</label
            >
            <input
              v-model="email"
              type="email"
              name="email"
              required
              class="w-full mt-1 p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <p v-if="errors.email" class="text-red-500 text-sm">
              {{ errors.email }}
            </p>
          </div>

          <!-- Пароль -->
          <div>
            <label
              for="login-password"
              class="block text-sm font-medium text-gray-600"
              >Пароль</label
            >
            <input
              v-model="password"
              type="password"
              name="password"
              required
              class="w-full mt-1 p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <p v-if="errors.password" class="text-red-500 text-sm">
              {{ errors.password }}
            </p>
          </div>

          <!-- Кнопка входу -->
          <button
            type="submit"
            class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition duration-300"
          >
            Увійти
          </button>

          <!-- Посилання на реєстрацію -->
          <p class="text-center text-sm text-gray-500 mt-4">
            Немає акаунту?
            <router-link to="/register" class="text-blue-500 hover:underline"
              >Зареєструватися
            </router-link>
          </p>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import { loginUser } from '../api'
import { useRouter } from 'vue-router'

export default {
  name: 'LoginPage',
  setup() {
    const router = useRouter()
    const email = ref('')
    const password = ref('')
    const errors = ref({})

    const validateForm = () => {
      errors.value = {}

      if (!password.value) {
        errors.value.password = "Пароль обов'язковий"
      } else if (password.value.length < 6) {
        errors.value.password = 'Пароль повинен бути не менше 6 символів'
      }
    }

    const submitForm = () => {
      validateForm()
      if (Object.keys(errors.value).length === 0) {
        const userData = {
          email: email.value,
          password: password.value,
        }

        loginUser(userData).then(response => {
          if (!response.success) {
            Object.entries(response.errors).forEach(([key, value]) => {
              errors.value[key] = value[0]
            })
            return
          }

          localStorage.setItem('token', response.token)
          router.push('/')
        })
      }
    }

    return {
      errors,
      email,
      password,
      submitForm,
    }
  },
}
</script>
