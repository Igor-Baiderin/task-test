import './bootstrap';
import {createApp} from "vue";
import MainComponent from "@/MainComponent.vue";
/**
 * add bootstrap
 */
import "bootstrap/dist/css/bootstrap.css"
import "bootstrap"
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
const app = createApp({

    components: {
        MainComponent,
        VueDatePicker
    },
})

app.mount('#app')

