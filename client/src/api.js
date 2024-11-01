import axios from 'axios'

const API_URL = 'http://127.0.0.1:8000/api'

const api = axios.create({
  baseURL: API_URL,
})
api.interceptors.request.use(config => {
  const token = localStorage.getItem('token')

  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }

  return config
})

api.interceptors.response.use({}, async error => {
  if (error.response.data.error === 'Token expired') {
    const token = localStorage.getItem('token')

    return axios
      .post(
        `${API_URL}/auth/refresh`,
        {},
        {
          headers: {
            authorization: `Bearer ${token}`,
          },
        },
      )
      .then(r => {
        const newToken = localStorage.setItem('token', r.data.token)

        error.config.headers.Authorization = `Bearer ${newToken}`

        return api.request(error.config)
      })
  }
})

export const getPosts = async () => {
  return await api.get('/posts')
}

export const registrationUser = async data => {
  return await api.post('/auth/register', data)
}
export const loginUser = async data => {
  return await api.post(`/auth/login`, data)
}

export const getUserData = async () => {
  return await api.get(`/auth/me`).then(r => r.data)
}

export const logout = async () => {
  return await api.post(`/auth/logout`)
}

export const getUser = async userId => {
  return await api.get(`/user/${userId}`)
}

export const addPost = async data => {
  return await api.post(`posts`, data)
}

export const toggleLike = async postId => {
  return await api.post(`posts/${postId}/like`)
}
