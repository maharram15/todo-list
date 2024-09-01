import { useSession } from 'h3'
import { useNuxtApp } from 'nuxt/app'

export default defineEventHandler(async (event) => {
  const config = useRuntimeConfig()
  const session = await useSession(event, {
    name: config.session.name as string,
    password: config.session.password as string,
    maxAge: config.session.maxAge as number
  })

  const token = session.data?.token || -1

  try {
    return await $fetch(config.public.baseUrl + '/api/v1/tasks', {
      query: {
        sort: 'created_at'
      },
      headers: {
        Authorization: `Bearer ${token}`
      }
    })
  } catch (e) {
    setResponseStatus(event, e.statusCode)
    return e?.data || {}
  }
})