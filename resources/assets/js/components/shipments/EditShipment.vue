<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent>
        <v-card>
            <v-card-title>
                Edit Shipment
                <v-spacer></v-spacer>
                <v-btn icon dark @click="close">
                    <v-icon color="black">close</v-icon>
                </v-btn>
            </v-card-title>
            <v-container grid-list-md v-show="!loader">
                <v-card-text>
                    <v-layout wrap>
                        <v-form ref="form" @submit.prevent="submit">
                            <v-container grid-list-xl fluid>
                                <v-layout wrap>
                                    <!-- <div v-for="client in clients" :key="client.id" v-if="client.id = selectC.id"> -->

                                    <!--  -->
                                    <v-flex sm6>
                                        <h3><b>Pickup At</b></h3>
                                        <v-divider></v-divider>
                                        <div v-if="role === 'Customer'">
                                            <v-layout wrap row>
                                                <v-flex xs6 sm6>
                                                    <v-text-field v-model="role" color="blue darken-2" label="Sender name" required></v-text-field>
                                                </v-flex>
                                                <!-- </div> -->
                                                <v-flex xs6 sm6>
                                                    <v-text-field v-model="user.email" color="blue darken-2" label="Sender Email" required></v-text-field>
                                                </v-flex>
                                                <v-flex xs6 sm6>
                                                    <v-text-field v-model="user.address" color="blue darken-2" label="Sender Address" required></v-text-field>
                                                </v-flex>
                                                <v-flex xs6 sm6>
                                                    <v-text-field v-model="user.city" color="blue darken-2" label="Sender City" required></v-text-field>
                                                </v-flex>
                                                <v-flex xs6 sm6>
                                                    <v-text-field v-model="user.phone" color="blue darken-2" label="Sender Phone" required></v-text-field>
                                                </v-flex>

                                                <v-flex xs6 sm6>
                                                    <v-text-field v-model="user.country" color="blue darken-2" label="Country" required></v-text-field>
                                                </v-flex>
                                            </v-layout>
                                        </div>
                                        <div v-else>
                                            <!-- <v-card-text>
                                                    <v-autocomplete :items="clients" :filter="customFilter" color="white" item-text="name" label="Search Sender"></v-autocomplete>
                                                </v-card-text> -->

                                            <v-autocomplete v-model="model" :items="customerArr" :loading="isLoading" :search-input.sync="search" chips clearable hide-details hide-selected item-text="name" item-value="id" label="Search for a client..." solo>
                                                <template slot="no-data">
                                                    <v-list-tile>
                                                        <v-list-tile-title>
                                                            Search for
                                                            <strong>Clients</strong>
                                                        </v-list-tile-title>
                                                    </v-list-tile>
                                                </template>
                                                <template slot="selection" slot-scope="{ item, selected }">
                                                    <v-chip :selected="selected" color="blue-grey" class="white--text">
                                                        <v-icon left>mdi-coin</v-icon>
                                                        <span v-text="item.name"></span>
                                                    </v-chip>
                                                </template>
                                                <template slot="item" slot-scope="{ item, tile }">
                                                    <v-list-tile-avatar color="indigo" class="headline font-weight-light white--text">
                                                        {{ item.name.charAt(0) }}
                                                    </v-list-tile-avatar>
                                                    <v-list-tile-content>
                                                        <v-list-tile-title v-text="item.name"></v-list-tile-title>
                                                        <v-list-tile-sub-title v-text="item.email"></v-list-tile-sub-title>
                                                    </v-list-tile-content>
                                                    <v-list-tile-action>
                                                        <v-icon>mdi-coin</v-icon>
                                                    </v-list-tile-action>
                                                </template>
                                            </v-autocomplete>
                                            <v-divider></v-divider>

                                            <div v-if="!model">
                                                <v-layout wrap row>
                                                    <v-flex xs6 sm6>
                                                        <v-text-field v-model="form.sender_name" color="blue darken-2" label="Sender Name" required></v-text-field>
                                                    </v-flex>
                                                    <v-flex xs6 sm6>
                                                        <v-text-field v-model="form.sender_email" color="blue darken-2" label="Sender Email" required></v-text-field>
                                                    </v-flex>
                                                    <v-flex xs6 sm6>
                                                        <v-text-field v-model="form.sender_address" color="blue darken-2" label="Sender Address" required></v-text-field>
                                                    </v-flex>
                                                    <v-flex xs6 sm6>
                                                        <v-text-field v-model="form.sender_city" color="blue darken-2" label="Sender City" required></v-text-field>
                                                    </v-flex>
                                                    <v-flex xs6 sm6>
                                                        <v-text-field v-model="form.sender_phone" color="blue darken-2" label="Sender Phone" required></v-text-field>
                                                    </v-flex>
                                                </v-layout>
                                            </div>
                                            <!-- <v-flex xs6 sm6 v-if="cust.id === model">
                                                    <v-select :items="clients" v-model="selectCl" label="Select Sender" single-line item-text="name" item-value="id" return-object persistent-hint></v-select>
                                                </v-flex> -->
                                            <div v-if="model" v-for="cust in clients" :key="cust.id">
                                                <v-layout wrap row>
                                                    <v-flex xs6 sm6 v-if="cust.id === model">
                                                        <v-text-field v-model="cust.name" color="blue darken-2" label="Sender Name" required></v-text-field>
                                                    </v-flex>
                                                    <v-flex xs6 sm6 v-if="cust.id === model">
                                                        <v-text-field v-model="cust.email" color="blue darken-2" label="Sender Email" required></v-text-field>
                                                    </v-flex>
                                                    <v-flex xs6 sm6 v-if="cust.id === model">
                                                        <v-text-field v-model="cust.address" color="blue darken-2" label="Sender Address" required></v-text-field>
                                                    </v-flex>
                                                    <v-flex xs6 sm6 v-if="cust.id === model">
                                                        <v-text-field v-model="cust.city" color="blue darken-2" label="Sender City" required></v-text-field>
                                                    </v-flex>
                                                    <v-flex xs6 sm6 v-if="cust.id === model">
                                                        <v-text-field v-model="cust.phone" color="blue darken-2" label="Sender Phone" required></v-text-field>
                                                    </v-flex>

                                                    <v-flex xs6 sm6 v-if="cust.id === model">
                                                        <v-text-field v-model="cust.country" color="blue darken-2" label="Country" required></v-text-field>
                                                    </v-flex>
                                                </v-layout>
                                            </div>
                                        </div>
                                    </v-flex>
                                    <v-flex sm6>
                                        <h3><b>Deriver To</b></h3>
                                        <v-divider></v-divider>
                                        <v-layout wrap>
                                            <v-flex xs6 sm6>
                                                <v-text-field v-model="form.client_name" color="blue darken-2" label="Client name" required></v-text-field>
                                            </v-flex>
                                            <!-- </div> -->
                                            <v-flex xs6 sm6>
                                                <v-text-field v-model="form.client_email" color="blue darken-2" label="Client Email" required></v-text-field>
                                            </v-flex>
                                            <v-flex xs6 sm6>
                                                <v-text-field v-model="form.client_address" color="blue darken-2" label="Client Address" required></v-text-field>
                                            </v-flex>
                                            <v-flex xs6 sm6>
                                                <v-text-field v-model="form.client_city" color="blue darken-2" label="Client City" required></v-text-field>
                                            </v-flex>
                                            <v-flex xs6 sm6>
                                                <v-text-field v-model="form.client_phone" color="blue darken-2" label="Client Phone" required></v-text-field>
                                            </v-flex>

                                            <v-flex xs6 sm6>
                                                <v-text-field v-model="form.from_city" color="blue darken-2" label="From" required></v-text-field>
                                            </v-flex>
                                            <v-flex xs6 sm6>
                                                <v-text-field v-model="form.cod_amount" color="blue darken-2" label="COD Amount" required></v-text-field>
                                            </v-flex>
                                            <v-flex xs6 sm6>
                                                <v-text-field v-model="form.to_city" color="blue darken-2" label="To" required></v-text-field>
                                            </v-flex>
                                            <v-flex xs6 sm6>
                                                <v-text-field v-model="form.amount_ordered" color="blue darken-2" label="Quantity" required></v-text-field>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>

                                    <!-- Details -->
                                    <v-layout wrap>
                                        <v-flex sm12>
                                            <h3><b>Parcel Details</b></h3>
                                            <v-divider></v-divider>
                                            <v-layout wrap>

                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Product Description</th>
                                                            <!-- <th scope="col">COD Amount</th> -->
                                                            <th scope="col">Price</th>
                                                            <th scope="col">Quantity</th>
                                                            <th scope="col">Total Weight</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="product, key in form.products">
                                                            <th scope="row">{{ key+1 }}</th>
                                                            <td><input type="text" class="form-control" placeholder="Product Description" v-model="product.product_name"></td>
                                                            <!-- <td><input type="text" class="form-control" placeholder="COD Amount" v-model="product.cod_amount"></td> -->
                                                            <td><input type="text" class="form-control" placeholder="Price" v-model="product.price"></td>
                                                            <td><input type="text" class="form-control" placeholder="Quantity" v-model="product.quantity"></td>
                                                            <td><input type="text" class="form-control" placeholder="Total Weight" v-model="product.weight"></td>
                                                            <td>
                                                                <v-btn @click="remove(product)" icon class="mx-0">
                                                                    <v-icon color="pink darken-2" small>delete</v-icon>
                                                                </v-btn>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <v-divider></v-divider>

                                                <!-- <v-flex xs12 sm12>
                                                    <v-text-field v-model="subTotal" color="blue darken-2" label="Price" disabled></v-text-field>
                                                </v-flex> -->
                                                <v-btn color="primary" flat @click="add_product">Add product</v-btn>
                                            </v-layout>
                                        </v-flex>
                                    </v-layout>
                                    <!-- Details -->

                                    <v-flex xs12 sm12>
                                        <v-layout wrap>
                                            <v-divider></v-divider>

                                            <v-flex sm4>
                                                <h3><b>Service Type</b></h3>
                                                <v-divider></v-divider>
                                                <v-layout wrap>
                                                    <select class="custom-select custom-select-md col-md-12" v-model="form.shipment_type">
                                                        <option value="Pick up">Pick up</option>
                                                        <option value="OVS">OVS</option>
                                                        <option value="Same day">Same day</option>
                                                    </select>

                                                    <div class="form-group col-md-6">
                                                        <label for="insurance" class="col-md-4 col-form-label text-md-right">Insuarance</label>
                                                        <select class="custom-select" v-model="form.insuarance_status">
                                                            <option value="yes">Yes</option>
                                                            <option value="no">No</option>
                                                        </select>
                                                    </div>
                                                    <!-- </div>  -->
                                                    <div class="form-group col-md-4">
                                                        <label for="payment" class="col-md-4 col-form-label text-md-right">Paid</label>
                                                        <select class="custom-select" v-model="form.payment">
                                                            <option value="yes">Yes</option>
                                                            <option value="no">No</option>
                                                        </select>
                                                    </div>
                                                </v-layout>
                                            </v-flex>
                                            <v-flex sm4>
                                                <h3><b>Status</b></h3>
                                                <v-divider></v-divider>
                                                <v-layout wrap>
                                                    <select class="custom-select custom-select-md col-md-12" v-model="form.status">
                                                        <option value="Awaiting Approval">Awaiting Approval</option>
                                                        <option value="Approved">Approved</option>
                                                        <option value="Arrived">Arrived</option>
                                                        <option value="Awaiting Confirmation">Awaiting Confirmation</option>
                                                        <option value="Cancelled ">Call Back</option>
                                                        <option value="Cancelled">Cancelled</option>
                                                        <option value="Cleared">Cleared</option>
                                                        <option value="Delivered">Delivered</option>
                                                        <option value="Dispatched">Dispatched</option>
                                                        <option value="Hold">Hold</option>
                                                        <option value="Not Available">Not Available</option>
                                                        <option value="Not Picking">Not Picking</option>
                                                        <option value="Out For Destination">Out For Destination</option>
                                                        <option value="Offline">Offline</option>
                                                        <option value="Out For Delivery">Out For Delivery</option>
                                                        <option value="Returned">Returned</option>
                                                        <option value="Ready For Depart">Ready For Depart</option>
                                                        <option value="Scheduled">Scheduled</option>
                                                        <option value="Shipment Collected">Shipment Collected</option>
                                                        <option value="Transit">Transit</option>
                                                        <option value="Waiting for Scan">Waiting for scan</option>
                                                        <option value="Wrong Number">Wrong Number</option>
                                                    </select>
                                                </v-layout>
                                            </v-flex>
                                            <v-flex sm4>
                                                <h3><b>Special Instructions</b></h3>
                                                <v-divider></v-divider>
                                                <v-layout wrap>
                                                    <v-flex xs12 sm12>

                                                        <v-textarea v-model="form.remark" color="blue">
                                                            <div slot="label">
                                                                Instructions
                                                            </div>
                                                        </v-textarea>
                                                    </v-flex>
                                                </v-layout>
                                            </v-flex>

                                            <v-flex xs12 sm4>
                                                <v-select :items="clients" v-model="selectC" :hint="`${selectC.name}`" label="Select Client" single-line item-text="name" item-value="id" return-object persistent-hint></v-select>
                                            </v-flex>
                                            <v-flex xs12 sm4>
                                                <v-select :items="riders" v-model="selectD" :hint="`${select.name}`" label="Select Driver" single-line item-text="name" item-value="id" return-object persistent-hint></v-select>
                                            </v-flex>
                                            <v-flex xs12 sm4>
                                                <v-select :items="branches" v-model="selectB" :hint="`${selectB.branch_name}`" label="Select Branch" single-line item-text="branch_name" item-value="id" return-object persistent-hint></v-select>
                                            </v-flex>

                                            <v-flex xs12 sm4>
                                                <v-text-field v-model="form.booking_date" :type="'date'" color="blue darken-2" label="Booking Date" required></v-text-field>
                                            </v-flex>

                                            <v-flex xs12 sm4>
                                                <v-text-field v-model="form.derivery_date" :type="'date'" color="blue darken-2" label="Deriery Date" required></v-text-field>
                                            </v-flex>

                                            <v-flex xs12 sm4>
                                                <v-text-field v-model="form.derivery_time" :type="'time'" color="blue darken-2" label="Ready Time" required></v-text-field>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>
                                    <!--  -->

                                </v-layout>
                                <div class="row">

                                </div>
                                <v-flex xs6 sm6>
                                    <v-text-field v-model="form.bar_code" color="blue darken-2" label="Barcode" required></v-text-field>
                                </v-flex>
                                <barcode v-bind:value="form.bar_code"></barcode>
                            </v-container>
                        </v-form>
                    </v-layout>
                </v-card-text>
                <v-card-actions>
                    <!-- <v-btn flat @click="resetForm">reset</v-btn> -->
                    <v-btn flat @click="close">Close</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn flat color="primary" @click="save" :loading="loading" :disabled="loading">Update Shipment</v-btn>
                </v-card-actions>
            </v-container>
            <div v-show="loader" style="text-align: center">
                <v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
            </div>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
