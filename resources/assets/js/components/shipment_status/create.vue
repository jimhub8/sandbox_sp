<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="700px">
        <v-card>
            <v-progress-linear :indeterminate="loading" v-show="loading"></v-progress-linear>

            <v-card-title>
                <span class="headline text-center" style="margin: auto;">update Status</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout row wrap>
                        <v-flex sm12>
                            <div>
                                <!-- <label for="">Waybill</label> -->
                                <!-- <el-autocomplete v-model="form.waybill_no" placeholder="Please input" @select="handleSelect"></el-autocomplete> -->
                                <v-text-field v-model="form.bar_code" color="blue darken-2" label="Waybill" append-icon="search" @change="Waybill_search">
                                </v-text-field>
                            </div>
                            <div v-show="update_status">
                                <div>
                                    <label for="">Status</label>
                                    <el-select v-model="form.status" filterable clearable placeholder="status" style="width: 100%;">
                                        <el-option v-for="item in statuses" :key="item.id" :label="item.name" :value="item.name">
                                        </el-option>
                                    </el-select>
                                </div>
                                <div>
                                    <label for="">Rider</label>
                                    <el-select v-model="form.driver" filterable clearable placeholder="status" style="width: 100%;">
                                        <el-option v-for="item in riders" :key="item.id" :label="item.name" :value="item.id">
                                        </el-option>
                                    </el-select>
                                </div>
                                <div>
                                    <label for="">Branch</label>
                                    <el-select v-model="form.branch_id" filterable clearable placeholder="status" style="width: 100%;">
                                        <el-option v-for="item in branches" :key="item.id" :label="item.branch_name" :value="item.id">
                                        </el-option>
                                    </el-select>
                                </div>
                                <div>
                                    <label for="">Comment</label>
                                    <el-input type="textarea" placeholder="Please input" v-model="form.comment">
                                    </el-input>
                                </div>
                            </div>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn color="blue darken-1" flat @click="close">Close</v-btn>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="save" :loading="loading" :disabled="loading">Save</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
export default {
    data: () => ({
        dialog: false,
        loading: false,
        update_status: false,
        shipment: {},
        form: {},
        errors: {},
        payload: {
            model: 'statusupdates',
        },
        gender: [{
                value: 'Male',
                lable: 'Male',
            },
            {
                value: 'Female',
                lable: 'Female',
            },
        ]
    }),
    created() {
        eventBus.$on("openCreateStatusupdate", data => {
            this.dialog = true;
        });
    },

    methods: {
        getStatus() {
            var payload = {
                url: '/getStatuses',
                list: 'updateStatusList',
            }
            this.$store.dispatch('getItems', payload)
        },
        save() {
            this.payload = {
                data: this.form,
                url: 'statusupdates'
            }
            this.$store.dispatch('postItems', this.payload)
                .then(response => {
                    this.$message.success('Updated.');
                    eventBus.$emit("statusupdateEvent")
                });
        },

        Waybill_search() {
            this.loading = true
            // alert('test')
            axios.get(`/Waybill_search/${this.form.bar_code}`)
                .then((response) => {
                    this.loading = false

                    // console.log(response.data.status);
                    if (response.data.status) {
                        this.form = response.data.shipment
                        // this.form.driver = response.data.shipment.driver
                        // this.form.status = response.data.shipment.status
                        // this.form.branch_id = response.data.shipment.branch_id
                        this.update_status = true
                    } else {
                        this.$message.error('Oops, order not found.');
                    }

                    // this.AllShip = response.data
                    // this.loader = false
                })
                .catch((error) => {
                    this.loading = false
                    // this.errors = error.response.data.errors
                    // this.loader = false
                })
        },
        close() {
            this.dialog = false;
        },
        getBranch() {
            var payload = {
                url: '/getBranchEger',
                list: 'updateBranchesList',
            }
            this.$store.dispatch('getItems', payload)
        },
        getDrivers() {
            var payload = {
                url: '/getDrivers',
                list: 'updateRidersList',
            }
            this.$store.dispatch('getItems', payload)
        },
    },
    mounted() {

        this.getStatus()
        this.getBranch()
        this.getDrivers()
    },
    computed: {
        statuses() {
            return this.$store.getters.statuses
        },
        riders() {
            return this.$store.getters.riders
        },
        branches() {
            return this.$store.getters.branches
        }
    },
};
</script>
