<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="500px">
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Change password</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout row wrap>
                        <v-flex sm12>
                            <v-card-text>
                                <div>
                                    <v-text-field v-model="form.password" :append-icon="show ? 'visibility' : 'visibility_off'" :type="show ? 'text' : 'password'" name="input-10-1" label="New password" counter @click:append="show = !show"></v-text-field>
                                    <!-- <v-text-field v-model="form.password" :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'" :rules="[rules.required, rules.min]" :type="show ? 'text' : 'password'" name="input-10-1" label="Normal with hint text" hint="At least 8 characters" counter @click:append="show = !show"></v-text-field> -->
                                </div>
                                <small class="has-text-danger" v-if="errors.password">{{ errors.password[0] }}</small>
                            </v-card-text>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn color="blue darken-1" flat @click="close">Close</v-btn>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="passwordChange" :loading="loading" :disabled="loading">Update</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
export default {
    data: () => ({
        dialog: false,
        show: false,
        loading: false,
        form: {
            password: ''
        },
        errors: {},
        rules: {
            required: value => !!value || 'Required.',
            min: v => v.length >= 8 || 'Min 8 characters',
            emailMatch: () => ('The email and password you entered don\'t match'),
        },
    }),
    created() {
        eventBus.$on("openPasswordEvent", data => {
            // console.log(data);

            this.dialog = true;
            this.form.id = data
        });
    },

    methods: {
        passwordChange(id) {
            this.loading = true;
            axios
                .post(`/change_password/${this.form.id}`, this.form)
                .then(response => {
                    this.loading = false;
                    eventBus.$emit('alertRequest', 'updated')
                })
                .catch(error => {
                    this.loading = false;

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
                    this.errors = error.response.data.errors;
                });
        },
        close() {
            this.dialog = false;
        }
    },
};
</script>
