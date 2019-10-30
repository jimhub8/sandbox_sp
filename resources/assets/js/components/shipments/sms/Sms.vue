<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent width="500px">
        <v-card v-if="dialog">
            <v-card-title>
                Send Sms
                <v-spacer></v-spacer>
                <v-btn icon dark @click="close">
                    <v-icon color="black">close</v-icon>
                </v-btn>
            </v-card-title>
            <v-container grid-list-md>
                <v-layout row wrap>
                    <v-flex xs12>
                            <v-flex xs12 sm12>
                                <v-textarea v-model="form.message" color="blue">
                                    <div slot="label">
                                        Message
                                    </div>
                                </v-textarea>
                            </v-flex>
                            <!-- </v-layout> -->
                    </v-flex>
                </v-layout>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-btn flat @click="dialog = false">Close</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" flat @click="sendSms" :loading="loading" :disabled="loading">Send sms</v-btn>
                </v-card-actions>
            </v-container>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
export default {
    data() {
        return {
            shipments: [],
            dialog: false,
            form: {
                shipments: [],
                message: '',
            },
        };
    },
    methods: {
        sendSms() {
            // alert(this.updateitedItem.id);
            this.loading = true;
            axios
                .post('/send_sms', this.form)
                .then(response => {
                    this.loading = false;
                    eventBus.$emit("alertRequest", 'messages sent');
                })
                .catch(error => {
                    this.loading = false;
                    if (error.response.status === 500) {
                        eventBus.$emit('errorEvent', error.response.statusText)
                        return
                    } else if (error.response.status === 401 || error.response.status === 409) {
                        eventBus.$emit('reloadRequest', error.response.statusText)
                    } else if (error.response.status === 422) {
                        eventBus.$emit('errorEvent', error.response.data.message + ': ' + error.response.statusText)
                        return
                    }
                    this.errors = error.response.data.errors;
                });
        },
    },
    mounted() {
        axios
            .get("/delStatus")
            .then(response => {
                this.statuses = response.data;
            })
            .catch(error => {
                this.errors = error.response.data.errors;
            });
    },
    created () {
        eventBus.$on('sendSmsEvent', data => {
            this.dialog= true
            this.form.shipments = data
        })
    },
};
</script>
