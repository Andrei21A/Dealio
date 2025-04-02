<template>
    <div class="product-index">
      <h1>PRODUCT INDEX COMPONENT LOADED</h1>
      <div v-for="product in products" :key="product.id">
        <Link :href="`/products/${product.id}`">{{ product.title }}</Link>
      </div>
    </div>
  </template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    defineProps({
        products: Array,
    })
</script>
