import { useSession } from 'h3'
import { useNuxtApp } from 'nuxt/app'

export default defineEventHandler(async (event) => {
  const body = await readBody(event)
  const config = useRuntimeConfig()
  try {
    return await fetch(config.public.baseUrl + '/api/v1/users/', {
      method: 'POST',
      body,
    })
  } catch (e) {
    return {
      message: e.data.message
    }
  }
})