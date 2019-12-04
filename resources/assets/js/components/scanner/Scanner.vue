<template>
<v-content>
    <v-container fluid fill-height v-show="!loader">
        <v-layout justify-center align-center>
            <v-snackbar v-model="snackbar" absolute top center dark :color="color">
                <span>{{message}}</span>
                <v-icon dark>{{ icon }}</v-icon>
            </v-snackbar>
            <v-card>
                <!-- <small class="has-text-danger" v-if="errors.form.status_in">{{ errors.status_in[0] }}</small><br>
                <small class="has-text-danger" v-if="errors.form.branch_id">{{ errors.branch_id[0] }}</small><br>
                <small class="has-text-danger" v-if="errors.form.status_out">{{ errors.status_out[0] }}</small><br>
                <small class="has-text-danger" v-if="errors.form.rider_out">{{ errors.rider_out[0] }}</small> -->
                <v-layout row wrap>
                    <v-flex sm6>
                        <v-form ref="form" @submit.prevent style="width: 100%;">
                            <v-container grid-list-md text-xs-center>
                                <h2>Branch </h2>
                                <v-divider></v-divider>
                                <v-layout row wrap>
                                    <!-- <v-flex xs6 sm6>
                                        <v-text-field v-model="form_in.scan_date" :type="'date'" color="blue darken-2" label="Date" required></v-text-field>
                                    </v-flex> -->
                                    <div class="form-group col-md-4">
                                        <label for="">Status</label>
                                        <select v-model="form_in.status_in" class="custom-select custom-select-md col-md-12">
                                            <option v-for="status in statuses" :key="status.id" :value="status.name">{{ status.name }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Branches</label>
                                        <select v-model="form_in.branch_id" class="custom-select custom-select-md col-md-12">
                                            <option v-for="branch in branches" :key="branch.id" :value="branch.id">{{ branch.branch_name }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputAddress2">Location</label>
                                        <input type="text" class="form-control" id="inputAddress2" placeholder="Location" v-model="form_in.location_in">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="inputCity">Remarks</label>
                                        <textarea class="form-control" v-model="form_in.remarks_in" placeholder="Remarks" rows="3"></textarea>
                                    </div>
                                </v-layout>
                                <v-layout row wrap>
                                    <v-flex xs12 sm12>
                                        <div class="form-group col-md-12">
                                            <label for="inputAddress1">Inscan</label>
                                            <input type="text" class="form-control" id="inputAddress1" placeholder="Barcode" v-model="form_in.bar_code_in" @change="Inscan" ref="scanIn">
                                        </div><br>
                                        <v-flex xs12 sm12>
                                            <barcode :value="form_in.bar_code_in" style="height: 30px;"></barcode>
                                        </v-flex>
                                        <v-divider></v-divider>

                                        <!-- <download-excel :data="AllScanned" :fields="json_fields">
                                            <v-btn color="primary" flat @click="Inscansub" :disabled="loading" :loading="loading">Outscan
                                            </v-btn>
                                        </download-excel> -->

                                        <download-excel name="Dispatch Inbound.csv" :data="AllScanned" type="csv" :fields="json_fields">
                                            <v-btn color="primary" flat @click="Inscansub" :disabled="loading_in" :loading="loading_in">Outscan
                                            </v-btn>
                                        </download-excel>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-form>
                    </v-flex>
                    <v-divider vertical></v-divider>
                    <v-flex sm5>
                        <v-form ref="form" @submit.prevent style="width: 100%;">
                            <v-container grid-list-md text-xs-center>
                                <h2>Out Scan</h2>
                                <v-divider></v-divider>
                                <v-layout row wrap>
                                    <div class="form-group col-md-4">
                                        <label for="">Status</label>
                                        <select v-model="form_out.status_out" class="custom-select custom-select-md col-md-12">
                                            <option v-for="status in statuses" :key="status.id" :value="status.name">{{ status.name }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Rider</label>
                                        <select v-model="form_out.rider_out" class="custom-select custom-select-md col-md-12">
                                            <option v-for="rider in AllRiders" :key="rider.id" :value="rider.id">{{ rider.name }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputAddress2">Location</label>
                                        <input type="text" class="form-control" id="inputAddress2" placeholder="Location" v-model="form_out.location_out">
                                    </div>
                                    <v-flex xs6 sm6>
                                        <v-text-field v-model="form_out.scan_date_out" :type="'date'" color="blue darken-2" label="Date" required></v-text-field>
                                    </v-flex>
                                    <div class="form-group col-md-12">
                                        <label for="inputCity">Remarks</label>
                                        <textarea class="form-control" v-model="form_out.remarks_out" placeholder="Remarks" rows="3"></textarea>
                                    </div>
                                </v-layout>
                                <v-layout row wrap>
                                    <v-flex xs12 sm12>
                                        <div class="form-group">
                                            <label for="inputAddress2">Outscan</label>
                                            <input type="text" class="form-control" id="inputAddress2" placeholder="Barcode" v-model="form_out.bar_code_out" @change="Outscan">
                                        </div><br>
                                        <v-flex xs12 sm12>
                                            <barcode :value="form_out.bar_code_out" style="height: 30px;"></barcode>
                                        </v-flex>
                                        <v-divider></v-divider>
                                        <!-- <download-excel name="Dispatch Inbound.csv" :data="AllScanned" :fields="json_fields" type="csv"> -->
                                        <v-btn color="primary" flat @click="OutscanSub" :disabled="loading" :loading="loading">Outscan
                                        </v-btn>
                                        <!-- </download-excel> -->
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-form>
                    </v-flex>
                </v-layout>
                <v-divider></v-divider>


                <download-excel :data="scanned_shipments" type= "csv" name="Dispatch Inbound.csv" :fields="json_fields" v-if="scanned_shipments.length > 0" style="float: right; margin-right: 10px;">
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                            <v-btn icon v-on="on" slot="activator" class="mx-0" color="primary">
                                <i color="info" class="fas fa-file-excel"></i>
                            </v-btn>
                        </template>
                        <span>Download report</span>
                    </v-tooltip>
                    <el-tag>{{ scanned_shipments.length }}</el-tag>
                </download-excel>

                <v-divider></v-divider>
                <!-- <download-excel :data="scanned_shipments" name="Dispatch Inbound.csv" :fields="json_fields" v-if="scanned_shipments.length > 0">
                        Export
                        <img src="/storage/csv.png" style="width: 30px; height: 30px; cursor: pointer;">
                    </download-excel> -->
                <v-card v-if="AllScanned.length > 0">
                    <!-- <download-excel class="btn" :data="scanned_shipments" :fields="json_fields" type="csv">
                        Download Excel
                    </download-excel> -->
                    <v-card-title>
                        Shipments
                        <v-tooltip right>
                            <template v-slot:activator="{ on }">
                                <v-btn icon v-on="on" slot="activator" class="mx-0" @click="resetForm">
                                    <v-icon color="blue darken-2" small>refresh</v-icon>
                                </v-btn>
                            </template>
                            <span>Reset all</span>
                        </v-tooltip>
                        <VSpacer />
                        <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details></v-text-field>
                    </v-card-title>
                    <v-data-table :headers="headers" :items="AllScanned" class="elevation-1" :loading="loading" :search="search">
                        <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
                        <template slot="items" slot-scope="props">
                            <td>{{ props.item.bar_code }}</td>
                            <td class="text-xs-right">{{ props.item.cod_amount }}</td>
                            <td class="text-xs-right">{{ props.item.client_name }}</td>
                            <td class="text-xs-right">{{ props.item.client_address }}</td>
                            <td class="text-xs-right">{{ props.item.client_phone }}</td>
                            <td class="text-xs-right">{{ props.item.derivery_date }}</td>
                            <td class="text-xs-right">{{ props.item.speciial_instruction }}</td>
                            <td class="justify-center layout px-0">
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-btn icon v-on="on" slot="activator" class="mx-0" @click="removeItem(props.item)">
                                            <v-icon color="pink darken-2" small>delete</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Remove</span>
                                </v-tooltip>
                            </td>
                        </template>
                        <v-alert slot="no-results" :value="true" color="error" icon="warning">
                            Your search for "{{ search }}" found no results.
                        </v-alert>
                    </v-data-table>
                </v-card>
            </v-card>
        </v-layout>
    </v-container>
    <div v-show="loader" style="text-align: center; width: 100%;">
        <v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
    </div>
</v-content>
</template>

<script>
import VueBarcode from 'vue-barcode';
export default {
    props: ['user'],
    components: {
        'barcode': VueBarcode
        // , UpdateShipment
    },
    data() {
        const defaultForm = Object.freeze({
            bar_code: ''
        })
        return {
            errors: [],
            search: '',
            message: 'test',
            scanned_shipments: [],
            AllShipments: {},
            form: Object.assign({}, defaultForm),
            form_out: {
                rider_out: '',
                bar_code_out: '',
                status_out: '',
                scan_date_out: '',
                remarks_out: '',
                location_out: ''
            },
            form_in: {
                branch_id: '',
                bar_code_in: '',
                status_in: '',
                // scan_date: '',
                remarks_in: '',
                location_in: ''
            },
            branches: [],
            snackbar: false,
            errors: {},
            icon: 'check_circle',
            color: 'black',
            loader: false,
            loading_in: false,
            loading: false,
            search: '',
            statuses: [],
            AllRiders: [],
            AllScanned: [],
            headers: [{
                    text: 'Waybill Number',
                    align: 'left',
                    value: 'bar_code'
                },
                {
                    text: 'Cod Amount',
                    value: 'cod_amount'
                },
                {
                    text: 'Client Name',
                    value: 'client_name'
                },
                {
                    text: 'Client Address',
                    value: 'client_address'
                },
                {
                    text: 'Client Phone',
                    value: 'client_phone'
                },
                {
                    text: 'Delivery date',
                    value: 'derivery_date'
                },
                {
                    text: 'Special Instructions',
                    value: 'speciial_instruction'
                },
                {
                    text: 'Actions',
                    sortable: false
                }
            ],
            json_fields: {
                "Order Id": "order_id",
                "Product Name": "client_email",
                "Client Name": "client_name",
                "Client Address": "client_address",
                "Special Instructions": "speciial_instruction",
                "Contact": "client_phone",
                "Amount": "cod_amount",
                "Payment Code": 'null',
                "Delivery Date": "null",
                "Time": "null",
            },
        }
    },
    methods: {
        myClickEvent($event) {
            const elem = this.$refs.myBtn
            elem.click()
        },
        reset() {
            this.form = Object.assign({}, this.defaultForm)
            this.$refs.form_in.reset()
        },
        resetForm() {
            this.AllScanned = []
        },
        fetchData() {
            axios.post('/filter_rider', this.form_out).then((response) => {
                    // console.log(response.data);
                    this.scanned_shipments = response.data
                    return response.data
                })
                .catch((error) => {
                    this.loading = false
                    this.errors = error.response.data.errors
                })
        },
        Outscan() {
            this.loading = true
            axios.post(`/barcodeUpdate/${this.form_out.bar_code_out}`, this.$data.form_out)
                .then((response) => {
                    this.loading = false
                    // console.log(response.data.length);
                    if (response.data.length > 1) {

                        this.$message({
                            type: 'error',
                            message: response.data.length + ' shipment found'
                        });
                    }
                    if (response.data.errors === 'errors') {
                        this.$message({
                            type: 'error',
                            message: 'Order Not found'
                        });
                    } else {
                        response.data.forEach(element => {
                            this.AllScanned.push(element);
                        });
                        this.form_out.bar_code_out = ''
                    }
                })
                .catch((error) => {
                    this.loading = false;
                    if (error.response.status === 500) {
                        eventBus.$emit('errorEvent', error.response.statusText)
                        return
                    } else if (error.response.status === 401 || error.response.status === 409) {
                        // window.location.href = "/apilogin";
                        eventBus.$emit('reloadRequest')
                        return
                        eventBus.$emit('reloadRequest')
                    } else if (error.response.status === 422) {
                        eventBus.$emit('errorEvent', error.response.data.message)
                        return
                    }
                    this.errors = error.response.data.errors;
                })
        },
        Inscan() {
            this.loading_in = true
            axios.post(`/barcodeIn/${this.form_in.bar_code_in}`, this.$data.form_in)
                .then((response) => {
                    this.loading_in = false
                    // console.log(response.data.length);
                    if (response.data.length > 1) {
                        this.$message({
                            type: 'error',
                            message: response.data.length + ' shipment found'
                        });
                    }
                    if (response.data.errors === 'errors') {
                        // if (response.errors) {
                        this.snackbar = true
                        this.message = 'shipment Not found'
                        this.icon = 'block'
                        this.color = 'error'
                    } else {
                        // this.AllScanned.push(response.data);
                        this.form_in.bar_code_in = ''
                        response.data.forEach(element => {
                            this.AllScanned.push(element);
                        });
                        this.form_in.bar_code_in = ''
                    }
                })
                .catch((error) => {
                    this.loading = false;
                    if (error.response.status === 500) {
                        eventBus.$emit('errorEvent', error.response.statusText)
                        return
                    } else if (error.response.status === 401 || error.response.status === 409) {
                        // window.location.href = "/apilogin";
                        eventBus.$emit('reloadRequest')
                        return
                    } else if (error.response.status === 422) {
                        eventBus.$emit('errorEvent', error.response.data.message)
                        return
                    }
                    this.errors = error.response.data.errors;
                })
        },

        OutscanSub() {
            this.loading = true
            this.$confirm(this.AllScanned.length + ' orders will be scanned' + '. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning',
                center: true
            }).then(() => {
                axios.post('/statusUpdateIn', {
                        scan: this.$data.AllScanned,
                        form: this.$data.form_out
                    })
                    .then((response) => {
                        this.loading = false
                        this.fetchData()
                        this.resetForm()
                        // this.snackbar = true
                        // this.message = 'successifully scanned'
                        // this.icon = 'check_circle'
                        // this.color = 'indigo'
                        this.$message({
                            type: 'success',
                            message: 'successifully scanned'
                        });
                    })
                    .catch((error) => {
                        this.loading = false;
                        if (error.response.status === 500) {
                            eventBus.$emit('errorEvent', error.response.statusText)
                            return
                        } else if (error.response.status === 401 || error.response.status === 409) {
                            // window.location.href = "/apilogin";
                            eventBus.$emit('reloadRequest')
                            return
                        } else if (error.response.status === 422) {
                            eventBus.$emit('errorEvent', error.response.data.message)
                            return
                        }
                        this.errors = error.response.data.errors;
                    })
            }).catch(() => {
                this.loading = false
                this.$message({
                    type: 'error',
                    message: 'Scan canceled'
                });
            });
        },

        Inscansub() {
            this.loading_in = true
            this.$confirm(this.AllScanned.length + ' orders will be scanned' + '. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning',
                center: true
            }).then(() => {
                axios.post('/statusUpdateIn', {
                        scan: this.$data.AllScanned,
                        form: this.$data.form_in
                    })
                    .then((response) => {
                        this.loading_in = false
                        this.snackbar = true
                        this.message = 'successifully scanned'
                        this.icon = 'check_circle'
                        this.color = 'indigo'
                        this.resetForm()
                    })
                    .catch((error) => {
                        this.loading_in = false;
                        if (error.response.status === 500) {
                            eventBus.$emit('errorEvent', error.response.statusText)
                            return
                        } else if (error.response.status === 401 || error.response.status === 409) {
                            // window.location.href = "/apilogin";
                            eventBus.$emit('reloadRequest')
                            return
                        } else if (error.response.status === 422) {
                            eventBus.$emit('errorEvent', error.response.data.message)
                            return
                        }
                        this.errors = error.response.data.errors;
                    })

            }).catch(() => {
                this.loading = false;
                this.$message({
                    type: 'error',
                    message: 'Scan canceled'
                });
            });
        },
        removeItem(item) {
            // this.loading = true;
            const index = this.AllScanned.indexOf(item)
            this.AllScanned.splice(index, 1)
        }
    },
    mounted() {
        this.loader = true
        // axios.get('/getShipments')
        //     .then((response) => {
        //         this.AllShipments = response.data
        //         this.loader = false
        //     })
        //     .catch((error) => {
        //         this.errors = error.response.data.errors
        //         this.loader = false
        //     })
        axios.get('/getStatuses')
            .then((response) => {
                this.statuses = response.data
                this.loader = false
            })
            .catch((error) => {
                if (error.response.status === 500) {
                    eventBus.$emit('errorEvent', error.response.statusText)
                    this.loading = false
                    return
                } else if (error.response.status === 401 || error.response.status === 409) {
                    this.loading = false
                    eventBus.$emit('reloadRequest')
                    return
                } else if (error.response.status === 422) {
                    this.loading = false
                    eventBus.$emit('errorEvent', error.response.data.message + ': ' + error.response.statusText)
                    return
                }
                this.errors = error.response.data.errors
            })

        axios.get('/getBranch')
            .then((response) => {
                this.branches = response.data
            })
            .catch((error) => {
                if (error.response.status === 500) {
                    eventBus.$emit('errorEvent', error.response.statusText)
                    this.loading = false
                    return
                } else if (error.response.status === 401 || error.response.status === 409) {
                    this.loading = false
                    eventBus.$emit('reloadRequest')
                    return
                } else if (error.response.status === 422) {
                    this.loading = false
                    eventBus.$emit('errorEvent', error.response.data.message + ': ' + error.response.statusText)
                    return
                }
                this.errors = error.response.data.errors
                this.loader = false
            })

        axios.get('/getDrivers')
            .then((response) => {
                this.AllRiders = response.data
            })
            .catch((error) => {
                this.errors = error.response.data.errors
            })
    },
    computed: {
        formIsValid() {
            return (
                this.form.bar_code
            )
        },
        submit() {
            if (this.form.bar_code) {
                return this.Outscan
            }
        }
    },
}
</script>

<style scoped>

</style>
