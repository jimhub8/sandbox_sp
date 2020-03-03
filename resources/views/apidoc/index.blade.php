<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>API Reference</title>

    <link rel="stylesheet" href="/docs/css/style.css" />
    <script src="/docs/js/all.js"></script>


          <script>
        $(function() {
            setupLanguages(["bash","javascript"]);
        });
      </script>
      </head>

  <body class="">
    <a href="#" id="nav-button">
      <span>
        NAV
        <img src="/docs/images/navbar.png" />
      </span>
    </a>
    <div class="tocify-wrapper">
        <img src="/docs/images/logo.png" />
                    <div class="lang-selector">
                                  <a href="#" data-language-name="bash">bash</a>
                                  <a href="#" data-language-name="javascript">javascript</a>
                            </div>
                            <div class="search">
              <input type="text" class="search" id="input-search" placeholder="Search">
            </div>
            <ul class="search-results"></ul>
              <div id="toc">
      </div>
                    <ul class="toc-footer">
                                  <li><a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a></li>
                            </ul>
            </div>
    <div class="page-wrapper">
      <div class="dark-box"></div>
      <div class="content">
          <!-- START_INFO -->
<h1>Info</h1>
<p>Welcome to the generated API reference.
<a href="{{ route("apidoc", ["format" => ".json"]) }}">Get Postman Collection</a></p>
<!-- END_INFO -->
<h1>general</h1>
<!-- START_3205ce71c134175d802bda484c46394e -->
<h2>Get you orders</h2>
<p>The orders will have a pagination of 100</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://courier.jimkiarie8/api/shipment" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://courier.jimkiarie8/api/shipment"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "data": [
        {
            "airway_bill_no": "EMS0220222",
            "amount_ordered": 1,
            "booking_date": "2020-01-13",
            "charges": null,
            "client_address": "Riruta, kabiria. Near kivuli center",
            "client_city": null,
            "client_email": "SLICER",
            "client_id": 1,
            "client_name": "Edward njenga",
            "client_phone": "722703019",
            "cod_amount": "3500.00",
            "created_at": "2020-01-13T13:13:21.000000Z",
            "derivery_date": "2019-04-11",
            "derivery_status": "Delivered",
            "dispatch_date": null,
            "distance": null,
            "driver": null,
            "from_city": null,
            "id": 1,
            "insuarance_status": null,
            "lat": null,
            "lat_to": null,
            "lng": null,
            "lng_to": null,
            "location": null,
            "order_id": null,
            "paid": null,
            "pickup_at": 0,
            "pickup_id": 0,
            "products": [
                {
                    "id": 1,
                    "product_name": "Test Product",
                    "weight": 0,
                    "price": 299,
                    "total": 299,
                    "quantity": 1,
                    "user_id": 1,
                    "branch_id": null,
                    "lat_from": "-1.2875376",
                    "long_from": "36.8142597",
                    "shipments_id": 1,
                    "deleted_at": null,
                    "created_at": "2019-11-16 21:04:23",
                    "updated_at": "2019-11-16 21:04:23"
                },
                {
                    "id": 2,
                    "product_name": "test prod",
                    "weight": 0,
                    "price": 299,
                    "total": 299,
                    "quantity": 4,
                    "user_id": 1,
                    "branch_id": null,
                    "lat_from": "-1.2875376",
                    "long_from": "36.8142597",
                    "shipments_id": 1,
                    "deleted_at": null,
                    "created_at": "2019-11-16 21:04:23",
                    "updated_at": "2019-11-16 21:04:23"
                }
            ],
            "receiver_name": null,
            "sender_address": "main st",
            "sender_city": "Nairobi",
            "sender_email": "jane@doe.com",
            "sender_name": "John Doe",
            "sender_phone": "7220100",
            "speciial_instruction": null,
            "status": "Delivered",
            "statuses": [
                {
                    "id": 3,
                    "user_id": 1,
                    "branch_id": 1,
                    "shipment_id": 1,
                    "status": "Dispatched",
                    "location": null,
                    "geo_location": null,
                    "lat": null,
                    "lng": null,
                    "ip": null,
                    "state_name": null,
                    "country": null,
                    "state": null,
                    "city": null,
                    "remark": null,
                    "deleted_at": null,
                    "created_at": "2019-12-03 10:33:24",
                    "updated_at": "2019-12-03 10:33:24"
                },
                {
                    "id": 19,
                    "user_id": 1,
                    "branch_id": 1,
                    "shipment_id": 1,
                    "status": "Scheduled",
                    "location": null,
                    "geo_location": null,
                    "lat": null,
                    "lng": null,
                    "ip": null,
                    "state_name": null,
                    "country": null,
                    "state": null,
                    "city": null,
                    "remark": null,
                    "deleted_at": null,
                    "created_at": "2019-12-05 11:43:15",
                    "updated_at": "2019-12-05 11:43:15"
                },
                {
                    "id": 20,
                    "user_id": 1,
                    "branch_id": 1,
                    "shipment_id": 1,
                    "status": "Scheduled",
                    "location": null,
                    "geo_location": null,
                    "lat": null,
                    "lng": null,
                    "ip": null,
                    "state_name": null,
                    "country": null,
                    "state": null,
                    "city": null,
                    "remark": null,
                    "deleted_at": null,
                    "created_at": "2019-12-09 14:34:47",
                    "updated_at": "2019-12-09 14:34:47"
                },
                {
                    "id": 21,
                    "user_id": 1,
                    "branch_id": 1,
                    "shipment_id": 1,
                    "status": "Scheduled",
                    "location": null,
                    "geo_location": null,
                    "lat": null,
                    "lng": null,
                    "ip": null,
                    "state_name": null,
                    "country": null,
                    "state": null,
                    "city": null,
                    "remark": null,
                    "deleted_at": null,
                    "created_at": "2019-12-09 14:35:05",
                    "updated_at": "2019-12-09 14:35:05"
                },
                {
                    "id": 22,
                    "user_id": 1,
                    "branch_id": 1,
                    "shipment_id": 1,
                    "status": "Dispatched",
                    "location": null,
                    "geo_location": null,
                    "lat": null,
                    "lng": null,
                    "ip": null,
                    "state_name": null,
                    "country": null,
                    "state": null,
                    "city": null,
                    "remark": null,
                    "deleted_at": null,
                    "created_at": "2019-12-09 14:35:15",
                    "updated_at": "2019-12-09 14:35:15"
                },
                {
                    "id": 35,
                    "user_id": 1,
                    "branch_id": 1,
                    "shipment_id": 1,
                    "status": "Dispatched",
                    "location": null,
                    "geo_location": null,
                    "lat": null,
                    "lng": null,
                    "ip": null,
                    "state_name": null,
                    "country": null,
                    "state": null,
                    "city": null,
                    "remark": null,
                    "deleted_at": null,
                    "created_at": "2020-01-08 11:58:39",
                    "updated_at": "2020-01-08 11:58:39"
                },
                {
                    "id": 47,
                    "user_id": 1,
                    "branch_id": 1,
                    "shipment_id": 1,
                    "status": "Delivered",
                    "location": null,
                    "geo_location": null,
                    "lat": null,
                    "lng": null,
                    "ip": null,
                    "state_name": null,
                    "country": null,
                    "state": null,
                    "city": null,
                    "remark": null,
                    "deleted_at": null,
                    "created_at": "2020-01-17 10:20:24",
                    "updated_at": "2020-01-17 10:20:24"
                }
            ],
            "sub_total": null,
            "to_city": null,
            "user_id": 1,
            "weight": null
        }
    ],
    "links": {
        "first": "http:\/\/localhost\/api\/shipment?page=1",
        "last": "http:\/\/localhost\/api\/shipment?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "http:\/\/localhost\/api\/shipment",
        "per_page": 2,
        "to": 1,
        "total": 1
    }
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/shipment</code></p>
<!-- END_3205ce71c134175d802bda484c46394e -->
<!-- START_8258d421f456b2d71668be13ab2c6919 -->
<h2>Create a new order.</h2>
<p>Send a json file with the following details</p>
<p>{
&quot;bar_code&quot;: &quot;EMS0220222&quot;,
&quot;quantity&quot;: 1,
&quot;client_address&quot;: &quot;Riruta, kabiria. Near kivuli center&quot;,
&quot;client_city&quot;: ''Nairobi'',
&quot;product_name&quot;: &quot;SLICER&quot;,
&quot;client_name&quot;: &quot;Edward njenga&quot;,
&quot;client_phone&quot;: &quot;722703019&quot;,
&quot;cod_amount&quot;: &quot;3500.00&quot;,
&quot;products&quot;: [
{
&quot;product_name&quot;: &quot;Test Product&quot;,
&quot;price&quot;: 299,
&quot;total&quot;: 299,
&quot;quantity&quot;: 1,
},
{
&quot;product_name&quot;: &quot;Test Product&quot;,
&quot;price&quot;: 299,
&quot;total&quot;: 299,
&quot;quantity&quot;: 1,
},
]
}</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://courier.jimkiarie8/api/shipment" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://courier.jimkiarie8/api/shipment"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>HTTP Request</h3>
<p><code>POST api/shipment</code></p>
<!-- END_8258d421f456b2d71668be13ab2c6919 -->
<!-- START_bea6a4710aa000c21b76424a43974df2 -->
<h2>api/shipment/{shipment}</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://courier.jimkiarie8/api/shipment/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://courier.jimkiarie8/api/shipment/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "data": [
        {
            "airway_bill_no": "EMS0220222",
            "amount_ordered": 1,
            "booking_date": "2020-01-13",
            "charges": null,
            "client_address": "Riruta, kabiria. Near kivuli center",
            "client_city": null,
            "client_email": "SLICER",
            "client_id": 1,
            "client_name": "Edward njenga",
            "client_phone": "722703019",
            "cod_amount": "3500.00",
            "created_at": "2020-01-13T13:13:21.000000Z",
            "derivery_date": "2019-04-11",
            "derivery_status": "Delivered",
            "dispatch_date": null,
            "distance": null,
            "driver": null,
            "from_city": null,
            "id": 1,
            "insuarance_status": null,
            "lat": null,
            "lat_to": null,
            "lng": null,
            "lng_to": null,
            "location": null,
            "order_id": null,
            "paid": null,
            "pickup_at": 0,
            "pickup_id": 0,
            "products": [
                {
                    "id": 1,
                    "product_name": "Test Product",
                    "weight": 0,
                    "price": 299,
                    "total": 299,
                    "quantity": 1,
                    "user_id": 1,
                    "branch_id": null,
                    "lat_from": "-1.2875376",
                    "long_from": "36.8142597",
                    "shipments_id": 1,
                    "deleted_at": null,
                    "created_at": "2019-11-16 21:04:23",
                    "updated_at": "2019-11-16 21:04:23"
                },
                {
                    "id": 2,
                    "product_name": "test prod",
                    "weight": 0,
                    "price": 299,
                    "total": 299,
                    "quantity": 4,
                    "user_id": 1,
                    "branch_id": null,
                    "lat_from": "-1.2875376",
                    "long_from": "36.8142597",
                    "shipments_id": 1,
                    "deleted_at": null,
                    "created_at": "2019-11-16 21:04:23",
                    "updated_at": "2019-11-16 21:04:23"
                }
            ],
            "receiver_name": null,
            "sender_address": "main st",
            "sender_city": "Nairobi",
            "sender_email": "jane@doe.com",
            "sender_name": "John Doe",
            "sender_phone": "7220100",
            "speciial_instruction": null,
            "status": "Delivered",
            "statuses": [
                {
                    "id": 3,
                    "user_id": 1,
                    "branch_id": 1,
                    "shipment_id": 1,
                    "status": "Dispatched",
                    "location": null,
                    "geo_location": null,
                    "lat": null,
                    "lng": null,
                    "ip": null,
                    "state_name": null,
                    "country": null,
                    "state": null,
                    "city": null,
                    "remark": null,
                    "deleted_at": null,
                    "created_at": "2019-12-03 10:33:24",
                    "updated_at": "2019-12-03 10:33:24"
                },
                {
                    "id": 19,
                    "user_id": 1,
                    "branch_id": 1,
                    "shipment_id": 1,
                    "status": "Scheduled",
                    "location": null,
                    "geo_location": null,
                    "lat": null,
                    "lng": null,
                    "ip": null,
                    "state_name": null,
                    "country": null,
                    "state": null,
                    "city": null,
                    "remark": null,
                    "deleted_at": null,
                    "created_at": "2019-12-05 11:43:15",
                    "updated_at": "2019-12-05 11:43:15"
                },
                {
                    "id": 20,
                    "user_id": 1,
                    "branch_id": 1,
                    "shipment_id": 1,
                    "status": "Scheduled",
                    "location": null,
                    "geo_location": null,
                    "lat": null,
                    "lng": null,
                    "ip": null,
                    "state_name": null,
                    "country": null,
                    "state": null,
                    "city": null,
                    "remark": null,
                    "deleted_at": null,
                    "created_at": "2019-12-09 14:34:47",
                    "updated_at": "2019-12-09 14:34:47"
                },
                {
                    "id": 21,
                    "user_id": 1,
                    "branch_id": 1,
                    "shipment_id": 1,
                    "status": "Scheduled",
                    "location": null,
                    "geo_location": null,
                    "lat": null,
                    "lng": null,
                    "ip": null,
                    "state_name": null,
                    "country": null,
                    "state": null,
                    "city": null,
                    "remark": null,
                    "deleted_at": null,
                    "created_at": "2019-12-09 14:35:05",
                    "updated_at": "2019-12-09 14:35:05"
                },
                {
                    "id": 22,
                    "user_id": 1,
                    "branch_id": 1,
                    "shipment_id": 1,
                    "status": "Dispatched",
                    "location": null,
                    "geo_location": null,
                    "lat": null,
                    "lng": null,
                    "ip": null,
                    "state_name": null,
                    "country": null,
                    "state": null,
                    "city": null,
                    "remark": null,
                    "deleted_at": null,
                    "created_at": "2019-12-09 14:35:15",
                    "updated_at": "2019-12-09 14:35:15"
                },
                {
                    "id": 35,
                    "user_id": 1,
                    "branch_id": 1,
                    "shipment_id": 1,
                    "status": "Dispatched",
                    "location": null,
                    "geo_location": null,
                    "lat": null,
                    "lng": null,
                    "ip": null,
                    "state_name": null,
                    "country": null,
                    "state": null,
                    "city": null,
                    "remark": null,
                    "deleted_at": null,
                    "created_at": "2020-01-08 11:58:39",
                    "updated_at": "2020-01-08 11:58:39"
                },
                {
                    "id": 47,
                    "user_id": 1,
                    "branch_id": 1,
                    "shipment_id": 1,
                    "status": "Delivered",
                    "location": null,
                    "geo_location": null,
                    "lat": null,
                    "lng": null,
                    "ip": null,
                    "state_name": null,
                    "country": null,
                    "state": null,
                    "city": null,
                    "remark": null,
                    "deleted_at": null,
                    "created_at": "2020-01-17 10:20:24",
                    "updated_at": "2020-01-17 10:20:24"
                }
            ],
            "sub_total": null,
            "to_city": null,
            "user_id": 1,
            "weight": null
        }
    ]
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/shipment/{shipment}</code></p>
<!-- END_bea6a4710aa000c21b76424a43974df2 -->
<!-- START_c8173b2bedca44632bcbb485f4bb4ffe -->
<h2>Update the specified resource in storage.</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X PUT \
    "http://courier.jimkiarie8/api/shipment/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://courier.jimkiarie8/api/shipment/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>HTTP Request</h3>
