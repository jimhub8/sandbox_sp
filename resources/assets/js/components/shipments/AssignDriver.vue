<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent width="500px">
        <v-card v-if="dialog">
            <v-card-title>
                Assign Driver
                <v-spacer></v-spacer>
                <v-btn icon dark @click="close">
                    <v-icon color="black">close</v-icon>
                </v-btn>
            </v-card-title>
            <v-container grid-list-md>
                <v-layout row wrap>
                    <v-flex xs12>
                        <v-card>
                            <select class="custom-select custom-select-md col-md-12" v-model="form.driver" style="font-size: 15px;">
                                <option v-for="driver in riders" :key="driver.id" :value="driver.id">{{ driver.name }}</option>
                            </select>
                            <v-flex xs12 sm12>
                                <v-textarea v-model="form.remark" color="blue">
                                    <div slot="label">
                                        Remark <small>(optional)</small>
                                    </div>
                                </v-textarea>
                            </v-flex>
                        </v-card>
                    </v-flex>
                </v-layout>
                <v-card-actions>
                    <v-btn flat @click="close">Close</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" flat @click="driverAssign" :loading="loading" :disabled="loading">Assign Driver</v-btn>
                </v-card-actions>
            </v-container>
            <v-divider></v-divider>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
export default {
    props: ['updateitedItem', 'selectedItems'],
    data() {
        return {
            dialog: false,
            form: {
                'remark': '',
                'driver': '',
            },
        }
    },
    methods: {
        driverAssign() {
            // alert(this.updateitedItem.id);
            var payload = {
                url: '/assignDriver',
                data: {
                    selected: this.selectedItems,
                    form: this.form
                },
            }
            this.$store.dispatch('postItems', payload)
                .then((response) => {
                    eventBus.$emit('alertRequest', 'Rider assigned')
                    eventBus.$emit('selectClear');
                    this.close();

                })
        },
        close() {
            this.dialog = false
        },
    },
    created() {
        eventBus.$on('AssignDriverlEvent', data => {
            this.dialog = true
        });
    },
    computed: {
        riders() {
            return this.$store.getters.riders
        },
        loading() {
            return this.$store.getters.loading
        }
    },
}
</script>
