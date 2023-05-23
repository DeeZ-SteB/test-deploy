import { createApp } from 'vue';
import store from './store';

// Pages
import AnalyticsPage from './pages/main/AnalyticsPage.vue';

// Components
import ExampleComponent from './components/ExampleComponent.vue';

const app = createApp({});

app.use(store);

// Register pages
app.component('analytics-page', AnalyticsPage);

// Registered components
app.component('example-component', ExampleComponent);

app.mount('#app-root');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });
