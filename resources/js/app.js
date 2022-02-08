require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

import moment from 'moment';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

moment.locale("pt-br");

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .mixin({
                methods: {
                    route,
                    formatDateMessage(value) {
                        if(value)
                            return moment(value).format('HH::mm');
                    }
                }
            })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
