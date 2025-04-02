<template>
    <Link href="/"> Main Page</Link>&nbsp;
    <Link href="/products"> Show Page</Link>

    <div>
        This page timer : {{ timer }}
    </div>
    <slot></slot>
    </template>
    
    <script setup>
        import { Link } from '@inertiajs/vue3';
    import { ref } from 'vue';
    
        const timer = ref(0)
        setInterval(() => timer.value++, 1000)
    </script>
    