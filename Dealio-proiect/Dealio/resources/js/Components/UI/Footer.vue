<template>
    <footer class="w-full border-t border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 py-8 mt-10">
        <div class="container mx-auto px-4 text-gray-600 dark:text-gray-400 text-sm">
            <div class="flex flex-col md:flex-row justify-between items-center md:items-start gap-6">
                <!-- Contact Info -->
                <div class="text-center md:text-left space-y-1">
                    <div><strong>Email:</strong> <a href="mailto:support@dealio.com"
                            class="text-blue-300 hover:underline">support@dealio.com</a></div>
                    <div><strong>Phone:</strong> +1 (123) 456-7890</div>
                    <div><strong>Location:</strong> 123 Market Street, Tech City, USA</div>
                </div>

                <!-- Copyright / Credits -->
                <div class="text-center md:text-right space-y-1">
                    <div>&copy; {{ new Date().getFullYear() }} Dealio. Almost all rights reserved.</div>
                    <div>Built by <a href="https://yourportfolio.com" class="text-blue-300 hover:underline"
                            target="_blank">Anea Andrei</a></div>
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup>
// No logic needed, simple static footer
</script>

<style scoped>
footer {
    flex-shrink: 0;
}
</style>
