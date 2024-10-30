import { createStore } from 'vuex'

const store = createStore({
  state: {
    isAuthenticated: false,
  },
  mutations: {
    setAuthentication(state, status) {
      state.isAuthenticated = status
    },
  },
  actions: {
    checkAuthentication({ commit }) {
      const token = localStorage.getItem('token')
      commit('setAuthentication', !!token)
    },
  },
})

export default store
