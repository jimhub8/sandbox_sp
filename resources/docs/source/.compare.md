---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://courier.jimkiarie8/docs/collection.json)

<!-- END_INFO -->

#general


<!-- START_3205ce71c134175d802bda484c46394e -->
## Get you orders
The orders will have a pagination of 100

> Example request:

```bash
curl -X GET \
    -G "http://courier.jimkiarie8/api/shipment" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
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
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
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
}
```

### HTTP Request
`GET api/shipment`


<!-- END_3205ce71c134175d802bda484c46394e -->

<!-- START_8258d421f456b2d71668be13ab2c6919 -->
## Create a new order.

Send a json file with the following details


{
"bar_code": "EMS0220222",
"quantity": 1,
"client_address": "Riruta, kabiria. Near kivuli center",
"client_city": ''Nairobi'',
"product_name": "SLICER",
"client_name": "Edward njenga",
"client_phone": "722703019",
"cod_amount": "3500.00",
"products": [
{
"product_name": "Test Product",
"price": 299,
"total": 299,
"quantity": 1,
},
{
"product_name": "Test Product",
"price": 299,
"total": 299,
"quantity": 1,
},
]
}

> Example request:

```bash
curl -X POST \
    "http://courier.jimkiarie8/api/shipment" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
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
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/shipment`


<!-- END_8258d421f456b2d71668be13ab2c6919 -->

<!-- START_bea6a4710aa000c21b76424a43974df2 -->
## api/shipment/{shipment}
> Example request:

```bash
curl -X GET \
    -G "http://courier.jimkiarie8/api/shipment/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
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
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
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
}
```

### HTTP Request
`GET api/shipment/{shipment}`


<!-- END_bea6a4710aa000c21b76424a43974df2 -->

<!-- START_c8173b2bedca44632bcbb485f4bb4ffe -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT \
    "http://courier.jimkiarie8/api/shipment/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
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
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/shipment/{shipment}`

`PATCH api/shipment/{shipment}`


<!-- END_c8173b2bedca44632bcbb485f4bb4ffe -->

<!-- START_2c89045893cfc9898aef3e7c5facd1ab -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE \
    "http://courier.jimkiarie8/api/shipment/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
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
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/shipment/{shipment}`


<!-- END_2c89045893cfc9898aef3e7c5facd1ab -->

<!-- START_eedd5fc79d117dd05927d596e68be80c -->
## Logged in user details

> Example request:

```bash
curl -X GET \
    -G "http://courier.jimkiarie8/api/loggedin_user" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
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
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": null
}
```

### HTTP Request
`GET api/loggedin_user`


<!-- END_eedd5fc79d117dd05927d596e68be80c -->

<!-- START_c5cd019d2bded3ef997832bc64efa504 -->
## Search through you orders
Search by order_no, client phone number or client name
The orders will have a pagination of 100

> Example request:

```bash
curl -X GET \
    -G "http://courier.jimkiarie8/api/search/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
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
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
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
}
```

### HTTP Request
`GET api/search/{order_no}`


<!-- END_c5cd019d2bded3ef997832bc64efa504 -->

<!-- START_ddc5ea523d62154609ac550d33d0989c -->
## api/getShipments
> Example request:

```bash
curl -X GET \
    -G "http://courier.jimkiarie8/api/getShipments" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
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
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/getShipments`


<!-- END_ddc5ea523d62154609ac550d33d0989c -->