import VueBarcode from "vue-barcode";
export default {
    props: ["user", 'role'],
    components: {
        barcode: VueBarcode
    },
    data() {
        return {
            selectCl: [],
            form: {},
            dialog: false,
            customerArr: [],
            selectD: [],
            selectC: [],
            selectB: [],
            select: [],
            isLoading: false,
            loader: false,
            search: null,
            model: null,
            items: [{
                    state: "Yes",
                    abbr: "yes"
                },
                {
                    state: "No",
                    abbr: "no"
                }
            ]
        }
    },
    watch: {
        search(val) {
            // Items have already been loaded
            if (this.customerArr.length > 0) return

            this.isLoading = true

            // Lazily load input customerArr
            // axios.get('/getCustomer')
            //     .then(res => {
            this.customerArr = this.clients
            this.isLoading = false
            // })
            // .catch(err => {
            //     console.log(err)
            // })
            //   .finally(() => (this.isLoading = false))
        }
    },
    methods: {
        save() {
            var payload = {
                url: '/shipment/' + this.form.id,
                data: {
                    form: this.form,
                    selectD: this.selectD,
                    selectC: this.selectC,
                    selectB: this.selectB,
                    user: this.user,
                    selectCl: this.selectCl
                },
            }
            this.$store.dispatch('patchItems', payload)
        },
        close() {
            this.dialog = false
        },
        add_product() {
            this.form.products.push({
                product_name: '',
                weight: '',
                quantity: 1,
                price: 0,
            })
        },
        remove(product) {
            const index = this.form.products.indexOf(product)
            this.form.products.splice(index, 1)
        }
    },
    created () {
        eventBus.$on('updateOrdersEvent', data => {
            this.dialog = true
            this.form = data
        })
    },
    computed: {
        clients() {
            return this.$store.getters.clients
        },
        branches() {
            return this.$store.getters.branches
        },
        riders() {
            return this.$store.getters.riders
        },
        loading() {
            return this.$store.getters.loading
        },
    },
}
</script>