<p><code>PUT api/shipment/{shipment}</code></p>
<p><code>PATCH api/shipment/{shipment}</code></p>
<!-- END_c8173b2bedca44632bcbb485f4bb4ffe -->
<!-- START_2c89045893cfc9898aef3e7c5facd1ab -->
<h2>Remove the specified resource from storage.</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "http://courier.jimkiarie8/api/shipment/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://courier.jimkiarie8/api/shipment/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>HTTP Request</h3>
<p><code>DELETE api/shipment/{shipment}</code></p>
<!-- END_2c89045893cfc9898aef3e7c5facd1ab -->
<!-- START_eedd5fc79d117dd05927d596e68be80c -->
<h2>Logged in user details</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://courier.jimkiarie8/api/loggedin_user" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://courier.jimkiarie8/api/loggedin_user"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": null
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/loggedin_user</code></p>
<!-- END_eedd5fc79d117dd05927d596e68be80c -->
<!-- START_c5cd019d2bded3ef997832bc64efa504 -->
<h2>Search through you orders</h2>
<p>Search by order_no, client phone number or client name
The orders will have a pagination of 100</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://courier.jimkiarie8/api/search/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://courier.jimkiarie8/api/search/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "data": [
        {
            "airway_bill_no": "EMS0220222",
            "amount_ordered": 1,
            "booking_date": "2020-01-13",
            "charges": null,
            "client_address": "Riruta, kabiria. Near kivuli center",
            "client_city": null,
            "client_email": "SLICER",
            "client_id": 1,
            "client_name": "Edward njenga",
            "client_phone": "722703019",
            "cod_amount": "3500.00",
            "created_at": "2020-01-13T13:13:21.000000Z",
            "derivery_date": "2019-04-11",
            "derivery_status": "Delivered",
            "dispatch_date": null,
            "distance": null,
            "driver": null,
            "from_city": null,
            "id": 1,
            "insuarance_status": null,
            "lat": null,
            "lat_to": null,
            "lng": null,
            "lng_to": null,
            "location": null,
            "order_id": null,
            "paid": null,
            "pickup_at": 0,
            "pickup_id": 0,
            "products": [
                {
                    "id": 1,
                    "product_name": "Test Product",
                    "weight": 0,
                    "price": 299,
                    "total": 299,
                    "quantity": 1,
                    "user_id": 1,
                    "branch_id": null,
                    "lat_from": "-1.2875376",
                    "long_from": "36.8142597",
                    "shipments_id": 1,
                    "deleted_at": null,
                    "created_at": "2019-11-16 21:04:23",
                    "updated_at": "2019-11-16 21:04:23"
                },
                {
                    "id": 2,
                    "product_name": "test prod",
                    "weight": 0,
                    "price": 299,
                    "total": 299,
                    "quantity": 4,
                    "user_id": 1,
                    "branch_id": null,
                    "lat_from": "-1.2875376",
                    "long_from": "36.8142597",
                    "shipments_id": 1,
                    "deleted_at": null,
                    "created_at": "2019-11-16 21:04:23",
                    "updated_at": "2019-11-16 21:04:23"
                }
            ],
            "receiver_name": null,
            "sender_address": "main st",
            "sender_city": "Nairobi",
            "sender_email": "jane@doe.com",
            "sender_name": "John Doe",
            "sender_phone": "7220100",
            "speciial_instruction": null,
            "status": "Delivered",
            "statuses": [
                {
                    "id": 3,
                    "user_id": 1,
                    "branch_id": 1,
                    "shipment_id": 1,
                    "status": "Dispatched",
                    "location": null,
                    "geo_location": null,
                    "lat": null,
                    "lng": null,
                    "ip": null,
                    "state_name": null,
                    "country": null,
                    "state": null,
                    "city": null,
                    "remark": null,
                    "deleted_at": null,
                    "created_at": "2019-12-03 10:33:24",
                    "updated_at": "2019-12-03 10:33:24"
                },
                {
                    "id": 19,
                    "user_id": 1,
                    "branch_id": 1,
                    "shipment_id": 1,
                    "status": "Scheduled",
                    "location": null,
                    "geo_location": null,
                    "lat": null,
                    "lng": null,
                    "ip": null,
                    "state_name": null,
                    "country": null,
                    "state": null,
                    "city": null,
                    "remark": null,
                    "deleted_at": null,
                    "created_at": "2019-12-05 11:43:15",
                    "updated_at": "2019-12-05 11:43:15"
                },
                {
                    "id": 20,
                    "user_id": 1,
                    "branch_id": 1,
                    "shipment_id": 1,
                    "status": "Scheduled",
                    "location": null,
                    "geo_location": null,
                    "lat": null,
                    "lng": null,
                    "ip": null,
                    "state_name": null,
                    "country": null,
                    "state": null,
                    "city": null,
                    "remark": null,
                    "deleted_at": null,
                    "created_at": "2019-12-09 14:34:47",
                    "updated_at": "2019-12-09 14:34:47"
                },
                {
                    "id": 21,
                    "user_id": 1,
                    "branch_id": 1,
                    "shipment_id": 1,
                    "status": "Scheduled",
                    "location": null,
                    "geo_location": null,
                    "lat": null,
                    "lng": null,
                    "ip": null,
                    "state_name": null,
                    "country": null,
                    "state": null,
                    "city": null,
                    "remark": null,
                    "deleted_at": null,
                    "created_at": "2019-12-09 14:35:05",
                    "updated_at": "2019-12-09 14:35:05"
                },
                {
                    "id": 22,
                    "user_id": 1,
                    "branch_id": 1,
                    "shipment_id": 1,
                    "status": "Dispatched",
                    "location": null,
                    "geo_location": null,
                    "lat": null,
                    "lng": null,
                    "ip": null,
                    "state_name": null,
                    "country": null,
                    "state": null,
                    "city": null,
                    "remark": null,
                    "deleted_at": null,
                    "created_at": "2019-12-09 14:35:15",
                    "updated_at": "2019-12-09 14:35:15"
                },
                {
                    "id": 35,
                    "user_id": 1,
                    "branch_id": 1,
                    "shipment_id": 1,
                    "status": "Dispatched",
                    "location": null,
                    "geo_location": null,
                    "lat": null,
                    "lng": null,
                    "ip": null,
                    "state_name": null,
                    "country": null,
                    "state": null,
                    "city": null,
                    "remark": null,
                    "deleted_at": null,
                    "created_at": "2020-01-08 11:58:39",
                    "updated_at": "2020-01-08 11:58:39"
                },
                {
                    "id": 47,
                    "user_id": 1,
                    "branch_id": 1,
                    "shipment_id": 1,
                    "status": "Delivered",
                    "location": null,
                    "geo_location": null,
                    "lat": null,
                    "lng": null,
                    "ip": null,
                    "state_name": null,
                    "country": null,
                    "state": null,
                    "city": null,
                    "remark": null,
                    "deleted_at": null,
                    "created_at": "2020-01-17 10:20:24",
                    "updated_at": "2020-01-17 10:20:24"
                }
            ],
            "sub_total": null,
            "to_city": null,
            "user_id": 1,
            "weight": null
        }
    ],
    "links": {
        "first": "http:\/\/localhost\/api\/search\/1?page=1",
        "last": "http:\/\/localhost\/api\/search\/1?page=45",
        "prev": null,
        "next": "http:\/\/localhost\/api\/search\/1?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 45,
        "path": "http:\/\/localhost\/api\/search\/1",
        "per_page": 1,
        "to": 1,
        "total": 45
    }
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/search/{order_no}</code></p>
<!-- END_c5cd019d2bded3ef997832bc64efa504 -->
<!-- START_ddc5ea523d62154609ac550d33d0989c -->
<h2>api/getShipments</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://courier.jimkiarie8/api/getShipments" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://courier.jimkiarie8/api/getShipments"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (500):</p>
</blockquote>
<pre><code class="language-json">{
    "message": "Server Error"
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/getShipments</code></p>
<!-- END_ddc5ea523d62154609ac550d33d0989c -->
      </div>
      <div class="dark-box">
                        <div class="lang-selector">
                                    <a href="#" data-language-name="bash">bash</a>
                                    <a href="#" data-language-name="javascript">javascript</a>
                              </div>
                </div>
    </div>
  </body>
</html>