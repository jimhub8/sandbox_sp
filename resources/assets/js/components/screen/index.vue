<template>
<v-content>
    <v-container fluid fill-height>
        <v-layout justify-center align-center>
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
                                                <v-icon color="purple">shopping_cart</v-icon>
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
                                                <v-icon color="red">check_circle</v-icon>
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
                <v-divider></v-divider>
    <myChart></myChart>
                <!-- <v-btn @click="getBranchCount" flat color="primary">Count</v-btn> -->
            </v-flex>
        </v-layout>
    </v-container>
</v-content>
</template>

<script>
import myChart from '../charts/Screen'
export default {
    props: ['total', 'delivered', 'client'],
    components: {
        myChart,
    },
    data() {
        return {

        }
    },
    methods: {

    },
    computed: {
        delivered_perc() {
            return ((parseInt(this.delivered) * parseInt(this.total)) / 100)
        }
    },

}
</script>

<style scoped>
.justify-center {
    margin-top: -100px !important;
}

.card-stats {
    margin-top: -10px;
    padding: 20px 0;
}

/* .statistics {
    background: #f0f0f0 !important;
} */

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
