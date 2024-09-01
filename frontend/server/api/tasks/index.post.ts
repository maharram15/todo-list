import { useSession } from 'h3'
import { useNuxtApp } from 'nuxt/app'
import * as crypto from 'node:crypto'

export default defineEventHandler(async (event) => {
  try {
    const body = await readBody(event)
    const config = useRuntimeConfig()
    const session = await useSession(event, {
      name: config.session.name as string,
      password: config.session.password as string,
      maxAge: config.session.maxAge as number
    })

    const token = session.data?.token || -1
    body.id = body.id || crypto.randomUUID()
    return await $fetch(config.public.baseUrl + '/api/v1/tasks/', {
      headers: {
        Authorization: `Bearer ${token}`
      },
      method: 'POST',
      body
    })
  } catch (e) {
    setResponseStatus(event, e.statusCode)
    return e?.data || {}
  }
})