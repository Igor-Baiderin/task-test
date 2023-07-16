import './bootstrap';
import {createApp} from "vue";
import MainComponent from "@/MainComponent.vue";
/**
 * add bootstrap
 */
import "bootstrap/dist/css/bootstrap.css"
import "bootstrap"
const app = createApp({

    components: {
        MainComponent,
    },
})

app.mount('#app')

