<template>
<v-content>
    <div v-show="loader" style="text-align: center">
        <v-progress-circular :width="3" indeterminate color="blue" style="margin: 1rem"></v-progress-circular>
    </div>
    <v-container fluid fill-height v-show="!loader">
        <!-- <div> -->
        <v-layout justify-center align-center>
            <!-- <v-layout row>
                <v-flex xs6 sm6>
                </v-flex>
            </v-layout> -->
            <v-layout wrap>
                <v-flex xs4 sm4 style="margin-top: 40px;">
                    <v-card>
                        <myClientReport></myClientReport>
                    </v-card>
                </v-flex>

                <!-- <v-divider vertical></v-divider> -->
                <v-flex xs4 sm4 style="margin-top: 40px;">
                    <v-card>
                        <mySReport :statuses="statuses"></mySReport>
                    </v-card>
                </v-flex>

                <v-flex xs4 sm4 style="margin-top: 40px;">
                    <v-card>
                        <myBranchReport :branches="branches" :statuses="statuses"></myBranchReport>
                    </v-card>
                </v-flex>
                <!-- <v-divider vertical></v-divider> -->
                <v-flex xs4 sm4 style="margin-top: 140px;">
                    <v-card>
                        <myRiderReport></myRiderReport>
                    </v-card>
                </v-flex>
                <v-flex xs4 sm4 style="margin-top: 140px;">
                    <v-card>
                        <myDeliveryReport :countries="countries" :user="user" :statuses="statuses"></myDeliveryReport>
                    </v-card>
                </v-flex>
                <!--
                <v-flex xs4 sm4 style="margin-top: 40px;">
                    <v-card>
                        <h1>Product Reports</h1>
                        <hr>
                        <label for="">Status</label>
                        <v-flex xs12 sm12>
                            <v-text-field v-model="ProdR.email" color="blue darken-2" label="Product email" required></v-text-field>
                        </v-flex>
                        <select v-model="ProdR.status" class="custom-select custom-select-md col-md-12">
                            <option value=""></option>
                            <option v-for="status in statuses" :key="status.id" :value="status.name">{{ status.name }}</option>
                        </select>
                        Delivery Date Between:
                        <hr>
                        <v-flex xs12 sm12>
                            <v-text-field v-model="ProdR.start_date" label="start date" type="date" color="blue darken-2" required></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm12>
                            <v-text-field v-model="ProdR.end_date" label="End Date" type="date" color="blue darken-2" required></v-text-field>
                        </v-flex>
                        <v-card-actions>
                            <v-btn flat @click="AllProdR" :loading="Pload" :disabled="Pload" success color="black">Get Data</v-btn>
                            <v-spacer></v-spacer>
                            <v-btn flat color="orange">{{ AllProd.length }} </v-btn>
                        </v-card-actions>
                        <v-divider></v-divider>
                        <download-excel :data="AllProd" :fields="json_fields" v-show="Pdown">
                            Export
                            <img src="/storage/csv.png" style="width: 30px; height: 30px; cursor: pointer;">
                        </download-excel>
                        <v-snackbar :timeout="timeout" bottom="bottom" :color="color" left="left" v-model="snackbar">
                            {{ message }}
                            <v-icon dark right>check_circle</v-icon>
                        </v-snackbar>
                    </v-card>
                </v-flex>-->
            </v-layout>
        </v-layout>

        <!-- </div> -->
    </v-container>
</v-content>
</template>

<script>
import mySReport from './status_report'
import myDeliveryReport from './delivery_report'
import myClientReport from './client_report'
import myRiderReport from './rider_report'
import myBranchReport from './branch_report'
export default {
    props: ['user'],
    components: {
        mySReport,
        myDeliveryReport,
        myClientReport,
        myRiderReport,
        myBranchReport
    },
    data() {
        return {
            loader: false,
            message: 'Success',
            color: 'black',
            json_fields: {
                'Order Id': 'order_id',
                'Sender Name': 'sender_name',
                'Sender Email': 'sender_email',
                'Sender Phone': 'sender_phone',
                'Sender City': 'sender_city',
                'Sender Address': 'sender_address',
                'Driver': 'driver',
                'Client Name': 'client_name',
                'Client Email': 'client_email',
                'Client Phone': 'client_phone',
                'Client City': 'client_city',
                'Client Address': 'client_address',
                'Derivery Status': 'status',
                'From': 'sender_address',
                'To': 'client_address',
                'Derivery Date': 'derivery_date',
                'Derivery Time': 'derivery_time',
                'Quantity': 'amount_ordered',
                'COD Amount': 'cod_amount',
                'Booking Date': 'booking_date',
                'Special Instructions': 'speciial_instruction',
                'Last updated': 'updated_at'
            },

        }
    },
    methods: {
        getCountry() {
            var payload = {
                url: '/getCountry',
                list: 'updateCountryList',
                data: this.form,
            }
            this.$store.dispatch('getItems', payload)
        },
        getCustomer() {
            var payload = {
                url: '/getCustomer',
                list: 'updateClientList',
                data: this.form,
            }
            this.$store.dispatch('getItems', payload)
        },
        getDrivers() {
            var payload = {
                url: '/getDrivers',
                list: 'updateRidersList',
                data: this.form,
            }
            this.$store.dispatch('getItems', payload)
        },
        getBranch() {
            var payload = {
                url: '/getBranchEger',
                list: 'updateBranchesList',
                data: this.form,
            }
            this.$store.dispatch('getItems', payload)
        },
        getStatus() {
            var payload = {
                url: '/getStatuses',
                list: 'updateStatusList',
            }
            this.$store.dispatch('getItems', payload)
        },
    },
    mounted() {
        // this.loader = true;
        // this.getDrivers()
        // this.getCustomer()
        this.getBranch()
        this.getStatus()
        this.getCountry()
    },

    computed: {
        clients() {
            return this.$store.getters.clients
        },
        countries() {
            return this.$store.getters.countries
        },
        branches() {
            return this.$store.getters.branches
        },
        statuses() {
            return this.$store.getters.statuses
        },
    },
}
</script>

<style scoped>
.theme--light.v-card {
    background-color: rgba(158, 158, 158, 0.08);
    height: 550px;
}
</style>
