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
                                            <h3 class="info-title"><span><b>{{ country_count }}</b></span></h3>
                                            <h6 class="stats-title"><strong>Total Shipments</strong></h6>
                                        </div>
                                    </div>
                                </div>
                                <v-divider vertical></v-divider>
                                <div class="col-md-3">
                                    <div class="statistics">
                                        <div class="">
                                            <div class="icon icon-success">
                                                <v-icon color="purple">account_circle</v-icon>
                                            </div>
                                            <h3 class="info-title"><span><b>{{ Allusers }}</b></span></h3>
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
                                            <h3 class="info-title"><span><b>{{ countryC.length }}</b></span></h3>
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
                                            <h3 class="info-title"><span><b>{{ branchC.length }}</b></span></h3>
                                            <h6 class="stats-title"><strong> Target</strong></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- </div> -->
                <div class="col-md-12" style="margin-top: 40px;">
                    <div class="card card-stats card-raised">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="statistics">
                                        <div class="">
                                            <div class="icon icon-danger">
                                                <v-icon color="danger">cloud</v-icon>
                                            </div>
                                            <h3 class="info-title"><span><b>{{ AllScheduled }}</b></span></h3>
                                            <h6 class="stats-title"><strong> Current</strong></h6>
                                        </div>
                                    </div>
                                </div>
                                <v-divider vertical></v-divider>
                                <div class="col-md-3">
                                    <div class="statistics">
                                        <div class="">
                                            <div class="icon icon-primary">
                                                <v-icon color="pink">check_circle</v-icon>
                                            </div>
                                            <h3 class="info-title"><span><b>{{ AllDelivered }}</b></span></h3>
                                            <h6 class="stats-title"><strong>Delivered</strong></h6>
                                        </div>
                                    </div>
                                </div>
                                <v-divider vertical></v-divider>
                                <div class="col-md-3">
                                    <div class="statistics">
                                        <div class="">
                                            <div class="icon icon-success">
                                                <v-icon color="orange">cloud</v-icon>
                                            </div>
                                            <h3 class="info-title"><span><b>{{ AllPending }}</b></span></h3>
                                            <h6 class="stats-title"><strong>Pending</strong></h6>
                                        </div>
                                    </div>
                                </div>
                                <v-divider vertical></v-divider>
                                <div class="col-md-2">
                                    <div class="statistics">
                                        <div class="">
                                            <div class="icon icon-info">
                                                <v-icon color="info">block</v-icon>
                                            </div>
                                            <h3 class="info-title"><span><b>{{ AllCanceled }}</b></span></h3>
                                            <h6 class="stats-title"><strong>Cancelled</strong></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <v-divider></v-divider>

                <!-- <v-btn @click="getBranchCount" flat color="primary">Count</v-btn> -->
            </v-flex>
        </v-layout>
    </v-container>
</v-content>
</template>

<script>
export default {
    props: ["user"],
    data() {
        return {

        }
    },
    methods: {
        
    }
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
