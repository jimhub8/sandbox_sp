<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="500px">
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Task Details</span>
                <VSpacer />

                <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                        <v-btn v-on="on" icon class="mx-0" @click="close" slot="activator">
                            <v-icon small color="blue darken-2">close</v-icon>
                        </v-btn>
                    </template>
                    <span>close</span>
                </v-tooltip>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout row wrap>
                        <v-flex sm12>
                            <ul class="list-group">
                                <li class="list-group-item"><b>Item</b> <span style="float: right">{{ form.item }}</span></li>
                                <li class="list-group-item"><b>Purchased from</b> <span style="float: right">{{ form.purchased_from }}</span></li>
                                <li class="list-group-item"><b>Purchase date</b> <span style="float: right">{{ form.purchase_date }}</span></li>
                                <li class="list-group-item"><b>Amount</b> <span style="float: right">{{ form.amount }}</span></li>
                                <li class="list-group-item"><b>Quantity</b> <span style="float: right">{{ form.qty }}</span></li>
                                <li class="list-group-item"><b>Remark</b> <span style="float: right">{{ form.remark }}</span></li>
                                <li class="list-group-item"><b>Status</b> <span style="float: right">{{ form.status }}</span></li>
                            </ul>


                                <div v-show="disapproved">
                                    <label for="">Reason</label>
                                    <el-input type="textarea" placeholder="Please input" v-model="form.disapprove_reason" maxlength="500" show-word-limit>
                                    </el-input>
                                </div>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn flat v-show="disapproved" color="primary">Submit</v-btn>
                <v-btn flat @click="close" color="primary">Close</v-btn>
                <v-spacer></v-spacer>
                <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                        <v-btn v-on="on" icon class="mx-0" @click="approve" slot="activator">
                            <v-icon small color="blue darken-2">check_circle</v-icon>
                        </v-btn>
                    </template>
                    <span>Approve</span>
                </v-tooltip>
                <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                        <v-btn v-on="on" icon class="mx-0" @click="Disapprove" slot="activator">
                            <v-icon small color="red darken-2">block</v-icon>
                        </v-btn>
                    </template>
                    <span>Disapprove</span>
                </v-tooltip>
            </v-card-actions>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
export default {
    data: () => ({
        dialog: false,
        disapproved: false,
        loading: false,
        form: {},
        payload: {
            model: 'leaves',
        },
    }),
    created() {
        eventBus.$on("openShowTask", data => {
            this.dialog = true;
            this.form = data;
        });
    },

    methods: {
        close() {
            this.dialog = false;
        },
        Disapprove(){
            this.disapproved = true
        },
        approve(){
            this.disapproved = false
        }
    },
};
</script>
