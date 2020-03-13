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
[Get Postman Collection](http://sandbox.jim/docs/collection.json)

<!-- END_INFO -->

#general


<!-- START_a925a8d22b3615f12fca79456d286859 -->
## Login user and create token
To login you will provide you email and password.

You will get a response with an


{
"accessToken": "access_token",
"token": {
"id": "id",
"user_id": 1,
"client_id": 1,
"name": "Personal Access Token",
"scopes": [],
"revoked": false,
"created_at": "2020-03-13 09:28:24",
"updated_at": "2020-03-13 09:28:24",
"expires_at": "2021-03-13 09:28:24"
}
}

> Example request:

```bash
curl -X POST \
    "http://sandbox.jim/api/auth/login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://sandbox.jim/api/auth/login"
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
`POST api/auth/login`


<!-- END_a925a8d22b3615f12fca79456d286859 -->

<!-- START_16928cb8fc6adf2d9bb675d62a2095c5 -->
## Logout user (Revoke the token)

> Example request:

```bash
curl -X GET \
    -G "http://sandbox.jim/api/auth/logout" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://sandbox.jim/api/auth/logout"
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


> Example response (401):

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/auth/logout`


<!-- END_16928cb8fc6adf2d9bb675d62a2095c5 -->

<!-- START_ff6d656b6d81a61adda963b8702034d2 -->
## Get the authenticated User

> Example request:

```bash
curl -X GET \
    -G "http://sandbox.jim/api/auth/user" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://sandbox.jim/api/auth/user"
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


> Example response (401):

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/auth/user`


<!-- END_ff6d656b6d81a61adda963b8702034d2 -->

<!-- START_8efbe258b403f46396ec1dff3d1e5620 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X GET \
    -G "http://sandbox.jim/api/status" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://sandbox.jim/api/status"
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
[
    {
        "id": 11,
        "name": "Busy",
        "deleted_at": null,
        "created_at": "2018-12-20 21:28:32",
        "updated_at": "2018-12-20 21:28:32"
    },
    {
        "id": 18,
        "name": "Call back if i dont call back",
        "deleted_at": null,
        "created_at": "2018-12-27 22:34:14",
        "updated_at": "2018-12-27 22:34:14"
    },
    {
        "id": 13,
        "name": "Call back in a few",
        "deleted_at": null,
        "created_at": "2018-12-20 21:53:18",
        "updated_at": "2018-12-20 21:53:18"
    },
    {
        "id": 3,
        "name": "Cancelled",
        "deleted_at": null,
        "created_at": "2018-12-20 19:15:16",
        "updated_at": "2018-12-20 19:15:16"
    },
    {
        "id": 2,
        "name": "Delivered",
        "deleted_at": null,
        "created_at": "2018-12-20 17:52:15",
        "updated_at": "2018-12-20 17:52:15"
    },
    {
        "id": 15,
        "name": "Did not place the order",
        "deleted_at": null,
        "created_at": "2018-12-20 22:47:24",
        "updated_at": "2018-12-20 22:47:24"
    },
    {
        "id": 6,
        "name": "Dispatched",
        "deleted_at": null,
        "created_at": "2018-12-20 19:16:05",
        "updated_at": "2018-12-20 19:16:05"
    },
    {
        "id": 20,
        "name": "Excess numbers",
        "deleted_at": null,
        "created_at": "2019-01-03 00:24:42",
        "updated_at": "2019-01-03 00:24:42"
    },
    {
        "id": 14,
        "name": "Hanged up",
        "deleted_at": null,
        "created_at": "2018-12-20 22:08:03",
        "updated_at": "2018-12-20 22:08:03"
    },
    {
        "id": 17,
        "name": "Incomplete number",
        "deleted_at": null,
        "created_at": "2018-12-21 20:53:07",
        "updated_at": "2018-12-21 20:53:07"
    },
    {
        "id": 5,
        "name": "Not Available",
        "deleted_at": null,
        "created_at": "2018-12-20 19:15:53",
        "updated_at": "2018-12-20 19:15:53"
    },
    {
        "id": 4,
        "name": "Not Picking",
        "deleted_at": null,
        "created_at": "2018-12-20 19:15:43",
        "updated_at": "2018-12-20 19:15:43"
    },
    {
        "id": 21,
        "name": "Paying in installments",
        "deleted_at": null,
        "created_at": "2019-01-17 00:11:54",
        "updated_at": "2019-01-17 00:11:54"
    },
    {
        "id": 12,
        "name": "Picked up",
        "deleted_at": null,
        "created_at": "2018-12-20 21:40:05",
        "updated_at": "2018-12-20 21:40:05"
    },
    {
        "id": 16,
        "name": "Returned",
        "deleted_at": null,
        "created_at": "2018-12-21 20:00:09",
        "updated_at": "2018-12-21 20:00:09"
    },
    {
        "id": 1,
        "name": "Scheduled",
        "deleted_at": null,
        "created_at": "2018-12-20 17:52:05",
        "updated_at": "2018-12-20 17:52:05"
    },
    {
        "id": 19,
        "name": "Warehouse",
        "deleted_at": null,
        "created_at": "2018-12-27 23:03:18",
        "updated_at": "2018-12-27 23:03:18"
    },
    {
        "id": 8,
        "name": "Will call us back",
        "deleted_at": null,
        "created_at": "2018-12-20 20:52:20",
        "updated_at": "2018-12-20 20:52:20"
    },
    {
        "id": 10,
        "name": "Will call us back when around",
        "deleted_at": null,
        "created_at": "2018-12-20 20:53:20",
        "updated_at": "2018-12-20 20:53:20"
    },
    {
        "id": 9,
        "name": "Will call us back when financially stable",
        "deleted_at": null,
        "created_at": "2018-12-20 20:53:04",
        "updated_at": "2018-12-20 20:53:04"
    },
    {
        "id": 7,
        "name": "Wrong Number",
        "deleted_at": null,
        "created_at": "2018-12-20 19:16:22",
        "updated_at": "2018-12-20 19:16:22"
    }
]
```

### HTTP Request
`GET api/status`


<!-- END_8efbe258b403f46396ec1dff3d1e5620 -->

<!-- START_7ea19774b653ab501f5f28825297b33d -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST \
    "http://sandbox.jim/api/status" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://sandbox.jim/api/status"
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
`POST api/status`


<!-- END_7ea19774b653ab501f5f28825297b33d -->

<!-- START_57d72bbb9a0eadf1cc03f59b3575d88f -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT \
    "http://sandbox.jim/api/status/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://sandbox.jim/api/status/1"
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
`PUT api/status/{status}`

`PATCH api/status/{status}`


<!-- END_57d72bbb9a0eadf1cc03f59b3575d88f -->

<!-- START_2338829cfb377a2a681a6e196d3c7647 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE \
    "http://sandbox.jim/api/status/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://sandbox.jim/api/status/1"
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
`DELETE api/status/{status}`


<!-- END_2338829cfb377a2a681a6e196d3c7647 -->

<!-- START_3205ce71c134175d802bda484c46394e -->
## Get you orders
The orders will have a pagination of 100

> Example request:

```bash
curl -X GET \
    -G "http://sandbox.jim/api/shipment" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://sandbox.jim/api/shipment"
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


> Example response (401):

```json
{
    "error": "Unauthenticated."
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
    "http://sandbox.jim/api/shipment" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://sandbox.jim/api/shipment"
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
    -G "http://sandbox.jim/api/shipment/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://sandbox.jim/api/shipment/1"
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


> Example response (401):

```json
{
    "error": "Unauthenticated."
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
    "http://sandbox.jim/api/shipment/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://sandbox.jim/api/shipment/1"
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
    "http://sandbox.jim/api/shipment/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://sandbox.jim/api/shipment/1"
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
    -G "http://sandbox.jim/api/loggedin_user" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://sandbox.jim/api/loggedin_user"
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


> Example response (401):

```json
{
    "error": "Unauthenticated."
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
    -G "http://sandbox.jim/api/search/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://sandbox.jim/api/search/1"
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


> Example response (401):

```json
{
    "error": "Unauthenticated."
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
    -G "http://sandbox.jim/api/getShipments" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://sandbox.jim/api/getShipments"
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


> Example response (401):

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/getShipments`


<!-- END_ddc5ea523d62154609ac550d33d0989c -->


