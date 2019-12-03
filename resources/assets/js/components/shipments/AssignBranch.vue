<template>
<v-layout row justify-center>

    <v-dialog v-model="dialog" persistent width="500px">
        <v-card v-if="dialog">
            <v-card-title>
                Assign Branch
            </v-card-title>
            <v-spacer></v-spacer>
            <v-btn icon dark @click="close">
                <v-icon color="black">close</v-icon>
            </v-btn>
            <v-container grid-list-md>
                <v-layout row wrap>
                    <v-flex xs12>
                        <v-card>
                            <select class="custom-select custom-select-md col-md-12" v-model="form.branch_id" style="font-size: 15px;">
                                <option v-for="branch in branches" :key="branch.id" :value="branch.id">{{ branch.branch_name }}</option>
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
                    <v-btn color="primary" flat @click="branchAssign" :loading="loading" :disabled="loading">Update Branch</v-btn>
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
                'branch_id': '',
            },
        }
    },
    methods: {
        branchAssign() {
            var payload = {
                url: '/assignBranch',
                data: {
                    selected: this.selectedItems,
                    form: this.form
                },
            }
            this.$store.dispatch('postItems', payload)
                .then((response) => {
                    eventBus.$emit('alertRequest', 'Branch assigned')
                    eventBus.$emit('selectClear');
                    this.close();

                })
        },
        close() {
            this.dialog = false
        },
    },
    created() {
        eventBus.$on('AssignBranchlEvent', data => {
            this.dialog = true
        });
    },
    computed: {
        branches() {
            return this.$store.getters.branches
        },
        loading() {
            return this.$store.getters.loading
        }
    },
}
</script>
