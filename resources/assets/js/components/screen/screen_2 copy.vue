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
                    <div class="card card-stats card-raised">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="statistics">
                                        <div class="">
                                            <div class="icon icon-primary">
                                                <v-icon color="green">local_shipping</v-icon>
                                            </div>
                                            <h3 class="info-title"><span><b>{{ total }}</b></span></h3>
                                            <h6 class="stats-title"><strong>Total Shipments</strong></h6>
                                        </div>
                                    </div>
                                </div>
                                <v-divider vertical></v-divider>
                                <div class="col-md-3">
                                    <div class="statistics">
                                        <div class="">
                                            <div class="icon icon-success">
                                                <v-icon color="purple">offline_pin</v-icon>
                                            </div>
                                            <h3 class="info-title"><span><b>{{ delivered }}</b></span></h3>
                                            <h6 class="stats-title"><strong>Delivered</strong></h6>
                                        </div>
                                    </div>
                                </div>
                                <v-divider vertical></v-divider>
                                <div class="col-md-3">
                                    <div class="statistics">
                                        <div class="">
                                            <div class="icon icon-info">
                                                <v-icon color="indigo">map</v-icon>
                                            </div>
                                            <h3 class="info-title"><span><b>{{ delivered_perc }}%</b></span></h3>
                                            <h6 class="stats-title"><strong>Delivery percentage</strong></h6>
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
                    </div>
                </div>
                <!-- </div> -->
                <myChart style="height: 300px;" :client="client"></myChart>
                <!-- <v-btn @click="getBranchCount" flat color="primary">Count</v-btn> -->
                <div class="col-md-12">
                    <div class="card card-stats card-raised">
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
                    </div>
                </div>
            </v-flex>
        </v-layout>
    </v-container>
</v-content>
</template>

<script>
import myChart from '../charts/Screen_2'
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
            axios.get('/get_data_1')
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
            axios.get(`/get_filter_data_1/${this.client.id}`)
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
    box-shadow: 0 9px 30px -6px rgba(255, 54, 54, .5);
    padding: 5px;
    border-radius: 50%;
}

.info-title {
    margin-top: 20px;
}
</style>
