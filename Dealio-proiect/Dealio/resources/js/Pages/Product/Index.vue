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
        <div class="grid">
          <div class="text-form-title my-5 mx-4 border-b border-gray-300">Browse Categories</div>

          <div class="flex overflow-x-auto scrollbar-hidden space-x-4 px-4 py-4">
            <button v-for="category in categories" :key="category" class="btn-category"
              :class="{ 'bg-purple-600 text-white hover:bg-purple-700': category === selectedCategory }"
              @click="selectCategory(category)">
              {{ category }}
            </button>
          </div>
        </div>

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

        <div v-else-if="!searchTerm && !selectedCategory">
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
import { computed, ref, watch } from 'vue';
import { route } from 'ziggy-js';

defineOptions({ layout: MainLayout });

const page = usePage();
const user = computed(() => page.props.user);

const categories = [
  'Electronics', 'Clothing', 'Furniture', 'Laptops/Phones',
  'Books', 'Toys', 'Sport', 'Beauty', 'Other',
];

const props = defineProps({
  products: Array,
  search: String
});

const searchTerm = ref(props.search || '');
const selectedCategory = ref(props.category || '');
const filters = ref({}); // Store applied filters from the sidebar

function selectCategory(category) {
  selectedCategory.value = (selectedCategory.value === category) ? '' : category;
  applyFilters();
}

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

watch(searchTerm, () => {
  applyFilters();
});
</script>
