import { createInertiaApp } from '@inertiajs/vue3';
import { createApp, h } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue'; // Adjust path if needed

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
        const page = pages[`./Pages/${name}.vue`];
        
        if (!page) {
            throw new Error(`Page not found: ./Pages/${name}.vue`);
        }

        page.default.layout = page.default.layout || MainLayout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
});
