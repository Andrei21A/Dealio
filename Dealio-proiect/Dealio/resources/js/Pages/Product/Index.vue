<template>
  <div class="product-index">
    <!-- Header + Search -->
    <div
      class="w-full flex flex-col items-center p-4 border border-gray-300 bg-gray-50 dark:border-gray-700 dark:bg-gray-800">

      <h1 class="text-title my-10">Find exactly what you're looking for</h1>

      <div class="relative mb-8 w-[100%] max-w-[600px]">
        <span class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
          <Icon icon="material-symbols:search" width="24" />
        </span>
        <input type="text" v-model="searchTerm" placeholder="Search products..."
          class="h-14 pl-10 border rounded-xl shadow-sm dark:bg-gray-700 dark:text-gray-300 dark:border-gray-300" />
      </div>
    </div>

    <!-- Main content layout with sidebar + products -->
    <div class="flex px-8 py-10 gap-6">
      <!-- Filter Sidebar -->
      <div class="hidden lg:block w-1/4">
        <ProductFilters :filters="filters" @update:filters="handleFilterChange" />
      </div>

      <!-- Product Section -->
      <div class="w-full">

        <!-- Product Grid -->
        <div v-if="products.length && searchTerm"
          class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 px-4 py-10">
          <Box v-for="product in products" :key="product.id" :product="product" />
        </div>

        <div v-else-if="!products.length && searchTerm" class="text-form-title my-20">
          <div class="flex flex-col items-center">
            <div>No products found</div>
            <Icon icon="oui:face-sad" width="50" />
          </div>
        </div>

        <div v-else-if="!searchTerm && !hasActiveFilters">
          <div class="text-form-title my-5 mx-4 border-b border-gray-300">Most Popular</div>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 px-4 py-10">
            <Box v-for="product in products" :key="product.id" :product="product" />
          </div>
        </div>

        <div v-else>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 px-4 py-10">
            <Box v-for="product in products" :key="product.id" :product="product" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
import Box from '@/Components/UI/Box.vue';
import ProductFilters from '@/Components/UI/ProductFilters.vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Icon } from '@iconify/vue';
import { router, usePage } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { computed, ref, watch } from 'vue';
import { route } from 'ziggy-js';

defineOptions({ layout: MainLayout });

const page = usePage();
const user = computed(() => page.props.user);



const props = defineProps({
  products: Array,
  search: String
});

const searchTerm = ref(props.search || '');
const selectedCategory = ref(props.category || '');

const filters = ref({});

const hasActiveFilters = computed(() => {
  return Object.values(filters.value).some(value => {
    return Array.isArray(value) ? value.length > 0 : value !== null && value !== '' && value !== 'all';
  });
});


function handleFilterChange(newFilters) {
  filters.value = newFilters;
  applyFilters();
}

function applyFilters() {
  router.get(route('products.index'), {
    search: searchTerm.value,
    category: selectedCategory.value,
    ...filters.value,
  }, {
    preserveState: true,
    replace: true,
  });
}

watch(searchTerm, debounce(() => {
  applyFilters();
}, 500));
</script>
