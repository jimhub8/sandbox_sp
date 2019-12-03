<template>
<v-content>
    <v-flex sm12>
        <el-select v-model="client.id" filterable placeholder="Select Client" @change="get_filter">
            <el-option v-for="item in clients" :key="item.id" :label="item.name" :value="item.id">
            </el-option>
        </el-select>
    </v-flex>
    <transition name="fade">
        <Screen1 :clients="clients"  :client="client" v-show="screen_show"></Screen1>
    </transition>
    <transition name="fade">
        <Screen2 :clients="clients"  :client="client" v-show="!screen_show"></Screen2>
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
            screen_show: false,
            clients: [],
            client: {
                id: 1
            }
        }
    },

    created() {
        this.timer = window.setInterval(() => {
            this.screen_show = !this.screen_show
        }, 30000);
    },
    beforeDestroy() {
        clearInterval(this.timer);
    },
    methods: {
        getClients() {
            axios.get('clients')
                .then(response => {
                    this.clients = response.data
                })
                .catch(error => {
                    this.loading = false;
                    this.errors = error.response.data.errors;
                });
        },
        get_filter() {
            eventBus.$emit('refreshData')
        }
    },
    mounted () {
        this.getClients();
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

.fade-leave-active {
    transition: opacity 1s;
    opacity: 0;
}
</style>
