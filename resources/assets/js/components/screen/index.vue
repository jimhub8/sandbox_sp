<template>
<!-- <v-app  id="inspire"> -->
<v-app  id="inspire" style="background: #000000 !important">
    <v-content>
        <!-- <v-tooltip bottom>
        <template v-slot:activator="{ on }">
            <v-btn icon v-on="on" class="mx-0" @click="toggle_screen" slot="activator">
                <v-icon color="info darken-2" small>refresh</v-icon>
            </v-btn>
        </template>
        <span>Toggle Screens</span>
    </v-tooltip> -->

        <v-fab-transition>
            <v-btn @click="toggle_screen" flat v-model="screen_show" color="blue" dark fab fixed bottom right>
                <v-icon small>refresh</v-icon>
            </v-btn>
        </v-fab-transition>
        <!-- <VBtn color="success" @click="toggle_screen">text</VBtn> -->
        <transition name="fade">
            <Screen1 v-show="screen_show"></Screen1>
        </transition>
        <transition name="fade">
            <Screen2 v-show="!screen_show"></Screen2>
        </transition>
    </v-content>
</v-app>
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
    methods: {
        toggle_screen() {
            this.screen_show = !this.screen_show
        }
    },
    created() {
        // this.timer = window.setInterval(() => {
        //     this.screen_show = !this.screen_show
        // }, 30000);
    },
    beforeDestroy() {
        clearInterval(this.timer);
    },
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
/* This is for documentation purposes and will not be needed in your application */
  #lateral .v-speed-dial,
  #lateral .v-btn--floating {
    position: absolute;
  }
  #lateral .v-btn--floating {
    margin: 0 0 16px 16px;
  }
</style>
