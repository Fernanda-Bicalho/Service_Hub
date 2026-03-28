/**
 * Importamos o bootstrap.js que configura o Axios para o Sail
 * e lida com os tokens CSRF automaticamente.
 */
import './bootstrap';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';

createInertiaApp({
    // Define como o Inertia vai encontrar seus componentes Vue
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
        return pages[`./Pages/${name}.vue`];
    },

    // Configura a instância do Vue 3
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },

    // Opcional: Adiciona uma barra de carregamento durante a navegação
    progress: {
        color: '#4B5563',
    },
});