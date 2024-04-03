import './bootstrap';
import { createApp } from "vue/dist/vue.esm-bundler.js";
import Example from "./components/ExampleComponent.vue"

const app = createApp({
    components: {
        Example,
    }
});
app.mount("#app");
