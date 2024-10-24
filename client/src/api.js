export const getPosts = async () =>
  await fetch('http://127.0.0.1:8000/api/posts').then(r => r.json())
