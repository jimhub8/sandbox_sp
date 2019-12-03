<template>
<v-dialog v-model="dialog" persistent width="400px">
    <v-card>
        <v-card-title>
            Upload Excel Shipments
        </v-card-title>
        <v-container grid-list-md>
            <v-card-text>
                <v-layout wrap>
                    <form action="/importShipments" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" :value="csrf">
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Client</label>
                            <select class="custom-select custom-select-md col-md-8" name="client">
                                <option v-for="client in clients" :key="client.id" :value="client.id">{{ client.name }}</option>
                            </select>
                        </div>
                        <v-btn color="red" darken-1 raised @click="onPickFile" style="color: #fff;">Upload</v-btn>
                        <input type="file" name="shipment" id="csv" ref="fileInput" style="display: none">
                        <v-divider></v-divider>
                        <v-card-actions>
                            <v-btn flat @click="close">Close</v-btn>
                            <v-spacer></v-spacer>
                            <v-btn flat type="submit" color="primary">Upload</v-btn>
                        </v-card-actions>
                    </form>
                </v-layout>
            </v-card-text>
        </v-container>
    </v-card>
</v-dialog>
</template>

<script>
export default {
    data() {
        return {
            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            dialog: false,
            imagePlaced: false,
            AllCountries: [],
        }
    },
    methods: {
        onPickFile() {
            this.$refs.fileInput.click()
        },
        close() {
            this.dialog = false
        },
    },
    created() {
        eventBus.$on('uploadOrdersEvent', data => {
            this.dialog = true
        })
    },
    computed: {
        clients() {
            return this.$store.getters.clients
        },
    },
}
</script>
