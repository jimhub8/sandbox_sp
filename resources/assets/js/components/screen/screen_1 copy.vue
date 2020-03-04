<template>
<v-content>
    <vue-topprogress ref="topProgress"></vue-topprogress>
    <v-container fluid fill-height>
        <v-layout justify-center align-center row wrap>
            <v-flex sm12>
                <el-select v-model="client.id" filterable placeholder="Select Client" @change="get_filter_data">
                    <el-option v-for="item in clients" :key="item.id" :label="item.name" :value="item.id">
                    </el-option>
                </el-select>
            </v-flex>
            <v-flex sm12>
                <div class="col-md-12">

                    <div class="row">
                        <div class="col-12 col-sm-6 col-xl-3 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="text-white mt-3">Orders</h4>
                                            <h4 class="text-white mt-3">{{ total }}</h4>
                                            <h6 class="text-muted">Since last last week</h6>
                                        </div>
                                        <div class="icon-box icon-box-bg-image-warning">
                                            <v-icon color="indigo lighten-5">shopping_cart</v-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-3 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="text-white mt-3">Delivered</h4>
                                            <h4 class="text-white mt-3">{{ delivered }}</h4>
                                            <h6 class="text-muted">Since last week</h6>
                                        </div>
                                        <div class="icon-box icon-box-bg-image-info">
                                            <v-icon color="brown lighten-3">offline_pin</v-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-3 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="text-white mt-3">Delivery percentage</h4>
                                            <h4 class="text-white mt-3">{{ delivered_perc }}</h4>
                                            <h6 class="text-muted">Since last week</h6>
                                        </div>
                                        <div class="icon-box icon-box-bg-image-danger">
                                            <v-icon color="white">map</v-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-3 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="text-white mt-3">Target</h4>
                                            <h4 class="text-white mt-3">60%</h4>
                                            <h6 class="text-muted">Since last week</h6>
                                        </div>
                                        <div class="icon-box icon-box-bg-image-success">
                                            <v-icon color="grey lighten-1">gps_fixed</v-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- </div> -->
                <myChart style="height: 300px;" :client="client"></myChart>
                <!-- <v-btn @click="getBranchCount" flat color="primary">Count</v-btn> -->
                <div class="col-md-12">
                    <!-- <div class="card card-stats card-raised">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="statistics">
                                        <div class="">
                                            <div class="icon icon-primary">
                                                <v-icon color="green">beenhere</v-icon>
                                            </div>
                                            <h3 class="info-title"><span><b>{{ expected_del }}</b></span></h3>
                                            <h6 class="stats-title"><strong>Expected Deliveries</strong></h6>
                                        </div>
                                    </div>
                                </div>
                                <v-divider vertical></v-divider>
                                <div class="col-md-3">
                                    <div class="statistics">
                                        <div class="">
                                            <div class="icon icon-success">
                                                <v-icon color="purple">gps_off</v-icon>
                                            </div>
                                            <h3 class="info-title"><span><b>{{ remaining_del }}</b></span></h3>
                                            <h6 class="stats-title"><strong>Remaining</strong></h6>
                                        </div>
                                    </div>
                                </div>
                                <v-divider vertical></v-divider>
                                <div class="col-md-3">
                                    <div class="statistics">
                                        <div class="">
                                            <div class="icon icon-info">
                                                <v-icon color="indigo">block</v-icon>
                                            </div>
                                            <h3 class="info-title"><span><b>{{ remaining_per }}%</b></span></h3>
                                            <h6 class="stats-title"><strong>Remaining percentage</strong></h6>
                                        </div>
                                    </div>
                                </div>
                                <v-divider vertical></v-divider>
                                <div class="col-md-2">
                                    <div class="statistics">
                                        <div class="">
                                            <div class="icon icon-danger">
                                                <v-icon color="red">gps_fixed</v-icon>
                                            </div>
                                            <h3 class="info-title"><span><b>60%</b></span></h3>
                                            <h6 class="stats-title"><strong> Target</strong></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-12 col-sm-6 col-xl-3 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="text-white mt-3">Expected Deliveries</h4>
                                            <h4 class="text-white mt-3">{{ expected_del }}</h4>
                                            <h6 class="text-muted">Since last last week</h6>
                                        </div>
                                        <div class="icon-box icon-box-bg-image-warning">
                                            <v-icon color="indigo lighten-5">beenhere</v-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-3 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="text-white mt-3">Remaining</h4>
                                            <h4 class="text-white mt-3">{{ remaining_del }}</h4>
                                            <h6 class="text-muted">Since last week</h6>
                                        </div>
                                        <div class="icon-box icon-box-bg-image-info">
                                            <v-icon color="brown lighten-3">gps_off</v-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-3 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="text-white mt-3">Remaining percentage</h4>
                                            <h4 class="text-white mt-3">{{ remaining_per }}%</h4>
                                            <h6 class="text-muted">Since last week</h6>
                                        </div>
                                        <div class="icon-box icon-box-bg-image-danger">
                                            <v-icon color="white">block</v-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-3 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="text-white mt-3">Target</h4>
                                            <h4 class="text-white mt-3">60%</h4>
                                            <h6 class="text-muted">Since last week</h6>
                                        </div>
                                        <div class="icon-box icon-box-bg-image-success">
                                            <v-icon color="grey lighten-1">gps_fixed</v-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </v-flex>
        </v-layout>
    </v-container>
