<template>
    <div class="w-full md:w-72 bg-white dark:bg-gray-800 rounded-xl p-5 border dark:border-gray-600 shadow-md">
        <div class="mb-6">
            <h3 class="text-form-subtitle font-medium text-gray-700 dark:text-gray-300 mb-2">Price Range</h3>
            <div class="mb-6">
                <h3 class="text-form-subtitle font-medium text-gray-700 dark:text-gray-300 mb-2">Price Range</h3>

                <!-- Min/Max Number Inputs -->
                <div class="flex gap-2 mb-3">
                    <div class="relative w-1/2">
                        <span class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-900 dark:text-gray-300">$</span>
                        <input type="number" v-model.number="localFilters.minPrice" min="0"
                            :max="localFilters.maxPrice !== '' ? localFilters.maxPrice : 5000" step="50"
                            class="pl-5 w-full px-2 py-1 rounded border dark:bg-gray-700 dark:text-white dark:border-gray-500"
                            placeholder="Min" />
                    </div>
                    <div class="relative w-1/2">
                        <span class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-900 dark:text-gray-300">$</span>
                        <input type="number" v-model.number="localFilters.maxPrice"
                            :min="localFilters.minPrice !== '' ? localFilters.minPrice : 0" max="5000" step="50"
                            class="pl-5 w-full px-2 py-1 rounded border dark:bg-gray-700 dark:text-white dark:border-gray-500"
                            placeholder="Max" />
                    </div>
                </div>

                <!-- Range Sliders -->

                <div class="flex gap-2 items-center">
                    <input type="range" min="0" max="5000" step="50" v-model.number="localFilters.minPrice"
                        class="w-full accent-purple-600" />
                    <input type="range" min="0" max="5000" step="50" v-model.number="localFilters.maxPrice"
                        class="w-full accent-purple-600" />
                </div>
            </div>

        </div>


        <div class="mb-6">
            <h3 class="text-form-subtitle font-medium text-gray-700 dark:text-gray-300 mb-1">Location</h3>
            <select v-model="localFilters.location"
                class="w-full p-2 border rounded bg-white text-gray-800 dark:bg-gray-700 dark:text-white dark:border-gray-500">
                <option value="">Select location</option>
                <option v-for="city in cities" :key="city" :value="city">
                    {{ city }}
                </option>
            </select>
        </div>

        <div class="mb-6">
            <h3 class="text-form-subtitle font-medium text-gray-700 dark:text-gray-300 mb-2">Category</h3>
            <div class="flex flex-wrap gap-2">
                <button v-for="cat in categories" :key="cat" @click="toggleCategory(cat)" :class="[
                    'btn-category',
                    localFilters.categories.includes(cat)
                        ? 'bg-purple-600 text-white'
                        : 'bg-white text-gray-700 dark:bg-gray-700 dark:text-gray-300'
                ]" class="px-3 py-1 rounded-md text-sm transition-colors">
                    {{ cat }}
                </button>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Listing Type</h3>
            <div class="flex flex-wrap gap-2">
                <button v-for="type in listingTypes" :key="type.value" @click="localFilters.listingType = type.value"
                    :class="[
                        'btn-category',
                        localFilters.listingType === type.value
                            ? 'bg-purple-600 text-white'
                            : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300'
                    ]" class="px-3 py-1 rounded-md text-sm transition-colors">
                    {{ type.label }}
                </button>
            </div>
        </div>

        <button @click="applyFilters"
            class="w-full mt-5 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm rounded">
            Apply Filters
        </button>
    </div>
</template>

<script setup>
import { reactive, watch } from 'vue';

const emit = defineEmits(['update:filters']);

const props = defineProps({
    filters: Object,
});

// Default state for filters
const getDefaultFilters = () => ({
    minPrice: 0,
    maxPrice: 5000,
    location: '',
    categories: [],
    listingType: 'all',
});

const localFilters = reactive(getDefaultFilters());

const cities = [
    'Alba', 'Arad', 'Arges', 'Bacau', 'Bihor',
    'Bistrita-Nasaud', 'Botosani', 'Braila', 'Brasov', 'Bucuresti',
    'Buzau', 'Calarasi', 'Caras-Severin', 'Cluj', 'Constanta',
    'Covasna', 'Dambovita', 'Dolj', 'Galati', 'Giurgiu',
    'Gorj', 'Harghita', 'Hunedoara', 'Ialomita', 'Iasi',
    'Ilfov', 'Maramures', 'Mehedinti', 'Mures', 'Neamt',
    'Olt', 'Prahova', 'Salaj', 'Satu Mare', 'Sibiu',
    'Suceava', 'Teleorman', 'Timis', 'Tulcea', 'Valcea',
    'Vaslui', 'Vrancea'
];

const categories = [
    'Electronics', 'Clothing', 'Furniture', 'Laptops/Phones',
    'Books', 'Toys', 'Sport', 'Beauty', 'Other',
];

const listingTypes = [
    { label: 'All listings', value: 'all' },
    { label: 'Auctions only', value: 'auction' },
    { label: 'Buy now only', value: 'buy_now' },
];

function toggleCategory(cat) {
    const index = localFilters.categories.indexOf(cat);
    if (index === -1) {
        localFilters.categories.push(cat);
    } else {
        localFilters.categories.splice(index, 1);
    }
}

watch(
    () => props.filters,
    (newFilters) => {
        const filtersToApply = getDefaultFilters();
        if (newFilters) {
            for (const key in filtersToApply) {
                if (newFilters[key] !== undefined && newFilters[key] !== null) {
                    if (key === 'minPrice' || key === 'maxPrice') {
                        filtersToApply[key] = newFilters[key] === null ? '' : Number(newFilters[key]);
                    } else {
                        filtersToApply[key] = newFilters[key];
                    }
                }
            }
        }
        Object.assign(localFilters, filtersToApply);
    },
    { deep: true, immediate: true }
);

// Watch for price changes and validate them
watch(() => localFilters.minPrice, (newVal) => {
    if (newVal < 0) localFilters.minPrice = 0;
    if (newVal > localFilters.maxPrice && localFilters.maxPrice !== '') {
        localFilters.minPrice = localFilters.maxPrice;
    }
});

watch(() => localFilters.maxPrice, (newVal) => {
    if (newVal < 0) localFilters.maxPrice = 0;
    if (newVal > 5000) localFilters.maxPrice = 5000;
    if (newVal < localFilters.minPrice && localFilters.minPrice !== '') {
        localFilters.maxPrice = localFilters.minPrice;
    }
});

function applyFilters() {
    const minPrice = localFilters.minPrice === '' ? null : Number(localFilters.minPrice);
    const maxPrice = localFilters.maxPrice === '' ? null : Number(localFilters.maxPrice);

    emit('update:filters', {
        minPrice: minPrice,
        maxPrice: maxPrice,
        location: localFilters.location || null,
        categories: localFilters.categories.length > 0 ? localFilters.categories : null,
        listingType: localFilters.listingType
    });
}

function clearAll() {
    Object.assign(localFilters, getDefaultFilters());
    applyFilters();
}
</script>
