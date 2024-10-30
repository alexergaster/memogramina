import { createRouter, createWebHistory } from 'vue-router'
import HomePage from './views/HomePage.vue'
import RegPage from './views/RegPage.vue'
import LoginPage from './views/LoginPage.vue'
import AccountPage from './views/AccountPage.vue'

const routes = [
  { path: '/', component: HomePage },
  { path: '/register', component: RegPage },
  { path: '/login', component: LoginPage },
  { path: '/account/:id', name: 'account', component: AccountPage },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
