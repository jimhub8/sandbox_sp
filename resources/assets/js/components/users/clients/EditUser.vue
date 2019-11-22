<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="700px">
        <v-card>
            <v-card-title fixed>
                <span class="headline">Add User</span>
                <v-spacer></v-spacer>
                <v-btn icon dark @click="close">
                    <v-icon color="black">close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-form ref="form" @submit.prevent>
                            <v-container grid-list-xl fluid>
                                <v-layout wrap>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.name" color="purple darken-2" label="Full name" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.email" color="blue darken-2" label="Email" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.address" color="blue darken-2" label="Address" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.address">{{ errors.address[0] }}</small>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.city" color="blue darken-2" label="City" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.city">{{ errors.city[0] }}</small>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.phone" color="blue darken-2" label="Phone" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.phone">{{ errors.phone[0] }}</small>
                                    </v-flex>
                                    <div class="form-group col-md-6">
                                        <label for="">Country</label>
                                        <select class="custom-select custom-select-md col-md-12" v-model="form.countryList" @change="country_branch">
                                            <option v-for="country in countryList" :key="country.id" :value="country.id">{{ country.country_name }}</option>
                                        </select>
                                        <small class="has-text-danger" v-if="errors.countryList">{{ errors.countryList[0] }}</small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for=""> Report start day</label>
                                        <el-select v-model="form.start_day" filterable clearable placeholder="Select a day" style="width:100%">
                                            <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Report end day</label>
                                        <el-select v-model="form.end_day" filterable   clearable placeholder="Select a day" style="width:100%">
                                            <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Report Display</label>
                                        <el-select v-model="form.show_on" filterable   clearable placeholder="Select a day" style="width:100%">
                                            <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </v-layout>
                            </v-container>
                            <v-card-actions>
                                <v-btn flat @click="resetForm">reset</v-btn>
                                <v-btn flat @click="close">Close</v-btn>
                                <v-spacer></v-spacer>
                                <v-btn :disabled="loading" flat color="primary" @click="save" :loading="loading">Submit</v-btn>
                            </v-card-actions>
                        </v-form>
                    </v-layout>
                </v-container>
            </v-card-text>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
export default {
    props: ['countryList'],
    data() {
        return {
            dialog: false,
            options: [{
                value: 'Monday',
                label: 'Monday'
            }, {
                value: 'Tuesday',
                label: 'Tuesday'
            }, {
                value: 'Wednesday',
                label: 'Wednesday'
            }, {
                value: 'Thursday',
                label: 'Thursday'
            }, {
                value: 'Friday',
                label: 'Friday'
            }, {
                value: 'Saturday',
                label: 'Saturday'
            }, {
                value: 'Sunday',
                label: 'Sunday'
            }],
            loading: false,
            errors: [],
            selected: [],
            AllBranches: [],
            permissions: [],
            loader: false,
            e1: true,
            form: {},
        }
    },
    methods: {
        save() {
            this.loading = true
            axios.patch(`/clients/${this.form.id}`, this.form).
            then((response) => {
                    // alert('error1')
                    this.loading = false
                    // console.log(response);
                    // this.$parent.Allusers.push(response.data)
                    // this.close();
                    // this.resetForm();
                    this.$emit('alertRequest');
                })
                .catch((error) => {
                    this.loading = false
                    // alert('error2')
                    if (error.response.status === 500 || error.response.status === 405 ) {
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
                    this.loading = false
                    console.log(error)
                    this.errors = error.response.data.errors
                })
        },
        resetForm() {
            this.form = Object.assign({}, this.defaultForm)
            this.$refs.form.reset()
        },
        close() {
            this.dialog = false
        },
        country_branch() {
            this.countryList.forEach(element => {
                if (parseInt(this.form.countryList) == parseInt(element.id)) {
                    this.AllBranches = element.branches
                }
            });
        },
    },
    computed: {
        formIsValid() {
            return (
                this.form.name &&
                this.form.email &&
                this.form.phone &&
                // this.form.zipcode &&
                this.form.address &&
                this.form.city
            )
        },
    },
    created () {
        eventBus.$on('openClientEvent', data => {
            this.dialog = true
            this.form = data
        });
    },
}
</script>
