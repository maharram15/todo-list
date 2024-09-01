import { useSession } from 'h3'
import { useNuxtApp } from 'nuxt/app'

export default defineEventHandler(async (event) => {

  const body = await readBody(event)

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
    const { data } = await $fetch(config.public.baseUrl + '/api/v1/sessions', {
      method: 'POST',
      headers,
      body
    })

    await session.update({
      token: data.token || null
    });

    return data
  } catch (e) {
    setResponseStatus(event, e.statusCode)
    return {
      message: e.data.message
    }
  }
})