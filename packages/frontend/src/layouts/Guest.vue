<template>
    <div class="h-screen pt-14 md:pt-32 pb-6 px-4 md:px-0 bg-gray-300">
        <header class="max-w-lg mx-auto">
            <a href="/">
                <application-logo class="h-28 w-72 mx-auto"></application-logo>
            </a>
        </header>
        <div>
            <slot/>
        </div>
    </div>
</template>

<script>
import ApplicationLogo from '@/components/ApplicationLogo.vue'
import {ElNotification} from "element-plus";

import {computed, watch} from "vue";

export default {
    name: 'GuestLayout',
    components: {
        ApplicationLogo,
    },
    setup(){
    }
}
</script>
