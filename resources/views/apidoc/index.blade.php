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
<p>You will get a response with this JSON     *
{
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
<p>Example response (500):</p>
</blockquote>
<pre><code class="language-json">{
    "message": "Server Error"
}</code></pre>
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
&quot;data&quot;: {
&quot;bar_code&quot;: &quot;SP0000001&quot;,
&quot;quantity&quot;: 1,
&quot;client_address&quot;: &quot;123 main street&quot;,
&quot;client_city&quot;: &quot;Nairobi&quot;,
&quot;product_name&quot;: &quot;SLICER&quot;,
&quot;client_name&quot;: &quot;John Doe&quot;,
&quot;client_phone&quot;: &quot;+257000...&quot;,
&quot;cod_amount&quot;: &quot;1900.00&quot;,
&quot;products&quot;: [
{
&quot;product_name&quot;: &quot;Test Product&quot;,
&quot;price&quot;: 400,
&quot;total&quot;: 400,
&quot;quantity&quot;: 1
},
{
&quot;product_name&quot;: &quot;Test Product&quot;,
&quot;price&quot;: 1500,
&quot;total&quot;: 1500,
&quot;quantity&quot;: 1
}
]
}
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
<!-- START_da36888b3c63d07abfa784a281832530 -->
<h2>Create a new order.</h2>
<p>Send a json file with the following details</p>
<p>{
&quot;data&quot;: {
&quot;bar_code&quot;: &quot;SP0000001&quot;,
&quot;quantity&quot;: 1,
&quot;client_address&quot;: &quot;123 main street&quot;,
&quot;client_city&quot;: &quot;Nairobi&quot;,
&quot;product_name&quot;: &quot;SLICER&quot;,
&quot;client_name&quot;: &quot;John Doe&quot;,
&quot;client_phone&quot;: &quot;+257000...&quot;,
&quot;cod_amount&quot;: &quot;1900.00&quot;,
&quot;products&quot;: [
{
&quot;product_name&quot;: &quot;Test Product&quot;,
&quot;price&quot;: 400,
&quot;total&quot;: 400,
&quot;quantity&quot;: 1
},
{
&quot;product_name&quot;: &quot;Test Product&quot;,
&quot;price&quot;: 1500,
&quot;total&quot;: 1500,
&quot;quantity&quot;: 1
}
]
}
}</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://sandbox.jim/api/add_shipment" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://sandbox.jim/api/add_shipment"
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
<p><code>POST api/add_shipment</code></p>
<!-- END_da36888b3c63d07abfa784a281832530 -->
<!-- START_3a90b33f57bce1372f0ff7fa015803b2 -->
<h2>Some of the functionality may not be available in the but this can be incoporated as per your requirements</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://sandbox.jim/api/additional" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://sandbox.jim/api/additional"
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
<p><code>GET api/additional</code></p>
<!-- END_3a90b33f57bce1372f0ff7fa015803b2 -->
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