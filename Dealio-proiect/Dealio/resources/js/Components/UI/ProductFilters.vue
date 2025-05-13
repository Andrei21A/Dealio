<template>
    <div class="w-full md:w-72 bg-white dark:bg-gray-800 rounded-xl p-5 border dark:border-gray-600 shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-title font-semibold text-gray-800 dark:text-white">Filters</h2>
            <button @click="clearAll" class="text-sm text-blue-500 hover:underline">Clear all</button>
        </div>

        <!-- Price Range -->
        <div class="mb-6">
            <h3 class="text-form-subtitle font-medium text-gray-700 dark:text-gray-300 mb-2">Price Range</h3>
            <div class="flex gap-2 mb-2">
                <input type="number" v-model.number="localFilters.minPrice" placeholder="$ Min"
                    class="w-1/2 px-2 py-1 rounded border dark:bg-gray-700 dark:text-white dark:border-gray-500" />
                <input type="number" v-model.number="localFilters.maxPrice" placeholder="$ Max"
                    class="w-1/2 px-2 py-1 rounded border dark:bg-gray-700 dark:text-white dark:border-gray-500" />
            </div>
            <!-- Dual range slider -->
            <div class="text-xs text-gray-500 dark:text-gray-400 flex justify-between mt-1">
                <span>$0</span>
                <span>$5,000+</span>
            </div>
        </div>

        <!-- Location Dropdown -->
        <div class="mb-6">
            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location</h3>

            <button type="button" @click="showLocationDropdown = !showLocationDropdown"
                class="w-full p-2 border rounded flex items-center justify-between text-left bg-white text-gray-800 dark:bg-gray-700 dark:text-white dark:border-gray-500">
                <span>{{ localFilters.location || 'Select location' }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.293l3.71-4.06a.75.75 0 111.08 1.04l-4.25 4.65a.75.75 0 01-1.08 0l-4.25-4.65a.75.75 0 01.02-1.06z"
                        clip-rule="evenodd" />
                </svg>
            </button>

            <!-- Example dropdown list (you can style or make it dynamic as needed) -->
            <div v-if="showLocationDropdown"
                class="mt-2 border rounded bg-white dark:bg-gray-700 dark:text-white dark:border-gray-500 shadow">
                <ul>
                    <li v-for="city in cities" :key="city"
                        @click="localFilters.location = city; showLocationDropdown = false"
                        class="px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer">
                        {{ city }}
                    </li>
                </ul>
            </div>
        </div>



        <!-- Categories -->
        <div class="mb-6">
            <h3 class="text-form-subtitle font-medium text-gray-700 dark:text-gray-300 mb-2">Category</h3>
            <div v-for="cat in categories" :key="cat" class="flex items-center mb-1">
                <label class="text-sm text-gray-600 dark:text-gray-300">{{ cat }}</label>
                <input type="checkbox" v-model="localFilters.categories" :value="cat" class="mr-2 text-purple-600" />
            </div>
        </div>

        <!-- Listing Type -->
        <div>
            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Listing Type</h3>
            <div v-for="type in listingTypes" :key="type.value" class="flex items-center mb-1">
                <input type="radio" v-model="localFilters.listingType" :value="type.value" name="listing"
                    class="mr-2 text-purple-600" />
                <label class="text-sm text-gray-600 dark:text-gray-300">{{ type.label }}</label>
            </div>
        </div>

        <button @click="applyFilters"
            class="w-full mt-5 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm rounded">
            Apply Filters
        </button>
    </div>
</template>

<script setup>
import { onMounted, reactive, watch } from 'vue';

const emit = defineEmits(['update:filters']);

const props = defineProps({
    filters: Object
});

const localFilters = reactive({
    minPrice: '',
    maxPrice: '',
    rangePrice: 5000,
    location: '',
    distance: '25',
    categories: [],
    listingType: 'all'
});

// Update local filters when props change
watch(() => props.filters, (newFilters) => {
    if (newFilters) {
        Object.assign(localFilters, newFilters);
    }
}, { deep: true });

// Set defaults or sync with URL params on mount
onMounted(() => {
    if (props.filters) {
        Object.assign(localFilters, props.filters);
    }
});

// Watch for range price changes and update max price
watch(() => localFilters.rangePrice, (newValue) => {
    localFilters.maxPrice = newValue;
});

const categories = [
    'Electronics', 'Clothing', 'Furniture', 'Laptops/Phones',
    'Books', 'Toys', 'Sport', 'Beauty', 'Other'
];

const listingTypes = [
    { label: 'All listings', value: 'all' },
    { label: 'Auctions only', value: 'auction' },
    { label: 'Buy now only', value: 'buy_now' }
];

function applyFilters() {
    // Convert empty string values to null for cleaner URLs
    const cleanFilters = { ...localFilters };
    Object.keys(cleanFilters).forEach(key => {
        if (cleanFilters[key] === '') {
            cleanFilters[key] = null;
        }
    });

    // Only include categories if they are selected
    if (cleanFilters.categories && cleanFilters.categories.length === 0) {
        cleanFilters.categories = null;
    }

    emit('update:filters', cleanFilters);
}

function clearAll() {
    Object.assign(localFilters, {
        minPrice: '',
        maxPrice: '',
        rangePrice: 5000,
        location: '',
        distance: '25',
        categories: [],
        listingType: 'all'
    });
    applyFilters();
}
</script>
