<template>
    <form @submit.prevent="create">
        <div>
            <div>
                <label>Title</label>
                <input v-model="form.title" type="text" />
                <div v-if="form.errors.title" class="error">{{ form.errors.title }}</div>
            </div>
            <div>
                <label>Description</label>
                <input v-model="form.description" type="text" />
                <div v-if="form.errors.description" class="error">{{ form.errors.description }}</div>
            </div>
            <div>
                <label>Category</label>
                <select v-model="form.category">
                    <option value="">Select a category</option>
                    <option v-for="category in categories" :value="category" :key="category">
                        {{ category }}
                    </option>
                </select>
                <div v-if="form.errors.category" class="error">{{ form.errors.category }}</div>
            </div>
            <div>
                <label>Price</label>
                <input v-model="form.price" type="number" step="0.01" />
                <div v-if="form.errors.price" class="error">{{ form.errors.price }}</div>
            </div>
            <div>
                <button type="submit" :disabled="form.processing">
                    {{ form.processing ? 'Creating...' : 'Create' }}
                </button>
            </div>
        </div>
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';

const toast = useToast();
const categories = ['Electronics', 'Clothing', 'Furniture', 'Laptops', 'Other'];

const form = useForm({
    title: '',
    description: '',
    category: '',
    price: null,
    user_id: 1,
});

const create = () => {
    form.post('/products', {
        onSuccess: () => {
            // Formularul se resetează automat după succes
            // Mesajul flash va fi gestionat de MainLayout
            console.log('Product created successfully');
        },
        onError: (errors) => {
            // Afișează un toast de eroare pentru erorile de validare care nu sunt deja afișate
            if (Object.keys(errors).length > 0) {
                toast.error('Please check the form for errors.');
            }
        }
    });
};
</script>

<style scoped>
label {
    margin-right: 2em;
    display: block;
    margin-bottom: 0.5rem;
}

div {
    padding: 2px;
    margin-bottom: 1rem;
}

.error {
    color: red;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

select,
input {
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 100%;
    max-width: 400px;
}
</style>
