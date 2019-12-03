<template>
<div>
    <!-- <v-text-field color="success" :loading="loading"></v-text-field> -->
    <v-card class="mx-auto" style="padding: 10px;text-align: center;">
        <VCardTitle primary-title>
            <h1 style="margin: auto;">Rider Report</h1>
        </VCardTitle>
        <VDivider />
        <v-card-text>
            <div>
                <label for="">Rider</label>
                <el-select v-model="rider_report.rider" multiple filterable remote reserve-keyword placeholder="type at least 3 characters" :remote-method="getRider" :loading="loading" style="width: 100%;">
                    <el-option v-for="item in riders" :key="item.id" :label="item.name" :value="item.id">
                    </el-option>
                </el-select>
            </div>
            <div style="margin: 10px 0;"></div>
            <div class="block">
                <span class="demonstration" style="float: left">Start Date</span>
                <el-date-picker v-model="rider_report.start_date" type="date" placeholder="Pick a day" style="width: 100%;">
                </el-date-picker>
            </div>
            <div class="block">
                <span class="demonstration" style="float: left">End Date</span>
                <el-date-picker v-model="rider_report.end_date" type="date" placeholder="Pick a day" style="width: 100%;">
                </el-date-picker>
            </div>
        </v-card-text>
        <VDivider />

        <v-card-actions>
            <v-btn text color="info" flat @click="getReport" :loading="loading" :disabled="loading">
                Get Report
            </v-btn>
            <VSpacer />
            <download-excel :data="rider_data" name="Rider Report.csv" type="csv" :fields="json_fields" v-if="rider_data.length> 0">
                <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                        <v-btn icon v-on="on" slot="activator" class="mx-0" color="primary">
                            <i color="info" class="fas fa-file-excel"></i>
                        </v-btn>
                    </template>
                    <span>Download report</span>
                </v-tooltip>
            </download-excel>
            <el-tag type="red" v-if="rider_data.length > 0">{{ rider_data.length }}</el-tag>

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
            rider_report: {
                start_date: '',
                end_date: '',
                option: '',
                rider: [],
            },
            options: [{
                value: 'Orders',
                label: 'Orders'
            }, {
                value: 'Products',
                label: 'Products'
            }, ],
            rider_options: [],
            products: [],
            riders: [],
            loading: false,
            rider_data: [],
            order_data: [],
            json_fields: {
                'Order Id': 'order_id',
                'Sender Name': 'sender_name',
                'Sender Email': 'sender_email',
                'Sender Phone': 'sender_phone',
                'Sender City': 'sender_city',
                'Sender Address': 'sender_address',
                'Driver': 'driver',
                'Rider Name': 'rider_name',
                'Rider Email': 'rider_email',
                'Rider Phone': 'rider_phone',
                'Rider City': 'rider_city',
                'Rider Address': 'rider_address',
                'Derivery Status': 'status',
                'From': 'sender_address',
                'To': 'rider_address',
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
            axios.post('DriverReport', this.rider_report).then((response) => {
                this.loading = false
                this.rider_data = response.data
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
        getRider(query) {
            if (query.length > 2) {
                this.loading = true;
                this.form.search = query
                axios.get(`searchRider/${query}`).then((response) => {
                    this.loading = false
                    this.riders = response.data

                }).catch((error) => {
                    this.loading = true;
                })
            }
        },
        getProducts(query) {
            if (query.length > 2) {
                this.loading = true;
                axios.get(`filter_prod/${query}`).then((response) => {
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
