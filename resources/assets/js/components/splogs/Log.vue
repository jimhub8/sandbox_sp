<template>
<div>
    <v-content>
        <div v-show="loader" style="text-align: center; width: 100%;">
            <v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
        </div>
        <v-container fluid fill-height v-show="!loader">
            <v-layout justify-center align-center>

                <div v-show="!loader">
                    <v-layout wrap>
                        <v-flex sm12>
                            <v-text-field v-model="glsearch.search" append-icon="search" label="Global Search" single-line hide-details @keyup.enter="itemSearch"></v-text-field>
                        </v-flex>
                        <v-flex sm6>
                            <v-pagination v-model="AllCalls.current_page" :length="AllCalls.last_page" total-visible="5" @input="next()" circle v-if="AllCalls.last_page > 1"></v-pagination>
                        </v-flex>
                    </v-layout>
                    <v-card-title>
                        <v-flex xs6 sm12>
                            Logs
                        </v-flex>

                        <v-flex xs1 sm1>
                            <v-tooltip right>
                                <template v-slot:activator="{ on }">
                                    <v-btn v-on="on" icon slot="activator" class="mx-0" @click="getCalls">
                                        <v-icon color="blue darken-2" small>refresh</v-icon>
                                    </v-btn>
                                </template> <span>Refresh</span>
                            </v-tooltip>
                        </v-flex>

                        <v-flex xs4 sm2>
                            <label for="">Country</label>
                            <el-select v-model="form.country" filterable clearable placeholder="Select Country" style="width: 100%;">
                                <el-option v-for="item in countries" :key="item.id" :label="item.country_name" :value="item.id">
                                </el-option>
                            </el-select>
                        </v-flex>
                        <v-flex xs4 sm2 style="margin-left: 10px">
                            <label for="">Clients</label>
                            <el-select v-model="form.client_id" clearable filterable placeholder="Select User" @change="changeCat">
                                <el-option v-for="item in Allusers" :key="item.id" :label="item.name" :value="item.id">
                                </el-option>
                            </el-select>
                            <!-- <v-select :items="Allusers" v-model="select" label="Select User" single-line item-text="name" item-value="name" return-object persistent-hint></v-select> -->
                        </v-flex>
                        <v-flex xs12 sm2 style="margin-left: 10px">
                            <v-text-field label="Start Date" v-model="form.start_date" color="blue darken-2" type="date" required></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm2 style="margin-left: 10px">
                            <v-text-field label="End Date" v-model="form.end_date" color="blue darken-2" type="date" required></v-text-field>
                        </v-flex>
                        <v-flex sm1>
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <v-btn v-on="on" icon class="mx-0" @click="filter" slot="activator">
                                        <v-icon color="info darken-2" small>search</v-icon>
                                    </v-btn>
                                </template>
                                <span>Filter</span>
                            </v-tooltip>
                        </v-flex>
                        <v-flex sm1>
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <v-btn v-on="on" icon class="mx-0" @click="filReset" slot="activator">
                                        <v-icon color="info darken-2" small>settings_backup_restore</v-icon>
                                    </v-btn>
                                </template>
                                <span>Reset</span>
                            </v-tooltip>
                        </v-flex>
                        <v-spacer></v-spacer>
                        <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details></v-text-field>
                    </v-card-title>
                    <v-data-table :headers="headers" :items="AllCalls.data" :search="search" counter class="elevation-1">
                        <template slot="items" slot-scope="props">
                            <td class="text-xs-right">{{ props.item.user_name }}</td>
                            <td class="text-xs-right">{{ props.item.event }}</td>
                            <td class="text-xs-right">{{ props.item.shipment.airway_bill_no }}</td>
                            <td class="text-xs-right">{{ props.item.created_at }}</td>
                            <td class="justify-center layout px-0">
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-btn v-on="on" icon class="mx-0" @click="details(props.item)" slot="activator">
                                            <v-icon color="info darken-2" small>visibility</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Details</span>
                                </v-tooltip>
                            </td>
                        </template>
                        <v-alert slot="no-results" :value="true" color="error" icon="warning">
                            Your search for "{{ search }}" found no results.
                        </v-alert>
                    </v-data-table>
                </div>
            </v-layout>
        </v-container>
    </v-content>
    <show></show>
</div>
</template>

