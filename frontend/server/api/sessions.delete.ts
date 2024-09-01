import { useSession } from 'h3'
import { useNuxtApp } from 'nuxt/app'

export default defineEventHandler(async (event) => {
  const config = useRuntimeConfig()
  const session = await useSession(event, {
    name: config.session.name as string,
    password: config.session.password as string,
    maxAge: config.session.maxAge as number
  })
  const headers = {};

  const token = session.data?.token || null
  if (token) {
    headers.Authorization = `Bearer ${token}`;
  }

  try {
    const response = await $fetch(config.public.baseUrl + '/api/v1/sessions', {
      method: 'DELETE',
      headers,
    })

    await session.update({
      token: null
    });

    return response
  } catch (e) {
    setResponseStatus(event, e.statusCode)
    return {
      message: e.data.message
    }
  }
})