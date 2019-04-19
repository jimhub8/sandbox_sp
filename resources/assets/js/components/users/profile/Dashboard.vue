<template>
<v-layout wrap style="width: 80vw; margin-top: 20px; padding: 20px;">
    <v-flex sm6>
        <v-card>
            <v-card-title>
                <img :src="user.profile" alt="user.name" style="border-radius: 25px;height: 30px;">
                <v-spacer></v-spacer>
                <h3>Welcome {{ user.name }}!</h3>
            </v-card-title>
            <v-divider> </v-divider>
            <v-card-text>

                <h2> Your Shipto Address</h2>
                <h5>{{ user.name }}</h5>
                <v-btn flat color="primary">Choose your address</v-btn>
            </v-card-text>
            <v-card-actions>

            </v-card-actions>
        </v-card>
        <v-divider> </v-divider>
        <v-card>
            <v-card-title>
                <h3>Account Summary</h3>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-layout row>
                    <v-flex sm5>
                        <p><strong style="color: rgb(162, 156, 156);font-size: 15px;font-weight: bold;">TOTAL ORDERS: <span style="color: #009688;">0</span></strong></p>
                        <p><strong style="color: rgb(162, 156, 156);font-size: 15px;font-weight: bold;">IN TRANSIT: <span style="color: #009688;">0</span></strong></p>
                        <p><strong style="color: rgb(162, 156, 156);font-size: 15px;font-weight: bold;">PAYMENT PENDING: <span style="color: #009688;">0</span></strong></p>
                    </v-flex>
                    <v-flex sm5 offset-sm-2>
                        <p><strong style="color: rgb(162, 156, 156);font-size: 15px;font-weight: bold;">Delivered: <span style="color: #009688;">0</span></strong></p>
                        <p><strong style="color: rgb(162, 156, 156);font-size: 15px;font-weight: bold;">PAID: <span style="color: #009688;">0</span></strong></p>
                        <p><strong style="color: rgb(162, 156, 156);font-size: 15px;font-weight: bold;">DUE PAYMENTS: <span style="color: #009688;">0</span></strong></p>
                    </v-flex>
                </v-layout>
            </v-card-text>
            <v-card-actions>

            </v-card-actions>
        </v-card>
        <v-divider> </v-divider>
        <v-card>
            <v-card-title>
                <h3>Recent Orders</h3>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <table class="table table-bordered table-hover table-striped table-responsive">
                    <thead>
                        <th>Order id</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        <tr v-for="i in 4" :key="i">
                            <td>Lorem ipsum dolor sit amet, </td>
                            <td>voluptates fuga. Recusandae!</td>
                            <td>consectetur adipisicing elit.</td>
                        </tr>
                    </tbody>
                </table>
            </v-card-text>
            <v-card-actions>
                <v-btn flat color="primary" style="margin: auto;">View all orders</v-btn>
            </v-card-actions>
        </v-card>
    </v-flex>

    <v-flex sm6>
        <v-card>
            <v-card-title>
                <h3>ESTIMATE THE COST OF SHIPPING</h3>
            </v-card-title>
            <v-divider> </v-divider>

            <v-card-text>
                <h5>Shipping To </h5>
                <div class="row">
                    <div class="form-group col-md-12">
                        <select name="" id="" class="form-control">
                        <option value="">Kenya</option>
                        <option value="">Tanzania</option>
                    </select>
                    </div>
                    <div style="margin-top: 10px;" class="form-group col-md-5">
                        <label for="">Estimated Weight </label>
                        <input type="text" class="form-control">
                    </div>
                        <div style="margin-top: 10px;" class="form-group col-md-5 offset-md-2">
                            <label for="">Scale</label>
                            <input type="text" class="form-control">
                    </div>
                    <h4 class="col-md-12">Purchase Details</h4><br>
                    <div class="form-group col-md-12">
                        <label for="">Item Invoice Amount (KSH)</label>
                        <input type="text" class="form-control" placeholder="amount">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Product Name</label>
                        <input type="text" class="form-control" placeholder="Product Name">
                    </div>
                </div>
            </v-card-text>
            <v-card-actions>
                <v-btn flat color="primary" style="margin: auto;">Calculate</v-btn>
            </v-card-actions>
        </v-card>
    </v-flex>
</v-layout>
</template>

<script>
export default {
    props: ['user']
}
</script>

<style>

</style>
