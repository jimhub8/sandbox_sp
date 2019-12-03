<template>
<div>
    <v-content>
        <v-container fluid fill-height>
            <!-- Data table -->
            <div style="width: 100%;">
                <div v-show="loader" style="text-align: center">
                    <v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
                </div>
                <div v-show="!loader">
                    <v-spacer></v-spacer>
                    <v-layout wrap>
                        <v-flex sm6>
                            <v-pagination v-model="shipments.current_page" :length="shipments.last_page" total-visible="5" @input="next()" circle v-if="shipments.last_page > 1"></v-pagination>
                        </v-flex>
                        <v-flex sm6 id="input-cont">
                            <v-text-field v-model="glsearch.search" append-icon="search" label="Global Search" single-line hide-details @keyup.enter="itemSearch"></v-text-field>
                        </v-flex>
                    </v-layout>
                    <v-card style="background: rgba(5, 117, 230, 0.16); padding: 10px 0;">
                        <v-layout wrap>
                            <v-flex xs4 sm2 v-if="user.can['filter by country']">
                                <el-select v-model="form.country_id" clearable filterable placeholder="Select Country" @change="changeCat">
                                    <el-option v-for="item in countries" :key="item.id" :label="item.country_name" :value="item.id">
                                    </el-option>
                                </el-select>
                            </v-flex>
                            <v-flex xs4 sm2 offset-sm1>
                                <el-select v-model="form.branch_id" clearable filterable placeholder="Select Branch">
                                    <el-option v-for="item in branches" :key="item.id" :label="item.branch_name" :value="item.id">
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
                                <el-select v-model="form.client_id" clearable filterable placeholder="Select Client">
                                    <el-option v-for="item in clients" :key="item.id" :label="item.name" :value="item.id">
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
                    <v-card-title>
                        <download-excel :data="shipments.data" :fields="json_fields">
                            Export
                            <img src="/storage/csv.png" style="width: 30px; height: 30px; cursor: pointer;">
                        </download-excel>
                        <v-btn color="primary" flat @click="openShipment" v-if="user.can['create shipments']">Add Shipment</v-btn>
                        <v-btn color="primary" flat @click="ShipmentCsv" v-if="user.can['upload excel']">Upload Excel</v-btn>
                        <v-btn color="primary" flat @click="send_sms" v-if="user.can['send sms']">Send Sms</v-btn>
                        <v-btn color="primary" flat @click="google_upload" v-if="user.can['send sms']">Upload Orders</v-btn>
                        <v-tooltip right>
                            <template v-slot:activator="{ on }">
                                <v-btn icon v-on="on" slot="activator" class="mx-0" @click="sortItem">
                                    <v-icon color="blue darken-2" small>refresh</v-icon>
                                </v-btn>
                            </template>
                            <span>Refresh</span>
                        </v-tooltip>
                        <v-spacer></v-spacer>
                        <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details></v-text-field>
                    </v-card-title>
                    <v-data-table :headers="headers" :items="shipments.data" :search="search" counter select-all class="elevation-1" v-model="selected" :loading="loading">
                        <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
                        <template slot="items" slot-scope="props">
                            <td>
                                <v-checkbox v-model="props.selected" primary></v-checkbox>
                            </td>
                            <td class="text-xs-right">{{ props.item.created_at }}</td>
                            <td>
                                {{ props.item.bar_code }}
                            </td>
                            <td class="text-xs-right">{{ props.item.client_name }}</td>
                            <td class="text-xs-right">{{ props.item.client_phone }}</td>
                            <td class="text-xs-right">{{ props.item.client_email }}</td>
                            <td class="text-xs-right">{{ props.item.client_address }}</td>
                            <td class="text-xs-right">{{ props.item.client_city }}</td>
                            <td class="text-xs-right">{{ props.item.amount_ordered }} | {{ props.item.cod_amount }}</td>
                            <td class="text-xs-right">{{ props.item.status }}</td>
                            <td class="text-xs-right">{{ props.item.derivery_date }}</td>
                            <td class="text-xs-right" v-if="props.item.printReceipt === '1' || props.item.printReceipt === 1" style="background: rgba(23, 193, 60, 0.76);">
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-btn icon v-on="on" class="mx-0" @click="notPrinted(props.item)" slot="activator" v-if="user.can['print waybill']">
                                            <v-icon color="white darken-2">check_circle</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Mark Not Printed</span>
                                </v-tooltip>
                            </td>
                            <td class="text-xs-right" v-else>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-btn icon v-on="on" class="mx-0" @click="printed(props.item)" slot="activator" v-if="user.can['print waybill']">
                                            <v-icon color="blue darken-2">block</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Mark Printed</span>
                                </v-tooltip>
                            </td>
                            <td class="justify-center layout px-0">
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-btn icon v-on="on" class="mx-0" @click="editItem(props.item)" slot="activator" v-if="user.can['edit shipments']">
                                            <v-icon color="blue darken-2" small>edit</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Edit</span>
                                </v-tooltip>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-btn icon v-on="on" class="mx-0" @click="UpdateItems(props.item)" slot="activator" v-if="user.can['update status']">
                                            <v-icon color="blue darken-2" dark small>save</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Update Status</span>
                                </v-tooltip>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-btn icon v-on="on" class="mx-0" @click="deleteItem(props.item)" slot="activator" v-if="user.can['delete shipments']">
                                            <v-icon color="pink darken-2" small>delete</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Delete</span>
                                </v-tooltip>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-btn icon v-on="on" class="mx-0" @click="TzshowDetails(props.item)" slot="activator" v-if="user.can['single print'] && user.country_name === 'Tanzania'">
                                            <v-icon color="info darken-2" small>visibility</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Print</span>
                                </v-tooltip>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-btn icon v-on="on" class="mx-0" @click="showDetails(props.item)" slot="activator" v-if="user.can['single print'] && user.country_name === 'Kenya'">
                                            <v-icon color="info darken-2" small>visibility</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Print</span>
                                </v-tooltip>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-btn icon v-on="on" class="mx-0" @click="UgshowDetails(props.item)" slot="activator" v-if="user.can['single print'] && user.country_name === 'Uganda'">
                                            <v-icon color="info darken-2" small>visibility</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Print</span>
                                </v-tooltip>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-btn icon v-on="on" class="mx-0" @click="RwshowDetails(props.item)" slot="activator" v-if="user.can['single print'] && user.country_name === 'Rwanda'">
                                            <v-icon color="info darken-2" small>visibility</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Print</span>
                                </v-tooltip>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-btn icon v-on="on" class="mx-0" @click="ShipmentTrack(props.item)" slot="activator" v-if="user.can['shipment status']">
                                            <v-icon color="teal darken-2" small>call_split</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>View Status</span>
                                </v-tooltip>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-btn icon v-on="on" class="mx-0" @click="Shipcharges(props.item)" slot="activator" v-if="user.can['update charges']">
                                            <v-icon color="indigo darken-2" small>attach_money</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Charges</span>
                                </v-tooltip>
                            </td>
                        </template>
                        <v-alert slot="no-results" :value="true" color="error" icon="warning">
                            Your search for "{{ search }}" found no results.
                        </v-alert>
                    </v-data-table>
                    <v-btn color="primary" raised style="float: right;" @click="UpdateShipmentStatus" v-if="user.can['assign']">Update Status</v-btn>
                    <v-btn color="info" raised style="float: right;" @click="assignDriver" v-if="user.can['assign']">Assign Rider</v-btn>
                    <v-btn color="success" raised style="float: right;" @click="assignBranch" v-if="user.can['assign']">Assign Branch</v-btn>
                </div>
            </div>
            <!-- Data table -->
        </v-container>
    </v-content>
    <AddShipment :addShipment="dialog" @alertRequest="showalert" :Allcustomer="clients" :user="user" :role="role" :countries="countries" :AllDrivers="AllDrivers"></AddShipment>
    <EditShipment :EditShipment="dialog1" @alertRequest="showalert" :Allcustomer="clients" :user="user" :role="role" :countries="countries" :AllDrivers="AllDrivers" :form="editedItem"></EditShipment>
    <ShowShipment :element="element" :customers="clients" :showItems="showItem"></ShowShipment>
    <TzShipment></TzShipment>
    <RwPrintSpdf></RwPrintSpdf>
    <UgPrintSpdf></UgPrintSpdf>
    <UpdateShipment :UpdateShipment="updateModal" :markers="markers" :updateitedItem="updateitedItem" @alertRequest="showalert"></UpdateShipment>
    <UpdateShipmentStatus :UpdateShipmentStatus="UpdateShipmentModel" @alertRequest="showalert" :updateitedItem="editedItem" :selectedItems="selected"></UpdateShipmentStatus>
    <AssignDriver :AllDrivers="AllDrivers" :OpenAssignDriver="AssignDriverModel" @alertRequest="showalert" :updateitedItem="editedItem" :selectedItems="selected"></AssignDriver>
    <AssignBranch :countries="countries" :OpenAssignBranch="AssignBranchModel" @alertRequest="showalert" :updateitedItem="editedItem" :selectedItems="selected"></AssignBranch>
    <TrackShipment @refreshRequest="sortItem" :shipments="updateitedItem" :OpenTrackBranch="trackModel" @alertRequest="showalert" :updateitedItem="editedItem" :selectedItems="selected" :user="user"></TrackShipment>
    <myCsvFile></myCsvFile>
    <mySCharges></mySCharges>
    <mySms></mySms>
    <myGoogle :customers="clients"></myGoogle>
    <v-snackbar :timeout="timeout" bottom="bottom" :color="color" left="left" v-model="snackbar">
        {{ message }}
        <v-icon dark right>check_circle</v-icon>
    </v-snackbar>
