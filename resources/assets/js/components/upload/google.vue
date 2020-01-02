<template>
<v-dialog v-model="dialog" persistent width="400px">
    <v-card>
        <v-card-title>Upload Excel Shipments</v-card-title>
        <v-container grid-list-md>
            <v-card-text>
                <v-layout wrap>
                    <form action="/google_sheets" method="post" enctype="multipart/form-data" style="width: 100%;" ref="google_form">
                        <input type="hidden" name="_token" :value="csrf" />
                        <div class="form-group row">
                            <label for="password" class="col-form-label text-md-right">Client</label>
                            <select class="custom-select custom-select-md" name="client">
                                <option v-for="client in customers" :key="client.id" :value="client.id">{{ client.name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Sheet Name</label>
                            <input type="text" name="sheet_name" class="form-control"  style="width: 100%;"/>
                        </div>
                        <div class="form-group">
                            <label for="">Worksheet</label>
                            <input type="text" name="work_sheet" class="form-control"  style="width: 100%;"/>
                        </div>
                        <!-- <v-btn color="red" darken-1 raised @click="onPickFile" style="color: #fff;">Upload</v-btn>
                        <input type="file" name="shipment" id="csv" ref="fileInput" style="display: none" /> -->
                        <v-divider></v-divider>
                        <v-card-actions>
                            <v-btn flat @click="close">Close</v-btn>
                            <v-spacer></v-spacer>
                            <v-btn flat color="primary" :disabled="loading" @click="disable_btn">Upload</v-btn>
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
    props: ["customers"],
    data() {
        return {
            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            dialog: false,
            loading: false,
            imagePlaced: false
        };
    },
    methods: {
        disable_btn() {
            this.loading = true
            this.$refs.google_form.submit()
        },
        close() {
            this.dialog = false;
        }
    },
    created() {
        eventBus.$on("GoogleUploadEvent", data => {
            this.dialog = true;
        });
    }
};
</script>
