<template>
    <Link :href="route('products.show', { product: product.id })">
    <div class="border rounded-lg shadow hover:shadow-lg transition overflow-hidden bg-white dark:bg-gray-800">
        <!-- Auction Badge -->
        <div class="relative">
            <div v-if="product.auction_status === 'ongoing'">
                <span class="absolute top-4 left-4 bg-gray-900 text-white px-4 py-2 rounded-full text-md font-medium">
                    Auction Ongoing
                </span>
            </div>
            <div v-else-if="product.status === 'sold'">
                <span class="absolute top-4 left-4 bg-red-600 text-white px-4 py-2 rounded-full text-md font-medium">
                    Sold
                </span>
            </div>
            <!-- Product Image(s) -->
            <div v-if="product.images && product.images.length > 0">
                <img :src="getImageUrl(product.images[0].file_name)" :alt="product.title"
                    class="w-full h-64 object-cover" />
            </div>
            <!-- Fallback Image if No Product Images Available -->
            <div v-else>
                <img :src="'/api/placeholder/400/320'" :alt="product.title"
                    class="w-full max-h-48 object-cover rounded-t" />
            </div>
        </div>
        <!-- Content Section -->
        <div class="p-5">
            <!-- Product Title -->
            <h2 class="text-subtitle mb-2">{{ product.title }}</h2>
            <!-- Current Bid -->
            <div class="text-gray-500 mb-1 dark:text-gray-400">Current bid:</div>
            <div class="text-3xl font-bold mb-4">${{ formatPrice(product.price) }}</div>
            <!-- Location -->
            <div class="flex items-center text-gray-600 mb-4 dark:text-gray-400">
                <Icon icon="oui:vis-map-coordinate" height="24"></Icon>
                <span>{{ product.location }}</span>
            </div>
            <!-- Seller and Time Posted -->
            <div class="flex justify-between items-center text-gray-600 dark:text-gray-400">
                <div>{{ product.user?.user_name || 'Anonymous' }}</div>
                <div>{{ formatTimeAgo(product.created_at) }}</div>
            </div>
        </div>
    </div>
    </Link>
</template>

<script setup>
import { Icon } from '@iconify/vue';
import { Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
})

const formatPrice = (price) => {
    return parseFloat(price).toLocaleString(undefined, { minimumFractionDigits: 0, maximumFractionDigits: 0 })
}

// Format relative time
const formatTimeAgo = (dateString) => {
    if (!dateString) return 'Recently';

    const date = new Date(dateString);
    const now = new Date();
    const diffTime = Math.abs(now - date);
    const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));

    if (diffDays === 0) {
        return 'Today';
    } else if (diffDays === 1) {
        return 'Yesterday';
    } else {
        return `${diffDays} days ago`;
    }
}

// Calculate time left for auction
const getTimeLeft = () => {
    if (!props.product.auctions?.end_time) return '1d 23h left'; // Default fallback

    const endTime = new Date(props.product.auctions.end_time);
    const now = new Date();

    if (endTime <= now) {
        return 'Auction ended';
    }

    const diffTime = endTime - now;
    const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
    const diffHours = Math.floor((diffTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

    return `${diffDays}d ${diffHours}h left`;
}

const getImageUrl = (fileName) => {
    return `/storage/${fileName}`; // Assumes images are stored under storage/app/public
}

</script>
