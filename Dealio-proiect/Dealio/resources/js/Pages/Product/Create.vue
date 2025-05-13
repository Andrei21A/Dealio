<template>
    <form @submit.prevent="create">
        <div class="min-h-screen flex items-center justify-center bg-gray-100 p-4 dark:bg-gray-800">
            <div class="bg-white rounded-lg shadow-lg max-w-3xl w-full p-6 dark:bg-gray-900">
                <h1 class="text-form-title">Add a new product
                </h1>
                <div class="w-full border-b border-gray-300 mb-6"></div>

                <!-- Images Section -->
                <div class="mb-6">
                    <label class="text-form-subtitle block mb-2">Images (up to 5)</label>
                    <div class="grid grid-cols-5 gap-4">
                        <div v-for="(imageUrl, index) in imagePreviewUrls" :key="index"
                            class="relative aspect-square bg-gray-100 rounded-lg overflow-hidden border border-gray-200 dark:bg-gray-700 dark:border-gray-600">
                            <img :src="imageUrl" alt="Preview"
                                class="absolute top-0 left-0 w-full h-full object-cover" />
                            <button @click="removeImage(index)" type="button"
                                class="absolute top-1 right-1 bg-white rounded-full p-1 shadow hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700">
                                &times;
                            </button>
                        </div>
                        <div v-for="index in 5 - imagePreviewUrls.length" :key="'placeholder-' + index"
                            class="aspect-square bg-gray-50 rounded-lg border border-dashed border-gray-300 flex flex-col items-center justify-center cursor-pointer dark:bg-gray-700 dark:border-gray-300"
                            @click="triggerFileInput">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            <span class="text-sm text-gray-500 mt-1">Upload</span>
                        </div>
                    </div>
                    <input ref="fileInput" type="file" multiple @change="handleImageChange" class="hidden" />
                </div>

                <!-- Title -->
                <div class="mb-6">
                    <label for="title" class="text-form-subtitle block mb-2">Title</label>
                    <input v-model="form.title" type="text" id="title" placeholder="What are you selling?"
                        class="w-full p-3 border border-gray-300 rounded-lg dark:border-gray-300 dark:bg-gray-700" />
                    <div v-if="form.errors.title" class="mt-1 text-sm text-red-600">{{ form.errors.title }}</div>
                </div>

                <!-- Listing Type -->
                <div class="mb-6">
                    <label class="text-form-subtitle block mb-2">Listing Type</label>
                    <div class="flex w-full gap-4">
                        <button type="button" :class="[
                            'flex-1 text-center p-3 rounded-lg border transition',
                            form.auction_status === 'fixed'
                                ? 'bg-purple-600 text-white border-purple-900'
                                : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100'
                        ]" @click="form.auction_status = 'fixed'">
                            Fixed Price
                        </button>
                        <button type="button" :class="[
                            'flex-1 text-center p-3 rounded-lg border transition',
                            form.auction_status === 'auction'
                                ? 'bg-purple-600 text-white border-purple-900'
                                : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100'
                        ]" @click="form.auction_status = 'auction'">
                            Auction
                        </button>
                    </div>
                </div>


                <!-- Category and Condition -->
                <div class="relative">
                    <label class="text-form-subtitle block mb-2">Category</label>
                    <button type="button" @click="showCategoryDropdown = !showCategoryDropdown"
                        class="w-full p-3 border border-gray-300 rounded-lg bg-white text-gray-800 text-left flex justify-between items-center dark:border-gray-300 dark:bg-gray-700 dark:text-gray-300">
                        <span>{{ form.category || 'Select category' }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.293l3.71-4.06a.75.75 0 111.08 1.04l-4.25 4.65a.75.75 0 01-1.08 0l-4.25-4.65a.75.75 0 01.02-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <ul v-show="showCategoryDropdown"
                        class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto dark:bg-gray-700 dark:border-gray-300 dark:text-gray-300">
                        <li v-for="category in categories" :key="category" @click="selectCategory(category)"
                            class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                            {{ category }}
                        </li>
                    </ul>

                    <div v-if="form.errors.category" class="mt-1 text-sm text-red-600">{{ form.errors.category }}</div>
                </div>

                <!-- Price and Location -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="price" class="text-form-subtitle block mb-2">Price ($)</label>
                        <input v-model="form.price" type="number" step="0.01" id="price" placeholder="0.00"
                            class="w-full p-3 border border-gray-300 rounded-lg dark:border-gray-300 dark:bg-gray-700 dark:text-gray-300" />
                        <div v-if="form.errors.price" class="mt-1 text-sm text-red-600">{{ form.errors.price }}</div>
                    </div>
                    <div>
                        <label for="location" class="text-form-subtitle block mb-2">Location</label>
                        <input v-model="form.location" type="text" id="location" placeholder="City, State"
                            class="w-full p-3 border border-gray-300 rounded-lg dark:border-gray-300 dark:bg-gray-700 dark:text-gray-300" />
                        <div v-if="form.errors.location" class="mt-1 text-sm text-red-600">{{ form.errors.location }}
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="text-form-subtitle block mb-2">Description</label>
                    <textarea v-model="form.description" id="description" rows="5" @input="autoResize"
                        placeholder="Describe what you're selling in detail..."
                        class="w-full p-3 border border-gray-300 rounded-lg dark:border-gray-300 dark:bg-gray-700 dark:text-gray-300"></textarea>
                    <div v-if="form.errors.description" class="mt-1 text-sm text-red-600">{{ form.errors.description }}
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" :disabled="form.processing" class="w-full btn">
                        {{ form.processing ? 'Creating...' : 'Create Listing' }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { useToast } from 'vue-toastification';

const toast = useToast();
const fileInput = ref(null);
const categories = [
    'Electronics',
    'Clothing',
    'Furniture',
    'Laptops/Phones',
    'Books',
    'Toys',
    'Sport',
    'Beauty',
    'Other',
];
//const conditions = ['New', 'Like New', 'Good', 'Fair', 'Poor'];
const imagePreviewUrls = ref([]);

const form = useForm({
    title: '',
    description: '',
    category: '',
    condition: '',
    auction_status: 'fixed',
    location: '',
    price: null,
    images: null
});

watch(() => form.images, (files) => {
    imagePreviewUrls.value = [];
    if (files) {
        for (let i = 0; i < Math.min(files.length, 5); i++) {
            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreviewUrls.value.push(e.target.result);
            };
            reader.readAsDataURL(files[i]);
        }
    }
});

const triggerFileInput = () => {
    fileInput.value.click();
};

const handleImageChange = (event) => {
    const files = event.target.files;
    // Only allow up to 5 images
    if (files.length > 5) {
        toast.warning('Maximum 5 images allowed');
        const fileList = new DataTransfer();
        for (let i = 0; i < 5; i++) {
            fileList.items.add(files[i]);
        }
        form.images = fileList.files;
    } else {
        form.images = files;
    }
};

const removeImage = (index) => {

    if (form.images) {
        const dt = new DataTransfer();
        for (let i = 0; i < form.images.length; i++) {
            if (i !== index) {
                dt.items.add(form.images[i]);
            }
        }
        form.images = dt.files.length > 0 ? dt.files : null;
        // Remove the preview URL
        imagePreviewUrls.value.splice(index, 1);
    }
};

const showCategoryDropdown = ref(false);

const selectCategory = (category) => {
    form.category = category;
    showCategoryDropdown.value = false;
};
const create = () => {

    if (!form.images || form.images.length === 0) {
        toast.error('Please upload at least one image.');
    }

    form.post('/products', {
        onSuccess: () => {
            form.reset();
            imagePreviewUrls.value = [];
        },
        onError: (errors) => {
            if (Object.keys(errors).length > 0) {
                toast.error('Please check the form for errors.');
            }
        }
    });
};
</script>
