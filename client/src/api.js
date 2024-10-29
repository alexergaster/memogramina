const API_URL = 'http://127.0.0.1:8000/api'

const handleFetch = async (url, options) => {
  try {
    const response = await fetch(url, options)
    if (!response.ok) {
      return { error: true, status: response.status }
    }
    return await response.json()
  } catch (error) {
    console.error('Помилка запиту:', error)
    return { error: true, status: 500 }
  }
}

export const getPosts = async () => {
  return await handleFetch(`${API_URL}/posts`, {
    method: 'GET',
  })
}

export const registrationUser = async data => {
  return await handleFetch(`${API_URL}/auth/register`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(data),
  })
}
export const loginUser = async data => {
  return await handleFetch(`${API_URL}/auth/login`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(data),
  })
}

export const getUser = async token => {
  return await handleFetch(`${API_URL}/auth/me`, {
    method: 'GET',
    headers: {
      Authorization: `Bearer ${token}`,
    },
  })
}

export const refreshToken = async oldToken => {
  return await handleFetch(`${API_URL}/auth/refresh`, {
    method: 'POST',
    headers: {
      Authorization: `Bearer ${oldToken}`,
    },
  })
}

export const logout = async token => {
  return await handleFetch(`${API_URL}/auth/logout`, {
    method: 'POST',
    headers: {
      Authorization: `Bearer ${token}`,
    },
  })
}