</v-content>
</template>

<script>
import myChart from '../charts/Screen'
import {
    vueTopprogress
} from "vue-top-progress";
export default {
    // props: ['total', 'delivered', 'client'],
    components: {
        myChart,
        vueTopprogress
    },
    data() {
        return {
            total: null,
            delivered: null,
            client: [],
            clients: [],
        }
    },
    methods: {
        get_data() {
            eventBus.$emit('screenProgressEvent')
            axios.get('/get_data')
                .then(response => {
                    eventBus.$emit('screenStopProgressEvent')
                    this.total = response.data.total
                    this.client = response.data.client
                    this.delivered = response.data.delivered
                    // eventBus.$emit('refreshChartEvent')
                    eventBus.$emit('getChartEvent', this.client)
                })
                .catch(error => {
                    eventBus.$emit('screenStopProgressEvent')
                    this.loading = false;
                    this.errors = error.response.data.errors;
                });
        },
        get_filter_data() {
            eventBus.$emit('refreshChartEvent')
            // console.log(id);
            eventBus.$emit('screenProgressEvent')
            axios.get(`/get_filter_data/${this.client.id}`)
                .then(response => {
                    eventBus.$emit('screenStopProgressEvent')
                    this.total = response.data.total
                    this.client = response.data.client
                    this.delivered = response.data.delivered
                    eventBus.$emit('refreshChartEvent')
                })
                .catch(error => {
                    eventBus.$emit('screenStopProgressEvent')
                    this.loading = false;
                    this.errors = error.response.data.errors;
                });
        },
        getClients() {
            axios.get('/clients')
                .then(response => {
                    this.clients = response.data
                })
                .catch(error => {
                    this.loading = false;
                    this.errors = error.response.data.errors;
                });
        }
    },
    computed: {
        delivered_perc() {
            return parseFloat((parseInt(this.delivered) / parseInt(this.total)) * 100).toFixed(2)
        },
        expected_del() {
            return parseInt(parseInt(this.total) * 60 / 100)
        },
        remaining_del() {
            return parseInt(this.expected_del - parseInt(this.delivered))
        },
        remaining_per() {
            return parseFloat(60 - this.delivered_perc).toFixed(2)
        },
    },
    mounted() {
        this.get_data();
        this.getClients();
    },
    created() {
        this.timer = window.setInterval(() => {
            this.get_filter_data();
            // eventBus.$emit('refreshChartEvent')
        }, 60000);
        eventBus.$on("screenStopProgressEvent", data => {
            this.$refs.topProgress.done();
        });

        eventBus.$on("screenProgressEvent", data => {
            this.$refs.topProgress.start();
        });
    },
    beforeDestroy() {
        clearInterval(this.timer);
    },
}
</script>

<style scoped>
.card-stats {
    margin-top: -10px;
    padding: 10px 0;
}

.progress-Ship {
    margin-top: 100px !important;
}

.v-icon {
    font-size: 64px !important;
}

.v-icon {
    /* box-shadow: 0 9px 30px -6px #fff; */
    box-shadow: -2px -3px 17px 7px #1d4dd47a;
    padding: 5px;
    border-radius: 50%;
}

.info-title {
    margin-top: 20px;
}

.card .card-body {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: rgb(24, 25, 28) !important;
    background-clip: border-box;
    border: 1px solid #313452;
    border-radius: 0;
}
</style>
