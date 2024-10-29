import { createRouter, createWebHistory } from 'vue-router'
import HomePage from './views/HomePage.vue'
import RegPage from './views/RegPage.vue'
import LoginPage from './views/LoginPage.vue'
import ProfilePage from './views/ProfilePage.vue'

const routes = [
  { path: '/', component: HomePage },
  { path: '/register', component: RegPage },
  { path: '/login', component: LoginPage },
  { path: '/profile/:id', name: 'profile', component: ProfilePage },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
