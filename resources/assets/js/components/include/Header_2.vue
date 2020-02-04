<template>
<v-app id="inspire">
    <v-navigation-drawer v-model="drawer" :clipped="clipped" app>

        <v-list dense id="navigation">
            <v-img :aspect-ratio="16/9" src="/storage/landS.jpg">
                <v-layout pa-2 column fill-height class="lightbox white--text">
                    <v-spacer></v-spacer>
                    <v-flex shrink>
                        <div class="subheading">{{ user.name }}</div>
                        <div class="body-1">{{ user.email }}</div>
                    </v-flex>
                </v-layout>
            </v-img>
            <template>
                <v-card>
                    <router-link to="/" class="v-list-item v-list-item--link theme--light">
                        <div class="v-list__tile__action">
                            <v-icon>dashboard</v-icon>
                        </div>
                        <div class="v-list-item__content">
                            <div class="v-list-item__title">Dashboard</div>
                        </div>
                    </router-link>
                    <router-link to="/shipments" class="v-list-item v-list-item--link theme--light"  v-if="user.can['view shipments'] || user.is_client">
                        <div class="v-list__tile__action">
                            <v-icon>local_shipping</v-icon>
                        </div>
                        <div class="v-list-item__content">
                            <div class="v-list-item__title">My Shipments</div>
                        </div>
                    </router-link>
                    <router-link to="/profile" class="v-list-item v-list-item--link theme--light" v-if="!user.is_client">
                        <div class="v-list__tile__action">
                            <v-icon>account_circle</v-icon>
                        </div>
                        <div class="v-list-item__content">
                            <div class="v-list-item__title">My Profile</div>
                        </div>
                    </router-link>

                    <router-link to="/reports" class="v-list-item v-list-item--link theme--light">
                        <div class="v-list__tile__action">
                            <v-icon>book</v-icon>
                        </div>
                        <div class="v-list-item__content">
                            <div class="v-list-item__title">Reports</div>
                        </div>
                    </router-link>

                    <v-list-group prepend-icon="account_circle">
                        <template v-slot:activator>
                            <v-list-item-title>Print</v-list-item-title>
                        </template>
                        <router-link to="/print" class="v-list-item v-list-item--link theme--light">
                            <div class="v-list__tile__action">
                                <v-icon>people_outline</v-icon>
                            </div>
                            <div class="v-list-item__content">
                                <div class="v-list-item__title">Users</div>
                            </div>
                        </router-link>
                        <router-link to="/roles" class="v-list-item v-list-item--link theme--light">
                            <div class="v-list__tile__action">
                                <v-icon>gavel</v-icon>
                            </div>
                            <div class="v-list-item__content">
                                <div class="v-list-item__title">Roles</div>
                            </div>
                        </router-link>
                    </v-list-group>

                    <v-list-group prepend-icon="account_circle">
                        <template v-slot:activator>
                            <v-list-item-title>Users</v-list-item-title>
                        </template>
                        <router-link to="/users" class="v-list-item v-list-item--link theme--light">
                            <div class="v-list__tile__action">
                                <v-icon>people_outline</v-icon>
                            </div>
                            <div class="v-list-item__content">
                                <div class="v-list-item__title">Users</div>
                            </div>
                        </router-link>
                        <router-link to="/roles" class="v-list-item v-list-item--link theme--light">
                            <div class="v-list__tile__action">
                                <v-icon>gavel</v-icon>
                            </div>
                            <div class="v-list-item__content">
                                <div class="v-list-item__title">Roles</div>
                            </div>
                        </router-link>
                    </v-list-group>
                </v-card>
            </template>
        </v-list>
    </v-navigation-drawer>

    <v-app-bar :clipped-left="clipped" app color="blue darken-3" dark>
        <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
        <v-toolbar-title style="width: 300px" class="ml-0 pl-4">
            <img src="/storage/logo.jpg" alt style="width: 130px; height: 60px;border-radius: 20px;">
        </v-toolbar-title>
        <v-spacer />
        <Logout :user="user"></Logout>
        <!-- <VDivider vertical style="margin-top: 0px;" /> -->

    </v-app-bar>

    <v-snackbar :timeout="timeout" bottom :color="Snackcolor" right v-model="snackbar">
        {{ message }}
        <v-icon dark right>{{ icon }}</v-icon>
    </v-snackbar>
    <v-footer style="background: #e2e0e0 !important;" app>
        <span style="color: #000; margin: auto;">Mft fulfillment center &copy; {{ new Date().getFullYear() }}</span>
    </v-footer>
    <!-- <myDrawerOpen :user="user"></myDrawerOpen> -->

