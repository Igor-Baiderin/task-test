import './bootstrap';

import {createApp} from "vue";

// import {createApp, h} from "vue/dist/vue.esm-bundler";
import {library} from '@fortawesome/fontawesome-svg-core'
/* import font awesome icon component */
import {FontAwesomeIcon, FontAwesomeLayers, FontAwesomeLayersText} from '@fortawesome/vue-fontawesome'
/* import specific icons */
import {fas} from '@fortawesome/free-solid-svg-icons'
import {fab} from '@fortawesome/free-brands-svg-icons'
import MainComponent from "@/MainComponent.vue";

library.add(fas, fab)

const app = createApp({

    components: {
        MainComponent,
        FontAwesomeIcon,
        FontAwesomeLayers,
        FontAwesomeLayersText
    }
})

app.mount('#app')

