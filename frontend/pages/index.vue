<script setup lang="ts">

import { navigateTo } from '#app'
import { awaitExpression } from '@babel/types'

const tasks = ref(null)

const loadTasks = async () => {
  try {
    const response = await $fetch('/api/tasks')
    tasks.value = response || { data: [] }
  } catch (e) {
    if (e.statusCode === 401) {
      navigateTo('/login')
    }
  }
}

const newTask = ref({
  title: null,
  description: null
})

const closeTask = (taskId: string) => {
  tasks.value.data = tasks.value.data.map((task) => {
    if (task.id == taskId) {
      task.status = 'complete'
    }

    return task
  })
}

const getIcon = function(status: string) {
  /**
   * @note waiting statuses: draft, new, in-progress, wont-do, completed
   */
  if (status === 'complete') {
    return 'accept'
  }
  if (status === 'wont-do') {
    return 'decline'
  }

  return 'wait'
}
const error = ref(null)
const save = async function() {
  error.value = null
  try {
    const response = await $fetch('/api/tasks', {
      method: 'POST',
      body: newTask.value
    })
    tasks.value.data.unshift(response.data)
    newTask.value = {
      title: null,
      description: null
    }
  } catch (e) {

    if (e.statusCode === 401) {
      navigateTo('/login')
    }
    error.value = e.message
  }
}
const addOpen = ref(false)

useHead({
  bodyAttrs: {
    class: [
      'p-5',
      'bg-white',
      'antialiased',
      'dark:bg-gray-900'
    ]
  }
})

const taskOpened = ref(null)
const taskChanged = ref(false)

const openTask = async function(taskID: string) {
  if (taskOpened?.value && taskOpened?.value.id === taskID) {
    return
  }
  taskChanged.value = false
  try {
    const response = await $fetch(`/api/tasks/${taskID}`)
    taskOpened.value = response.data
  } catch (e) {
    if (e.statusCode === 401) {
      navigateTo('/login')
    }
    taskOpened.value = null
    error.value = e.message
  }
}

const taskEditTitleEl = ref(null)
const changeTask = () => {
  setTimeout(() => {
    document.getElementById(`taskTitleInput_${taskOpened.value.id}`)?.focus()
  }, 5)
  taskChanged.value = true
}

const selectTask = () => {
  addOpen.value = !addOpen.value
}

const saveTask = async () => {
  try {
    const response = await $fetch(`/api/tasks/${taskOpened.value.id}`, {
      method: 'PUT',
      body: {
        title: taskOpened.value.title,
        description: taskOpened.value.description || null,
        status: taskOpened.value.status
      }
    })
    tasks.value.data = tasks.value.data.map((item) => {
      if (item.id === response.data.id) {
        item = response.data
      }

      return item
    })
  } catch (e) {
    if (e.statusCode === 401) {
      navigateTo('/login')
    }
    error.value = e.message
  }

  taskChanged.value = false
}

const changeTaskStatus = async (status: string, taskID: string) => {
  taskChanged.value = false
  try {
    const response = await $fetch(`/api/tasks/${taskID}`, {
      method: 'PUT',
      body: {
        status
      }
    })

    tasks.value.data = tasks.value.data.map((item) => {
      if (item.id === response.data.id) {
        item = response.data
      }

      return item
    })
  } catch (e) {
    if (e.statusCode === 401) {
      navigateTo('/login')
    }
    error.value = e.message
  }
}
const makeWontDo = async (taskID: string) => changeTaskStatus('wont-do', taskID)
const makeInProgress = (taskID: string) => changeTaskStatus('in-progress', taskID)
const makeComplete = (taskID: string) => changeTaskStatus('completed', taskID)

const deleteTask = async (taskID: string) => {
  try {
    const response = await $fetch(`/api/tasks/${taskID}`, {
      method: 'DELETE'
    })

    tasks.value.data = tasks.value.data.filter((item) => item.id !== taskID)
  } catch (e) {
    if (e.statusCode === 401) {
      navigateTo('/login')
    }
  }
}

onMounted(() => loadTasks())
</script>