</v-app>
</template>
<script>
import Logout from "./Logout";
// import myDrawerOpen from '../drawer/Drawer'
export default {
    components: {
        Logout,
    },
    props: ["user"],
    data() {
        return {
            role: "",
            Snackcolor: '',
            color: "#1867c0",
            clipped: false,
            loading: false,
            dialog: false,
            mini_drawer: true,
            drawer: true,
            drawerRight: false,
            right: null,
            mode: "",
            company: {},
            AllBranches: [],
            Allcustomers: [],
            AllDrivers: [],
            snackbar: false,
            timeout: 5000,
            message: "Success",
            fullscreenLoading: false,
            icon: "",
        };
    },
    methods: {
        openShipment() {
            this.dialog = true;
            this.getBranch();
            this.getCustomer();
            this.getDrivers();
        },

        getCustomer() {
            axios
                .get("/getCustomer")
                .then(response => {
                    this.Allcustomers = response.data;
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
        },
        getDrivers() {
            axios
                .get("/getDrivers")
                .then(response => {
                    this.AllDrivers = response.data;
                })
                .catch(error => {
                    // console.log(error);
                    this.errors = error.response.data.errors;
                });
        },
        getBranch() {
            axios
                .get("/getBranchEger")
                .then(response => {
                    this.AllBranches = response.data;
                })
                .catch(error => {
                    // console.log(error);
                    this.errors = error.response.data.errors;
                });
        },
        close() {
            this.dialog = false;
        },

        showalert(data) {
            // this.message = data;
            // this.Snackcolor = "indigo";
            // this.snackbar = true;

            this.$message({
              type: 'success',
              message: data
            });
        },
        showError(data) {
            // this.message = data;
            // this.Snackcolor = "indigo";
            // this.snackbar = true;

            this.$message({
              type: 'error',
              message: data
            });
        },
        openFullScreen() {
            this.loading = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
        },
        closeFullScreen() {
            this.loading.close();
        }
    },
    created() {
        eventBus.$on("progressEvent", data => {
            this.$refs.topProgress.start();
        });
        eventBus.$on("StoprogEvent", data => {
            this.$refs.topProgress.done();
        });
        eventBus.$on("alertRequest", data => {
            this.showalert(data)
        });
        eventBus.$on("errorEvent", data => {
            this.showError(data)
        });
        eventBus.$on("LoadingEvent", data => {
            // this.openFullScreen(data)
        });
        eventBus.$on("stopLoadingEvent", data => {
            // this.closeFullScreen(data)
        });
    },
    computed: {
        // loadpage() {
        //     if(this.$store.getters.isLoading) {
        //         return this.openFullScreen()
        //     }
        //     return this.$store.getters.isLoading
        // }
    },

};
</script>
<style scoped>
.v-expansion-panel__container:hover {
    border-radius: 10px !important;
    width: 90% !important;
    margin-left: 15px !important;
    background: #e3edfe !important;
    color: #1a73e8 !important;
}

.theme--light {
    background-color: #212120 !important;
    /* background: url('storage/logo1.jpg') !important; */
    color: #fff !important;
}

.v-toolbar[data-booted=true] {
    transition: .2s cubic-bezier(.4, 0, .2, 1);
    z-index: 100 !important;
}

.theme--light[data-v-67cb1297] {
    z-index: 101 !important;
}

.theme--dark.v-btn:not(.v-btn--text):not(.v-btn--text):not(.v-btn--outlined) {
    background-color: transparent !important;
}

.theme--light.v-application {
    /* margin-top: -650px; */
}
</style>
