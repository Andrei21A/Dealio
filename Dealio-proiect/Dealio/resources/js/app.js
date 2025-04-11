import { createInertiaApp } from "@inertiajs/vue3";
import { createApp, h } from "vue";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import MainLayout from "./Layouts/MainLayout.vue";

createInertiaApp({
    resolve: async (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", {
            eager: true,
        });

        const page = pages[`./Pages/${name}.vue`];

        if (!page) {
            throw new Error(`Page not found: ${name}`);
        }

        page.default.layout = page.default.layout || MainLayout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(Toast, {
                position: "top-right",
                timeout: 3000,
                closeOnClick: true,
                pauseOnHover: true,
                draggable: true,
            })
            .mount(el);
    },
});