<script>
import show from './Show'
export default {
    props: ['user'],
    components: {
        show
    },
    data() {
        return {
            search: '',
            callCount: null,
            form: {},
            AllSc: [],
            AllCalls: [],
            loader: false,
            editedItem: {},
            loading: false,
            select: [],
            Allusers: [],
            glsearch: {
                search: ''
            },
            between: {
                start: 1,
                end: 500
            },
            headers: [{
                    text: 'User Name',
                    align: 'left',
                    value: 'user_name'
                },
                {
                    text: 'Event',
                    value: 'event'
                },
                {
                    text: 'Waybill Number',
                    value: 'shipment.airway_bill_no'
                },
                {
                    text: 'Updated at',
                    value: 'created_at'
                },
                {
                    text: 'Action',
                    sortable: false
                },
            ],
        }
    },
    methods: {
        getUsers() {
            this.loading = true
            axios.get('/getUsers')
                .then((response) => {
                    this.loading = false
                    this.Allusers = response.data
                })
                .catch((error) => {
                    this.loading = false
                    this.errors = error.response.data.errors
                })
        },
        details(item) {
            eventBus.$emit('ShowShipEvent', item);
        },
        getCalls() {
            eventBus.$emit("progressEvent");
            axios.get('/calls')
                .then((response) => {
                    eventBus.$emit("StoprogEvent");
                    this.loader = false;
                    this.AllCalls = response.data
                })
                .catch((error) => {
                    eventBus.$emit("StoprogEvent");
                    this.loader = false;
                    this.errors = error.response.data.errors
                })
        },
        filter() {
            eventBus.$emit("progressEvent");
            // this.form.client_id = this.select.id
            axios
                .post("/Filterlogs", this.form)
                .then(response => {
                    eventBus.$emit("StoprogEvent");
                    this.AllCalls = response.data;
                })
                .catch(error => {
                    eventBus.$emit("StoprogEvent");
                    this.errors = error.response.data.errors;
                });
        },
        filReset() {
            this.between.start = 1
            this.between.end = 500
            this.select = []
            this.form = []
            this.getCalls()
        },

        // next() {
        //     this.loading = true;
        //     this.between.start = parseInt(this.between.start) + 500;
        //     this.between.end = parseInt(this.between.end) + 500;
        //     this.filter()
        // },
        previous() {
            this.loading = true;
            if (this.between.start >= 500) {
                this.between.start = parseInt(this.between.start) - 500;
                this.between.end = parseInt(this.between.end) - 500;
                this.filter()

            } else {
                return;
                this.loading = false;
            }
        },

        next() {
            // this.loading = true;
            // this.between.start = parseInt(this.between.start) + 500;
            // this.between.end = parseInt(this.between.end) + 500;
            // this.sortItem()
            this.loading = true;
            axios.get(this.AllCalls.path + '?page=' + this.AllCalls.current_page, {
                    select: this.select,
                    no_btw: this.between,
                    selectStatus: this.selectItem,
                    form: this.form,
                    selectCountry: this.selectCountry
                })
                .then(response => {
                    this.loading = false;
                    this.AllCalls = response.data;
                    this.filterCount()

                })
                .catch(error => {
                    if (error.response.status === 500) {
                        eventBus.$emit('errorEvent', error.response.statusText)
                        this.loading = false
                        return
                    } else if (error.response.status === 401 || error.response.status === 409) {
                        this.loading = false
                        if (!user.is_client) {
                            eventBus.$emit('reloadRequest')
                        } else {
                            eventBus.$emit('reloadAppRequest')
                        }
                        return
                    } else if (error.response.status === 422) {
                        this.loading = false
                        eventBus.$emit('errorEvent', error.response.data.message + ': ' + error.response.statusText)
                        return
                    }
                    this.loading = false;
                    this.errors = error.response.data.errors;
                });
        },

        itemSearch() {

            eventBus.$emit("progressEvent");
            axios.get(`/logs_search/${this.glsearch.search}`)
                .then((response) => {
                    eventBus.$emit("StoprogEvent");
                    this.loader = false;
                    this.AllCalls = response.data
                })
                .catch((error) => {
                    eventBus.$emit("StoprogEvent");
                    this.loader = false;
                    this.errors = error.response.data.errors
                })
            // var payload = {
            //     url: '/logs_search/' + this.glsearch.search,
            //     list: 'updateShipmentsList',
            // }
            // this.$store.dispatch('searchItems', payload)
        },

        getCountry() {
            var payload = {
                url: '/getCountry',
                list: 'updateCountryList',
                data: this.form,
            }
            this.$store.dispatch('getItems', payload)
        },
    },
    mounted() {
        this.loader = true
        this.getUsers()
        this.getCountry()
        this.getCalls()
        axios
            .get("/callcount")
            .then(response => {
                this.callCount = response.data;
            })
            .catch(error => {
                this.errors = error.response.data.errors;
            });
    },
    computed: {
        countries() {
            return this.$store.getters.countries
        },
    },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            if (vm.user.can['view logs']) {
                next();
            } else {
                next('/unauthorized');
            }
        })
    }
}
</script>
