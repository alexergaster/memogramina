export const getPosts = async () =>
  await fetch('http://127.0.0.1:8000/api/posts', {
    method: 'GET',
  }).then(r => r.json())

export const registrationUser = async data => {
  const response = await fetch('http://127.0.0.1:8000/api/auth/register', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(data),
  })

  return response.json()
}
