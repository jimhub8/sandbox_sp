<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="500px">
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Create Expense</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout row wrap>
                        <v-flex sm12>
                            <v-card-text>
                                <div>
                                    <label for="">Employee</label>
                                    <el-select v-model="form.bought_by" placeholder="Select" style="width: 100%;">
                                        <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value">
                                        </el-option>
                                    </el-select>
                                </div>
                                <div>
                                    <label for="">Item</label>
                                    <el-input placeholder="Item Bought" v-model="form.item"></el-input>
                                </div>
                                <div>
                                    <label for="">Purchased From</label>
                                    <el-input placeholder="Purchased From" v-model="form.purchased_from"></el-input>
                                </div>
                                <div class="block">
                                    <span class="demonstration">Purchased on</span>
                                    <el-date-picker v-model="form.purchase_date" type="date" placeholder="Pick a day" style="width: 100%;">
                                    </el-date-picker>
                                </div>
                                <div>
                                    <label for="">Amount</label>
                                    <el-input placeholder="Purchased From" v-model="form.amount"></el-input>
                                </div>

                                <div>
                                    <label for="">Quantity</label>
                                    <el-input placeholder="Purchased From" v-model="form.qty"></el-input>
                                </div>
                                <div>
                                    <label for="">Remarks</label>
                                    <el-input type="textarea" placeholder="Please input" v-model="form.remarks" maxlength="500" show-word-limit>
                                    </el-input>
                                </div>
                            </v-card-text>
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
        form: {},
        payload: {
            model: 'expenses',
            data: null,
        },
    }),
    created() {
        eventBus.$on("openCreateExpenseType", data => {
            this.dialog = true;
        });
    },

    methods: {
        save() {
            this.payload.data = this.form
            this.$store.dispatch('postItems', this.payload)
        },
        close() {
            this.dialog = false;
        }
    },
};
</script>