</div>
</template>

<script>
import VueBarcode from "vue-barcode";
import AddShipment from "./Addshipment";
import EditShipment from "./EditShipment";
import ShowShipment from "./print/PrintSpdf";
import TzShipment from "./print/TzSprint";
import RwPrintSpdf from "./print/RwPrintSpdf";
import UgPrintSpdf from "./print/UgPrintSpdf";
import UpdateShipment from "./UpdateShipment";
import UpdateShipmentStatus from "./UpdateShipmentStatus";
import AssignDriver from "./AssignDriver";
import AssignBranch from "./AssignBranch";
import TrackShipment from "./TrackShipment";
import myCsvFile from "../csv/CsvFile";
import mySCharges from "./Charge";
import myGoogle from '../upload/google'
import mySms from './sms/Sms'
export default {
    props: ["user", "role"],
    components: {
        AddShipment,
        ShowShipment,
        EditShipment,
        barcode: VueBarcode,
        UpdateShipmentStatus,
        UpdateShipment,
        AssignDriver,
        AssignBranch,
        TrackShipment,
        myCsvFile,
        mySCharges,
        TzShipment,
        UgPrintSpdf,
        RwPrintSpdf,
        mySms,
        myGoogle,
    },
    data() {
        return {
            trackModel: false,
            chargeModal: false,
            printColor: "",
            printModal: false,
            mloading: false,
            timer: "",
            AllDrivers: [],
            element: [],
            glsearch: {
                search: ''
            },
            selectCountry: {
                country_id: "All",
                id: "all"
            },
            select: {
                branch_name: "All",
                id: "all"
            },
            selectItem: {
                name: "All"
            },
            json_fields: {
                "Order Id": "order_id",
                "Sender Name": "sender_name",
                "Sender Email": "sender_email",
                "Sender Phone": "sender_phone",
                "Sender City": "sender_city",
                "Sender Address": "sender_address",
                Driver: "driver",
                "Client Name": "client_name",
                "Client Email": "client_email",
                "Client Phone": "client_phone",
                "Client City": "client_city",
                "Client Address": "client_address",
                "Derivery Status": "status",
                From: "sender_address",
                To: "client_address",
                "Derivery Date": "derivery_date",
                "Derivery Time": "derivery_time",
                Quantity: "amount_ordered",
                "COD Amount": "cod_amount",
                "Booking Date": "booking_date",
                "Special Instructions": "speciial_instruction"
            },
            snackbar: false,
            timeout: 5000,
            message: "Success",
            color: "black",
            loader: false,
            updateModal: false,
            AssignBranchModel: false,
            UpdateShipmentModel: false,
            showdialog1: false,
            search: "",
            temp: "",
            dialog: false,
            dialog1: false,
            pdialog2: false,
            AssignDriverModel: false,
            updateitedItem: {},
            AllProducts: {},
            newProducts: {},
            coordinatesArr: [],
            showItem: {},
            editedItem: {},
            between: {
                start: 1,
                end: 500
            },
            form: {
                start_date: "",
                end_date: "",
                status: null,
                country_id: null,
                branch_id: null,
            },
            headers: [{
                    text: "Waybill Date",
                    value: "created_at"
                },
                {
                    text: "Waybill Number",
                    value: "bar_code"
                },
                {
                    text: "Client",
                    value: "client_name"
                },
                {
                    text: "Client Phone",
                    value: "client_phone"
                },
                {
                    text: "Client Email",
                    value: "client_email"
                },
                {
                    text: "Client Address",
                    value: "client_address"
                },
                {
                    text: "Client City",
                    value: "client_city"
                },
                {
                    text: "Qty&COD",
                    value: "amount_ordered"
                },
                {
                    text: "Status",
                    value: "status"
                },
                {
                    text: "Delivery Date",
                    value: "derivery_date"
                },
                {
                    text: "Receipt",
                    value: "printReceipt"
                },
                {
                    text: "Actions",
                    sortable: false
                }
            ],
            selected: [],
            AllRows: [],
            selectStatus: [],
            direction: "left",
            shipment: {},
            markers: [],
            shipmentsCount: null
        };
    },
    methods: {
        send_sms() {
            eventBus.$emit('sendSmsEvent', this.shipments.data)
        },
        google_upload() {
            eventBus.$emit('GoogleUploadEvent')
        },
        UpdateStatus() {
            axios
                .post(`/updateStatus/${this.updateitedItem.id}`, {
                    formobg: this.$data.updateitedItem,
                    address: this.$data.address
                })
                .then(response => {
                    this.resetForm();
                    this.message = "Updated";
                    this.color = "black";
                    this.snackbar = true;
                });
        },
        resetForm() {
            this.form = Object.assign({}, this.defaultForm);
            this.$refs.form.reset();
        },
        openShipment() {
            eventBus.$emit('addShipmentEvent')
        },
        addProduct() {
            axios
                .post(`/productAdd/${this.updateitedItem.id}`, this.$data.form)
                .then(response => {
                    // console.log(response.data);
                    this.message = "Product Added";
                    this.color = "black";
                    this.snackbar = true;
                    this.resetForm();
                    this.AllProducts.push(response.data);
                    this.pdialog2 = false;
                });
        },
        openProduct(updateitedItem) {
            this.pdialog2 = true;
        },
        UpdateItems(item) {
            eventBus.$emit("UpdateStatusEvent", item);
            // axios
            //     .post(`/getcoordinatesArray/${item.id}`)
            //     .then(response => (this.markers = response.data))
            //     .catch(error => (this.errors = error.response.data.errors));
            // console.log(this.coordinatesArr);
            // this.updateitedItem = Object.assign({}, item);
            // this.updatedIndex = this.shipments.data.indexOf(item);
            // this.updateModal = true;
        },
        editItem(item) {
            eventBus.$emit("updateOrdersEvent", item);
        },
        showDetails(item) {
            eventBus.$emit("printEvent", item);
        },
        TzshowDetails(item) {
            eventBus.$emit("TzprintEvent", item);
        },
        UgshowDetails(item) {
            eventBus.$emit("UgprintEvent", item);
        },
        RwshowDetails(item) {
            eventBus.$emit("RwprintEvent", item);
        },
        ShipmentTrack(item) {
            eventBus.$emit('TrackShipEvent', item);
        },
        Shipcharges(item) {
            eventBus.$emit('ShipchargesEvent', item);
            // this.shipment = Object.assign({}, item);
            // this.editedIndex = this.shipments.data.indexOf(item);
            // this.chargeModal = true;
        },
        ShipmentCsv() {
            eventBus.$emit('uploadOrdersEvent')
            // this.getCustomer();
        },
        deleteItem(item) {
            const index = this.shipments.data.indexOf(item);
            if (confirm("Are you sure you want to delete this item?")) {
                axios
                    .delete(`/shipment/${item.id}`)
                    .then(response => {
                        this.message = "Deleted";
                        this.color = "black";
                        this.snackbar = true;
                        this.shipments.data.splice(index, 1);
                        // console.log(response);
                    })
                    .catch(error => (this.errors = error.response.data.errors));
            }
        },
        notPrinted(item) {
            this.editedItem = Object.assign({}, item);
            this.editedIndex = this.shipments.data.indexOf(item);
            axios
                .post(`/notprinted/${item.id}`)
                .then(response => {
                    this.sortItem();
                    this.message = "Not Printed";
                    this.color = "black";
                    this.snackbar = true;
                })
                .catch(error => (this.errors = error.response.data.errors));
        },
        printed(item) {
            this.editedItem = Object.assign({}, item);
            this.editedIndex = this.shipments.data.indexOf(item);
            axios
                .post(`/printed/${item.id}`)
                .then(response => {
                    this.sortItem();
                    this.message = "Printed";
                    this.color = "black";
                    this.snackbar = true;
                })
                .catch(error => (this.errors = error.response.data.errors));
        },
        pending(item) {
            this.editedItem = Object.assign({}, item);
            this.editedIndex = this.shipments.data.indexOf(item);
            (this.mloading = true),
            axios
                .post(`/pending/${item.id}`)
                .then(response => {
                    (this.mloading = false), (this.message = "Pending");
                    this.color = "black";
                    this.snackbar = true;
                    Object.assign(this.shipments.data[this.editedIndex], this.editedItem);
                })
                .catch(error => (this.errors = error.response.data.errors));
        },
        updateCancelled() {
            axios
                .get("/updateCancelled")
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
        },
        UpdateShipmentStatus(item) {
            if (this.selected.length < 1) {
                this.message = "please select a shipment";
                this.color = "red";
                this.snackbar = true;
            } else {
                eventBus.$emit('UpdateShipmentModelEvent')
            }
        },
        assignDriver() {
            if (this.selected.length < 1) {
                this.message = "please select a shipment";
                this.color = "red";
                this.snackbar = true;
            } else {
                eventBus.$emit('AssignDriverlEvent')
                // this.AssignDriverModel = true;
                this.getDrivers();
            }
        },
        assignBranch() {
            if (this.selected.length < 1) {
                this.message = "please select a shipment";
                this.color = "red";
                this.snackbar = true;
            } else {
                eventBus.$emit('AssignBranchlEvent')
                // this.AssignBranchModel = true;
                // this.getBranch();
            }
        },
        assignPrint() {
            if (this.selected.length < 1) {
                this.message = "please select a shipment";
                this.color = "red";
                this.snackbar = true;
            } else {
                this.printModal = true;
            }
        },
        getTotal() {
            this.gettotlaAmount = true;
            if (this.form.quantity && this.form.price) {
                this.form.total = this.form.quantity * this.form.price;
            } else {
                this.form.total = 0;
            }
        },
        showalert() {
            this.message = "success";
            this.color = "indigo";
            this.snackbar = true;
        },
        sortItem() {
            // alert('test')
            if (this.shipments.current_page > 1) {
                this.next()
                return
            }
            var payload = {
                url: '/filterShipment',
                list: 'updateShipmentsList',
                data: this.form,
            }
            this.$store.dispatch('filterItems', payload)
            this.loader = false;
        },
        next() {
            var payload = {
                path: this.shipments.path,
                page: this.shipments.current_page,
                data: this.form,
                list: 'updateShipmentsList',
            }
            this.$store.dispatch('nextPage', payload)
        },

        filReset() {
            this.selectAss = {
                Assigned: "All"
            };
            this.selectItem = {
                name: "All"
            };
            this.selectCountry = {
                country_id: "All",
                id: "all"
            };
            this.getBranch()
            this.form.start_date = this.form.end_date = "";
            this.sortItem();
        },

        getCustomer() {
            var payload = {
                url: '/getCustomer',
                list: 'updateClientList',
                data: this.form,
            }
            this.$store.dispatch('getItems', payload)
        },
        getDrivers() {
            var payload = {
                url: '/getDrivers',
                list: 'updateRidersList',
                data: this.form,
            }
            this.$store.dispatch('getItems', payload)
        },
        getBranch() {
            var payload = {
                url: '/getBranchEger',
                list: 'updateBranchesList',
                data: this.form,
            }
            this.$store.dispatch('getItems', payload)
        },
        itemSearch() {
            var payload = {
                url: '/glSearch/' + this.glsearch.search,
                list: 'updateShipmentsList',
            }
            this.$store.dispatch('searchItems', payload)
        },
        changeCat(item) {
            var payload = {
                url: '/country_branch/' + item,
                list: 'updateBranchesList',
            }
            this.$store.dispatch('getItems', payload)
        },
        getStatus() {
            var payload = {
                url: '/getStatuses',
                list: 'updateStatusList',
            }
            this.$store.dispatch('getItems', payload)
        },
        getCountry() {
            var payload = {
                url: '/getCountry',
                list: 'updateCountryList',
                data: this.form,
            }
            this.$store.dispatch('getItems', payload)
        }
    },
    created() {
        eventBus.$on("selectClear", data => {
            this.selected = [];
        });

        eventBus.$on("refreshShipEvent", data => {
            this.sortItem()

        });
        eventBus.$on("TrackEvent", data => {
            this.updateModal = true;
        });
    },
    beforeDestroy() {
        clearInterval(this.timer);
    },
    mounted() {

        this.loader = true;
        this.sortItem();
        this.getStatus();
        this.getCustomer();
        this.getBranch();
        this.getCountry()
        axios
            .get("/getShipmentsCount")
            .then(response => {
                this.shipmentsCount = response.data;
            })
            .catch(error => {
                this.errors = error.response.data.errors;
            });
    },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            if (vm.user.can["view shipments"]) {
                next();
            } else {
                next("/unauthorized");
            }
        });
    },
    computed: {
        shipments() {
            return this.$store.getters.shipments
        },
        clients() {
            return this.$store.getters.clients
        },
        countries() {
            return this.$store.getters.countries
        },
        branches() {
            return this.$store.getters.branches
        },
        riders() {
            return this.$store.getters.riders
        },
        statuses() {
            return this.$store.getters.statuses
        },
        loading() {
            return this.$store.getters.loading
        },
    },

};
</script>

<style>
#create .speed-dial {
    position: absolute;
}

#create .btn--floating {
    position: relative;
}

.btn__content i {
    color: #fff !important;
    width: 50px;
}

.speed-dial__list i {
    color: #fff !important;
}

table.v-table tbody td:first-child,
table.v-table tbody td:not(:first-child),
table.v-table tbody th:first-child,
table.v-table tbody th:not(:first-child),
table.v-table thead td:first-child,
table.v-table thead td:not(:first-child),
table.v-table thead th:first-child,
table.v-table thead th:not(:first-child) {
    padding: 0 6px;
    font-size: 14px !important;
}

#input-cont .v-input__control {
    margin-top: -20px !important;
}
</style>
