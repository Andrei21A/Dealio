<template>
  <div class="product-index">
    <h1>PRODUCT INDEX COMPONENT LOADED</h1>
    <div>
      <Link :href="`/products/create`"> Create </Link>
    </div>
    <div v-for="product in products" :key="product.id">
      <Link :href="`/products/${product.id}`">{{ product.title }}
      </Link>
      <div>
        <Link :href="`/products/${product.id}/edit`"> Edit </Link>
      </div>
      <div>
        <Link :href="`/products/${product.id}`" method="DELETE">Delete</Link>
      </div>
    </div>
  </div>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import { Link } from '@inertiajs/vue3'

defineOptions({
  layout: MainLayout
})

defineProps({
  products: Array,
})
</script>

<style scoped>
.success {
  background-color: green;
  color: white;
  padding: 0.5rem 1rem;
  margin: 1rem 0;
  border-radius: 4px;
}
</style>
