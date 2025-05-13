<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
        <form @submit.prevent="register" class="w-full max-w-xl bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
            <h2 class="text-2xl font-semibold text-center text-gray-800 dark:text-white mb-6">Create Your Account</h2>

            <!-- Username -->
            <div class="mb-4">
                <label for="user_name"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Username</label>
                <input id="user_name" v-model="form.user_name" type="text"
                    class="w-full px-4 py-2 border rounded-lg shadow-sm dark:bg-gray-700 dark:text-gray-100 border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <div v-if="form.errors.user_name" class="text-red-500 text-sm mt-1">{{ form.errors.user_name }}</div>
            </div>

            <!-- Full Name -->
            <div class="mb-4">
                <label for="full_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full
                    Name</label>
                <input id="full_name" v-model="form.full_name" type="text"
                    class="w-full px-4 py-2 border rounded-lg shadow-sm dark:bg-gray-700 dark:text-gray-100 border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <div v-if="form.errors.full_name" class="text-red-500 text-sm mt-1">{{ form.errors.full_name }}</div>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">E-mail</label>
                <input id="email" v-model="form.email" type="text"
                    class="w-full px-4 py-2 border rounded-lg shadow-sm dark:bg-gray-700 dark:text-gray-100 border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</div>
            </div>

            <!-- Phone Number -->
            <div class="mb-4">
                <label for="phone_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone
                    Number</label>
                <input id="phone_number" v-model="form.phone_number" type="text"
                    class="w-full px-4 py-2 border rounded-lg shadow-sm dark:bg-gray-700 dark:text-gray-100 border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <div v-if="form.errors.phone_number" class="text-red-500 text-sm mt-1">{{ form.errors.phone_number }}
                </div>
            </div>

            <!-- Address -->
            <div class="mb-4">
                <label for="address"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address</label>
                <input id="address" v-model="form.address" type="text"
                    class="w-full px-4 py-2 border rounded-lg shadow-sm dark:bg-gray-700 dark:text-gray-100 border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <div v-if="form.errors.address" class="text-red-500 text-sm mt-1">{{ form.errors.address }}</div>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                <input id="password" v-model="form.password" type="password"
                    class="w-full px-4 py-2 border rounded-lg shadow-sm dark:bg-gray-700 dark:text-gray-100 border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <div v-if="form.errors.password" class="text-red-500 text-sm mt-1">{{ form.errors.password }}</div>
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <label for="password_confirmation"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm Password</label>
                <input id="password_confirmation" v-model="form.password_confirmation" type="password"
                    class="w-full px-4 py-2 border rounded-lg shadow-sm dark:bg-gray-700 dark:text-gray-100 border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <div v-if="form.errors.password_confirmation" class="text-red-500 text-sm mt-1">{{
                    form.errors.password_confirmation }}</div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-300">
                Create Account
            </button>

            <!-- Link to Login -->
            <div class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
                Already have an account?
                <Link :href="route('user-account.create')" class="text-blue-600 hover:underline">Click here</Link>
            </div>
        </form>
    </div>
</template>


<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

const form = useForm({
    user_name: null,
    full_name: null,
    email: null,
    address: null,
    phone_number: null,
    password: null,
    password_confirmation: null,
});

const register = () => {
    form.post(route('user-account.store'));
};
</script>
