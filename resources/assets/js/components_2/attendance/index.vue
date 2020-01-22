<template>
<v-content>
    <v-container fluid fill-height>
        <v-layout justify-center align-center wrap>
            <v-flex sm12>
                <v-card style="padding: 20px 0;">
                    <el-breadcrumb separator-class="el-icon-arrow-right">
                        <el-breadcrumb-item :to="{ path: '/' }">Dashboard</el-breadcrumb-item>
                        <el-breadcrumb-item>Attendances</el-breadcrumb-item>
                    </el-breadcrumb>
                </v-card>
            </v-flex>
            <v-flex sm12>
                <!-- <myFilter :form="form" :user="user" style></myFilter> -->
            </v-flex>
            <v-flex sm12>
                <v-card style="padding: 10px 0;">
                    <v-layout row>
                        <v-flex sm1 style="margin-left: 10px;">
                            <v-tooltip right>
                                <template v-slot:activator="{ on }">
                                    <v-btn icon v-on="on" slot="activator" class="mx-0" @click="getAttendances">
                                        <v-icon color="blue darken-2" small>refresh</v-icon>
                                    </v-btn>
                                </template>
                                <span>Refresh</span>
                            </v-tooltip>
                        </v-flex>
                        <v-flex sm2>
                            <h3 style="margin-left: 30px !important;margin-top: 10px;">Attendances</h3>
                        </v-flex>
                    </v-layout>
                </v-card>
            </v-flex>
            <v-flex sm12>
                <v-pagination v-model="attendances.current_page" :length="attendances.last_page" total-visible="5" @input="next_page(attendances.path, attendances.current_page)" circle v-if="attendances.last_page > 1"></v-pagination>
            </v-flex>
            <v-flex sm12>
                <vue-good-table class="table-hover" :columns="columns" :rows="attendances.data" :search-options="{ enabled: true }" :pagination-options="{enabled: true,mode: 'pages'}" v-loading="isLoading" :sort-options="{enabled: true, initialSortBy: {field: 'id', type: 'asc'}}">
                    <template slot="table-row" slot-scope="props">
                        <span v-if="props.column.field == 'created_at'">
                            <span>
                                <el-tag type="success">{{props.formattedRow.created_at}}</el-tag>
                            </span>
                        </span>
                        <span v-else-if="props.column.field == 'hours_worked'">
                            <span>
                                <el-tag type="danger">{{props.row.hours_worked}}</el-tag>
                            </span>
                        </span>
                        <span v-else-if="props.column.field == 'in_time'">
                            <span>
                                <el-tag>{{props.row.in_time}}</el-tag>
                            </span>
                        </span>
                        <span v-else-if="props.column.field == 'out_time'">
                            <span>
                                <el-tag type="info">{{props.row.out_time}}</el-tag>
                            </span>
                        </span>
                        <span v-else-if="props.column.field == 'over_time'">
                            <span>
                                <el-tag type="warning">{{props.row.over_time}}</el-tag>
                            </span>
                        </span>

                        <span v-else>{{ props.formattedRow[props.column.field] }}</span>
                    </template>
                </vue-good-table>
            </v-flex>
        </v-layout>
    </v-container>
</v-content>
</template>

<script>
export default {
    props: ['user'],
    data() {
        return {
            form: {},
            loader: false,
            search: "",
            payload: {
                model: 'attendance',
                update_list: 'updateAttendancesList'
            },
            checkedRows: [],
            columns: [
                {
                    label: "Date",
                    field: "created_at",
                    // type: "date",
                    // dateInputFormat: "YYYY-MM-DD",
                    // dateOutputFormat: "Do MMMM YYYY"
                },
                {
                    label: "In Time",
                    field: "in_time"
                },
                {
                    label: "Out Time",
                    field: "out_time"
                },
                {
                    label: "Hours worked",
                    field: "hours_worked"
                },
                {
                    label: "Over time",
                    field: "over_time"
                },
            ]
        };
    },
    methods: {
        openCreate() {
            eventBus.$emit("openCreateAttendanceType");
        },
        openEdit(data) {
            eventBus.$emit("openEditAttendanceType", data);
        },

        confirm_delete(item) {
            this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
            }).then(() => {
                this.deleteItem(item)
            }).catch(() => {
                this.$message({
                    type: 'error',
                    message: 'Delete canceled'
                });
            });
        },

        deleteItem(item) {
            this.$store.dispatch("deleteItem", "attendances/" + item.id).then(response => {
                this.$message({
                    type: 'success',
                    message: 'Delete completed'
                });
                this.getAttendances();
            });
        },
        getAttendances() {
            this.$store.dispatch("getData", this.payload);
        },
        updateSelected(url) {
            // alert('test')
            if (this.checkedRows.length < 1) {
                eventBus.$emit("errorEvent", "Please select atleast one row");
                return;
            }

            this.$store
                .dispatch("updateSelected", {
                    url,
                    checked: this.checkedRows
                })
                .then(response => {
                    eventBus.$emit("alertRequest", "Updated");
                    this.checkedRows = [];
                    this.getAttendances();
                });
        },
        selectionChanged(params) {
            this.checkedRows = params.selectedRows;
        },

        next_page(path, page) {
            var payload = {
                path: path,
                page: page,
                update_list: 'updateAttendancesList'
            }
            this.$store.dispatch("nextPage", payload);
        }
    },
    computed: {
        attendances() {
            return this.$store.getters.attendances;
        },

        isLoading() {
            return this.$store.getters.loading;
        }
    },
    mounted() {
        // this.$store.dispatch('getAttendances');
        eventBus.$emit("LoadingEvent");
        this.getAttendances();
    },
    created() {
        eventBus.$on("attendanceEvent", data => {
            this.getAttendances();
        });

        eventBus.$on("responseChooseEvent", data => {
            console.log(data);
            if (data == "Excel") {
                eventBus.$emit("openEditAttendance");
            } else {
                eventBus.$emit("openCreateAttendance");
            }
        });
    },

    //   beforeRouteEnter(to, from, next) {
    //     next(vm => {
    //       if (vm.user.can["view attendances"]) {
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

#description_tab span {
    font-style: inherit;
    font-weight: inherit;
    white-space: nowrap;
    text-overflow: ellipsis;
    max-width: 200px;
    overflow: hidden;
    display: block;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}
</style>
