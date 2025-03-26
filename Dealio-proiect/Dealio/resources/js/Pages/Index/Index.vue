<template>

    <div>
        Hello
        <Link href="/hello"> Show Page </Link>
        <div>{{ message }}</div>
    </div>

</template>

<script setup>
import { Link } from "@inertiajs/vue3";
defineProps({
    message: String,
});
</script>
