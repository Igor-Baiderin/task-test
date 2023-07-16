import './bootstrap';
import {createApp} from "vue";
import {library} from '@fortawesome/fontawesome-svg-core'
/* import font awesome icon component */
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
/* import specific icons */
import {fas} from '@fortawesome/free-solid-svg-icons'
import {fab} from '@fortawesome/free-brands-svg-icons'
import Paginate from "vuejs-paginate-next";
import MainComponent from "@/MainComponent.vue";

library.add(fas, fab)

const app = createApp({

    components: {
        MainComponent,
        FontAwesomeIcon,
    },
})

app.use(Paginate).mount('#app')

