<template>
<v-content>
    <transition name="fade">
        <Screen1 v-show="screen_show"></Screen1>
    </transition>
    <transition name="fade">
        <Screen2 v-show="!screen_show"></Screen2>
    </transition>
</v-content>
</template>

<script>
import Screen1 from './screen_1'
import Screen2 from './screen_2'
export default {
    components: {
        Screen1,
        Screen2
    },
    data() {
        return {
            screen_show: false
        }
    },
    created() {
        this.timer = window.setInterval(() => {
            this.screen_show = !this.screen_show
        }, 6000);
    },
    beforeDestroy() {
        clearInterval(this.timer);
    },
    methods: {},
}
</script>

<style scoped>
.fade-enter {
    opacity: 0;
}

.fade-enter-active {
    transition: opacity 1s;
}

.fade-leave {
    /* opacity: 1; */
}

.fade-leave-active {
    transition: opacity 1s;
    opacity: 0;
}
</style>
