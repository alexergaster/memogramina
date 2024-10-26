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
        <form action="#" method="POST" class="mt-4 space-y-4">
          <!-- Електронна пошта -->
          <div>
            <label
              for="login-email"
              class="block text-sm font-medium text-gray-600"
              >Електронна пошта</label
            >
            <input
              type="email"
              id="login-email"
              name="email"
              required
              class="w-full mt-1 p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>

          <!-- Пароль -->
          <div>
            <label
              for="login-password"
              class="block text-sm font-medium text-gray-600"
              >Пароль</label
            >
            <input
              type="password"
              id="login-password"
              name="password"
              required
              class="w-full mt-1 p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
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
