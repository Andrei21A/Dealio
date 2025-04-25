<template>
    <form @submit.prevent="register">
        <div class="w-1/2 mx-auto">
            <div>
                <label for="user_name" class="label">Your user-name</label>
                <input id="user_name" v-model="form.user_name" type="text" class="input" />
                <div v-if="form.errors.user_name" class="input-error">{{ form.errors.user_name }}</div>
            </div>

            <div>
                <label for="full_name"> Your full name </label>
                <input type="text" id="full_name" v-model="form.full_name">
                <div v-if="form.errors.full_name"> {{ form.errors.full_name }}</div>
            </div>

            <div class="mt-4">
                <label for="email" class="label">E-mail</label>
                <input id="email" v-model="form.email" type="text" class="input" />
                <div v-if="form.errors.email" class="input-error">{{ form.errors.email }}</div>
            </div>

            <div>
                <label for="phone_number"> Phone Number </label>
                <input type="text" id="phone_number" v-model="form.phone_number">
                <div v-if="form.errors.phone_number"> {{ form.errors.phone_number }}</div>
            </div>

            <div>
                <label for="address"> Your address </label>
                <input type="text" id="address" v-model="form.address">
                <div v-if="form.errors.address"> {{ form.errors.address }}</div>
            </div>

            <div class="mt-4">
                <label for="password" class="label">Password</label>
                <input id="password" v-model="form.password" type="password" class="input" />
                <div v-if="form.errors.password" class="input-error">{{ form.errors.password }}</div>
            </div>

            <div class="mt-4">
                <label for="password_confirmation" class="label">Confirm Password</label>
                <input id="password_confirmation" v-model="form.password_confirmation" type="password" class="input" />
                <div v-if="form.errors.password_confirmation" class="input-error">{{ form.errors.password_confirmation
                    }}</div>
            </div>

            <div class="mt-4">
                <button class="btn-primary w-full" type="submit">Create Account</button>
            </div>
            <Link :href="route('user-account.create')" class="text-sm text-gray-500"> You already have an account? Click
            here </Link>
        </div>
    </form>
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
    password_confirmation: null
});

const register = () => {
    form.post(route('user-account.store'));
};
</script>
