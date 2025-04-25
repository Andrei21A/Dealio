<template>
    <div
        class="max-w-sm rounded-2xl overflow-hidden shadow border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
        <!-- Image -->
        <div class="relative h-48 bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
            <!-- Optional Badge -->
            <div v-if="isAuction"
                class="absolute top-2 left-2 bg-gray-900 text-white text-sm px-3 py-1 rounded-full font-medium">
                Auction
            </div>
            <img v-if="product.image_path" :src="product.image_path" alt="Product" class="h-full w-full object-cover" />
            <div v-else class="text-gray-400">
                <Icon icon="material-symbols:image" width="40" />
            </div>
        </div>

        <!-- Info Section -->
        <div class="p-4 space-y-2">
            <h3 class="font-semibold text-lg truncate text-gray-900 dark:text-white">
                {{ product.title }}
            </h3>

            <div class="text-gray-500 dark:text-gray-300 text-sm">
                <span class="font-medium text-lg text-gray-900 dark:text-white">${{ product.price }}</span>
            </div>

            <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm gap-1">
                <Icon icon="mdi:map-marker" class="w-4 h-4" />
                <span>{{ product.location || 'Unknown location' }}</span>
            </div>

            <div class="flex justify-between items-center text-xs text-gray-400 mt-2">
                <span>{{ product.seller || 'Anonymous' }}</span>
                <span>{{ product.timeAgo || 'Some time ago' }}</span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Icon } from '@iconify/vue';

defineProps({
    product: Object,
    isAuction: Boolean,
});
</script>
