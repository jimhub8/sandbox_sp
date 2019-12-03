<template>
<v-content>
    <v-container fluid fill-height>
        <v-layout justify-center align-center>
            <v-layout row wrap>
                <v-flex xs12>
                    <input type="text" class="form-control" id="inputAddress2" placeholder="Barcode" v-model="form.bar_code" @change="search_order">
                </v-flex>
                <v-divider></v-divider>
                <v-flex sm12 style="margin-top: 30px">
                    <download-excel name="Dispatch Outbound.csv"  type="csv" :data="scanned_orders" :fields="json_fields">
                        Export
                        <img src="/storage/csv.png" style="width: 30px; height: 30px; cursor: pointer;">
                    </download-excel>
                    <v-tooltip right>
                        <template v-slot:activator="{ on }">
                            <v-btn icon v-on="on" slot="activator" class="mx-0" @click="resetForm">
                                <v-icon color="blue darken-2" small>refresh</v-icon>
                            </v-btn>
                        </template>
                        <span>Reset all</span>
                    </v-tooltip>
                    <v-data-table :headers="headers" :items="scanned_orders" class="elevation-1" :loading="loading" :search="search">
                        <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
                        <template slot="items" slot-scope="props">
                            <td>{{ props.item.bar_code }}</td>
                            <td class="text-xs-right">{{ props.item.client_email }}</td>
                            <td class="text-xs-right">{{ props.item.client_name }}</td>
                            <td class="text-xs-right">{{ props.item.client_phone }}</td>
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
                </v-flex>
            </v-layout>

        </v-layout>
    </v-container>
</v-content>
</template>

<script>
export default {
    data() {
        return {
            errors: {},
            scanned_orders: [],
            search: '',
            loading: false,
            form: {
                bar_code: ''
            },
            json_fields: {
                "Order Id": "order_id",
                "Product Name": "client_email",
                "Client Name": "client_name",
                "Contact": "client_phone",
                "Amount": "cod_amount",
                "Payment Code": 'null',
                "Delivery Date": "null",
                "Time": "null",
            },
            headers: [{
                    text: 'Order Id',
                    align: 'left',
                    value: 'bar_code'
                },
                {
                    text: 'Product Name',
                    value: 'client_email'
                },
                {
                    text: 'Client Name',
                    value: 'client_name'
                },
                {
                    text: 'Client Phone',
                    value: 'client_phone'
                },
                {
                    text: 'Actions',
                    sortable: false
                }
            ],
        }
    },
    methods: {
        search_order() {
            axios.get(`/search_order/${this.form.bar_code}`, this.$data.form_in)
                .then((response) => {
                    this.form.bar_code = ''
                    // console.log(response.data.length)
                    if (response.data) {
                        this.scanned_orders.push(response.data)
                    } else {
                        eventBus.$emit('errorEvent', 'no shipment found')
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

        removeItem(item) {
            // this.loading = true;
            const index = this.scanned_orders.indexOf(item)
            this.scanned_orders.splice(index, 1)
        },

        resetForm() {
            this.scanned_orders = []
        },

    },
}
</script>
