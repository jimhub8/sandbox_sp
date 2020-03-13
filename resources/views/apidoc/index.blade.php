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
<!-- START_a925a8d22b3615f12fca79456d286859 -->
<h2>Login user and create token</h2>
<p>To login you will provide you email and password.</p>
<p>You will get a response with an</p>
<p>{
&quot;accessToken&quot;: &quot;access_token&quot;,
&quot;token&quot;: {
&quot;id&quot;: &quot;id&quot;,
&quot;user_id&quot;: 1,
&quot;client_id&quot;: 1,
&quot;name&quot;: &quot;Personal Access Token&quot;,
&quot;scopes&quot;: [],
&quot;revoked&quot;: false,
&quot;created_at&quot;: &quot;2020-03-13 09:28:24&quot;,
&quot;updated_at&quot;: &quot;2020-03-13 09:28:24&quot;,
&quot;expires_at&quot;: &quot;2021-03-13 09:28:24&quot;
}
}</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://sandbox.jim/api/auth/login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>HTTP Request</h3>
<p><code>POST api/auth/login</code></p>
<!-- END_a925a8d22b3615f12fca79456d286859 -->
<!-- START_16928cb8fc6adf2d9bb675d62a2095c5 -->
<h2>Logout user (Revoke the token)</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://sandbox.jim/api/auth/logout" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (401):</p>
</blockquote>
<pre><code class="language-json">{
    "error": "Unauthenticated."
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/auth/logout</code></p>
<!-- END_16928cb8fc6adf2d9bb675d62a2095c5 -->
<!-- START_ff6d656b6d81a61adda963b8702034d2 -->
<h2>Get the authenticated User</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://sandbox.jim/api/auth/user" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (401):</p>
</blockquote>
<pre><code class="language-json">{
    "error": "Unauthenticated."
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/auth/user</code></p>
<!-- END_ff6d656b6d81a61adda963b8702034d2 -->
<!-- START_8efbe258b403f46396ec1dff3d1e5620 -->
<h2>Store a newly created resource in storage.</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://sandbox.jim/api/status" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">[
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
]</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/status</code></p>
<!-- END_8efbe258b403f46396ec1dff3d1e5620 -->
<!-- START_7ea19774b653ab501f5f28825297b33d -->
<h2>Store a newly created resource in storage.</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://sandbox.jim/api/status" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>HTTP Request</h3>
<p><code>POST api/status</code></p>
<!-- END_7ea19774b653ab501f5f28825297b33d -->
<!-- START_57d72bbb9a0eadf1cc03f59b3575d88f -->
<h2>Update the specified resource in storage.</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X PUT \
    "http://sandbox.jim/api/status/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>HTTP Request</h3>
<p><code>PUT api/status/{status}</code></p>
<p><code>PATCH api/status/{status}</code></p>
<!-- END_57d72bbb9a0eadf1cc03f59b3575d88f -->
<!-- START_2338829cfb377a2a681a6e196d3c7647 -->
<h2>Remove the specified resource from storage.</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "http://sandbox.jim/api/status/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>HTTP Request</h3>
<p><code>DELETE api/status/{status}</code></p>
<!-- END_2338829cfb377a2a681a6e196d3c7647 -->
<!-- START_3205ce71c134175d802bda484c46394e -->
<h2>Get you orders</h2>
<p>The orders will have a pagination of 100</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://sandbox.jim/api/shipment" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (401):</p>
</blockquote>
<pre><code class="language-json">{
    "error": "Unauthenticated."
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
    "http://sandbox.jim/api/shipment" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    -G "http://sandbox.jim/api/shipment/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (401):</p>
</blockquote>
<pre><code class="language-json">{
    "error": "Unauthenticated."
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
    "http://sandbox.jim/api/shipment/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    "http://sandbox.jim/api/shipment/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    -G "http://sandbox.jim/api/loggedin_user" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (401):</p>
</blockquote>
<pre><code class="language-json">{
    "error": "Unauthenticated."
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
    -G "http://sandbox.jim/api/search/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (401):</p>
</blockquote>
<pre><code class="language-json">{
    "error": "Unauthenticated."
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
    -G "http://sandbox.jim/api/getShipments" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (401):</p>
</blockquote>
<pre><code class="language-json">{
    "error": "Unauthenticated."
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