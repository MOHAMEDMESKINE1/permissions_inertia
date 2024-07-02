import './bootstrap';
import '../css/app.css';
import 'flowbite';
import { createApp, h } from 'vue';
import { createInertiaApp, router } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import VueClickAway from "vue3-click-away";
import PrimeVue from "primevue/config";
import 'primeicons/primeicons.css'
import "primevue/resources/themes/aura-light-green/theme.css"
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
import { initFlowbite } from 'flowbite';
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue,{
                unstyled: false,
            })
            .use(VueClickAway) // Makes 'v-click-away' directive usable in every component
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
}).then(() => {
    initFlowbite();
});
