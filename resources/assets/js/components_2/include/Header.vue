<template>
<div>
    <v-app id="inspire">
        <!-- temporary -->
        <vue-topprogress ref="topProgress"></vue-topprogress>
        <v-navigation-drawer right temporary v-model="right" fixed></v-navigation-drawer>
        <!-- temporary -->
        <v-navigation-drawer fixed :color="color" :clipped="$vuetify.breakpoint.lgAndUp" app v-model="drawer">
            <v-list dense id="navigation">
                <v-img :aspect-ratio="16/9" src="/storage/ps/landS.jpg">
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
                        <!-- <v-card style="background: url('storage/ps/landS.jpg')"> -->
                        <router-link to="/" class="v-list__tile v-list__tile--link" v-if="!user.is_client">
                            <div class="v-list__tile__action">
                                <i aria-hidden="true" class="icon material-icons">dashboard</i>
                            </div>
                            <div class="v-list__tile__content">
                                <div class="v-list__tile__title">Dashboard</div>
                            </div>
                        </router-link>
                        <router-link to="/expenses" class="v-list__tile v-list__tile--link" v-if="!user.is_client">
                            <div class="v-list__tile__action">
                                <i aria-hidden="true" class="icon material-icons">dashboard</i>
                            </div>
                            <div class="v-list__tile__content">
                                <div class="v-list__tile__title">Expenses</div>
                            </div>
                        </router-link>
                        <!--  -->
                        <!--  -->
                        <!--  -->
                        <v-list-group prepend-icon="book" v-if="user.can['outscan', 'inscan']">
                            <v-list-tile slot="activator">
                                <v-list-tile-title>Leave</v-list-tile-title>
                            </v-list-tile>

                            <router-link to="/leave" class="v-list__tile theme--light" style="text-decoration: none">
                                <div class="v-list__tile__action">
                                    <i class="fa fa-barcode nav_icon"></i>
                                </div>
                                <div class="v-list__tile__content">
                                    <div class="v-list__tile__title">Leave</div>
                                </div>
                            </router-link>
                            <router-link to="/leave_type" class="v-list__tile theme--light" style="text-decoration: none">
                                <v-list-tile-action>
                                    <v-icon>business</v-icon>
                                </v-list-tile-action>
                                <v-list-tile-title>Leave Type</v-list-tile-title>
                            </router-link>

                        </v-list-group>

                    </v-card>
                </template>
            </v-list>
        </v-navigation-drawer>
        <v-toolbar dark app :color="color" :clipped-left="$vuetify.breakpoint.lgAndUp" fixed>
            <v-toolbar-title style="width: 600px" class="ml-0 pl-3">
                <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>SpeedBall Courier
                <img src="/storage/logo.png" alt style="width: 60px; height: 60px; border-radius: 25%;">
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <div @click="check_in" style="cursor: pointer">
                <digital-clock displaySeconds="true" :blink="true" id="clock" />
            </div>
            <!-- <v-btn color="info"></v-btn> -->
            <v-divider vertical></v-divider>
            <v-divider vertical></v-divider>
            <Logout :user="user"></Logout>

        </v-toolbar>
    </v-app>

    <v-snackbar :timeout="timeout" bottom="bottom" :color="Snackcolor" left="left" v-model="snackbar">
        {{ message }}
        <v-icon dark right>check_circle</v-icon>
    </v-snackbar>
</div>
</template>

<script>
import {
    vueTopprogress
} from "vue-top-progress";
import Logout from "./Logout";

import DigitalClock from "vue-digital-clock";

export default {
    components: {
        vueTopprogress,
        Logout,
        DigitalClock
    },
    props: ["user"],
    data() {
        return {
            role: "",
            Snackcolor: '',
            color: "#132f51",
            dialog: false,
            drawer: true,
            drawerRight: false,
            right: null,
            mode: "",
            company: {},
            snackbar: false,
            timeout: 5000,
            message: "Success",
            location: {},
            location_coordinates: {
                long: 36.909391299999996,
                lat: -1.308786,
            }
        };
    },
    methods: {
        openShipment() {
            eventBus.$emit('addShipmentEvent')
        },

        getCustomer() {
            var payload = {
                url: '/getCustomer',
                list: 'updateClientList',
                data: this.form,
            }
            this.$store.dispatch('getItems', payload)
        },
        close() {
            this.dialog = false;
        },

        showalert(data) {
            this.message = data;
            this.Snackcolor = "indigo";
            this.snackbar = true;
        },

        errorAlert(data) {
            this.message = data;
            this.Snackcolor = "red";
            this.snackbar = true;
            this.icon = 'block'
        },

        reload_page() {
            window.location.href = "/apilogin";
        },
        reload_app_page() {
            window.location.href = "/login";
        },
        check_in() {
            if (navigator.geolocation) {
                var self = this;
                var c = {}
                navigator.geolocation.getCurrentPosition(function (position) {
                    console.log(position);

                    self.location = position;
                    console.log(position.coords);

                    this.getDifference()
                    // console.log(position.coords.latitude, position.coords.longitude)
                })

            }
        },

        getDifference() {
            // console.log(lat1, lng1);

            var lat1 = this.location.lat
            var lng1 = this.location.long

            var lat2 = this.location_coordinates.lat
            var lng2 = this.location_coordinates.long
            console.log(lat1, lng1, lat2, lng2);
            var R = 6371; // km
            var dLat = toRad(lat2 - lat1);
            var dLon = toRad(lon2 - lon1);
            var lat1 = toRad(lat1);
            var lat2 = toRad(lat2);

            var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.sin(dLon / 2) * Math.sin(dLon / 2) * Math.cos(lat1) * Math.cos(lat2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            var d = R * c;
            return d;
        },

        // Converts numeric degrees to radians
        toRad(Value) {
            return Value * Math.PI / 180;
        },
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
        eventBus.$on("reloadRequest", data => {
            this.reload_page()
        });
        eventBus.$on("reloadAppRequest", data => {
            this.reload_app_page()
        });
        eventBus.$on("errorEvent", data => {
            this.errorAlert(data)
        });
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

#clock {
    margin-right: 70px;
    width: 95px;
    font-size: 22px;
    font-family: "LatoWeb";
    height: 45px;
    position: absolute;
    border-radius: 4px;
    right: 25px;
    top: 6px;
    width: 145px;
    padding: 10px;
    padding-right: 5px;
    border: 0;
    box-shadow: 0px 0px 4px 0px #ccc;
    background: #122f51;
    text-align: center;
}
</style>
