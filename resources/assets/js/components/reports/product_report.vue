<template>
<div>
    <!-- <v-text-field color="success" :loading="loading"></v-text-field> -->
    <v-card class="mx-auto" style="padding: 10px;text-align: center;">
        <VCardTitle primary-title>
            <h1 style="margin: auto;">Product Report</h1>
        </VCardTitle>
        <VDivider />
        <v-card-text>
            <div>
                <label for="">Client</label>
                <el-select v-model="client_report.client" multiple filterable remote reserve-keyword placeholder="type at least 3 characters" :remote-method="getClient" :loading="loading" style="width: 100%;">
                    <el-option v-for="item in clients" :key="item.id" :label="item.name" :value="item.id">
                    </el-option>
                </el-select>
            </div>
            <div style="margin: 10px 0;"></div>
            <div class="block">
                <span class="demonstration" style="float: left">Start Date</span>
                <el-date-picker v-model="client_report.start_date" type="date" placeholder="Pick a day" style="width: 100%;">
                </el-date-picker>
            </div>
            <div class="block">
                <span class="demonstration" style="float: left">End Date</span>
                <el-date-picker v-model="client_report.end_date" type="date" placeholder="Pick a day" style="width: 100%;">
                </el-date-picker>
            </div>
        </v-card-text>
        <VDivider />

        <v-card-actions>
            <v-btn text color="info" flat @click="getReport" :loading="loading" :disabled="loading">
                Get Report
            </v-btn>
            <VSpacer />
            <download-excel :data="client_data" :fields="json_fields" v-if="client_data.length> 0">
                <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                        <v-btn icon v-on="on" slot="activator" class="mx-0" color="primary">
                            <i color="info" class="fas fa-file-excel"></i>
                        </v-btn>
                    </template>
                    <span>Download report</span>
                </v-tooltip>
            </download-excel>
            <el-tag type="red" v-if="client_data.length > 0">{{ client_data.length }}</el-tag>

        </v-card-actions>
    </v-card>
</div>
</template>

<script>
export default {
    props: ['user', 'statuses'],
    data() {
        return {
            form: {
                search: ''
            },
            client_report: {
                start_date: '',
                end_date: '',
                option: '',
                client: [],
            },
            options: [{
                value: 'Orders',
                label: 'Orders'
            }, {
                value: 'Products',
                label: 'Products'
            }, ],
            client_options: [],
            products: [],
            clients: [],
            loading: false,
            client_data: [],
            order_data: [],
            json_fields: {
                'Order Id': 'bar_code',
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
        getReport(query) {
            this.loading = true;
            this.form.search = query
            axios.post('/userDateExpo', this.client_report).then((response) => {
                this.loading = false
                this.client_data = response.data
                if (response.data.length < 1) {
                    eventBus.$emit('errorEvent', 'No data found')
                } else {
                    this.$store.dispatch('alertEvent', 'Data fetched')
                }
            }).catch((error) => {
                this.loading = false;
                if (error.response.status === 500) {
                    eventBus.$emit('errorEvent', error.response.statusText)
                    return
                } else if (error.response.status === 401 || error.response.status === 409) {
                    eventBus.$emit('reloadRequest', error.response.statusText)
                } else if (error.response.status === 422) {
                    eventBus.$emit('errorEvent', error.response.statusText)
                    return
                }
            })
        },
        getClient(query) {
            if (query.length > 2) {
                this.loading = true;
                this.form.search = query
                axios.get(`/searchClient/${query}`).then((response) => {
                    this.loading = false
                    this.clients = response.data

                }).catch((error) => {
                    this.loading = true;
                })
            }
        },
        getProducts(query) {
            if (query.length > 2) {
                this.loading = true;
                axios.get(`/filter_prod/${query}`).then((response) => {
                    this.loading = false
                    this.products = response.data

                }).catch((error) => {
                    this.loading = true;
                })
            }
        },
        // getApiStatuses() {
        //     this.$store.dispatch('getApiStatuses')
        // }
    },
    mounted() {
        // this.getApiStatuses();
    },
    computed: {
        // api_status() {
        //     return this.$store.getters.api_status
        // }
    },
}
</script>

<style scoped>
label {
    float: left;
}

.theme--light.v-card>.v-card__text {
    height: 450px;
}
</style>
