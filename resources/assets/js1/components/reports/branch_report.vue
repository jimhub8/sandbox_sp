<template>
<div>
    <!-- <v-text-field color="success" :loading="loading"></v-text-field> -->
    <v-card class="mx-auto" style="padding: 10px;text-align: center;">
        <VCardTitle primary-title>
            <h1 style="margin: auto;">Branch Report</h1>
        </VCardTitle>
        <VDivider />
        <v-card-text>
            <label for="">Status</label>
            <el-select v-model="branch_report.status" filterable clearable placeholder="Select status" style="width: 100%;">
                <el-option v-for="item in statuses" :key="item.name" :label="item.name" :value="item.name">
                </el-option>
            </el-select>
            <div style="margin: 10px 0;"></div>
            <div>
                <label for="">Branch</label>
            <el-select v-model="branch_report.branch" filterable clearable placeholder="Select status" style="width: 100%;">
                <el-option v-for="item in AllBranches" :key="item.id" :label="item.branch_name" :value="item.id">
                </el-option>
            </el-select>
                <!-- <el-select v-model="branch_report.branch" multiple filterable remote reserve-keyword placeholder="type at least 3 characters" :remote-method="getBranch" :loading="loading" style="width: 100%;">
                    <el-option v-for="item in branchs" :key="item.id" :label="item.name" :value="item.id">
                    </el-option>
                </el-select> -->
            </div>
            <div style="margin: 10px 0;"></div>
            <div class="block">
                <span class="demonstration" style="float: left">Start Date</span>
                <el-date-picker v-model="branch_report.start_date" type="date" placeholder="Pick a day" style="width: 100%;">
                </el-date-picker>
            </div>
            <div class="block">
                <span class="demonstration" style="float: left">End Date</span>
                <el-date-picker v-model="branch_report.end_date" type="date" placeholder="Pick a day" style="width: 100%;">
                </el-date-picker>
            </div>
        </v-card-text>
        <VDivider />

        <v-card-actions>
            <v-btn text color="info" flat @click="getReport" :loading="loading" :disabled="loading">
                Get Report
            </v-btn>
            <VSpacer />
            <download-excel :data="branch_data" name="Branch Report.csv" type="csv" :fields="json_fields" v-if="branch_data.length> 0">
                <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                        <v-btn icon v-on="on" slot="activator" class="mx-0" color="primary">
                            <i color="info" class="fas fa-file-excel"></i>
                        </v-btn>
                    </template>
                    <span>Download report</span>
                </v-tooltip>
            </download-excel>
            <el-tag type="red" v-if="branch_data.length > 0">{{ branch_data.length }}</el-tag>

        </v-card-actions>
    </v-card>
</div>
</template>

<script>
export default {
    props: ['user', 'statuses', 'AllBranches'],
    data() {
        return {
            form: {
                search: ''
            },
            branch_report: {
                start_date: '',
                end_date: '',
                option: '',
                branch: [],
            },
            options: [{
                value: 'Orders',
                label: 'Orders'
            }, {
                value: 'Products',
                label: 'Products'
            }, ],
            branch_options: [],
            products: [],
            branchs: [],
            loading: false,
            branch_data: [],
            order_data: [],
            json_fields: {
                'Order Id': 'order_id',
                'Sender Name': 'sender_name',
                'Sender Email': 'sender_email',
                'Sender Phone': 'sender_phone',
                'Sender City': 'sender_city',
                'Sender Address': 'sender_address',
                'Driver': 'driver',
                'Branch Name': 'branch_name',
                'Branch Email': 'branch_email',
                'Branch Phone': 'branch_phone',
                'Branch City': 'branch_city',
                'Branch Address': 'branch_address',
                'Derivery Status': 'status',
                'From': 'sender_address',
                'To': 'branch_address',
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
            axios.post('userDateExpo', this.branch_report).then((response) => {
                this.loading = false
                this.branch_data = response.data
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
        // this.getBranch();
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
