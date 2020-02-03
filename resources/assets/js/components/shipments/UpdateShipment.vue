<template>
<v-layout row justify-center>

    <v-dialog v-model="dialog" persistent width="500px">
        <v-card v-if="dialog">
            <v-card-title>
                Update Shipment
                <v-spacer></v-spacer>
                <v-btn icon dark @click="close">
                    <v-icon color="black">close</v-icon>
                </v-btn>
            </v-card-title>
            <v-container grid-list-md>
                <v-card style="width: 100%;">
                    <v-layout row wrap>
                        <v-flex sm12 style="border-left: 1px solid #c1c1c1;">
                            <div class="form-group col-md-12">
                                <label for="">Status</label>
                                <select class="custom-select custom-select-md col-md-12" v-model="updateitedItem.status">
                                    <option v-for="status in statuses" :key="status.id" :value="status.name">{{ status.name }}</option>
                                </select>
                            </div>
                            <div v-if="updateitedItem.status === 'Delivered'">
                                <v-flex xs12 sm12>
                                    <v-text-field v-model="updateitedItem.receiver_name" color="blue darken-2" label="Received By"></v-text-field>
                                </v-flex>
                                <v-flex xs12 sm12>
                                    <v-text-field v-model="updateitedItem.receiver_id" color="blue darken-2" label="Receiver id/phone number"></v-text-field>
                                </v-flex>
                            </div>
                            <div v-if="updateitedItem.status === 'Scheduled' || updateitedItem.status === 'Delivered'">
                                <v-flex xs12 sm12>
                                    <v-text-field v-model="updateitedItem.derivery_date" color="blue darken-2" label="Delivery Date" type="date"></v-text-field>
                                </v-flex>
                                <v-flex xs12 sm12>
                                    <v-text-field v-model="updateitedItem.derivery_time" color="blue darken-2" label="Delivery Time" type="time"></v-text-field>
                                </v-flex>
                                <v-flex xs4 sm12>
                                    <v-text-field v-model="updateitedItem.location" color="blue darken-2" label="Location" required></v-text-field>
                                </v-flex>
                            </div>
                            <div v-if="updateitedItem.status === 'Not Picking'">
                                <v-flex xs12 sm12>
                                    <v-text-field v-model="updateitedItem.derivery_date" color="blue darken-2" label="Date" type="date"></v-text-field>
                                </v-flex>
                                <v-flex xs4 sm12>
                                    <v-text-field v-model="updateitedItem.location" color="blue darken-2" label="Location" required></v-text-field>
                                </v-flex>
                            </div>
                            <v-flex xs12 sm12>
                                <v-textarea v-model="updateitedItem.speciial_instruction" color="blue">
                                    <div slot="label">
                                        Special Instructions <small>(optional)</small>
                                    </div>
                                </v-textarea>
                            </v-flex>
<!--
                            <v-flex xs12 sm12>
                                <v-btn flat color="primary" @click="paid" v-if="updateitedItem.paid === 0">Mark as paid</v-btn>
                                <v-btn flat color="primary" @click="paid" v-if="updateitedItem.paid === 1">Mark as unpaid</v-btn>
                                <v-btn color="primary" raised disabled style="color: rgb(76, 175, 80) !important;" v-if="updateitedItem.paid === 0">Not Paid</v-btn>
                                <v-btn color="primary" raised disabled style="color: rgb(76, 175, 80) !important;" v-if="updateitedItem.paid === 1">Paid</v-btn>
                            </v-flex> -->
                        </v-flex>
                    </v-layout>
                    <v-layout row wrap>

                    </v-layout>
                </v-card>
                <v-card-actions>
                    <v-btn flat @click="close">Close</v-btn>
                    <!-- <v-flex xs4 sm3>
                        <v-text-field v-model="dist" color="blue darken-2" label="Distance" ref="distanceGet" required></v-text-field>
                    </v-flex> -->
                    <v-spacer></v-spacer>
                    <v-btn color="primary" flat @click="UpdateStatus" :loading="loading" :disabled="loading">Update Status</v-btn>
                </v-card-actions>
            </v-container>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
// import VueGoogleAutocomplete from "vue-google-autocomplete";
export default {
    components: {
        // VueGoogleAutocomplete,
    },
    data() {
        return {
            dialog: false,
            loading: false,
            loading_loc: false,
            showMap: false,
            place: null,
            dist: "",
            updateitedItem: {},
        };
    },

    methods: {
        UpdateStatus() {
            // alert(this.updateitedItem.id);
            this.loading = true;
            axios
                .post(`/updateStatus/${this.updateitedItem.id}`, {
                    formobg: this.updateitedItem,
                    address: this.address
                })
                .then(response => {
                    console.log(response.data);
                    this.loading = false;
                    this.close();
                    eventBus.$emit('alertRequest', 'updated');

                    if (response.data.message) {
                        eventBus.$emit('errorEvent', response.data.message)
                        return
                    }
                    // Object.assign(this.$parent.AllShipments[this.$parent.editedIndex], this.$parent.updateitedItem)
                    eventBus.$emit("refreshShipEvent")
                    this.updateitedItem.derivery_date = "";
                    //   Object.assign(
                    //     this.$parent.AllShipments[this.$parent.editedIndex],
                    //     this.updateitedItem
                    //   );
                })
                .catch(error => {
                    // console.log(error.response.data.message);
                    this.loading = false;
                    if (error.response.status === 500) {
                        eventBus.$emit('errorEvent', error.response.statusText)
                        return
                    } else if (error.response.status === 401 || error.response.status === 409) {
                       // window.location.href = "/apilogin";
                        eventBus.$emit('reloadRequest')
                        return
                    }
                    else if (error.response.status === 422) {
                        eventBus.$emit('errorEvent', error.response.data.message)
                        return
                    }
                    this.errors = error.response.data.errors;
                });
        },
        paid() {
            if (this.updateitedItem.paid == 0) {
                this.updateitedItem.paid = 1;
            } else {
                this.updateitedItem.paid = 0;
            }
            axios
                .post(`/paid/${this.updateitedItem.id}`, this.updateitedItem)
                .then(response => {
                    this.loading = false;
                    this.alert();
                })
                .catch(error => {
                    this.loading = false;
                    this.errors = error.response.data.errors;
                });
        },

        close() {
            this.dialog = false
        },
        alert() {
            eventBus.$emit('alertRequest', 'Success')
        },
    },
    computed: {
        statuses() {
            return this.$store.getters.statuses
        }
    },
    created () {
        eventBus.$on('UpdateStatusEvent', data => {
            this.dialog = true
            this.updateitedItem = data
        });
    },
};
</script>
