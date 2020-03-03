<template>
<v-content>
    <v-container fluid fill-height>
        <v-layout justify-center align-center wrap>
            <v-flex sm12>
                <v-card style="padding: 20px 0;">
                    <el-breadcrumb separator-class="el-icon-arrow-right">
                        <el-breadcrumb-item :to="{ path: '/' }">Dashboard</el-breadcrumb-item>
                        <el-breadcrumb-item>Status updates</el-breadcrumb-item>
                    </el-breadcrumb>
                </v-card>
            </v-flex>
            <v-flex sm12>
                <v-card style="padding: 10px 0;">
                    <v-layout row>
                        <v-flex sm1 style="margin-left: 10px;">
                            <v-tooltip right>
                                <template v-slot:activator="{ on }">
                                    <v-btn icon v-on="on" slot="activator" class="mx-0" @click="getStatusupdates">
                                        <v-icon color="blue darken-2" small>refresh</v-icon>
                                    </v-btn>
                                </template>
                                <span>Refresh</span>
                            </v-tooltip>
                        </v-flex>
                        <v-flex sm3>
                            <h3>Status updates</h3>
                        </v-flex>
                        <v-flex offset-sm8 sm3>
                            <v-btn color="info" @click="openCreate" text>Update Status</v-btn>
                        </v-flex>
                    </v-layout>
                </v-card>
            </v-flex>
            <v-flex sm12>
                <myFilter></myFilter>
            </v-flex>
            <v-flex sm12>
                <v-pagination v-model="statusupdates.current_page" :length="statusupdates.last_page" total-visible="5" @input="next_page(statusupdates.path, statusupdates.current_page)" circle v-if="statusupdates.last_page > 1"></v-pagination>
            </v-flex>
            <v-flex sm12>
                <vue-good-table class="table-hover" :columns="columns" :rows="statusupdates.data" :search-options="{ enabled: true }" :pagination-options="{enabled: true,mode: 'pages'}" v-loading="isLoading">
                    <template slot="table-row" slot-scope="props">
                        <span v-if="props.column.field == 'created_at'">
                            <span>
                                <el-tag type="success">{{props.formattedRow.created_at}}</el-tag>
                            </span>
                        </span>
                        <!-- <span v-else-if="props.column.field == 'actions'">
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <v-btn v-on="on" icon class="mx-0" @click="openShow(props.row)" slot="activator">
                                        <v-icon small color="blue darken-2">visibility</v-icon>
                                    </v-btn>
                                </template>
                                <span>view {{ props.row.name }}</span>
                            </v-tooltip>
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <v-btn icon v-on="on" class="mx-0" @click="confirm_delete(props.row)" slot="activator">
                                        <v-icon small color="pink darken-2">delete</v-icon>
                                    </v-btn>
                                </template>
                                <span>Delete {{ props.row.name }}</span>
                            </v-tooltip>
                        </span> -->
                        <span v-else>{{ props.formattedRow[props.column.field] }}</span>
                    </template>
                </vue-good-table>
            </v-flex>
        </v-layout>
    </v-container>
    <Create></Create>
    <!-- <Edit></Edit> -->
</v-content>
</template>

<script>
import Create from "./create";
import myFilter from './filter'
export default {
    props: ['user'],
    components: {
        Create,
        myFilter,
    },
    data() {
        return {
            form: {},
            loader: false,
            search: "",
            payload: {
                model: 'statusupdates',
                update_list: 'updateStatusupdateList'
            },
            statusupdates_det: {
                data: []
            },
            statusupdates_search: [],
            temp: "",
            checkedRows: [],
            columns: [{
                    label: "Id#",
                    field: "id",
                    type: "number"
                },
                {
                    label: "Created by",
                    field: "created_by"
                },
                {
                    label: "Waybill no.",
                    field: "bar_code"
                },
                {
                    label: "Comment",
                    field: "comment"
                },
                {
                    label: "Status",
                    field: "delivery_status"
                },
                {
                    label: "Created On",
                    field: "created_at",
                    // type: "date",
                    // dateInputFormat: "YYYY-MM-DD",
                    // dateOutputFormat: "Do MMMM YYYY"
                },
                // {
                //     label: "Actions",
                //     field: "actions",
                //     sortable: false
                // }
            ]
        };
    },
    methods: {
        openCreate() {
            eventBus.$emit("openCreateStatusupdate");
            var payload = {
                model: 'groups',
                update_list: 'updateGroupList',
            }
            this.$store.dispatch("getItems", payload);
        },
        openShow(data) {
            eventBus.$emit("openShowStatusupdate", data);
        },
        getStatusupdates() {
            // var payload = {
            //     url: 'statusupdates',
            //     list: 'updateStatusupdateList',
            // }
            // this.$store.dispatch("getItems", payload);
            eventBus.$emit("StatusupdateRefreshEvent");

        },

        next_page(path, page) {
            var payload = {
                path: path,
                page: page,
            }
            // this.$store.dispatch("nextPage", payload);
            eventBus.$emit("NextPageStatusupdateRefreshEvent", payload);

        },
    },
    computed: {
        statusupdates() {
            return this.$store.getters.statusupdates;
        },
        isLoading() {
            return this.$store.getters.loading;
        }
    },
    mounted() {
        // this.$store.dispatch('getStatusupdates');
        eventBus.$emit("LoadingEvent");
        this.getStatusupdates();
    },
    created() {
        eventBus.$on("statusupdateEvent", data => {
            this.getStatusupdates();
        });

        eventBus.$on("responseChooseEvent", data => {
            console.log(data);
            if (data == "Excel") {
                eventBus.$emit("openEditStatusupdate");
            } else {
                eventBus.$emit("openCreateStatusupdate");
            }
        });
    },

    //   beforeRouteEnter(to, from, next) {
    //     next(vm => {
    //       if (vm.user.can["view statusupdates"]) {
    //         next();
    //       } else {
    //         next("/");
    //       }
    //     });
    //   }
};
</script>

<style scoped>
.el-input--prefix .el-input__inner {
    border-radius: 50px !important;
}

.v-toolbar__content,
.v-toolbar__extension {
    height: auto !important;
}

.v-avatar {
    height: 10px !important;
    width: 10px !important;
    margin-left: 40% !important;
}
</style>
