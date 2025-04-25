<template>
  <div class="product-index">
    <div
      class="container flex flex-col items-center p-4 border-b border-gray-300 bg-gray-50 dark:border-gray-700 dark:bg-gray-800">
      <h1 class="text-title my-10">Find exactly what you're looking for</h1>
      <!-- Search Bar -->
      <div class="relative w-full max-w-3xl mb-8">
        <span class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
          <Icon icon="material-symbols:search" width="24" />
        </span>
        <input type="text" v-model="searchTerm" placeholder="Search products..." class="w-full h-14 pl-10 pr-4 py-2 border rounded-xl shadow-sm 
         focus:outline-none focus:ring-2 focus:ring-gray-400 
         focus:border-gray-400 
         dark:bg-gray-700 dark:text-white dark:placeholder-gray-400" />
      </div>
    </div>
    <div class="text-subtitle my-6 px-4"> Most sought after products</div>

    <div
      class="overflow-hidden h-full border border-gray-200 rounded-xl hover:shadow-md transition-shadow bg-white dark:bg-gray-800">
      <!-- Image -->
      <div class="aspect-video relative overflow-hidden">
        <img :src="product.image || '/placeholder.svg'" :alt="product.title"
          class="object-cover w-full h-full absolute inset-0" />
        <span v-if="isAuction"
          class="absolute top-2 left-2 bg-slate-800 text-white text-xs px-2 py-1 rounded hover:bg-slate-700">
          Auction
        </span>
      </div>
    </div>
    <div v-for="product in products" :key="product.id">
      <Link :href="`/products/${product.id}`">{{ product.title }}
      </Link>
      <div>
        <Link :href="`/products/${product.id}/edit`"> Edit </Link>
      </div>
      <div v-if="user">
        <div>
          <Link :href="`/products/${product.id}`" method="delete">Delete</Link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Icon } from '@iconify/vue';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();

const user = computed(
  () => page.props.user,
)

defineOptions({
  layout: MainLayout
})

const props = defineProps({
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
