<template>
<div class="text-xs-center">
    <v-dialog v-model="OpenTrackBranch" hide-overlay persistent width="700">
        <v-card v-if="OpenTrackBranch">
            <div style="text-align: center">
                <v-divider></v-divider>
            </div>
            <v-toolbar card blue-grey darken-1>
                <v-toolbar-title class="body-2">Shipments Details</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn icon dark @click="close">
                    <v-icon color="black">close</v-icon>
                </v-btn>
            </v-toolbar>
            <v-card-text>
                <!-- <v-progress-linear indeterminate color="white" class="mb-0"></v-progress-linear> -->
                <ul class="list-group">
                    <li class="list-group-item active text-center">
                        <h2>Shipment {{ shipments.airway_bill_no }}</h2>
                    </li>
                </ul>
                <v-layout wrap>
                    <!-- <div v-for="shipments in AllShip.data" :key="shipments.id"> -->
                    <v-flex xs12 sm12>
                        <ul class="list-group">
                            <li class="list-group-item"><label for=""><b>Waybill Number: </b></label>{{ shipments.airway_bill_no }}</li>
                            <li class="list-group-item"><label for=""><b>From: </b></label>{{ shipments.sender_city }}</li>
                            <li class="list-group-item"><label for=""><b>Status: </b></label>{{ shipments.status }}</li>
                        </ul>
                    </v-flex>
                    <!-- </div> -->
                </v-layout>

                <v-toolbar card blue-grey darken-1>
                    <v-toolbar-title class="body-2">Updated fields</v-toolbar-title>
                </v-toolbar>
                <v-layout wrap>
                    <v-flex xs12 sm6>
                        <ul class="list-group">
                            <li class="list-group-item active text-center">
                                <h5>Original data</h5>
                            </li>
                            <li class="list-group-item" v-for="(data, key) in all_data.original_data" :key="key">
                                <label for=""><b>{{ key }}</b></label>{{ data }}
                            </li>
                        </ul>
                    </v-flex>
                    <v-flex xs12 sm6>
                        <ul class="list-group">
                            <li class="list-group-item active text-center">
                                <h5>Updated data</h5>
                            </li>
                            <li class="list-group-item" v-for="(data, key) in all_data.update_data" :key="key">
                                <label for=""><b>{{ key }}</b></label>{{ data }}
                            </li>
                        </ul>
                    </v-flex>
                </v-layout>
            </v-card-text>
            <v-card-actions>
                <v-btn color="blue darken-1" flat @click="close">Close</v-btn>
                <v-spacer></v-spacer>
            </v-card-actions>
            <v-divider></v-divider>
        </v-card>
    </v-dialog>
</div>
</template>

<script>
import VueBarcode from "vue-barcode";
export default {
    components: {
        barcode: VueBarcode
    },
    data() {
        return {
            all_data: [],
            shipD: [],
            shipments: [],
            OpenTrackBranch: false
        };
    },
    methods: {
        refresh() {
            this.$emit("refreshRequest");
        },
        TrackEvent() {
            eventBus.$emit("TrackEvent", this.shipments);
        },
        close() {
            // this.$emit("closeRequest");
            this.OpenTrackBranch = false
        },
        showShip(data) {
            axios
                .post(`/getshipD/${data.id}`)
                .then(response => {
                    this.shipD = response.data;
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
        },
        // shipmentGet(data) {
        //     axios
        //         .post(`/getShipSingle/${data.id}`)
        //         .then(response => {
        //             this.shipments = response.data;
        //         })
        //         .catch(error => {
        //             this.errors = error.response.data.errors;
        //         });
        // }
    },

    created() {
        eventBus.$on("ShowShipEvent", data => {
            // this.shipmentGet(data);
            this.showShip(data.shipment);
            this.all_data = data
            this.shipments = data.shipment
            this.OpenTrackBranch = true;
        });
    },
    computed: {
        getUrl() {
            return "pod/" + this.shipments.id;
        }
    }
};
</script>

<style scoped>
.vue-barcode-element {
    margin-top: 5px !important;
}
</style>
