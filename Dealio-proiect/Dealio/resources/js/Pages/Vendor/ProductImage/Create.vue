<template>
    <form @submit.prevent="uploadImages">
        <div>
            <label>Product Images</label>
            <input type="file" multiple @input="form.images = $event.target.files" />
            <div v-if="form.errors.images" class="error">{{ form.errors.images }}</div>

            <!-- Preview selected images (optional) -->
            <div v-if="imagePreviewUrls.length" class="image-preview">
                <div v-for="(imageUrl, index) in imagePreviewUrls" :key="index" class="preview-item">
                    <img :src="imageUrl" alt="Preview" />
                </div>
            </div>

            <div>
                <button type="submit" :disabled="form.processing">
                    {{ form.processing ? 'Uploading...' : 'Upload Images' }}
                </button>
            </div>
        </div>
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { useToast } from 'vue-toastification';

const props = defineProps({
    product: Object
});

const toast = useToast();
const imagePreviewUrls = ref([]);

const form = useForm({
    images: null
});

// Create image previews when files are selected
watch(() => form.images, (files) => {
    imagePreviewUrls.value = [];

    if (files) {
        for (let i = 0; i < files.length; i++) {
            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreviewUrls.value.push(e.target.result);
            };
            reader.readAsDataURL(files[i]);
        }
    }
});

const uploadImages = () => {
    // Use post() for multipart/form-data to upload files
    form.post(route('vendor.product.image.store', props.product.id), {
        preserveScroll: true,
        onSuccess: () => {
            // Reset the form and image previews
            form.reset('images');
            imagePreviewUrls.value = [];

            // Show success toast
            toast.success('Images uploaded successfully');
        },
        onError: (errors) => {
            if (Object.keys(errors).length > 0) {
                toast.error('Error uploading images. Please check the form.');
            }
        }
    });
};
</script>
