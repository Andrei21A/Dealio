<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
      <form @submit.prevent="login" class="w-full max-w-md bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
        <h2 class="text-2xl font-semibold text-center text-gray-800 dark:text-white mb-6">Login to Your Account</h2>
  
        <div class="mb-4">
          <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">E-mail</label>
          <input
            id="email"
            v-model="form.email"
            type="text"
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100"
          />
          <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</div>
        </div>
  
        <div class="mb-6">
          <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100"
          />
          <div v-if="form.errors.password" class="text-red-500 text-sm mt-1">{{ form.errors.password }}</div>
        </div>
  
        <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-300">
          Login
        </button>
  
        <div class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
          Don’t have an account?
          <Link :href="route('user-account.create')" class="text-blue-600 hover:underline">Click here</Link>
        </div>
      </form>
    </div>
  </template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

const form = useForm({
  email: null,
  password: null,
})

const login = () => {
  form.post(route('login.store'));
}
</script>
