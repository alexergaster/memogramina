import { createRouter, createWebHistory } from 'vue-router'
import store from './store'
import HomePage from './views/HomePage.vue'
import RegPage from './views/RegPage.vue'
import LoginPage from './views/LoginPage.vue'
import AccountPage from './views/AccountPage.vue'

const routes = [
  { path: '/', name: 'home', component: HomePage },
  { path: '/register', name: 'register', component: RegPage },
  { path: '/login', name: 'login', component: LoginPage },
  { path: '/account/:id', name: 'account', component: AccountPage },
  { path: '/:pathMatch(.*)*', name: '404', component: HomePage },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')

  store.dispatch('checkAuthentication')

  if (
    to.name !== 'home' &&
    to.name !== 'login' &&
    !token &&
    to.name !== 'register'
  ) {
    return next({
      name: 'login',
    })
  }

  if ((token && to.name === 'login') || (token && to.name === 'register')) {
    return next({
      name: 'home',
    })
  }
  next()
})

export default router