<template>
  <div class="container md:max-w-md mx-auto">
    <div class="flex justify-between items-center h-12 border-b py-3">
      <div class="flex">
        <h3 class="font-black uppercase text-xl">Todos</h3>
      </div>
      <div class="flex">
        <button type="button"
                class="border border-blue-500 text-blue-500 rounded-full w-8 h-8 hover:bg-accent hover:border-accent hover:text-white transition font-bold text-base"
                :class="{'rotate-45': addOpen}" @click="selectTask">+
        </button>
      </div>
    </div>
    <div v-if="addOpen" class="flex py-4 w-full flex-col space-y-2">
      <div class="flex">
        <input type="text" class="w-full border-b outline-0 py-2 px-2" placeholder="Task name"
               v-model="newTask.title">
      </div>
      <div class="flex">
          <textarea placeholder="description" class="w-full border p-2 outline-0"
                    v-model="newTask.description"></textarea>
      </div>
      <button
        class="border border-accent text-accent text-base font-bold rounded px-2 h-8 transition hover:bg-blue-500 hover:text-white hover:border-blue-500"
        @click="save">Save
      </button>
    </div>
    <div class="flex mt-2 flex-col" v-if="tasks?.data">
      <div
        class="group flex transition rounded-t flex-col w-full pt-2 border-b cursor-pointer"
        :class="{
            'hover:rounded hover:bg-gray-300 dark:hover:bg-white': taskOpened?.id !== task.id,
            'rounded bg-amber-50 border-0 shadow-md': taskOpened?.id === task.id,
          }"
        v-for="task in tasks?.data" :key="task.id" @click="openTask(task.id)">
        <div class="flex justify-between items-center text-base mb-3">
          <template v-if="!taskChanged || taskOpened.id !== task.id">
              <span class="text-base p-2">
                {{ task.title }}
              </span>
          </template>
          <template v-else-if="taskOpened.id === task.id">
            <input type="text" :id="`taskTitleInput_${task.id}`" v-model="taskOpened.title" class="w-full outline-0 p-2 focus:bg-amber-100 bg-amber-50 border-b border-b-gray-400" ref="taskEditTitleEl" />
          </template>
          <div v-if="taskOpened?.id !== task.id" class="pr-2 space-x-1">
            <button
              v-if="task.status !== 'completed' && task.status !== 'in-progress' && task.status !== 'wont-do'"
              @click="makeWontDo(task.id)"
              title="Wont do task"
              class="transition bg-accent py-2 px-3 rounded text-white group-hover:bg-blue-400 group-hover:hover:bg-amber-300 group-hover:hover:text-black">
              <svg-icon name="cancel" width="20" height="20" />
            </button>
            <button
              v-if="task.status === 'new' || task.status === 'draft' && task.status !== 'completed' && task.status !== 'wont-do'"
              @click="makeInProgress(task.id)"
              title="Start task"
              class="transition bg-accent py-2 px-3 rounded text-white group-hover:bg-blue-400 group-hover:hover:bg-amber-300 group-hover:hover:text-black">
              <svg-icon name="play" width="20" height="20" />
            </button>
            <button
              v-if="task.status === 'in-progress' && task.status !== 'completed' && task.status !== 'wont-do'"
              @click="makeComplete(task.id)"
              title="Complete task"
              class="transition bg-accent py-2 px-3 rounded text-white group-hover:bg-blue-400 group-hover:hover:bg-amber-300 group-hover:hover:text-black">
              <svg-icon name="complete" width="20" height="20" />
            </button>
            <button
              v-if="task.status === 'completed' || task.status === 'wont-do'"
              @click="deleteTask(task.id)"
              title="Delete task"
              class="transition bg-red-600 py-2 px-3 rounded text-white group-hover:bg-blue-400 group-hover:hover:bg-amber-300 group-hover:hover:text-black">
              <svg-icon name="delete" width="20" height="20" />
            </button>
          </div>
        </div>
        <div v-if="taskOpened?.id === task.id" class="border-t border-dashed pt-3 border-gray-400">
          <div class="flex flex-col">
            <div class="flex text-xs border-b border-dashed pb-2 border-gray-400">
              <template v-if="!taskChanged || taskOpened.id !== task.id">
                <span class="px-2">{{ taskOpened.description || 'No description...' }}</span>
              </template>
              <template v-else-if="taskOpened.id === task.id">
                <textarea class="w-full outline-0 p-2 focus:bg-amber-100 bg-amber-50 border-b border-b-gray-400" v-model="taskOpened.description"></textarea>
              </template>
            </div>
            <div class="flex justify-between text-sm p-2" v-if="task.status !== 'completed'">
              <div class="flex justify-start space-x-2">
                <button title="Change this task" class="rounded bg-green-700 p-2 text-white hover:bg-green-500 change" @click="changeTask" v-if="!taskChanged" @pointerdown.prevent>
                  <svg-icon name="edit" width="16" height="16" />
                </button>
                <button title="Save changes" class="rounded bg-green-700 p-2 text-white hover:bg-green-500 change" @click="saveTask" v-if="taskChanged">
                  <svg-icon name="save" width="16" height="16" />
                </button>
              </div>
              <div class="flex justify-start space-x-2">
                <button
                  v-if="task.status !== 'completed' && task.status !== 'in-progress' && task.status !== 'wont-do'"
                  @click="makeWontDo(task.id)"
                  title="Wont do task"
                  class="transition bg-accent py-2 px-3 rounded text-white group-hover:bg-blue-400 group-hover:hover:bg-amber-300 group-hover:hover:text-black">
                  <svg-icon name="cancel" width="16" height="16" />
                </button>
                <button
                  v-if="task.status === 'new' || task.status === 'draft' && task.status !== 'completed' && task.status !== 'wont-do'"
                  @click="makeInProgress(task.id)"
                  title="Start task"
                  class="transition bg-accent py-2 px-3 rounded text-white group-hover:bg-blue-400 group-hover:hover:bg-amber-300 group-hover:hover:text-black">
                  <svg-icon name="play" width="16" height="16" />
                </button>
                <button
                  v-if="task.status === 'in-progress' && task.status !== 'completed' && task.status !== 'wont-do'"
                  @click="makeComplete(task.id)"
                  title="Complete task"
                  class="transition bg-accent py-2 px-3 rounded text-white group-hover:bg-blue-400 group-hover:hover:bg-amber-300 group-hover:hover:text-black">
                  <svg-icon name="complete" width="16" height="16" />
                </button>
                <button
                  v-if="task.status === 'completed' || task.status === 'wont-do'"
                  @click="deleteTask(task.id)"
                  title="Delete task"
                  class="transition bg-red-600 py-2 px-3 rounded text-white group-hover:bg-blue-400 group-hover:hover:bg-amber-300 group-hover:hover:text-black">
                  <svg-icon name="delete" width="16" height="16" />
                </button>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
    <client-only>
      <div v-if="!addOpen && !tasks?.data" class="flex py-4 uppercase w-full text-center">
        no todos
      </div>
    </client-only>
  </div>
</template>