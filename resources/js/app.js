import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import Layout from "./layouts/Layout.vue";

const element = document.head.querySelector('meta[name="user"]');
const user = element.content ? JSON.parse(element.content) : null;

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./pages/**/*.vue', { eager: true })
        let page = pages[`./pages/${name}.vue`]
        page.default.layout = name === 'Login' ? undefined : Layout
        return page
    },
    setup({ el, App, props, plugin }) {
        props.user = user

        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el)
    },
})
