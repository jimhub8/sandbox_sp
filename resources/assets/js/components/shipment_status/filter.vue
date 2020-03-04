<template>
<div>
    <v-card style="background: rgba(5, 117, 230, 0.16); padding: 10px 0;">
        <v-layout wrap>
            <v-flex xs4 sm2>
                <el-select v-model="form.country_id" clearable filterable placeholder="Select Country" @change="changeCat">
                    <el-option v-for="item in countries" :key="item.id" :label="item.country_name" :value="item.id">
                    </el-option>
                </el-select>
            </v-flex>
            <v-flex xs4 sm2 offset-sm1>
                <el-select v-model="form.rider_id" clearable filterable placeholder="Select rider">
                    <el-option v-for="item in riders" :key="item.id" :label="item.name" :value="item.id">
                    </el-option>
                </el-select>
            </v-flex>
            <v-flex xs4 sm2 offset-sm1>
                <el-select v-model="form.status" clearable filterable placeholder="Select Status">
                    <el-option v-for="item in statuses" :key="item.name" :label="item.name" :value="item.name">
                    </el-option>
                </el-select>
            </v-flex>
            <v-flex xs4 sm2 offset-sm1>
                <el-select v-model="form.branch_id" clearable filterable placeholder="Select Branch">
                    <el-option v-for="item in branches" :key="item.id" :label="item.branch_name" :value="item.id">
                    </el-option>
                </el-select>
            </v-flex>
            <!-- <v-spacer></v-spacer> -->
            <v-flex xs12 sm2>
                <v-text-field label="Start Date" v-model="form.start_date" color="blue darken-2" type="date" required></v-text-field>
            </v-flex>
            <v-flex xs12 sm2 offset-sm1>
                <v-text-field label="End Date" v-model="form.end_date" color="blue darken-2" type="date" required></v-text-field>
            </v-flex>
            <!-- <v-spacer></v-spacer> -->
            <v-flex xs4 sm1>
                <v-btn raised color="info" @click="sortItem">Filter</v-btn>
            </v-flex>
            <v-flex xs4 sm1>
                <v-btn raised color="info" @click="filReset">Reset</v-btn>
            </v-flex>
        </v-layout>
    </v-card>
</div>
</template>

<script>
export default {
    data: () => ({
        dialog: false,
        loading: false,
        form: {
            rider_id: null,
            status: null,
            client_id: null,
        },
    }),
    methods: {
        sortItem() {
            var payload = {
                url: '/filter_updates',
                data: this.form,
                list: 'updateStatusupdateList',
            }
            this.$store.dispatch("filterItems", payload);
        },
        filReset() {
            this.form = {
                rider_id: null,
                status: null,
                client_id: null,
            }
        },

        next_page(data) {
            var payload = {
                path: data.path,
                page: data.page,
                data: this.form,
                list: 'updateStatusupdateList'
            }
            this.$store.dispatch("nextPage", payload);
        },
    },
    created() {
        eventBus.$on('StatusupdateRefreshEvent', data => {
            this.sortItem()
        });
        eventBus.$on('NextPageStatusupdateRefreshEvent', data => {
            this.next_page(data)
        });
    },

    mounted() {
        // this.sortItem();
    },

    computed: {
        statuses() {
            return this.$store.getters.statuses
        },
        riders() {
            return this.$store.getters.riders
        },
        branches() {
            return this.$store.getters.branches
        },
        countries() {
            return this.$store.getters.countries
        }
    },

};
</script>
