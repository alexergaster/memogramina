<template>
  <div class="p-4 bg-white shadow-lg rounded-lg overflow-hidden mb-3">
    <!-- Шапка посту -->
    <div class="flex items-center mb-4">
      <img
        @click="goAccountUser(post.user.id)"
        :src="post.user.image"
        alt="avatar"
        class="rounded-full h-10 w-10 cursor-pointer"
      />
      <div class="ml-4">
        <p
          class="font-bold cursor-pointer"
          @click="goAccountUser(post.user.id)"
        >
          {{ post.user.username }}
        </p>
        <p class="text-sm text-gray-500">2 hours ago</p>
      </div>
    </div>
    <!-- Зображення посту -->
    <img
      :src="post.image"
      alt="post image"
      class="w-full h-auto object-cover mb-4"
    />
    <!-- Взаємодії -->
    <div class="flex justify-between">
      <div class="flex space-x-4">
        <button class="focus:outline-none flex" @click="handlerLike(post.id)">
          <p class="mr-1">{{ localPost.likes.length }}</p>
          <p v-if="idLikePost">❤️ Like</p>
          <p v-else>🖤 Like</p>
        </button>
        <button class="focus:outline-none" @click="openModal">
          💬 Comment
        </button>
        <!-- <button class="focus:outline-none">🔁 Share</button> -->
      </div>
    </div>
    <p class="mt-4">
      <strong>{{ post.user.username }}</strong> {{ post.caption }}
    </p>

    <!-- Modal for comment -->
    <modal-item :isOpen="isModalOpen" :onClose="closeModal">
      <div class="flex items-center mb-4">
        <img
          :src="post.user.image"
          alt="avatar"
          class="rounded-full h-10 w-10"
        />
        <div class="ml-4">
          <p class="font-bold">{{ post.user.username }}</p>
          <p class="text-sm text-gray-500">2 hours ago</p>
        </div>
      </div>
      <img
        :src="post.image"
        alt="post image"
        class="w-full h-auto object-cover mb-4"
      />
      <div class="flex justify-between">
        <div class="flex space-x-4 flex-col">
          <div class="mb-3">
            Опис:
            {{ post.caption }}
          </div>
          <button class="focus:outline-none flex" @click="handlerLike(post.id)">
            <p class="mr-1">{{ localPost.likes.length }}</p>
            <p v-if="idLikePost">❤️ Like</p>
            <p v-else>🖤 Like</p>
          </button>
        </div>
      </div>
      <div
        class="my-6 flex items-center border-b-2 pb-2"
        v-for="(comment, idx) in localPost.comments"
        :key="idx"
      >
        <div>
          <div class="flex items-center mb-2">
            <img
              :src="post.user.image"
              alt="avatar"
              class="rounded-full h-10 w-10 mr-1"
            />
            <strong>{{ comment.user.username }}</strong>
          </div>
          {{ comment.content }}
        </div>
        <div
          class="ml-auto cursor-pointer"
          v-if="editingRights(comment.user.id)"
          @click="handlerRemoveComment(post.id, comment.id)"
        >
          🗑️
        </div>
      </div>

      <form @submit.prevent="handlerAddComment(post.id)" class="mt-4 space-y-4">
        <div>
          <label for="caption" class="block text-sm font-medium text-gray-600"
            >Caption</label
          >
          <textarea
            name="content"
            v-model="content"
            rows="2"
            required
            class="w-full mt-1 p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>
        <button
          type="submit"
          :disabled="addCommentRights"
          :class="{
            'bg-green-600': !addCommentRights,
            'hover:bg-green-500': !addCommentRights,
            'bg-gray-600': addCommentRights,
          }"
          class="w-full text-white py-2 rounded transition duration-300"
        >
          Додати
        </button>
      </form>
    </modal-item>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { toggleLike, addComment, removeComment } from '../api'
import { jwtDecode } from 'jwt-decode'
import ModalItem from '../components/ModalItem.vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const isModalOpen = ref(false)
const content = ref('')

const props = defineProps({
  post: {
    type: Object,
    required: true,
  },
})
// TODO: не подобається       👇          👇              👇
const userId = ref(-1)
const localPost = ref({ ...props.post })

// TODO: не подобається       👇          👇              👇
if (localStorage.getItem('token')) {
  userId.value = jwtDecode(localStorage.getItem('token')).sub
}

const goAccountUser = id => {
  router.push(`account/${id}`)
}

const openModal = () => {
  isModalOpen.value = true
}

const closeModal = () => {
  isModalOpen.value = false
}

const idLikePost = computed(() => {
  return localPost.value.likes.some(item => item['id'] == userId.value)
})

const addCommentRights = computed(() => {
  return userId.value < 0
})

const editingRights = authorId => {
  return authorId === +userId.value
}

const handlerRemoveComment = (id, commentId) => {
  removeComment(id, commentId).then(r => {
    if (r.data.success) {
      localPost.value.comments = localPost.value.comments.filter(
        item => item.id !== r.data.comment.id,
      )
    }
  })
}

const handlerAddComment = id => {
  if (content.value.length) {
    addComment(id, { content: content.value }).then(r => {
      if (r.data.success) {
        localPost.value.comments.push(r.data.data)
        content.value = ''
      }
    })
  }
}

const handlerLike = id => {
  toggleLike(id).then(r => {
    if (r.data.success) {
      r.data.data.message === 'Liked'
        ? localPost.value.likes.push(r.data.data.user)
        : (localPost.value.likes = localPost.value.likes.filter(
            item => item.id !== r.data.data.user.id,
          ))
    }
  })
}
</script>
