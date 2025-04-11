<template>
    <div>
        <div class="navigation">
            <Link href="/products">Products</Link>&nbsp;
            <Link href="/products/create">Add Product</Link>
        </div>

        <slot>Default</slot>
    </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { watch } from 'vue'
import { useToast } from 'vue-toastification'

const toast = useToast()
const page = usePage()

watch(() => page.props.flash, (newFlash) => {
    if (newFlash?.success) {
        toast.success(newFlash.success)
    }

    if (newFlash?.error) {
        toast.error(newFlash.error)
    }
}, { deep: true, immediate: true })
</script>

<style scoped>
.navigation {
    margin-bottom: 20px;
}

.success {
    background-color: green;
    color: white;
    padding: 0.5rem 1rem;
    margin: 1rem 0;
    border-radius: 4px;
}
</style>
