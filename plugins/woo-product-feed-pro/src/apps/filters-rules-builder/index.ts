import $ from 'jquery';
declare global {
  interface Window {
    $: typeof $;
    jQuery: typeof $;
  }
}
window.$ = $;
window.jQuery = $;
import 'vue-select/dist/vue-select.css';
import 'vite/modulepreload-polyfill';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import './index.scss';
import App from './App.vue';

/***************************************************************************
 * Create Vue App
 ***************************************************************************
 *
 * We instantiate a new Vue app.
 *
 */
const app = createApp(App);

/***************************************************************************
 * Use Vue plugins
 ***************************************************************************
 *
 * We register all the Vue plugins that we're going to use.
 *
 */
app.use(createPinia());

/***************************************************************************
 * Provide window object
 ***************************************************************************
 *
 * We set the window object global app property so that we can access it
 * within the app.
 */
app.provide('$window', window);

/***************************************************************************
 * Mount Vue App
 ***************************************************************************
 *
 * We mount the Vue app to the DOM with the target id.
 *
 */
app.mount('#filters-rules-builder-app');
