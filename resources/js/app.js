import './bootstrap';
import {createApp} from "vue";
import MainComponent from "@/MainComponent.vue";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
const options = {
    // You can set your default options here for vue-toastification
};
const app = createApp({
    components: {
        MainComponent,
        VueDatePicker
    },
})
app.use(Toast, options).mount('#app')

