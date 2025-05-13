<template>
    <header class="border-b border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 w-full">
        <div class="container mx-auto">
            <nav class="p-4 flex items-center justify-between">
                <Link :href="route('products.index')" class="flex-shrink-0 font-playful text-3xl text-blue-400">
                Dealio
                </Link>

                <div class="flex-1 flex justify-end space-x-4">
                    <div v-if="user" class="flex items-center space-x-4">
                        <div>{{ user.user_name }}</div>
                        <Link href="/products/create" class="btn text-md ml-12">+Product</Link>
                    </div>
                    <div v-else class="flex items-center space-x-4">
                        <Link :href="route('login')">Sign In</Link>
                        <Link :href="route('user-account.create')">Register</Link>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <div>
        <div class="navigation"></div>
        <slot />
    </div>

    <Footer />
</template>

<script setup>
import Footer from '@/Components/UI/Footer.vue'
import { Link, usePage } from '@inertiajs/vue3'
import { computed, watch } from 'vue'
import { useToast } from 'vue-toastification'
import { route } from 'ziggy-js'

const toast = useToast()
const page = usePage()

const user = computed(() => page.props.user)

watch(
    () => page.props.flash,
    (newFlash) => {
        if (newFlash?.success) toast.success(newFlash.success)
        if (newFlash?.error) toast.error(newFlash.error)
    },
    { deep: true, immediate: true }
)
</script>
