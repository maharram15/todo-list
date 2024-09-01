<script setup lang="ts">
import { navigateTo } from '#app'
import { $fetch } from 'ofetch'

useHead({
  title: 'Login',
  bodyAttrs: {
    class: [
      'p-5',
      'bg-white',
      'antialiased',
      'dark:bg-gray-900'
    ]
  }
})


const login = ref(null)
const password = ref(null)

const error = ref(null)

const auth = async () => {
  try {
    const { data } = await $fetch('/api/sessions', {
      method: 'POST',
      body: {
        login: login.value,
        password: password.value
      }
    })
    navigateTo('/')
  } catch (e) {
    error.value = e.data.message
  }
}
</script>

<template>
  <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <div class="space-y-6">
        <div>
          <label for="login" class="block text-sm font-medium leading-6 text-gray-900">Login</label>
          <div class="mt-2">
            <input id="login" v-model="login" name="login" required class="pl-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>
        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
          </div>
          <div class="mt-2">
            <input id="password" v-model="password" name="password" type="password" required class="pl-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>

        <div>
          <button type="button" @click="auth" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
        </div>
        <div>
          {{ error }}
        </div>
      </div>
    </div>
  </div>
</template>