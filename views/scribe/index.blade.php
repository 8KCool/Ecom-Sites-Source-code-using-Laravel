<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Paiaki Angola API Reference</title>

    <link href="https://fonts.googleapis.com/css?family=PT+Sans&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset("vendor/scribe/css/style.css") }}" media="screen" />
        <link rel="stylesheet" href="{{ asset("vendor/scribe/css/print.css") }}" media="print" />
        <script src="{{ asset("vendor/scribe/js/all.js") }}"></script>

        <link rel="stylesheet" href="{{ asset("vendor/scribe/css/highlight-darcula.css") }}" media="" />
        <script src="{{ asset("vendor/scribe/js/highlight.pack.js") }}"></script>
    <script>hljs.initHighlightingOnLoad();</script>

</head>

<body class="" data-languages="[&quot;bash&quot;,&quot;javascript&quot;,&quot;php&quot;]">
<a href="#" id="nav-button">
      <span>
        NAV
            <img src="{{ asset("vendor/scribe/images/navbar.png") }}" alt="-image" class=""/>
      </span>
</a>
<div class="tocify-wrapper">
                <div class="lang-selector">
                            <a href="#" data-language-name="bash">bash</a>
                            <a href="#" data-language-name="javascript">javascript</a>
                            <a href="#" data-language-name="php">php</a>
                    </div>
        <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>
    <ul class="search-results"></ul>

    <ul id="toc">
    </ul>

            <ul class="toc-footer" id="toc-footer">
                            <li><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li><a href='http://github.com/knuckleswtf/scribe'>Documentation powered by Scribe ✍</a></li>
                    </ul>
            <ul class="toc-footer" id="last-updated">
            <li>Last updated: June 25 2021</li>
        </ul>
</div>
<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1>Introduction</h1>
<p>Paiaki Angola API specification and documentation.</p>
<p>This documentation aims to provide all the information you need to work with our API.</p>
<aside>As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).</aside>
<p><strong>Important:</strong> By default the API uses an access token set in the <strong><code>/.env</code></strong> file with the variable <code>APP_API_TOKEN</code>, whose its value
need to be added in the header of all the API requests with <code>X-AppApiToken</code> as key. On the other hand, the key <code>X-AppType</code> must not be added to the header... This key is only useful for the included web client and for API documentation.</p>
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>
<script>
    var baseUrl = "https://paiaki.com";
</script>
<script src="{{ asset("vendor/scribe/js/tryitout-2.7.9.js") }}"></script>
<blockquote>
<p>Base URL</p>
</blockquote>
<pre><code class="language-yaml">https://laraclassified.bedigit.local</code></pre><h1>Authenticating requests</h1>
<p>To authenticate requests, include an <strong><code>Authorization</code></strong> header with the value <strong><code>"Bearer {YOUR_AUTH_TOKEN}"</code></strong>.</p>
<p>All authenticated endpoints are marked with a <code>requires authentication</code> badge in the documentation below.</p>
<p>You can retrieve your token by visiting your dashboard and clicking <b>Generate API token</b>.</p><h1>Authentication</h1>
<h2>Log in</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "https://laraclassified.bedigit.local/api/auth/login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs" \
    -d '{"login":"user@demosite.com","password":"123456","captcha_key":"eum"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/auth/login"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

let body = {
    "login": "user@demosite.com",
    "password": "123456",
    "captcha_key": "eum"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://laraclassified.bedigit.local/api/auth/login',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'json' =&gt; [
            'login' =&gt; 'user@demosite.com',
            'password' =&gt; '123456',
            'captcha_key' =&gt; 'eum',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "message": null,
    "result": {
        "id": 3,
        "name": "User Demo",
        "username": null,
        "created_at_formatted": "Feb 27th, 2021 at 14:41",
        "photo_url": "https:\/\/secure.gravatar.com\/avatar\/6c58d4583a9550a6e363976bc15caf67.jpg?s=150&amp;d=http%3A%2F%2Flaraclassified.bedigit.local%2Fimages%2Fuser.jpg&amp;r=g"
    },
    "extra": {
        "authToken": "117|4hY0TfeRro1ZFIuiluwdqwnP0XHS9Blkk8R64VwV",
        "tokenType": "Bearer",
        "isAdmin": false
    }
}</code></pre>
<div id="execution-results-POSTapi-auth-login" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-auth-login"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-auth-login"></code></pre>
</div>
<div id="execution-error-POSTapi-auth-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-auth-login"></code></pre>
</div>
<form id="form-POSTapi-auth-login" data-method="POST" data-path="api/auth/login" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-auth-login', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-auth-login" onclick="tryItOut('POSTapi-auth-login');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-auth-login" onclick="cancelTryOut('POSTapi-auth-login');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-auth-login" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/auth/login</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>login</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="login" data-endpoint="POSTapi-auth-login" data-component="body" required  hidden>
<br>
The user's login (Can be email address or phone number).
</p>
<p>
<b><code>password</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="password" name="password" data-endpoint="POSTapi-auth-login" data-component="body" required  hidden>
<br>
The user's password.
</p>
<p>
<b><code>captcha_key</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="captcha_key" data-endpoint="POSTapi-auth-login" data-component="body"  hidden>
<br>
Key generated by the CAPTCHA endpoint calling (Required if the CAPTCHA verification is enabled from the Admin panel).
</p>

</form>
<h2>Log out</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/auth/logout/13" \
    -H "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/auth/logout/13"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/auth/logout/13',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {YOUR_AUTH_TOKEN}',
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "message": "You have been logged out. See you soon.",
    "result": null
}</code></pre>
<div id="execution-results-GETapi-auth-logout--userId-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-auth-logout--userId-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-auth-logout--userId-"></code></pre>
</div>
<div id="execution-error-GETapi-auth-logout--userId-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-auth-logout--userId-"></code></pre>
</div>
<form id="form-GETapi-auth-logout--userId-" data-method="GET" data-path="api/auth/logout/{userId}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_TOKEN}","Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-auth-logout--userId-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-auth-logout--userId-" onclick="tryItOut('GETapi-auth-logout--userId-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-auth-logout--userId-" onclick="cancelTryOut('GETapi-auth-logout--userId-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-auth-logout--userId-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/auth/logout/{userId}</code></b>
</p>
<p>
<label id="auth-GETapi-auth-logout--userId-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-auth-logout--userId-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>userId</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="userId" data-endpoint="GETapi-auth-logout--userId-" data-component="url"  hidden>
<br>
The ID of the user to logout.
</p>
</form>
<h2>Forgot password</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "https://laraclassified.bedigit.local/api/auth/password/email" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs" \
    -d '{"login":"user@demosite.com","captcha_key":"omnis"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/auth/password/email"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

let body = {
    "login": "user@demosite.com",
    "captcha_key": "omnis"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://laraclassified.bedigit.local/api/auth/password/email',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'json' =&gt; [
            'login' =&gt; 'user@demosite.com',
            'captcha_key' =&gt; 'omnis',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "message": "We have e-mailed your password reset link!",
    "result": null
}</code></pre>
<div id="execution-results-POSTapi-auth-password-email" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-auth-password-email"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-auth-password-email"></code></pre>
</div>
<div id="execution-error-POSTapi-auth-password-email" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-auth-password-email"></code></pre>
</div>
<form id="form-POSTapi-auth-password-email" data-method="POST" data-path="api/auth/password/email" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-auth-password-email', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-auth-password-email" onclick="tryItOut('POSTapi-auth-password-email');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-auth-password-email" onclick="cancelTryOut('POSTapi-auth-password-email');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-auth-password-email" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/auth/password/email</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>login</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="login" data-endpoint="POSTapi-auth-password-email" data-component="body" required  hidden>
<br>
The user's login (Can be email address or phone number).
</p>
<p>
<b><code>captcha_key</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="captcha_key" data-endpoint="POSTapi-auth-password-email" data-component="body"  hidden>
<br>
Key generated by the CAPTCHA endpoint calling (Required if the CAPTCHA verification is enabled from the Admin panel).
</p>

</form>
<h2>Reset password token</h2>
<p>Reset password token verification</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "https://laraclassified.bedigit.local/api/auth/password/token" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/auth/password/token"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://laraclassified.bedigit.local/api/auth/password/token',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (422):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "The given data was invalid.",
    "result": null,
    "errors": {
        "code": [
            "The code field is required."
        ]
    },
    "error_code": 1
}</code></pre>
<div id="execution-results-POSTapi-auth-password-token" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-auth-password-token"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-auth-password-token"></code></pre>
</div>
<div id="execution-error-POSTapi-auth-password-token" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-auth-password-token"></code></pre>
</div>
<form id="form-POSTapi-auth-password-token" data-method="POST" data-path="api/auth/password/token" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-auth-password-token', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-auth-password-token" onclick="tryItOut('POSTapi-auth-password-token');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-auth-password-token" onclick="cancelTryOut('POSTapi-auth-password-token');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-auth-password-token" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/auth/password/token</code></b>
</p>
</form>
<h2>Reset password</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "https://laraclassified.bedigit.local/api/auth/password/reset" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs" \
    -d '{"login":"john.doe@domain.tld","password":"js!X07$z61hLA","password_confirmation":"js!X07$z61hLA","captcha_key":"et"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/auth/password/reset"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

let body = {
    "login": "john.doe@domain.tld",
    "password": "js!X07$z61hLA",
    "password_confirmation": "js!X07$z61hLA",
    "captcha_key": "et"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://laraclassified.bedigit.local/api/auth/password/reset',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'json' =&gt; [
            'login' =&gt; 'john.doe@domain.tld',
            'password' =&gt; 'js!X07$z61hLA',
            'password_confirmation' =&gt; 'js!X07$z61hLA',
            'captcha_key' =&gt; 'et',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (422):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "The given data was invalid.",
    "result": null,
    "errors": {
        "token": [
            "The token field is required."
        ]
    },
    "error_code": 1
}</code></pre>
<div id="execution-results-POSTapi-auth-password-reset" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-auth-password-reset"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-auth-password-reset"></code></pre>
</div>
<div id="execution-error-POSTapi-auth-password-reset" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-auth-password-reset"></code></pre>
</div>
<form id="form-POSTapi-auth-password-reset" data-method="POST" data-path="api/auth/password/reset" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-auth-password-reset', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-auth-password-reset" onclick="tryItOut('POSTapi-auth-password-reset');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-auth-password-reset" onclick="cancelTryOut('POSTapi-auth-password-reset');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-auth-password-reset" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/auth/password/reset</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>login</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="login" data-endpoint="POSTapi-auth-password-reset" data-component="body" required  hidden>
<br>
The user's login (Can be email address or phone number).
</p>
<p>
<b><code>password</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="password" name="password" data-endpoint="POSTapi-auth-password-reset" data-component="body" required  hidden>
<br>
The user's password.
</p>
<p>
<b><code>password_confirmation</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="password" name="password_confirmation" data-endpoint="POSTapi-auth-password-reset" data-component="body" required  hidden>
<br>
The confirmation of the user's password.
</p>
<p>
<b><code>captcha_key</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="captcha_key" data-endpoint="POSTapi-auth-password-reset" data-component="body"  hidden>
<br>
Key generated by the CAPTCHA endpoint calling (Required if the CAPTCHA verification is enabled from the Admin panel).
</p>

</form><h1>Captcha</h1>
<h2>Get CAPTCHA</h2>
<p>Calling this endpoint is mandatory if the captcha is enabled in the Admin panel.
Return a JSON data with an 'img' item that contains the captcha image to show and a 'key' item that contains the generated key to send for validation.</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/captcha" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/captcha"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/captcha',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (429):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Too Many Requests,Please Slow Down",
    "result": null,
    "error_code": 1
}</code></pre>
<div id="execution-results-GETapi-captcha" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-captcha"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-captcha"></code></pre>
</div>
<div id="execution-error-GETapi-captcha" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-captcha"></code></pre>
</div>
<form id="form-GETapi-captcha" data-method="GET" data-path="api/captcha" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-captcha', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-captcha" onclick="tryItOut('GETapi-captcha');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-captcha" onclick="cancelTryOut('GETapi-captcha');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-captcha" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/captcha</code></b>
</p>
</form><h1>Categories</h1>
<h2>List categories</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/categories?parentId=0&amp;embed=iure" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/categories"
);

let params = {
    "parentId": "0",
    "embed": "iure",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/categories',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'parentId'=&gt; '0',
            'embed'=&gt; 'iure',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "message": null,
    "result": {
        "data": [
            {
                "id": 1,
                "parent_id": null,
                "name": "Automobiles",
                "slug": "automobiles",
                "description": "",
                "picture": "app\/categories\/skin-blue\/car.png",
                "icon_class": null,
                "active": "1",
                "lft": "2",
                "rgt": "19",
                "depth": "0",
                "type": "classified",
                "is_for_permanent": "1",
                "parentClosure": null
            },
            {
                "id": 9,
                "parent_id": null,
                "name": "Phones &amp; Tablets",
                "slug": "phones-and-tablets",
                "description": "",
                "picture": "app\/categories\/skin-blue\/mobile-alt.png",
                "icon_class": "icon-laptop",
                "active": "1",
                "lft": "20",
                "rgt": "29",
                "depth": "0",
                "type": "classified",
                "is_for_permanent": "0",
                "parentClosure": null
            },
            {
                "id": 14,
                "parent_id": null,
                "name": "Electronics",
                "slug": "electronics",
                "description": "",
                "picture": "app\/categories\/skin-blue\/fa-laptop.png",
                "icon_class": "icon-theatre",
                "active": "1",
                "lft": "30",
                "rgt": "61",
                "depth": "0",
                "type": "classified",
                "is_for_permanent": "0",
                "parentClosure": null
            },
            {
                "id": 30,
                "parent_id": null,
                "name": "Furniture &amp; Appliances",
                "slug": "furniture-appliances",
                "description": "",
                "picture": "app\/categories\/skin-blue\/couch.png",
                "icon_class": "icon-basket-1",
                "active": "1",
                "lft": "62",
                "rgt": "75",
                "depth": "0",
                "type": "classified",
                "is_for_permanent": "0",
                "parentClosure": null
            },
            {
                "id": 37,
                "parent_id": null,
                "name": "Real estate",
                "slug": "real-estate",
                "description": "",
                "picture": "app\/categories\/skin-blue\/fa-home.png",
                "icon_class": "icon-home",
                "active": "1",
                "lft": "76",
                "rgt": "93",
                "depth": "0",
                "type": "classified",
                "is_for_permanent": "0",
                "parentClosure": null
            },
            {
                "id": 46,
                "parent_id": null,
                "name": "Animals &amp; Pets",
                "slug": "animals-and-pets",
                "description": "",
                "picture": "app\/categories\/skin-blue\/paw.png",
                "icon_class": "icon-guidedog",
                "active": "1",
                "lft": "94",
                "rgt": "109",
                "depth": "0",
                "type": "classified",
                "is_for_permanent": "0",
                "parentClosure": null
            },
            {
                "id": 54,
                "parent_id": null,
                "name": "Fashion",
                "slug": "fashion",
                "description": "",
                "picture": "app\/categories\/skin-blue\/tshirt.png",
                "icon_class": "icon-heart",
                "active": "1",
                "lft": "110",
                "rgt": "125",
                "depth": "0",
                "type": "classified",
                "is_for_permanent": "0",
                "parentClosure": null
            },
            {
                "id": 62,
                "parent_id": null,
                "name": "Beauty &amp; Well being",
                "slug": "beauty-well-being",
                "description": "",
                "picture": "app\/categories\/skin-blue\/spa.png",
                "icon_class": "icon-search",
                "active": "1",
                "lft": "126",
                "rgt": "147",
                "depth": "0",
                "type": "classified",
                "is_for_permanent": "0",
                "parentClosure": null
            },
            {
                "id": 73,
                "parent_id": null,
                "name": "Jobs",
                "slug": "jobs",
                "description": "",
                "picture": "app\/categories\/skin-blue\/mfglabs-users.png",
                "icon_class": "icon-megaphone-1",
                "active": "1",
                "lft": "148",
                "rgt": "195",
                "depth": "0",
                "type": "job-offer",
                "is_for_permanent": "0",
                "parentClosure": null
            },
            {
                "id": 97,
                "parent_id": null,
                "name": "Services",
                "slug": "services",
                "description": "",
                "picture": "app\/categories\/skin-blue\/ion-clipboard.png",
                "icon_class": "fa fa-briefcase",
                "active": "1",
                "lft": "196",
                "rgt": "229",
                "depth": "0",
                "type": "classified",
                "is_for_permanent": "0",
                "parentClosure": null
            },
            {
                "id": 114,
                "parent_id": null,
                "name": "Learning",
                "slug": "learning",
                "description": "",
                "picture": "app\/categories\/skin-blue\/fa-graduation-cap.png",
                "icon_class": "icon-book-open",
                "active": "1",
                "lft": "230",
                "rgt": "245",
                "depth": "0",
                "type": "classified",
                "is_for_permanent": "0",
                "parentClosure": null
            },
            {
                "id": 122,
                "parent_id": null,
                "name": "Local Events",
                "slug": "local-events",
                "description": "",
                "picture": "app\/categories\/skin-blue\/calendar-alt.png",
                "icon_class": "icon-megaphone-1",
                "active": "1",
                "lft": "246",
                "rgt": "271",
                "depth": "0",
                "type": "classified",
                "is_for_permanent": "0",
                "parentClosure": null
            },
            {
                "id": 136,
                "parent_id": null,
                "name": "Je test une nouvelle",
                "slug": "je-test-une-nouvelle",
                "description": "Merci",
                "picture": "app\/default\/categories\/fa-folder-skin-blue.png",
                "icon_class": null,
                "active": "1",
                "lft": "272",
                "rgt": "273",
                "depth": "0",
                "type": "classified",
                "is_for_permanent": "0",
                "parentClosure": null
            }
        ]
    }
}</code></pre>
<div id="execution-results-GETapi-categories" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-categories"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-categories"></code></pre>
</div>
<div id="execution-error-GETapi-categories" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-categories"></code></pre>
</div>
<form id="form-GETapi-categories" data-method="GET" data-path="api/categories" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-categories', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-categories" onclick="tryItOut('GETapi-categories');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-categories" onclick="cancelTryOut('GETapi-categories');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-categories" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/categories</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>parentId</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="parentId" data-endpoint="GETapi-categories" data-component="query"  hidden>
<br>
The ID of the parent category of the sub categories to retrieve.
</p>
<p>
<b><code>embed</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="embed" data-endpoint="GETapi-categories" data-component="query"  hidden>
<br>
The Comma-separated list of the category relationships for Eager Loading. Possible values: parent,children
</p>
</form>
<h2>Get category</h2>
<p>Get category by it's unique slug or ID.</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/categories/molestias?parentCatSlug=car" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/categories/molestias"
);

let params = {
    "parentCatSlug": "car",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/categories/molestias',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'parentCatSlug'=&gt; 'car',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "message": null,
    "result": []
}</code></pre>
<div id="execution-results-GETapi-categories--slugOrId-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-categories--slugOrId-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-categories--slugOrId-"></code></pre>
</div>
<div id="execution-error-GETapi-categories--slugOrId-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-categories--slugOrId-"></code></pre>
</div>
<form id="form-GETapi-categories--slugOrId-" data-method="GET" data-path="api/categories/{slugOrId}" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-categories--slugOrId-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-categories--slugOrId-" onclick="tryItOut('GETapi-categories--slugOrId-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-categories--slugOrId-" onclick="cancelTryOut('GETapi-categories--slugOrId-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-categories--slugOrId-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/categories/{slugOrId}</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>slugOrId</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="slugOrId" data-endpoint="GETapi-categories--slugOrId-" data-component="url"  hidden>
<br>
The slug or ID of the category.
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>parentCatSlug</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="parentCatSlug" data-endpoint="GETapi-categories--slugOrId-" data-component="query"  hidden>
<br>
The slug of the parent category to retrieve used when category's slug provided instead of ID.
</p>
</form>
<h2>List category&#039;s fields</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "https://laraclassified.bedigit.local/api/categories/voluptate/fields" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs" \
    -d '{"language_code":"en","post_id":1}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/categories/voluptate/fields"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

let body = {
    "language_code": "en",
    "post_id": 1
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://laraclassified.bedigit.local/api/categories/voluptate/fields',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'json' =&gt; [
            'language_code' =&gt; 'en',
            'post_id' =&gt; 1,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Page Not Found."
}</code></pre>
<div id="execution-results-POSTapi-categories--id--fields" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-categories--id--fields"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-categories--id--fields"></code></pre>
</div>
<div id="execution-error-POSTapi-categories--id--fields" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-categories--id--fields"></code></pre>
</div>
<form id="form-POSTapi-categories--id--fields" data-method="POST" data-path="api/categories/{id}/fields" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-categories--id--fields', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-categories--id--fields" onclick="tryItOut('POSTapi-categories--id--fields');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-categories--id--fields" onclick="cancelTryOut('POSTapi-categories--id--fields');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-categories--id--fields" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/categories/{id}/fields</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="POSTapi-categories--id--fields" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>language_code</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="language_code" data-endpoint="POSTapi-categories--id--fields" data-component="body"  hidden>
<br>
The code of the user's spoken language.
</p>
<p>
<b><code>post_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="post_id" data-endpoint="POSTapi-categories--id--fields" data-component="body" required  hidden>
<br>
The unique ID of the post.
</p>

</form><h1>Contact</h1>
<h2>Send Form</h2>
<p>Send a message to the site owner.</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "https://laraclassified.bedigit.local/api/contact" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs" \
    -d '{"first_name":"John","last_name":"Doe","email":"john.doe@domain.tld","message":"Nesciunt porro possimus maiores voluptatibus accusamus velit qui aspernatur.","country_code":"US","country_name":"United Sates","captcha_key":"voluptate"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/contact"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

let body = {
    "first_name": "John",
    "last_name": "Doe",
    "email": "john.doe@domain.tld",
    "message": "Nesciunt porro possimus maiores voluptatibus accusamus velit qui aspernatur.",
    "country_code": "US",
    "country_name": "United Sates",
    "captcha_key": "voluptate"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://laraclassified.bedigit.local/api/contact',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'json' =&gt; [
            'first_name' =&gt; 'John',
            'last_name' =&gt; 'Doe',
            'email' =&gt; 'john.doe@domain.tld',
            'message' =&gt; 'Nesciunt porro possimus maiores voluptatibus accusamus velit qui aspernatur.',
            'country_code' =&gt; 'US',
            'country_name' =&gt; 'United Sates',
            'captcha_key' =&gt; 'voluptate',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "message": "Your message has been sent to our moderators. Thank you.",
    "result": {
        "first_name": "John",
        "last_name": "Doe",
        "email": "john.doe@domain.tld",
        "message": "Nesciunt porro possimus maiores voluptatibus accusamus velit qui aspernatur.",
        "country_code": "US",
        "country_name": "United Sates",
        "captcha_key": "voluptate"
    }
}</code></pre>
<div id="execution-results-POSTapi-contact" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-contact"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-contact"></code></pre>
</div>
<div id="execution-error-POSTapi-contact" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-contact"></code></pre>
</div>
<form id="form-POSTapi-contact" data-method="POST" data-path="api/contact" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-contact', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-contact" onclick="tryItOut('POSTapi-contact');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-contact" onclick="cancelTryOut('POSTapi-contact');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-contact" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/contact</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>first_name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="first_name" data-endpoint="POSTapi-contact" data-component="body" required  hidden>
<br>
The user's first name.
</p>
<p>
<b><code>last_name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="last_name" data-endpoint="POSTapi-contact" data-component="body" required  hidden>
<br>
The user's last name.
</p>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="email" data-endpoint="POSTapi-contact" data-component="body" required  hidden>
<br>
The user's email address.
</p>
<p>
<b><code>message</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="message" data-endpoint="POSTapi-contact" data-component="body" required  hidden>
<br>
The message to send.
</p>
<p>
<b><code>country_code</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="country_code" data-endpoint="POSTapi-contact" data-component="body" required  hidden>
<br>
The user's country code.
</p>
<p>
<b><code>country_name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="country_name" data-endpoint="POSTapi-contact" data-component="body" required  hidden>
<br>
The user's country name.
</p>
<p>
<b><code>captcha_key</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="captcha_key" data-endpoint="POSTapi-contact" data-component="body"  hidden>
<br>
Key generated by the CAPTCHA endpoint calling (Required if the CAPTCHA verification is enabled from the Admin panel).
</p>

</form>
<h2>Report post</h2>
<p>Report abuse or issues</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "https://laraclassified.bedigit.local/api/posts/3/report" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs" \
    -d '{"report_type_id":2,"email":"john.doe@domain.tld","message":"Et sunt voluptatibus ducimus id assumenda sint.","captcha_key":"est"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/posts/3/report"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

let body = {
    "report_type_id": 2,
    "email": "john.doe@domain.tld",
    "message": "Et sunt voluptatibus ducimus id assumenda sint.",
    "captcha_key": "est"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://laraclassified.bedigit.local/api/posts/3/report',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'json' =&gt; [
            'report_type_id' =&gt; 2,
            'email' =&gt; 'john.doe@domain.tld',
            'message' =&gt; 'Et sunt voluptatibus ducimus id assumenda sint.',
            'captcha_key' =&gt; 'est',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "message": "Your report has sent successfully to us. Thank you!",
    "result": {
        "report_type_id": 2,
        "email": "john.doe@domain.tld",
        "message": "Et sunt voluptatibus ducimus id assumenda sint.",
        "captcha_key": "est"
    },
    "extra": {
        "post": {
            "id": 3,
            "country_code": "US",
            "user_id": "2",
            "category_id": "7",
            "post_type_id": "2",
            "title": "Chevrolet Colorado (2018) used",
            "description": "Ex dolorum perspiciatis autem unde est velit quia. Quisquam provident quidem corrupti blanditiis dolorem officiis ducimus ipsa. Eum modi asperiores saepe voluptate quo. Dignissimos perferendis illum eaque nesciunt soluta laboriosam et. Quae id eum dolorem velit aut commodi quo id.\n\nVoluptates excepturi ut consectetur non facere. Eos voluptas magni dolore dolores tempore. Accusantium qui sed iste soluta necessitatibus ipsa incidunt. Dolor dolorum cupiditate inventore laborum saepe.\n\nIncidunt sed aut modi veritatis. Iste placeat nihil quas. Suscipit possimus voluptatem rerum quae sunt voluptatem quo ducimus.",
            "tags": "vel,quam,accusantium",
            "price": "80178.00",
            "negotiable": "0",
            "contact_name": "Admin Demo",
            "email": "admin@demosite.com",
            "phone": "+3581876675678",
            "phone_hidden": "0",
            "address": null,
            "city_id": "48771",
            "lat": "43.49",
            "lon": "-116.42",
            "ip_addr": "79.189.12.7",
            "visits": "27443",
            "tmp_token": null,
            "email_token": null,
            "phone_token": "demoFaker",
            "verified_email": "1",
            "verified_phone": "1",
            "accept_terms": "1",
            "accept_marketing_offers": "1",
            "is_permanent": "0",
            "reviewed": "1",
            "featured": "1",
            "archived": "0",
            "archived_at": "2021-03-20T02:33:49.000000Z",
            "deletion_mail_sent_at": null,
            "fb_profile": null,
            "partner": null,
            "created_at": "2021-03-14T03:45:26.000000Z",
            "updated_at": "2021-03-20T02:33:49.000000Z",
            "slug": "chevrolet-colorado-2018-used",
            "created_at_formatted": "Mar 13th, 2021 at 22:45",
            "user_photo_url": "https:\/\/secure.gravatar.com\/avatar\/2c8d72670651b506eb9d86d8e666b24a.jpg?s=150&amp;d=http%3A%2F%2Flaraclassified.bedigit.local%2Fimages%2Fuser.jpg&amp;r=g"
        }
    }
}</code></pre>
<div id="execution-results-POSTapi-posts--id--report" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-posts--id--report"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-posts--id--report"></code></pre>
</div>
<div id="execution-error-POSTapi-posts--id--report" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-posts--id--report"></code></pre>
</div>
<form id="form-POSTapi-posts--id--report" data-method="POST" data-path="api/posts/{id}/report" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-posts--id--report', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-posts--id--report" onclick="tryItOut('POSTapi-posts--id--report');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-posts--id--report" onclick="cancelTryOut('POSTapi-posts--id--report');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-posts--id--report" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/posts/{id}/report</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="id" data-endpoint="POSTapi-posts--id--report" data-component="url" required  hidden>
<br>
The post ID.
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>report_type_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="report_type_id" data-endpoint="POSTapi-posts--id--report" data-component="body" required  hidden>
<br>
The report type ID.
</p>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="email" data-endpoint="POSTapi-posts--id--report" data-component="body" required  hidden>
<br>
The user's email address.
</p>
<p>
<b><code>message</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="message" data-endpoint="POSTapi-posts--id--report" data-component="body" required  hidden>
<br>
The message to send.
</p>
<p>
<b><code>captcha_key</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="captcha_key" data-endpoint="POSTapi-posts--id--report" data-component="body"  hidden>
<br>
Key generated by the CAPTCHA endpoint calling (Required if the CAPTCHA verification is enabled from the Admin panel).
</p>

</form><h1>Countries</h1>
<h2>List countries</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/countries?embed=maiores" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/countries"
);

let params = {
    "embed": "maiores",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/countries',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'embed'=&gt; 'maiores',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "message": null,
    "result": {
        "data": [
            {
                "code": "AD",
                "name": "Andorra",
                "capital": "Andorra la Vella",
                "continent_code": "EU",
                "tld": ".ad",
                "currency_code": "EUR",
                "phone": "376",
                "languages": "ca",
                "time_zone": "Europe\/Andorra",
                "date_format": null,
                "datetime_format": null,
                "background_image": "app\/logo\/header-60562b381cd19.jpg",
                "admin_type": "0",
                "admin_field_active": "0",
                "active": "1"
            },
            {
                "code": "AE",
                "name": "United Arab Emirates",
                "capital": "Abu Dhabi",
                "continent_code": "AS",
                "tld": ".ae",
                "currency_code": "AED",
                "phone": "971",
                "languages": "ar-AE,fa,en,hi,ur",
                "time_zone": "Asia\/Dubai",
                "date_format": null,
                "datetime_format": null,
                "background_image": "app\/logo\/header-60562b381df8c.jpg",
                "admin_type": "0",
                "admin_field_active": "0",
                "active": "1"
            },
            {
                "code": "AF",
                "name": "Afghanistan",
                "capital": "Kabul",
                "continent_code": "AS",
                "tld": ".af",
                "currency_code": "AFN",
                "phone": "93",
                "languages": "fa-AF,ps,uz-AF,tk",
                "time_zone": "Asia\/Kabul",
                "date_format": null,
                "datetime_format": null,
                "background_image": "app\/logo\/header-60562b381ee90.jpg",
                "admin_type": "0",
                "admin_field_active": "0",
                "active": "1"
            },
            {
                "code": "AG",
                "name": "Antigua and Barbuda",
                "capital": "St. John's",
                "continent_code": "NA",
                "tld": ".ag",
                "currency_code": "XCD",
                "phone": "+1-268",
                "languages": "en-AG",
                "time_zone": "America\/Antigua",
                "date_format": null,
                "datetime_format": null,
                "background_image": "app\/logo\/header-60562b381ff82.jpg",
                "admin_type": "0",
                "admin_field_active": "0",
                "active": "1"
            },
            {
                "code": "AI",
                "name": "Anguilla",
                "capital": "The Valley",
                "continent_code": "NA",
                "tld": ".ai",
                "currency_code": "XCD",
                "phone": "+1-264",
                "languages": "en-AI",
                "time_zone": "America\/Anguilla",
                "date_format": null,
                "datetime_format": null,
                "background_image": "app\/logo\/header-60562b3820ba0.jpg",
                "admin_type": "0",
                "admin_field_active": "0",
                "active": "1"
            },
            {
                "code": "AL",
                "name": "Albania",
                "capital": "Tirana",
                "continent_code": "EU",
                "tld": ".al",
                "currency_code": "ALL",
                "phone": "355",
                "languages": "sq,el",
                "time_zone": "Europe\/Tirane",
                "date_format": null,
                "datetime_format": null,
                "background_image": "app\/logo\/header-60562b382139d.jpg",
                "admin_type": "0",
                "admin_field_active": "0",
                "active": "1"
            },
            {
                "code": "AM",
                "name": "Armenia",
                "capital": "Yerevan",
                "continent_code": "AS",
                "tld": ".am",
                "currency_code": "AMD",
                "phone": "374",
                "languages": "hy",
                "time_zone": "Asia\/Yerevan",
                "date_format": null,
                "datetime_format": null,
                "background_image": "app\/logo\/header-60562b3821f79.jpg",
                "admin_type": "0",
                "admin_field_active": "0",
                "active": "1"
            },
            {
                "code": "AN",
                "name": "Netherlands Antilles",
                "capital": "Willemstad",
                "continent_code": "NA",
                "tld": ".an",
                "currency_code": "ANG",
                "phone": "599",
                "languages": "nl-AN,en,es",
                "time_zone": "UTC",
                "date_format": null,
                "datetime_format": null,
                "background_image": "app\/logo\/header-60562b3822cea.jpg",
                "admin_type": "0",
                "admin_field_active": "0",
                "active": "1"
            },
            {
                "code": "AO",
                "name": "Angola",
                "capital": "Luanda",
                "continent_code": "AF",
                "tld": ".ao",
                "currency_code": "AOA",
                "phone": "244",
                "languages": "pt-AO",
                "time_zone": "Africa\/Luanda",
                "date_format": null,
                "datetime_format": null,
                "background_image": "app\/logo\/header-60562b3823475.jpg",
                "admin_type": "0",
                "admin_field_active": "0",
                "active": "1"
            },
            {
                "code": "AR",
                "name": "Argentina",
                "capital": "Buenos Aires",
                "continent_code": "SA",
                "tld": ".ar",
                "currency_code": "ARS",
                "phone": "54",
                "languages": "es-AR,en,it,de,fr,gn",
                "time_zone": "America\/Argentina\/Buenos_Aires",
                "date_format": null,
                "datetime_format": null,
                "background_image": "app\/logo\/header-60562b3823f41.jpg",
                "admin_type": "0",
                "admin_field_active": "0",
                "active": "1"
            },
            {
                "code": "AS",
                "name": "American Samoa",
                "capital": "Pago Pago",
                "continent_code": "OC",
                "tld": ".as",
                "currency_code": "USD",
                "phone": "+1-684",
                "languages": "en-AS,sm,to",
                "time_zone": "Pacific\/Pago_Pago",
                "date_format": null,
                "datetime_format": null,
                "background_image": "app\/logo\/header-60562b382468c.jpg",
                "admin_type": "0",
                "admin_field_active": "0",
                "active": "1"
            },
            {
                "code": "AT",
                "name": "Austria",
                "capital": "Vienna",
                "continent_code": "EU",
                "tld": ".at",
                "currency_code": "EUR",
                "phone": "43",
                "languages": "de-AT,hr,hu,sl",
                "time_zone": "Europe\/Vienna",
                "date_format": null,
                "datetime_format": null,
                "background_image": "app\/logo\/header-60562b3825511.jpg",
                "admin_type": "0",
                "admin_field_active": "0",
                "active": "1"
            }
        ],
        "links": {
            "first": "http:\/\/localhost\/api\/countries?page=1",
            "last": "http:\/\/localhost\/api\/countries?page=21",
            "prev": null,
            "next": "http:\/\/localhost\/api\/countries?page=2"
        },
        "meta": {
            "current_page": 1,
            "from": 1,
            "last_page": 21,
            "links": [
                {
                    "url": null,
                    "label": "&amp;laquo; Previous",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries?page=1",
                    "label": "1",
                    "active": true
                },
                {
                    "url": "http:\/\/localhost\/api\/countries?page=2",
                    "label": "2",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries?page=3",
                    "label": "3",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries?page=4",
                    "label": "4",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries?page=5",
                    "label": "5",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries?page=6",
                    "label": "6",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries?page=7",
                    "label": "7",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries?page=8",
                    "label": "8",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries?page=9",
                    "label": "9",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries?page=10",
                    "label": "10",
                    "active": false
                },
                {
                    "url": null,
                    "label": "...",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries?page=20",
                    "label": "20",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries?page=21",
                    "label": "21",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries?page=2",
                    "label": "Next &amp;raquo;",
                    "active": false
                }
            ],
            "path": "http:\/\/localhost\/api\/countries",
            "per_page": "12",
            "to": 12,
            "total": 251
        }
    }
}</code></pre>
<div id="execution-results-GETapi-countries" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-countries"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-countries"></code></pre>
</div>
<div id="execution-error-GETapi-countries" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-countries"></code></pre>
</div>
<form id="form-GETapi-countries" data-method="GET" data-path="api/countries" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-countries', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-countries" onclick="tryItOut('GETapi-countries');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-countries" onclick="cancelTryOut('GETapi-countries');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-countries" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/countries</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>embed</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="embed" data-endpoint="GETapi-countries" data-component="query"  hidden>
<br>
Comma-separated list of the country relationships for Eager Loading. Possible values: currency
</p>
</form>
<h2>Get country</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/countries/DE?embed=dolore" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/countries/DE"
);

let params = {
    "embed": "dolore",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/countries/DE',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'embed'=&gt; 'dolore',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "message": null,
    "result": {
        "code": "DE",
        "name": "Germany",
        "capital": "Berlin",
        "continent_code": "EU",
        "tld": ".de",
        "currency_code": "EUR",
        "phone": "49",
        "languages": "de",
        "time_zone": "Europe\/Berlin",
        "date_format": null,
        "datetime_format": null,
        "background_image": "app\/logo\/header-60562b3840814.jpg",
        "admin_type": "0",
        "admin_field_active": "0",
        "active": "1"
    }
}</code></pre>
<div id="execution-results-GETapi-countries--code-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-countries--code-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-countries--code-"></code></pre>
</div>
<div id="execution-error-GETapi-countries--code-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-countries--code-"></code></pre>
</div>
<form id="form-GETapi-countries--code-" data-method="GET" data-path="api/countries/{code}" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-countries--code-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-countries--code-" onclick="tryItOut('GETapi-countries--code-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-countries--code-" onclick="cancelTryOut('GETapi-countries--code-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-countries--code-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/countries/{code}</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>code</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="code" data-endpoint="GETapi-countries--code-" data-component="url"  hidden>
<br>
The country's ISO 3166-1 code.
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>embed</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="embed" data-endpoint="GETapi-countries--code-" data-component="query"  hidden>
<br>
Comma-separated list of the country relationships for Eager Loading. Possible values: currency
</p>
</form>
<h2>List admin. divisions (1)</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/countries/US/subAdmins1?embed=fugiat" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/countries/US/subAdmins1"
);

let params = {
    "embed": "fugiat",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/countries/US/subAdmins1',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'embed'=&gt; 'fugiat',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "message": null,
    "result": {
        "data": [
            {
                "code": "US.AR",
                "country_code": "US",
                "name": "Arkansas",
                "active": "1"
            },
            {
                "code": "US.DC",
                "country_code": "US",
                "name": "Washington, D.C.",
                "active": "1"
            },
            {
                "code": "US.DE",
                "country_code": "US",
                "name": "Delaware",
                "active": "1"
            },
            {
                "code": "US.FL",
                "country_code": "US",
                "name": "Florida",
                "active": "1"
            },
            {
                "code": "US.GA",
                "country_code": "US",
                "name": "Georgia",
                "active": "1"
            },
            {
                "code": "US.KS",
                "country_code": "US",
                "name": "Kansas",
                "active": "1"
            },
            {
                "code": "US.LA",
                "country_code": "US",
                "name": "Louisiana",
                "active": "1"
            },
            {
                "code": "US.MD",
                "country_code": "US",
                "name": "Maryland",
                "active": "1"
            },
            {
                "code": "US.MO",
                "country_code": "US",
                "name": "Missouri",
                "active": "1"
            },
            {
                "code": "US.MS",
                "country_code": "US",
                "name": "Mississippi",
                "active": "1"
            },
            {
                "code": "US.NC",
                "country_code": "US",
                "name": "North Carolina",
                "active": "1"
            },
            {
                "code": "US.OK",
                "country_code": "US",
                "name": "Oklahoma",
                "active": "1"
            }
        ],
        "links": {
            "first": "http:\/\/localhost\/api\/countries\/US\/subAdmins1?page=1",
            "last": "http:\/\/localhost\/api\/countries\/US\/subAdmins1?page=5",
            "prev": null,
            "next": "http:\/\/localhost\/api\/countries\/US\/subAdmins1?page=2"
        },
        "meta": {
            "current_page": 1,
            "from": 1,
            "last_page": 5,
            "links": [
                {
                    "url": null,
                    "label": "&amp;laquo; Previous",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/subAdmins1?page=1",
                    "label": "1",
                    "active": true
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/subAdmins1?page=2",
                    "label": "2",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/subAdmins1?page=3",
                    "label": "3",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/subAdmins1?page=4",
                    "label": "4",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/subAdmins1?page=5",
                    "label": "5",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/subAdmins1?page=2",
                    "label": "Next &amp;raquo;",
                    "active": false
                }
            ],
            "path": "http:\/\/localhost\/api\/countries\/US\/subAdmins1",
            "per_page": "12",
            "to": 12,
            "total": 51
        }
    }
}</code></pre>
<div id="execution-results-GETapi-countries--countryCode--subAdmins1" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-countries--countryCode--subAdmins1"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-countries--countryCode--subAdmins1"></code></pre>
</div>
<div id="execution-error-GETapi-countries--countryCode--subAdmins1" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-countries--countryCode--subAdmins1"></code></pre>
</div>
<form id="form-GETapi-countries--countryCode--subAdmins1" data-method="GET" data-path="api/countries/{countryCode}/subAdmins1" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-countries--countryCode--subAdmins1', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-countries--countryCode--subAdmins1" onclick="tryItOut('GETapi-countries--countryCode--subAdmins1');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-countries--countryCode--subAdmins1" onclick="cancelTryOut('GETapi-countries--countryCode--subAdmins1');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-countries--countryCode--subAdmins1" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/countries/{countryCode}/subAdmins1</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>countryCode</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="countryCode" data-endpoint="GETapi-countries--countryCode--subAdmins1" data-component="url"  hidden>
<br>
The country code of the country of the cities to retrieve.
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>embed</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="embed" data-endpoint="GETapi-countries--countryCode--subAdmins1" data-component="query"  hidden>
<br>
Comma-separated list of the administrative division (1) relationships for Eager Loading. Possible values: country
</p>
</form>
<h2>List admin. divisions (2)</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/countries/US/subAdmins2?embed=qui" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/countries/US/subAdmins2"
);

let params = {
    "embed": "qui",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/countries/US/subAdmins2',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'embed'=&gt; 'qui',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "message": null,
    "result": {
        "data": [
            {
                "code": "US.AL.113",
                "country_code": "US",
                "subadmin1_code": "US.AL",
                "name": "Russell County",
                "active": "1"
            },
            {
                "code": "US.GA.183",
                "country_code": "US",
                "subadmin1_code": "US.GA",
                "name": "Long County",
                "active": "1"
            },
            {
                "code": "US.KY.015",
                "country_code": "US",
                "subadmin1_code": "US.KY",
                "name": "Boone County",
                "active": "1"
            },
            {
                "code": "US.KY.205",
                "country_code": "US",
                "subadmin1_code": "US.KY",
                "name": "Rowan County",
                "active": "1"
            },
            {
                "code": "US.AL.007",
                "country_code": "US",
                "subadmin1_code": "US.AL",
                "name": "Bibb County",
                "active": "1"
            },
            {
                "code": "US.TN.013",
                "country_code": "US",
                "subadmin1_code": "US.TN",
                "name": "Campbell County",
                "active": "1"
            },
            {
                "code": "US.AL.009",
                "country_code": "US",
                "subadmin1_code": "US.AL",
                "name": "Blount County",
                "active": "1"
            },
            {
                "code": "US.AL.011",
                "country_code": "US",
                "subadmin1_code": "US.AL",
                "name": "Bullock County",
                "active": "1"
            },
            {
                "code": "US.AL.013",
                "country_code": "US",
                "subadmin1_code": "US.AL",
                "name": "Butler County",
                "active": "1"
            },
            {
                "code": "US.AL.015",
                "country_code": "US",
                "subadmin1_code": "US.AL",
                "name": "Calhoun County",
                "active": "1"
            },
            {
                "code": "US.AL.017",
                "country_code": "US",
                "subadmin1_code": "US.AL",
                "name": "Chambers County",
                "active": "1"
            },
            {
                "code": "US.AL.019",
                "country_code": "US",
                "subadmin1_code": "US.AL",
                "name": "Cherokee County",
                "active": "1"
            }
        ],
        "links": {
            "first": "http:\/\/localhost\/api\/countries\/US\/subAdmins2?page=1",
            "last": "http:\/\/localhost\/api\/countries\/US\/subAdmins2?page=262",
            "prev": null,
            "next": "http:\/\/localhost\/api\/countries\/US\/subAdmins2?page=2"
        },
        "meta": {
            "current_page": 1,
            "from": 1,
            "last_page": 262,
            "links": [
                {
                    "url": null,
                    "label": "&amp;laquo; Previous",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/subAdmins2?page=1",
                    "label": "1",
                    "active": true
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/subAdmins2?page=2",
                    "label": "2",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/subAdmins2?page=3",
                    "label": "3",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/subAdmins2?page=4",
                    "label": "4",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/subAdmins2?page=5",
                    "label": "5",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/subAdmins2?page=6",
                    "label": "6",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/subAdmins2?page=7",
                    "label": "7",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/subAdmins2?page=8",
                    "label": "8",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/subAdmins2?page=9",
                    "label": "9",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/subAdmins2?page=10",
                    "label": "10",
                    "active": false
                },
                {
                    "url": null,
                    "label": "...",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/subAdmins2?page=261",
                    "label": "261",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/subAdmins2?page=262",
                    "label": "262",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/subAdmins2?page=2",
                    "label": "Next &amp;raquo;",
                    "active": false
                }
            ],
            "path": "http:\/\/localhost\/api\/countries\/US\/subAdmins2",
            "per_page": "12",
            "to": 12,
            "total": 3142
        }
    }
}</code></pre>
<div id="execution-results-GETapi-countries--countryCode--subAdmins2" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-countries--countryCode--subAdmins2"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-countries--countryCode--subAdmins2"></code></pre>
</div>
<div id="execution-error-GETapi-countries--countryCode--subAdmins2" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-countries--countryCode--subAdmins2"></code></pre>
</div>
<form id="form-GETapi-countries--countryCode--subAdmins2" data-method="GET" data-path="api/countries/{countryCode}/subAdmins2" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-countries--countryCode--subAdmins2', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-countries--countryCode--subAdmins2" onclick="tryItOut('GETapi-countries--countryCode--subAdmins2');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-countries--countryCode--subAdmins2" onclick="cancelTryOut('GETapi-countries--countryCode--subAdmins2');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-countries--countryCode--subAdmins2" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/countries/{countryCode}/subAdmins2</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>countryCode</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="countryCode" data-endpoint="GETapi-countries--countryCode--subAdmins2" data-component="url"  hidden>
<br>
The country code of the country of the cities to retrieve.
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>embed</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="embed" data-endpoint="GETapi-countries--countryCode--subAdmins2" data-component="query"  hidden>
<br>
Comma-separated list of the administrative division (2) relationships for Eager Loading. Possible values: country,subAdmin1
</p>
</form>
<h2>List cities</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/countries/US/cities?embed=laudantium" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/countries/US/cities"
);

let params = {
    "embed": "laudantium",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/countries/US/cities',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'embed'=&gt; 'laudantium',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "message": null,
    "result": {
        "data": [
            {
                "id": 42321,
                "country_code": "US",
                "name": "Bay Minette",
                "latitude": "30.88",
                "longitude": "-87.77",
                "subadmin1_code": "US.AL",
                "subadmin2_code": "US.AL.003",
                "population": "9118",
                "time_zone": "America\/Chicago",
                "active": "1"
            },
            {
                "id": 42322,
                "country_code": "US",
                "name": "Edna",
                "latitude": "28.98",
                "longitude": "-96.65",
                "subadmin1_code": "US.TX",
                "subadmin2_code": "US.TX.239",
                "population": "5792",
                "time_zone": "America\/Chicago",
                "active": "1"
            },
            {
                "id": 42323,
                "country_code": "US",
                "name": "Henderson",
                "latitude": "32.15",
                "longitude": "-94.8",
                "subadmin1_code": "US.TX",
                "subadmin2_code": "US.TX.401",
                "population": "13529",
                "time_zone": "America\/Chicago",
                "active": "1"
            },
            {
                "id": 42324,
                "country_code": "US",
                "name": "Fort Hunt",
                "latitude": "38.73",
                "longitude": "-77.06",
                "subadmin1_code": "US.VA",
                "subadmin2_code": "US.VA.059",
                "population": "16045",
                "time_zone": "America\/New_York",
                "active": "1"
            },
            {
                "id": 42325,
                "country_code": "US",
                "name": "Trinity",
                "latitude": "28.18",
                "longitude": "-82.68",
                "subadmin1_code": "US.FL",
                "subadmin2_code": "US.FL.101",
                "population": "10907",
                "time_zone": "America\/New_York",
                "active": "1"
            },
            {
                "id": 42326,
                "country_code": "US",
                "name": "Villas",
                "latitude": "26.55",
                "longitude": "-81.87",
                "subadmin1_code": "US.FL",
                "subadmin2_code": "US.FL.071",
                "population": "11569",
                "time_zone": "America\/New_York",
                "active": "1"
            },
            {
                "id": 42327,
                "country_code": "US",
                "name": "Bessemer",
                "latitude": "33.4",
                "longitude": "-86.95",
                "subadmin1_code": "US.AL",
                "subadmin2_code": "US.AL.073",
                "population": "26730",
                "time_zone": "America\/Chicago",
                "active": "1"
            },
            {
                "id": 42328,
                "country_code": "US",
                "name": "Paducah",
                "latitude": "37.08",
                "longitude": "-88.6",
                "subadmin1_code": "US.KY",
                "subadmin2_code": "US.KY.145",
                "population": "24864",
                "time_zone": "America\/Chicago",
                "active": "1"
            },
            {
                "id": 42329,
                "country_code": "US",
                "name": "Red Chute",
                "latitude": "32.56",
                "longitude": "-93.61",
                "subadmin1_code": "US.LA",
                "subadmin2_code": "US.LA.015",
                "population": "6261",
                "time_zone": "America\/Chicago",
                "active": "1"
            },
            {
                "id": 42330,
                "country_code": "US",
                "name": "Jessup",
                "latitude": "39.15",
                "longitude": "-76.78",
                "subadmin1_code": "US.MD",
                "subadmin2_code": "US.MD.003",
                "population": "7137",
                "time_zone": "America\/New_York",
                "active": "1"
            },
            {
                "id": 42331,
                "country_code": "US",
                "name": "Birmingham",
                "latitude": "33.52",
                "longitude": "-86.8",
                "subadmin1_code": "US.AL",
                "subadmin2_code": "US.AL.073",
                "population": "212461",
                "time_zone": "America\/Chicago",
                "active": "1"
            },
            {
                "id": 42332,
                "country_code": "US",
                "name": "Delhi Hills",
                "latitude": "39.09",
                "longitude": "-84.61",
                "subadmin1_code": "US.OH",
                "subadmin2_code": "US.OH.061",
                "population": "5259",
                "time_zone": "America\/New_York",
                "active": "1"
            }
        ],
        "links": {
            "first": "http:\/\/localhost\/api\/countries\/US\/cities?page=1",
            "last": "http:\/\/localhost\/api\/countries\/US\/cities?page=600",
            "prev": null,
            "next": "http:\/\/localhost\/api\/countries\/US\/cities?page=2"
        },
        "meta": {
            "current_page": 1,
            "from": 1,
            "last_page": 600,
            "links": [
                {
                    "url": null,
                    "label": "&amp;laquo; Previous",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/cities?page=1",
                    "label": "1",
                    "active": true
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/cities?page=2",
                    "label": "2",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/cities?page=3",
                    "label": "3",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/cities?page=4",
                    "label": "4",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/cities?page=5",
                    "label": "5",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/cities?page=6",
                    "label": "6",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/cities?page=7",
                    "label": "7",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/cities?page=8",
                    "label": "8",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/cities?page=9",
                    "label": "9",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/cities?page=10",
                    "label": "10",
                    "active": false
                },
                {
                    "url": null,
                    "label": "...",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/cities?page=599",
                    "label": "599",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/cities?page=600",
                    "label": "600",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost\/api\/countries\/US\/cities?page=2",
                    "label": "Next &amp;raquo;",
                    "active": false
                }
            ],
            "path": "http:\/\/localhost\/api\/countries\/US\/cities",
            "per_page": "12",
            "to": 12,
            "total": 7197
        }
    }
}</code></pre>
<div id="execution-results-GETapi-countries--countryCode--cities" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-countries--countryCode--cities"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-countries--countryCode--cities"></code></pre>
</div>
<div id="execution-error-GETapi-countries--countryCode--cities" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-countries--countryCode--cities"></code></pre>
</div>
<form id="form-GETapi-countries--countryCode--cities" data-method="GET" data-path="api/countries/{countryCode}/cities" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-countries--countryCode--cities', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-countries--countryCode--cities" onclick="tryItOut('GETapi-countries--countryCode--cities');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-countries--countryCode--cities" onclick="cancelTryOut('GETapi-countries--countryCode--cities');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-countries--countryCode--cities" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/countries/{countryCode}/cities</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>countryCode</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="countryCode" data-endpoint="GETapi-countries--countryCode--cities" data-component="url"  hidden>
<br>
The country code of the country of the cities to retrieve.
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>embed</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="embed" data-endpoint="GETapi-countries--countryCode--cities" data-component="query"  hidden>
<br>
Comma-separated list of the city relationships for Eager Loading. Possible values: country,subAdmin1,subAdmin2
</p>
</form>
<h2>Get admin. division (1)</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/subAdmins1/dignissimos?embed=aliquid" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/subAdmins1/dignissimos"
);

let params = {
    "embed": "aliquid",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/subAdmins1/dignissimos',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'embed'=&gt; 'aliquid',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Entry for Models\\SubAdmin1 not found",
    "result": null,
    "error_code": 1
}</code></pre>
<div id="execution-results-GETapi-subAdmins1--code-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-subAdmins1--code-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-subAdmins1--code-"></code></pre>
</div>
<div id="execution-error-GETapi-subAdmins1--code-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-subAdmins1--code-"></code></pre>
</div>
<form id="form-GETapi-subAdmins1--code-" data-method="GET" data-path="api/subAdmins1/{code}" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-subAdmins1--code-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-subAdmins1--code-" onclick="tryItOut('GETapi-subAdmins1--code-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-subAdmins1--code-" onclick="cancelTryOut('GETapi-subAdmins1--code-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-subAdmins1--code-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/subAdmins1/{code}</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>code</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="code" data-endpoint="GETapi-subAdmins1--code-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>embed</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="embed" data-endpoint="GETapi-subAdmins1--code-" data-component="query"  hidden>
<br>
Comma-separated list of the administrative division (1) relationships for Eager Loading. Possible values: country
</p>
</form>
<h2>Get admin. division (2)</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/subAdmins2/omnis?embed=necessitatibus" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/subAdmins2/omnis"
);

let params = {
    "embed": "necessitatibus",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/subAdmins2/omnis',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'embed'=&gt; 'necessitatibus',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Entry for Models\\SubAdmin2 not found",
    "result": null,
    "error_code": 1
}</code></pre>
<div id="execution-results-GETapi-subAdmins2--code-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-subAdmins2--code-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-subAdmins2--code-"></code></pre>
</div>
<div id="execution-error-GETapi-subAdmins2--code-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-subAdmins2--code-"></code></pre>
</div>
<form id="form-GETapi-subAdmins2--code-" data-method="GET" data-path="api/subAdmins2/{code}" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-subAdmins2--code-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-subAdmins2--code-" onclick="tryItOut('GETapi-subAdmins2--code-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-subAdmins2--code-" onclick="cancelTryOut('GETapi-subAdmins2--code-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-subAdmins2--code-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/subAdmins2/{code}</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>code</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="code" data-endpoint="GETapi-subAdmins2--code-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>embed</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="embed" data-endpoint="GETapi-subAdmins2--code-" data-component="query"  hidden>
<br>
Comma-separated list of the administrative division (2) relationships for Eager Loading. Possible values: country,subAdmin1
</p>
</form>
<h2>Get city</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/cities/laborum?embed=nisi" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/cities/laborum"
);

let params = {
    "embed": "nisi",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/cities/laborum',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'embed'=&gt; 'nisi',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Page Not Found."
}</code></pre>
<div id="execution-results-GETapi-cities--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-cities--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-cities--id-"></code></pre>
</div>
<div id="execution-error-GETapi-cities--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-cities--id-"></code></pre>
</div>
<form id="form-GETapi-cities--id-" data-method="GET" data-path="api/cities/{id}" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-cities--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-cities--id-" onclick="tryItOut('GETapi-cities--id-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-cities--id-" onclick="cancelTryOut('GETapi-cities--id-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-cities--id-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/cities/{id}</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-cities--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>embed</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="embed" data-endpoint="GETapi-cities--id-" data-component="query"  hidden>
<br>
Comma-separated list of the city relationships for Eager Loading. Possible values: country,subAdmin1,subAdmin2
</p>
</form><h1>Home</h1>
<h2>List sections</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/homeSections" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/homeSections"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/homeSections',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (429):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Too Many Requests,Please Slow Down",
    "result": null,
    "error_code": 1
}</code></pre>
<div id="execution-results-GETapi-homeSections" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-homeSections"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-homeSections"></code></pre>
</div>
<div id="execution-error-GETapi-homeSections" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-homeSections"></code></pre>
</div>
<form id="form-GETapi-homeSections" data-method="GET" data-path="api/homeSections" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-homeSections', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-homeSections" onclick="tryItOut('GETapi-homeSections');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-homeSections" onclick="cancelTryOut('GETapi-homeSections');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-homeSections" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/homeSections</code></b>
</p>
</form><h1>Packages</h1>
<h2>List packages</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/packages?embed=currency" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/packages"
);

let params = {
    "embed": "currency",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/packages',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'embed'=&gt; 'currency',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "message": null,
    "result": {
        "data": [
            {
                "id": 1,
                "name": "Regular List",
                "short_name": "Free",
                "ribbon": "red",
                "has_badge": "1",
                "price": "0.00",
                "currency_code": "USD",
                "promo_duration": null,
                "duration": null,
                "pictures_limit": null,
                "description": "",
                "facebook_ads_duration": "0",
                "google_ads_duration": "0",
                "twitter_ads_duration": "0",
                "linkedin_ads_duration": "0",
                "recommended": "0",
                "active": "1",
                "parent_id": null,
                "lft": "2",
                "rgt": "3",
                "depth": "0",
                "currency": {
                    "code": "USD",
                    "name": "United States Dollar",
                    "symbol": "$",
                    "html_entities": "&amp;#36;",
                    "in_left": "1",
                    "decimal_places": "2",
                    "decimal_separator": ".",
                    "thousand_separator": ","
                }
            },
            {
                "id": 2,
                "name": "Top page Ad",
                "short_name": "Premium",
                "ribbon": "orange",
                "has_badge": "1",
                "price": "7.50",
                "currency_code": "PLN",
                "promo_duration": "7",
                "duration": "60",
                "pictures_limit": "10",
                "description": "Featured on the homepage\r\nFeatured in the category",
                "facebook_ads_duration": "0",
                "google_ads_duration": "0",
                "twitter_ads_duration": "0",
                "linkedin_ads_duration": "0",
                "recommended": "1",
                "active": "1",
                "parent_id": null,
                "lft": "4",
                "rgt": "5",
                "depth": "0",
                "currency": {
                    "code": "PLN",
                    "name": "Poland Zloty",
                    "symbol": "zł",
                    "html_entities": "&amp;#122;&amp;#322;",
                    "in_left": "0",
                    "decimal_places": "2",
                    "decimal_separator": ".",
                    "thousand_separator": ","
                }
            },
            {
                "id": 3,
                "name": "Top page Ad+",
                "short_name": "Premium+",
                "ribbon": "green",
                "has_badge": "1",
                "price": "9.00",
                "currency_code": "USD",
                "promo_duration": "30",
                "duration": "120",
                "pictures_limit": "15",
                "description": "Featured on the homepage\nFeatured in the category",
                "facebook_ads_duration": "0",
                "google_ads_duration": "0",
                "twitter_ads_duration": "0",
                "linkedin_ads_duration": "0",
                "recommended": "0",
                "active": "1",
                "parent_id": null,
                "lft": "6",
                "rgt": "7",
                "depth": "0",
                "currency": {
                    "code": "USD",
                    "name": "United States Dollar",
                    "symbol": "$",
                    "html_entities": "&amp;#36;",
                    "in_left": "1",
                    "decimal_places": "2",
                    "decimal_separator": ".",
                    "thousand_separator": ","
                }
            }
        ]
    }
}</code></pre>
<div id="execution-results-GETapi-packages" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-packages"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-packages"></code></pre>
</div>
<div id="execution-error-GETapi-packages" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-packages"></code></pre>
</div>
<form id="form-GETapi-packages" data-method="GET" data-path="api/packages" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-packages', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-packages" onclick="tryItOut('GETapi-packages');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-packages" onclick="cancelTryOut('GETapi-packages');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-packages" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/packages</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>embed</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="embed" data-endpoint="GETapi-packages" data-component="query"  hidden>
<br>
Comma-separated list of the package relationships for Eager Loading.
</p>
</form>
<h2>Get package</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/packages/2?embed=currency" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/packages/2"
);

let params = {
    "embed": "currency",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/packages/2',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'embed'=&gt; 'currency',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "message": null,
    "result": {
        "id": 2,
        "name": "Top page Ad",
        "short_name": "Premium",
        "ribbon": "orange",
        "has_badge": "1",
        "price": "7.50",
        "currency_code": "PLN",
        "promo_duration": "7",
        "duration": "60",
        "pictures_limit": "10",
        "description": "Featured on the homepage\r\nFeatured in the category",
        "facebook_ads_duration": "0",
        "google_ads_duration": "0",
        "twitter_ads_duration": "0",
        "linkedin_ads_duration": "0",
        "recommended": "1",
        "active": "1",
        "parent_id": null,
        "lft": "4",
        "rgt": "5",
        "depth": "0",
        "currency": {
            "code": "PLN",
            "name": "Poland Zloty",
            "symbol": "zł",
            "html_entities": "&amp;#122;&amp;#322;",
            "in_left": "0",
            "decimal_places": "2",
            "decimal_separator": ".",
            "thousand_separator": ","
        }
    }
}</code></pre>
<div id="execution-results-GETapi-packages--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-packages--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-packages--id-"></code></pre>
</div>
<div id="execution-error-GETapi-packages--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-packages--id-"></code></pre>
</div>
<form id="form-GETapi-packages--id-" data-method="GET" data-path="api/packages/{id}" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-packages--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-packages--id-" onclick="tryItOut('GETapi-packages--id-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-packages--id-" onclick="cancelTryOut('GETapi-packages--id-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-packages--id-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/packages/{id}</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="id" data-endpoint="GETapi-packages--id-" data-component="url"  hidden>
<br>
The package's ID.
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>embed</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="embed" data-endpoint="GETapi-packages--id-" data-component="query"  hidden>
<br>
Comma-separated list of the package relationships for Eager Loading.
</p>
</form><h1>Pages</h1>
<h2>List pages</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/pages?excludedFromFooter=1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/pages"
);

let params = {
    "excludedFromFooter": "1",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/pages',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'excludedFromFooter'=&gt; '1',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "message": null,
    "result": {
        "data": [
            {
                "id": 4,
                "parent_id": null,
                "type": "standard",
                "name": "FAQ",
                "slug": "faq",
                "picture": null,
                "title": "Frequently Asked Questions",
                "content": "&lt;p&gt;&lt;b&gt;How do I place an ad?&lt;\/b&gt;&lt;\/p&gt;&lt;p&gt;It's very easy to place an ad: click on the button \"Post free Ads\" above right.&lt;\/p&gt;&lt;p&gt;&lt;b&gt;What does it cost to advertise?&lt;\/b&gt;&lt;\/p&gt;&lt;p&gt;The publication is 100% free throughout the website.&lt;\/p&gt;&lt;p&gt;&lt;b&gt;If I post an ad, will I also get more spam e-mails?&lt;\/b&gt;&lt;\/p&gt;&lt;p&gt;Absolutely not because your email address is not visible on the website.&lt;\/p&gt;&lt;p&gt;&lt;b&gt;How long will my ad remain on the website?&lt;\/b&gt;&lt;\/p&gt;&lt;p&gt;In general, an ad is automatically deactivated from the website after 3 months. You will receive an email a week before D-Day and another on the day of deactivation. You have the ability to put them online in the following month by logging into your account on the site. After this delay, your ad will be automatically removed permanently from the website.&lt;\/p&gt;&lt;p&gt;&lt;b&gt;I sold my item. How do I delete my ad?&lt;\/b&gt;&lt;\/p&gt;&lt;p&gt;Once your product is sold or leased, log in to your account to remove your ad.&lt;\/p&gt;",
                "external_link": null,
                "name_color": null,
                "title_color": null,
                "target_blank": "0",
                "excluded_from_footer": "0",
                "active": "1",
                "lft": "2",
                "rgt": "3",
                "depth": "1"
            },
            {
                "id": 3,
                "parent_id": null,
                "type": "standard",
                "name": "Anti-Scam",
                "slug": "anti-scam",
                "picture": null,
                "title": "Anti-Scam",
                "content": "&lt;p&gt;&lt;b&gt;Protect yourself against Internet fraud!&lt;\/b&gt;&lt;\/p&gt;&lt;p&gt;The vast majority of ads are posted by honest people and trust. So you can do excellent business. Despite this, it is important to follow a few common sense rules following to prevent any attempt to scam.&lt;\/p&gt;&lt;p&gt;&lt;b&gt;Our advices&lt;\/b&gt;&lt;\/p&gt;&lt;ul&gt;&lt;li&gt;Doing business with people you can meet in person.&lt;\/li&gt;&lt;li&gt;Never send money by Western Union, MoneyGram or other anonymous payment systems.&lt;\/li&gt;&lt;li&gt;Never send money or products abroad.&lt;\/li&gt;&lt;li&gt;Do not accept checks.&lt;\/li&gt;&lt;li&gt;Ask about the person you're dealing with another confirming source name, address and telephone number.&lt;\/li&gt;&lt;li&gt;Keep copies of all correspondence (emails, ads, letters, etc.) and details of the person.&lt;\/li&gt;&lt;li&gt;If a deal seems too good to be true, there is every chance that this is the case. Refrain.&lt;\/li&gt;&lt;\/ul&gt;&lt;p&gt;&lt;b&gt;Recognize attempted scam&lt;\/b&gt;&lt;\/p&gt;&lt;ul&gt;&lt;li&gt;The majority of scams have one or more of these characteristics:&lt;\/li&gt;&lt;li&gt;The person is abroad or traveling abroad.&lt;\/li&gt;&lt;li&gt;The person refuses to meet you in person.&lt;\/li&gt;&lt;li&gt;Payment is made through Western Union, Money Gram or check.&lt;\/li&gt;&lt;li&gt;The messages are in broken language (English or French or ...).&lt;\/li&gt;&lt;li&gt;The texts seem to be copied and pasted.&lt;\/li&gt;&lt;li&gt;The deal seems to be too good to be true.&lt;\/li&gt;&lt;\/ul&gt;",
                "external_link": null,
                "name_color": null,
                "title_color": null,
                "target_blank": "0",
                "excluded_from_footer": "0",
                "active": "1",
                "lft": "4",
                "rgt": "5",
                "depth": "1"
            },
            {
                "id": 1,
                "parent_id": null,
                "type": "terms",
                "name": "Terms",
                "slug": "terms",
                "picture": null,
                "title": "Terms &amp; Conditions",
                "content": "&lt;h4&gt;&lt;b&gt;Definitions&lt;\/b&gt;&lt;\/h4&gt;&lt;p&gt;Each of the terms mentioned below have in these Conditions of Sale LaraClassified Service (hereinafter the \"Conditions\") the following meanings:&lt;\/p&gt;&lt;ol&gt;&lt;li&gt;Announcement&amp;nbsp;: refers to all the elements and data (visual, textual, sound, photographs, drawings), presented by an Advertiser editorial under his sole responsibility, in order to buy, rent or sell a product or service and broadcast on the Website and Mobile Site.&lt;\/li&gt;&lt;li&gt;Advertiser&amp;nbsp;: means any natural or legal person, a major, established in France, holds an account and having submitted an announcement, from it, on the Website. Any Advertiser must be connected to the Personal Account for deposit and or manage its ads. Ad first deposit automatically entails the establishment of a Personal Account to the Advertiser.&lt;\/li&gt;&lt;li&gt;Personal Account&amp;nbsp;: refers to the free space than any Advertiser must create and which it should connect from the Website to disseminate, manage and view its ads.&lt;\/li&gt;&lt;li&gt;LaraClassified&amp;nbsp;: means the company that publishes and operates the Website and Mobile Site {YourCompany}, registered at the Trade and Companies Register of {YourCity} under the number {YourCompany Registration Number} whose registered office is at {YourCompany Address}.&lt;\/li&gt;&lt;li&gt;Customer Service&amp;nbsp;: LaraClassified means the department to which the Advertiser may obtain further information. This service can be contacted via email by clicking the link on the Website and Mobile Site.&lt;\/li&gt;&lt;li&gt;LaraClassified Service&amp;nbsp;: LaraClassified means the services made available to Users and Advertisers on the Website and Mobile Site.&lt;\/li&gt;&lt;li&gt;Website&amp;nbsp;: means the website operated by LaraClassified accessed mainly from the URL &lt;a href=\"https:\/\/bedigit.com\"&gt;https:\/\/bedigit.com&lt;\/a&gt; and allowing Users and Advertisers to access the Service via internet LaraClassified.&lt;\/li&gt;&lt;li&gt;Mobile Site&amp;nbsp;: is the mobile site operated by LaraClassified accessible from the URL &lt;a href=\"https:\/\/bedigit.com\"&gt;https:\/\/bedigit.com&lt;\/a&gt; and allowing Users and Advertisers to access via their mobile phone service {YourSiteName}.&lt;\/li&gt;&lt;li&gt;User&amp;nbsp;: any visitor with access to LaraClassified Service via the Website and Mobile Site and Consultant Service LaraClassified accessible from different media.&lt;\/li&gt;&lt;\/ol&gt;&lt;h4&gt;&lt;b&gt;Subject&lt;\/b&gt;&lt;\/h4&gt;&lt;p&gt;These Terms and Conditions Of Use establish the contractual conditions applicable to any subscription by an Advertiser connected to its Personal Account from the Website and Mobile Site.&lt;br&gt;&lt;\/p&gt;&lt;h4&gt;&lt;b&gt;Acceptance&lt;\/b&gt;&lt;\/h4&gt;&lt;p&gt;Any use of the website by an Advertiser is full acceptance of the current Terms.&lt;br&gt;&lt;\/p&gt;&lt;h4&gt;&lt;b&gt;Responsibility&lt;\/b&gt;&lt;\/h4&gt;&lt;p&gt;Responsibility for LaraClassified can not be held liable for non-performance or improper performance of due control, either because of the Advertiser, or a case of major force.&lt;br&gt;&lt;\/p&gt;&lt;h4&gt;&lt;b&gt;Modification of these terms&lt;\/b&gt;&lt;\/h4&gt;&lt;p&gt;LaraClassified reserves the right, at any time, to modify all or part of the Terms and Conditions.&lt;\/p&gt;&lt;p&gt;Advertisers are advised to consult the Terms to be aware of the changes.&lt;\/p&gt;&lt;h4&gt;&lt;b&gt;Miscellaneous&lt;\/b&gt;&lt;\/h4&gt;&lt;p&gt;If part of the Terms should be illegal, invalid or unenforceable for any reason whatsoever, the provisions in question would be deemed unwritten, without questioning the validity of the remaining provisions will continue to apply between Advertisers and LaraClassified.&lt;\/p&gt;&lt;p&gt;Any complaints should be addressed to Customer Service LaraClassified.&lt;\/p&gt;",
                "external_link": null,
                "name_color": null,
                "title_color": null,
                "target_blank": "0",
                "excluded_from_footer": "0",
                "active": "1",
                "lft": "6",
                "rgt": "7",
                "depth": "1"
            },
            {
                "id": 2,
                "parent_id": null,
                "type": "privacy",
                "name": "Privacy",
                "slug": "privacy",
                "picture": null,
                "title": "Privacy",
                "content": "&lt;p&gt;Your privacy is an important part of our relationship with you. Protecting your privacy is only part of our mission to provide a secure web environment. When using our site, including our services, your information will remain strictly confidential. Contributions made on our blog or on our forum are open to public view; so please do not post any personal information in your dealings with others. We accept no liability for those actions because it is your sole responsibility to adequate and safe post content on our site. We will not share, rent or share your information with third parties.&lt;\/p&gt;&lt;p&gt;When you visit our site, we collect technical information about your computer and how you access our website and analyze this information such as Internet Protocol (IP) address of your computer, the operating system used by your computer, the browser (eg, Chrome, Firefox, Internet Explorer or other) your computer uses, the name of your Internet service provider (ISP), the Uniform Resource Locator (URL) of the website from which you come and the URL to which you go next and certain operating metrics such as the number of times you use our website. This general information can be used to help us better understand how our site is viewed and used. We may share this general information about our site with our business partners or the general public. For example, we may share the information on the number of daily unique visitors to our site with potential corporate partners or use them for advertising purposes. This information does contain any of your personal data that can be used to contact you or identify you.&lt;\/p&gt;&lt;p&gt;When we place links or banners to other sites of our website, please note that we do not control this kind of content or practices or privacy policies of those sites. We do not endorse or assume no responsibility for the privacy policies or information collection practices of any other website other than managed sites LaraClassified.&lt;\/p&gt;&lt;p&gt;We use the highest security standard available to protect your identifiable information in transit to us. All data stored on our servers are protected by a secure firewall for the unauthorized use or activity can not take place. Although we make every effort to protect your personal information against loss, misuse or alteration by third parties, you should be aware that there is always a risk that low-intentioned manage to find a way to thwart our security system or that Internet transmissions could be intercepted.&lt;\/p&gt;&lt;p&gt;We reserve the right, without notice, to change, modify, add or remove portions of our Privacy Policy at any time and from time to time. These changes will be posted publicly on our website. When you visit our website, you accept all the terms of our privacy policy. Your continued use of this website constitutes your continued agreement to these terms. If you do not agree with the terms of our privacy policy, you should cease using our website.&lt;\/p&gt;",
                "external_link": null,
                "name_color": null,
                "title_color": null,
                "target_blank": "0",
                "excluded_from_footer": "0",
                "active": "1",
                "lft": "8",
                "rgt": "9",
                "depth": "1"
            }
        ]
    }
}</code></pre>
<div id="execution-results-GETapi-pages" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-pages"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-pages"></code></pre>
</div>
<div id="execution-error-GETapi-pages" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-pages"></code></pre>
</div>
<form id="form-GETapi-pages" data-method="GET" data-path="api/pages" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-pages', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-pages" onclick="tryItOut('GETapi-pages');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-pages" onclick="cancelTryOut('GETapi-pages');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-pages" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/pages</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>excludedFromFooter</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="GETapi-pages" hidden><input type="radio" name="excludedFromFooter" value="1" data-endpoint="GETapi-pages" data-component="query" ><code>true</code></label>
<label data-endpoint="GETapi-pages" hidden><input type="radio" name="excludedFromFooter" value="0" data-endpoint="GETapi-pages" data-component="query" ><code>false</code></label>
<br>
Select or unselect pages that can list in footer.
</p>
</form>
<h2>Get page</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/pages/autem" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/pages/autem"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/pages/autem',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "message": null,
    "result": []
}</code></pre>
<div id="execution-results-GETapi-pages--slugOrId-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-pages--slugOrId-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-pages--slugOrId-"></code></pre>
</div>
<div id="execution-error-GETapi-pages--slugOrId-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-pages--slugOrId-"></code></pre>
</div>
<form id="form-GETapi-pages--slugOrId-" data-method="GET" data-path="api/pages/{slugOrId}" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-pages--slugOrId-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-pages--slugOrId-" onclick="tryItOut('GETapi-pages--slugOrId-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-pages--slugOrId-" onclick="cancelTryOut('GETapi-pages--slugOrId-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-pages--slugOrId-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/pages/{slugOrId}</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>slugOrId</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="slugOrId" data-endpoint="GETapi-pages--slugOrId-" data-component="url" required  hidden>
<br>
The slug or ID of the page.
</p>
</form><h1>Payment Methods</h1>
<h2>List payment methods</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/paymentMethods?countryCode=US" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/paymentMethods"
);

let params = {
    "countryCode": "US",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/paymentMethods',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'countryCode'=&gt; 'US',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "message": null,
    "result": {
        "data": [
            {
                "id": 5,
                "name": "offlinepayment",
                "display_name": "Offline Payment",
                "description": null,
                "has_ccbox": "0",
                "is_compatible_api": "1",
                "countries": "",
                "active": "1",
                "lft": "5",
                "rgt": "5",
                "depth": "1",
                "parent_id": "0"
            }
        ]
    }
}</code></pre>
<div id="execution-results-GETapi-paymentMethods" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-paymentMethods"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-paymentMethods"></code></pre>
</div>
<div id="execution-error-GETapi-paymentMethods" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-paymentMethods"></code></pre>
</div>
<form id="form-GETapi-paymentMethods" data-method="GET" data-path="api/paymentMethods" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-paymentMethods', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-paymentMethods" onclick="tryItOut('GETapi-paymentMethods');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-paymentMethods" onclick="cancelTryOut('GETapi-paymentMethods');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-paymentMethods" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/paymentMethods</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>countryCode</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="countryCode" data-endpoint="GETapi-paymentMethods" data-component="query"  hidden>
<br>
Country code. Select only the payment methods related to a country.
</p>
</form>
<h2>Get payment method</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/paymentMethods/7" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/paymentMethods/7"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/paymentMethods/7',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Entry for Models\\PaymentMethod not found",
    "result": null,
    "error_code": 1
}</code></pre>
<div id="execution-results-GETapi-paymentMethods--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-paymentMethods--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-paymentMethods--id-"></code></pre>
</div>
<div id="execution-error-GETapi-paymentMethods--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-paymentMethods--id-"></code></pre>
</div>
<form id="form-GETapi-paymentMethods--id-" data-method="GET" data-path="api/paymentMethods/{id}" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-paymentMethods--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-paymentMethods--id-" onclick="tryItOut('GETapi-paymentMethods--id-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-paymentMethods--id-" onclick="cancelTryOut('GETapi-paymentMethods--id-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-paymentMethods--id-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/paymentMethods/{id}</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="id" data-endpoint="GETapi-paymentMethods--id-" data-component="url" required  hidden>
<br>
Can be the ID (int) or name (string) of the payment method.
</p>
</form><h1>Payments</h1>
<h2>List payments</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/payments?embed=enim" \
    -H "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/payments"
);

let params = {
    "embed": "enim",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/payments',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {YOUR_AUTH_TOKEN}',
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'embed'=&gt; 'enim',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (401):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Unauthenticated or Token Expired, Please Login",
    "result": null,
    "error_code": 1
}</code></pre>
<div id="execution-results-GETapi-payments" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-payments"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-payments"></code></pre>
</div>
<div id="execution-error-GETapi-payments" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-payments"></code></pre>
</div>
<form id="form-GETapi-payments" data-method="GET" data-path="api/payments" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_TOKEN}","Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-payments', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-payments" onclick="tryItOut('GETapi-payments');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-payments" onclick="cancelTryOut('GETapi-payments');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-payments" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/payments</code></b>
</p>
<p>
<label id="auth-GETapi-payments" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-payments" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>embed</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="embed" data-endpoint="GETapi-payments" data-component="query"  hidden>
<br>
Comma-separated list of the payment relationships for Eager Loading. Possible values: post,paymentMethod,package,currency
</p>
</form>
<h2>Get payment</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/payments/excepturi?embed=perferendis" \
    -H "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/payments/excepturi"
);

let params = {
    "embed": "perferendis",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/payments/excepturi',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {YOUR_AUTH_TOKEN}',
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'embed'=&gt; 'perferendis',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Page Not Found."
}</code></pre>
<div id="execution-results-GETapi-payments--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-payments--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-payments--id-"></code></pre>
</div>
<div id="execution-error-GETapi-payments--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-payments--id-"></code></pre>
</div>
<form id="form-GETapi-payments--id-" data-method="GET" data-path="api/payments/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_TOKEN}","Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-payments--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-payments--id-" onclick="tryItOut('GETapi-payments--id-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-payments--id-" onclick="cancelTryOut('GETapi-payments--id-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-payments--id-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/payments/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-payments--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-payments--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-payments--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>embed</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="embed" data-endpoint="GETapi-payments--id-" data-component="query"  hidden>
<br>
Comma-separated list of the payment relationships for Eager Loading. Possible values: post,paymentMethod,package,currency
</p>
</form>
<h2>Store payment</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<p>Note: This endpoint is only available for the multi steps post edition.</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "https://laraclassified.bedigit.local/api/payments?package=15" \
    -H "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs" \
    -d '{"country_code":"US","post_id":2,"package_id":1,"payment_method_id":5}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/payments"
);

let params = {
    "package": "15",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

let body = {
    "country_code": "US",
    "post_id": 2,
    "package_id": 1,
    "payment_method_id": 5
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://laraclassified.bedigit.local/api/payments',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {YOUR_AUTH_TOKEN}',
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'package'=&gt; '15',
        ],
        'json' =&gt; [
            'country_code' =&gt; 'US',
            'post_id' =&gt; 2,
            'package_id' =&gt; 1,
            'payment_method_id' =&gt; 5,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Post not found",
    "result": null,
    "error_code": 1
}</code></pre>
<div id="execution-results-POSTapi-payments" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-payments"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-payments"></code></pre>
</div>
<div id="execution-error-POSTapi-payments" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-payments"></code></pre>
</div>
<form id="form-POSTapi-payments" data-method="POST" data-path="api/payments" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_TOKEN}","Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-payments', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-payments" onclick="tryItOut('POSTapi-payments');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-payments" onclick="cancelTryOut('POSTapi-payments');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-payments" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/payments</code></b>
</p>
<p>
<label id="auth-POSTapi-payments" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-payments" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>package</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="package" data-endpoint="POSTapi-payments" data-component="query"  hidden>
<br>
Selected package ID.
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>country_code</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="country_code" data-endpoint="POSTapi-payments" data-component="body" required  hidden>
<br>
The code of the user's country.
</p>
<p>
<b><code>post_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="post_id" data-endpoint="POSTapi-payments" data-component="body" required  hidden>
<br>
The post's ID.
</p>
<p>
<b><code>package_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="package_id" data-endpoint="POSTapi-payments" data-component="body" required  hidden>
<br>
The package's ID (Auto filled when the query parameter 'package' is set).
</p>
<p>
<b><code>payment_method_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="payment_method_id" data-endpoint="POSTapi-payments" data-component="body"  hidden>
<br>
The payment method's ID (required when the selected package's price is > 0).
</p>

</form><h1>Pictures</h1>
<h2>Get picture</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/pictures/non?embed=post" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/pictures/non"
);

let params = {
    "embed": "post",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/pictures/non',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'embed'=&gt; 'post',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Page Not Found."
}</code></pre>
<div id="execution-results-GETapi-pictures--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-pictures--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-pictures--id-"></code></pre>
</div>
<div id="execution-error-GETapi-pictures--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-pictures--id-"></code></pre>
</div>
<form id="form-GETapi-pictures--id-" data-method="GET" data-path="api/pictures/{id}" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-pictures--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-pictures--id-" onclick="tryItOut('GETapi-pictures--id-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-pictures--id-" onclick="cancelTryOut('GETapi-pictures--id-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-pictures--id-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/pictures/{id}</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-pictures--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>embed</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="embed" data-endpoint="GETapi-pictures--id-" data-component="query"  hidden>
<br>
The list of the picture relationships separated by comma for Eager Loading.
</p>
</form>
<h2>Store picture</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<p>Note: This endpoint is only available for the multi steps post edition.</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "https://laraclassified.bedigit.local/api/pictures" \
    -H "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    -H "Content-Type: multipart/form-data" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs" \
    -F "country_code=US" \
    -F "count_packages=3" \
    -F "count_payment_methods=1" \
    -F "post_id=2" \
    -F "pictures[]=@/private/var/folders/r0/k0xbnx757k3fnz09_6g9rp6w0000gn/T/phpIUsWLu" </code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/pictures"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

const body = new FormData();
body.append('country_code', 'US');
body.append('count_packages', '3');
body.append('count_payment_methods', '1');
body.append('post_id', '2');
body.append('pictures[]', document.querySelector('input[name="pictures[]"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://laraclassified.bedigit.local/api/pictures',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {YOUR_AUTH_TOKEN}',
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'multipart' =&gt; [
            [
                'name' =&gt; 'country_code',
                'contents' =&gt; 'US'
            ],
            [
                'name' =&gt; 'count_packages',
                'contents' =&gt; '3'
            ],
            [
                'name' =&gt; 'count_payment_methods',
                'contents' =&gt; '1'
            ],
            [
                'name' =&gt; 'post_id',
                'contents' =&gt; '2'
            ],
            [
                'name' =&gt; 'pictures[]',
                'contents' =&gt; fopen('/private/var/folders/r0/k0xbnx757k3fnz09_6g9rp6w0000gn/T/phpIUsWLu', 'r')
            ],
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Post not found",
    "result": null,
    "error_code": 1
}</code></pre>
<div id="execution-results-POSTapi-pictures" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-pictures"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-pictures"></code></pre>
</div>
<div id="execution-error-POSTapi-pictures" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-pictures"></code></pre>
</div>
<form id="form-POSTapi-pictures" data-method="POST" data-path="api/pictures" data-authed="1" data-hasfiles="1" data-headers='{"Authorization":"Bearer {YOUR_AUTH_TOKEN}","Content-Type":"multipart\/form-data","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-pictures', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-pictures" onclick="tryItOut('POSTapi-pictures');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-pictures" onclick="cancelTryOut('POSTapi-pictures');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-pictures" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/pictures</code></b>
</p>
<p>
<label id="auth-POSTapi-pictures" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-pictures" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>country_code</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="country_code" data-endpoint="POSTapi-pictures" data-component="body" required  hidden>
<br>
The code of the user's country.
</p>
<p>
<b><code>count_packages</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="count_packages" data-endpoint="POSTapi-pictures" data-component="body" required  hidden>
<br>
The number of available packages.
</p>
<p>
<b><code>count_payment_methods</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="count_payment_methods" data-endpoint="POSTapi-pictures" data-component="body" required  hidden>
<br>
The number of available payment methods.
</p>
<p>
<b><code>post_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="post_id" data-endpoint="POSTapi-pictures" data-component="body" required  hidden>
<br>
The post's ID.
</p>
<p>
<b><code>pictures</code></b>&nbsp;&nbsp;<small>file[]</small>     <i>optional</i> &nbsp;
<input type="file" name="pictures.0" data-endpoint="POSTapi-pictures" data-component="body"  hidden>
<input type="file" name="pictures.1" data-endpoint="POSTapi-pictures" data-component="body" hidden>
<br>
The files to upload.
</p>

</form>
<h2>Delete picture</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<p>Note: This endpoint is only available for the multi steps post edition.
For newly created posts, the post's ID need to be added in the request input with the key 'new_post_id'.
The 'new_post_id' and 'new_post_tmp_token' fields need to be removed or unset during the post edition steps.</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "https://laraclassified.bedigit.local/api/pictures/ducimus" \
    -H "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs" \
    -d '{"post_id":2}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/pictures/ducimus"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

let body = {
    "post_id": 2
}

fetch(url, {
    method: "DELETE",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;delete(
    'https://laraclassified.bedigit.local/api/pictures/ducimus',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {YOUR_AUTH_TOKEN}',
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'json' =&gt; [
            'post_id' =&gt; 2,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Page Not Found."
}</code></pre>
<div id="execution-results-DELETEapi-pictures--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-pictures--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-pictures--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-pictures--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-pictures--id-"></code></pre>
</div>
<form id="form-DELETEapi-pictures--id-" data-method="DELETE" data-path="api/pictures/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_TOKEN}","Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-pictures--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-DELETEapi-pictures--id-" onclick="tryItOut('DELETEapi-pictures--id-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-DELETEapi-pictures--id-" onclick="cancelTryOut('DELETEapi-pictures--id-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-DELETEapi-pictures--id-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/pictures/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-pictures--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-pictures--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-pictures--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>post_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="post_id" data-endpoint="DELETEapi-pictures--id-" data-component="body" required  hidden>
<br>
The post's ID.
</p>

</form>
<h2>Reorder pictures</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<p>Note: This endpoint is only available for the multi steps post edition.</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "https://laraclassified.bedigit.local/api/pictures/reorder" \
    -H "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs" \
    -H "X-Action: bulk" \
    -d '{"post_id":2,"body":"quia"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/pictures/reorder"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
    "X-Action": "bulk",
};

let body = {
    "post_id": 2,
    "body": "quia"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://laraclassified.bedigit.local/api/pictures/reorder',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {YOUR_AUTH_TOKEN}',
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
            'X-Action' =&gt; 'bulk',
        ],
        'json' =&gt; [
            'post_id' =&gt; 2,
            'body' =&gt; 'quia',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (400):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Invalid JSON format for the \"body\" field.",
    "result": null,
    "error_code": 1
}</code></pre>
<div id="execution-results-POSTapi-pictures-reorder" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-pictures-reorder"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-pictures-reorder"></code></pre>
</div>
<div id="execution-error-POSTapi-pictures-reorder" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-pictures-reorder"></code></pre>
</div>
<form id="form-POSTapi-pictures-reorder" data-method="POST" data-path="api/pictures/reorder" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_TOKEN}","Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs","X-Action":"bulk"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-pictures-reorder', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-pictures-reorder" onclick="tryItOut('POSTapi-pictures-reorder');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-pictures-reorder" onclick="cancelTryOut('POSTapi-pictures-reorder');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-pictures-reorder" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/pictures/reorder</code></b>
</p>
<p>
<label id="auth-POSTapi-pictures-reorder" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-pictures-reorder" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>post_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="post_id" data-endpoint="POSTapi-pictures-reorder" data-component="body" required  hidden>
<br>
The post's ID.
</p>
<p>
<b><code>body</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="body" data-endpoint="POSTapi-pictures-reorder" data-component="body" required  hidden>
<br>
Encoded json of the new pictures' positions array [['id' => 2, 'position' => 1], ['id' => 1, 'position' => 2], ...]
</p>

</form>
<h2>List pictures</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/posts/aliquam/pictures?embed=voluptatibus&amp;postId=1&amp;latest=" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/posts/aliquam/pictures"
);

let params = {
    "embed": "voluptatibus",
    "postId": "1",
    "latest": "",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/posts/aliquam/pictures',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'embed'=&gt; 'voluptatibus',
            'postId'=&gt; '1',
            'latest'=&gt; '',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Page Not Found."
}</code></pre>
<div id="execution-results-GETapi-posts--postId--pictures" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-posts--postId--pictures"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-posts--postId--pictures"></code></pre>
</div>
<div id="execution-error-GETapi-posts--postId--pictures" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-posts--postId--pictures"></code></pre>
</div>
<form id="form-GETapi-posts--postId--pictures" data-method="GET" data-path="api/posts/{postId}/pictures" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-posts--postId--pictures', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-posts--postId--pictures" onclick="tryItOut('GETapi-posts--postId--pictures');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-posts--postId--pictures" onclick="cancelTryOut('GETapi-posts--postId--pictures');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-posts--postId--pictures" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/posts/{postId}/pictures</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>postId</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="postId" data-endpoint="GETapi-posts--postId--pictures" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>embed</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="embed" data-endpoint="GETapi-posts--postId--pictures" data-component="query"  hidden>
<br>
The list of the picture relationships separated by comma for Eager Loading. Possible values: post
</p>
<p>
<b><code>postId</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="postId" data-endpoint="GETapi-posts--postId--pictures" data-component="query"  hidden>
<br>
List of pictures related to a post (using the post ID).
</p>
<p>
<b><code>latest</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="GETapi-posts--postId--pictures" hidden><input type="radio" name="latest" value="1" data-endpoint="GETapi-posts--postId--pictures" data-component="query" ><code>true</code></label>
<label data-endpoint="GETapi-posts--postId--pictures" hidden><input type="radio" name="latest" value="0" data-endpoint="GETapi-posts--postId--pictures" data-component="query" ><code>false</code></label>
<br>
Get only the first picture after ordering (as object instead of collection).
</p>
</form><h1>Posts</h1>
<h2>List posts</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/posts?embed=reiciendis" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/posts"
);

let params = {
    "embed": "reiciendis",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/posts',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'embed'=&gt; 'reiciendis',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "message": null,
    "result": {
        "data": [
            {
                "id": 6913,
                "country_code": "US",
                "user_id": null,
                "category_id": "100",
                "post_type_id": "1",
                "title": "Do you have something to sell",
                "description": "&lt;p&gt;&lt;span style=\"text-align:center;\"&gt;Do you have something to sell, to rent, any service to offer or a job offer? Post it at LaraClassified, its free, for local business and very easy to use!&lt;\/span&gt;&lt;br&gt;&lt;\/p&gt;",
                "tags": "",
                "price": "129.00",
                "negotiable": null,
                "contact_name": "User Test",
                "email": "titi@lola.com",
                "phone": "",
                "phone_hidden": null,
                "address": null,
                "city_id": "48507",
                "lat": "39.74",
                "lon": "-104.98",
                "ip_addr": "::1",
                "visits": "2",
                "tmp_token": "211bbf79ce0675de0a3b38e0dbc22a53",
                "email_token": "632617a1a84b0f4818f3eeffd5774489",
                "phone_token": null,
                "verified_email": "1",
                "verified_phone": "1",
                "accept_terms": "1",
                "accept_marketing_offers": "0",
                "is_permanent": "0",
                "reviewed": "0",
                "featured": "0",
                "archived": "0",
                "archived_at": "2021-06-25T01:40:43.000000Z",
                "deletion_mail_sent_at": null,
                "fb_profile": null,
                "partner": null,
                "created_at": "2021-06-24T09:57:30.000000Z",
                "updated_at": "2021-06-25T01:40:43.000000Z",
                "slug": "do-you-have-something-to-sell",
                "created_at_formatted": "Jun 24th, 2021 at 05:57",
                "user_photo_url": "http:\/\/laraclassified.bedigit.local\/images\/user.jpg"
            },
            {
                "id": 6912,
                "country_code": "US",
                "user_id": "1",
                "category_id": "107",
                "post_type_id": "2",
                "title": "Toyota RAV 4 cool",
                "description": "&lt;p&gt;&lt;span style=\"text-align:center;\"&gt;Do you have something to sell, to rent, any service to offer or a job offer? Post it at LaraClassified, its free, for local business and very easy to use!&lt;\/span&gt;&lt;br&gt;&lt;\/p&gt;",
                "tags": "",
                "price": "29.90",
                "negotiable": "1",
                "contact_name": "Administrator",
                "email": "admin@larapen.com",
                "phone": "061228281",
                "phone_hidden": null,
                "address": null,
                "city_id": "46016",
                "lat": "42.33",
                "lon": "-83.05",
                "ip_addr": "::1",
                "visits": "0",
                "tmp_token": "66ec62d5590e49787571b54f4be86e7a",
                "email_token": null,
                "phone_token": null,
                "verified_email": "1",
                "verified_phone": "1",
                "accept_terms": "0",
                "accept_marketing_offers": "0",
                "is_permanent": "0",
                "reviewed": "1",
                "featured": "1",
                "archived": "0",
                "archived_at": "2021-06-25T04:36:54.000000Z",
                "deletion_mail_sent_at": null,
                "fb_profile": null,
                "partner": null,
                "created_at": "2021-06-23T14:22:34.000000Z",
                "updated_at": "2021-06-25T04:36:54.000000Z",
                "slug": "toyota-rav-4-cool",
                "created_at_formatted": "Jun 23rd, 2021 at 10:22",
                "user_photo_url": "https:\/\/secure.gravatar.com\/avatar\/0d061d5f8a82133c0f84e37fe0f4ff3e.jpg?s=150&amp;d=http%3A%2F%2Flaraclassified.bedigit.local%2Fimages%2Fuser.jpg&amp;r=g"
            },
            {
                "id": 6911,
                "country_code": "US",
                "user_id": "1",
                "category_id": "4",
                "post_type_id": "2",
                "title": "Toyota RAV 4 cool",
                "description": "&lt;p&gt;&lt;span style=\"text-align:center;\"&gt;Do you have something to sell, to rent, any service to offer or a job offer? Post it at LaraClassified, its free, for local business and very easy to use!&lt;\/span&gt;&lt;br&gt;&lt;\/p&gt;",
                "tags": "",
                "price": null,
                "negotiable": null,
                "contact_name": "Administrator",
                "email": "admin@larapen.com",
                "phone": "061228281",
                "phone_hidden": null,
                "address": null,
                "city_id": "48201",
                "lat": "37.64",
                "lon": "-121.00",
                "ip_addr": "::1",
                "visits": "0",
                "tmp_token": "54bd04700dbf2174668ae5334a1abcab",
                "email_token": null,
                "phone_token": null,
                "verified_email": "1",
                "verified_phone": "1",
                "accept_terms": "0",
                "accept_marketing_offers": "0",
                "is_permanent": "0",
                "reviewed": "1",
                "featured": "0",
                "archived": "0",
                "archived_at": "2021-06-25T03:37:33.000000Z",
                "deletion_mail_sent_at": null,
                "fb_profile": null,
                "partner": null,
                "created_at": "2021-06-23T09:19:25.000000Z",
                "updated_at": "2021-06-25T03:37:33.000000Z",
                "slug": "toyota-rav-4-cool",
                "created_at_formatted": "Jun 23rd, 2021 at 05:19",
                "user_photo_url": "https:\/\/secure.gravatar.com\/avatar\/0d061d5f8a82133c0f84e37fe0f4ff3e.jpg?s=150&amp;d=http%3A%2F%2Flaraclassified.bedigit.local%2Fimages%2Fuser.jpg&amp;r=g"
            },
            {
                "id": 6910,
                "country_code": "US",
                "user_id": null,
                "category_id": "101",
                "post_type_id": "2",
                "title": "Toyota RAV 4 cool x",
                "description": "&lt;p&gt;&lt;span style=\"text-align:center;\"&gt;Do you have something to sell, to rent, any service to offer or a job offer? Post it at LaraClassified, its free, for local business and very easy to use!&lt;\/span&gt;&lt;br&gt;&lt;\/p&gt;",
                "tags": "",
                "price": "7.50",
                "negotiable": null,
                "contact_name": "Mayeul Akpovi",
                "email": "sa@gmail.com",
                "phone": "+22961228282",
                "phone_hidden": null,
                "address": null,
                "city_id": "44669",
                "lat": "32.78",
                "lon": "-96.81",
                "ip_addr": "::1",
                "visits": "1",
                "tmp_token": "4245088cbf0df60ae93968258c6aadb2",
                "email_token": "293080eb0c788888b42f7068a14a683e",
                "phone_token": null,
                "verified_email": "1",
                "verified_phone": "1",
                "accept_terms": "1",
                "accept_marketing_offers": "0",
                "is_permanent": "0",
                "reviewed": "0",
                "featured": "0",
                "archived": "0",
                "archived_at": "2021-06-23T09:15:25.000000Z",
                "deletion_mail_sent_at": null,
                "fb_profile": null,
                "partner": null,
                "created_at": "2021-06-23T09:14:56.000000Z",
                "updated_at": "2021-06-23T09:15:25.000000Z",
                "slug": "toyota-rav-4-cool-x",
                "created_at_formatted": "Jun 23rd, 2021 at 05:14",
                "user_photo_url": "http:\/\/laraclassified.bedigit.local\/images\/user.jpg"
            },
            {
                "id": 6909,
                "country_code": "US",
                "user_id": null,
                "category_id": "107",
                "post_type_id": "1",
                "title": "Do you have something to sell",
                "description": "&lt;p&gt;&lt;span style=\"text-align:center;\"&gt;Do you have something to sell, to rent, any service to offer or a job offer? Post it at LaraClassified, its free, for local business and very easy to use!&lt;\/span&gt;&lt;br&gt;&lt;\/p&gt;",
                "tags": "",
                "price": "222.00",
                "negotiable": null,
                "contact_name": "Mayeul Akpovi",
                "email": "dede@gmail.com",
                "phone": "+22961228282",
                "phone_hidden": null,
                "address": null,
                "city_id": "44873",
                "lat": "29.42",
                "lon": "-98.49",
                "ip_addr": "::1",
                "visits": "2",
                "tmp_token": "ff72e23575685da91c59d0322e38d419",
                "email_token": "83a3627b475f50c56a1dd971661163a5",
                "phone_token": null,
                "verified_email": "1",
                "verified_phone": "1",
                "accept_terms": "1",
                "accept_marketing_offers": "0",
                "is_permanent": "0",
                "reviewed": "0",
                "featured": "0",
                "archived": "0",
                "archived_at": "2021-06-23T09:13:50.000000Z",
                "deletion_mail_sent_at": null,
                "fb_profile": null,
                "partner": null,
                "created_at": "2021-06-23T09:13:10.000000Z",
                "updated_at": "2021-06-23T09:13:50.000000Z",
                "slug": "do-you-have-something-to-sell",
                "created_at_formatted": "Jun 23rd, 2021 at 05:13",
                "user_photo_url": "http:\/\/laraclassified.bedigit.local\/images\/user.jpg"
            },
            {
                "id": 6908,
                "country_code": "US",
                "user_id": "1",
                "category_id": "105",
                "post_type_id": "2",
                "title": "S'inscrire - {app_name}",
                "description": "&lt;p&gt;&lt;span style=\"text-align:center;\"&gt;Do you have something to sell, to rent, any service to offer or a job offer? Post it at LaraClassified, its free, for local business and very easy to use!&lt;\/span&gt;&lt;br&gt;&lt;\/p&gt;",
                "tags": "",
                "price": null,
                "negotiable": null,
                "contact_name": "Administrator",
                "email": "admin@larapen.com",
                "phone": "061228281",
                "phone_hidden": null,
                "address": null,
                "city_id": "47486",
                "lat": "40.44",
                "lon": "-80.00",
                "ip_addr": "::1",
                "visits": "0",
                "tmp_token": "dcfc18101ab5570807368e451ce7540f",
                "email_token": null,
                "phone_token": null,
                "verified_email": "1",
                "verified_phone": "1",
                "accept_terms": "0",
                "accept_marketing_offers": "0",
                "is_permanent": "0",
                "reviewed": "1",
                "featured": "0",
                "archived": "0",
                "archived_at": "2021-06-23T09:10:29.000000Z",
                "deletion_mail_sent_at": null,
                "fb_profile": null,
                "partner": null,
                "created_at": "2021-06-23T09:10:29.000000Z",
                "updated_at": "2021-06-23T09:10:29.000000Z",
                "slug": "sinscrire-app_name",
                "created_at_formatted": "Jun 23rd, 2021 at 05:10",
                "user_photo_url": "https:\/\/secure.gravatar.com\/avatar\/0d061d5f8a82133c0f84e37fe0f4ff3e.jpg?s=150&amp;d=http%3A%2F%2Flaraclassified.bedigit.local%2Fimages%2Fuser.jpg&amp;r=g"
            },
            {
                "id": 6907,
                "country_code": "US",
                "user_id": null,
                "category_id": "106",
                "post_type_id": "2",
                "title": "Toyota RAV ︎︎︎",
                "description": "&lt;p&gt;&lt;span style=\"text-align:center;\"&gt;Do you have something to sell, to rent, any service to offer or a job offer? Post it at LaraClassified, its free, for local business and very easy to use!&lt;\/span&gt;&lt;br&gt;&lt;\/p&gt;",
                "tags": "",
                "price": "1111.00",
                "negotiable": "1",
                "contact_name": "Toto Max",
                "email": "momo@toto.com",
                "phone": "",
                "phone_hidden": null,
                "address": null,
                "city_id": "43968",
                "lat": "35.05",
                "lon": "-78.88",
                "ip_addr": "::1",
                "visits": "1",
                "tmp_token": "f20f47a32f76b43b4e7793aa7b04ee21",
                "email_token": "0588dd90ce3a17b2ffd0e286b23d0a70",
                "phone_token": null,
                "verified_email": "1",
                "verified_phone": "1",
                "accept_terms": "1",
                "accept_marketing_offers": "0",
                "is_permanent": "0",
                "reviewed": "0",
                "featured": "0",
                "archived": "0",
                "archived_at": "2021-06-23T09:06:51.000000Z",
                "deletion_mail_sent_at": null,
                "fb_profile": null,
                "partner": null,
                "created_at": "2021-06-23T09:06:16.000000Z",
                "updated_at": "2021-06-23T09:06:51.000000Z",
                "slug": "toyota-rav-︎︎︎",
                "created_at_formatted": "Jun 23rd, 2021 at 05:06",
                "user_photo_url": "http:\/\/laraclassified.bedigit.local\/images\/user.jpg"
            },
            {
                "id": 6906,
                "country_code": "US",
                "user_id": null,
                "category_id": "100",
                "post_type_id": "1",
                "title": "Toyota RAV ︎︎︎",
                "description": "&lt;p&gt;&lt;span style=\"text-align:center;\"&gt;Do you have something to sell, to rent, any service to offer or a job offer? Post it at LaraClassified, its free, for local business and very easy to use!&lt;\/span&gt;&lt;br&gt;&lt;\/p&gt;",
                "tags": "",
                "price": "900.00",
                "negotiable": "1",
                "contact_name": "User Tata",
                "email": "toto@test.com",
                "phone": "",
                "phone_hidden": null,
                "address": null,
                "city_id": "46898",
                "lat": "40.78",
                "lon": "-73.97",
                "ip_addr": "::1",
                "visits": "1",
                "tmp_token": "85ab8eae56763ac222f726958bb0f046",
                "email_token": "967b7b5b9fa487615a35208d3e96c8db",
                "phone_token": null,
                "verified_email": "1",
                "verified_phone": "1",
                "accept_terms": "1",
                "accept_marketing_offers": "1",
                "is_permanent": "0",
                "reviewed": "0",
                "featured": "0",
                "archived": "0",
                "archived_at": "2021-06-23T09:07:04.000000Z",
                "deletion_mail_sent_at": null,
                "fb_profile": null,
                "partner": null,
                "created_at": "2021-06-23T07:56:24.000000Z",
                "updated_at": "2021-06-23T09:07:04.000000Z",
                "slug": "toyota-rav-︎︎︎",
                "created_at_formatted": "Jun 23rd, 2021 at 03:56",
                "user_photo_url": "http:\/\/laraclassified.bedigit.local\/images\/user.jpg"
            },
            {
                "id": 6905,
                "country_code": "US",
                "user_id": "1",
                "category_id": "106",
                "post_type_id": "2",
                "title": "Do you have something to sell XYZ",
                "description": "&lt;p&gt;&lt;span style=\"text-align:center;\"&gt;Do you have something to sell, to rent, any service to offer or a job offer? Post it at LaraClassified, its free, for local business and very easy to use!&lt;\/span&gt;&lt;br&gt;&lt;\/p&gt;",
                "tags": "",
                "price": "6000.00",
                "negotiable": "1",
                "contact_name": "Administrator",
                "email": "admin@larapen.com",
                "phone": "061228281",
                "phone_hidden": null,
                "address": null,
                "city_id": "44697",
                "lat": "32.73",
                "lon": "-97.32",
                "ip_addr": "::1",
                "visits": "0",
                "tmp_token": "d552f299ee854d2a3fd4c26428bf442c",
                "email_token": null,
                "phone_token": null,
                "verified_email": "1",
                "verified_phone": "1",
                "accept_terms": "0",
                "accept_marketing_offers": "0",
                "is_permanent": "0",
                "reviewed": "1",
                "featured": "0",
                "archived": "0",
                "archived_at": "2021-06-23T07:49:54.000000Z",
                "deletion_mail_sent_at": null,
                "fb_profile": null,
                "partner": null,
                "created_at": "2021-06-23T07:49:54.000000Z",
                "updated_at": "2021-06-23T07:49:54.000000Z",
                "slug": "do-you-have-something-to-sell-xyz",
                "created_at_formatted": "Jun 23rd, 2021 at 03:49",
                "user_photo_url": "https:\/\/secure.gravatar.com\/avatar\/0d061d5f8a82133c0f84e37fe0f4ff3e.jpg?s=150&amp;d=http%3A%2F%2Flaraclassified.bedigit.local%2Fimages%2Fuser.jpg&amp;r=g"
            },
            {
                "id": 6904,
                "country_code": "US",
                "user_id": null,
                "category_id": "101",
                "post_type_id": "2",
                "title": "S'inscrire - {app_name}",
                "description": "&lt;p&gt;&lt;span style=\"color:#292b2c;font-family:Roboto, Helvetica, Arial, sans-serif;font-size:13px;text-align:center;background-color:#ffffff;\"&gt;Do you have something to sell, to rent, any service to offer or a job offer? Post it at LaraClassified, its free, for local business and very easy to use!&lt;\/span&gt;&lt;\/p&gt;",
                "tags": "",
                "price": null,
                "negotiable": null,
                "contact_name": "Man Shark",
                "email": "oop@test.com",
                "phone": "",
                "phone_hidden": null,
                "address": null,
                "city_id": "48342",
                "lat": "37.34",
                "lon": "-121.89",
                "ip_addr": "::1",
                "visits": "1",
                "tmp_token": "78dba3204bc578190495c621c695bba0",
                "email_token": "c8e25781891bd17548f569f5097448c9",
                "phone_token": null,
                "verified_email": "1",
                "verified_phone": "1",
                "accept_terms": "1",
                "accept_marketing_offers": "0",
                "is_permanent": "0",
                "reviewed": "1",
                "featured": "1",
                "archived": "0",
                "archived_at": "2021-06-07T06:20:31.000000Z",
                "deletion_mail_sent_at": null,
                "fb_profile": null,
                "partner": null,
                "created_at": "2021-06-07T06:19:24.000000Z",
                "updated_at": "2021-06-07T06:20:31.000000Z",
                "slug": "sinscrire-app_name",
                "created_at_formatted": "Jun 7th, 2021 at 02:19",
                "user_photo_url": "http:\/\/laraclassified.bedigit.local\/images\/user.jpg"
            },
            {
                "id": 6903,
                "country_code": "US",
                "user_id": null,
                "category_id": "106",
                "post_type_id": "1",
                "title": "Toyota RAV 4 cool",
                "description": "&lt;p&gt;&lt;span style=\"color:#292b2c;font-family:Roboto, Helvetica, Arial, sans-serif;font-size:13px;text-align:center;background-color:#ffffff;\"&gt;Do you have something to sell, to rent, any service to offer or a job offer? Post it at LaraClassified, its free, for local business and very easy to use!&lt;\/span&gt;&lt;\/p&gt;",
                "tags": "",
                "price": "2333.00",
                "negotiable": null,
                "contact_name": "Edou",
                "email": "ddd@tata.com",
                "phone": "",
                "phone_hidden": null,
                "address": null,
                "city_id": "49142",
                "lat": "47.61",
                "lon": "-122.33",
                "ip_addr": "::1",
                "visits": "1",
                "tmp_token": "d0213015bede441a8493af8b4e47d6f7",
                "email_token": null,
                "phone_token": null,
                "verified_email": "1",
                "verified_phone": "1",
                "accept_terms": "1",
                "accept_marketing_offers": "0",
                "is_permanent": "0",
                "reviewed": "1",
                "featured": "1",
                "archived": "0",
                "archived_at": "2021-06-06T09:50:12.000000Z",
                "deletion_mail_sent_at": null,
                "fb_profile": null,
                "partner": null,
                "created_at": "2021-06-06T09:48:43.000000Z",
                "updated_at": "2021-06-06T09:50:12.000000Z",
                "slug": "toyota-rav-4-cool",
                "created_at_formatted": "Jun 6th, 2021 at 05:48",
                "user_photo_url": "http:\/\/laraclassified.bedigit.local\/images\/user.jpg"
            },
            {
                "id": 6902,
                "country_code": "US",
                "user_id": null,
                "category_id": "107",
                "post_type_id": "2",
                "title": "Do you have something to sell",
                "description": "&lt;p&gt;&lt;span style=\"color:#292b2c;font-family:Roboto, Helvetica, Arial, sans-serif;font-size:13px;text-align:center;background-color:#ffffff;\"&gt;Do you have something to sell, to rent, any service to offer or a job offer? Post it at LaraClassified, its free, for local business and very easy to use!&lt;\/span&gt;&lt;\/p&gt;",
                "tags": "",
                "price": "2343.00",
                "negotiable": null,
                "contact_name": "Edou",
                "email": "ddd@tata.com",
                "phone": "",
                "phone_hidden": null,
                "address": null,
                "city_id": "42634",
                "lat": "30.51",
                "lon": "-87.21",
                "ip_addr": "::1",
                "visits": "7",
                "tmp_token": "b138af1002d155785f3c1af412e87a8b",
                "email_token": null,
                "phone_token": null,
                "verified_email": "1",
                "verified_phone": "1",
                "accept_terms": "1",
                "accept_marketing_offers": "0",
                "is_permanent": "0",
                "reviewed": "1",
                "featured": "1",
                "archived": "0",
                "archived_at": "2021-06-12T13:49:08.000000Z",
                "deletion_mail_sent_at": null,
                "fb_profile": null,
                "partner": null,
                "created_at": "2021-06-06T08:56:29.000000Z",
                "updated_at": "2021-06-12T13:49:08.000000Z",
                "slug": "do-you-have-something-to-sell",
                "created_at_formatted": "Jun 6th, 2021 at 04:56",
                "user_photo_url": "http:\/\/laraclassified.bedigit.local\/images\/user.jpg"
            }
        ]
    },
    "extra": {
        "count": null,
        "preSearch": [],
        "fields": []
    }
}</code></pre>
<div id="execution-results-GETapi-posts" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-posts"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-posts"></code></pre>
</div>
<div id="execution-error-GETapi-posts" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-posts"></code></pre>
</div>
<form id="form-GETapi-posts" data-method="GET" data-path="api/posts" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-posts', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-posts" onclick="tryItOut('GETapi-posts');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-posts" onclick="cancelTryOut('GETapi-posts');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-posts" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/posts</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>embed</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="embed" data-endpoint="GETapi-posts" data-component="query"  hidden>
<br>
Comma-separated list of the post relationships for Eager Loading. Possible values: user,category,postType,city,latestPayment,savedByLoggedUser,pictures
</p>
</form>
<h2>Get post</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/posts/2?embed=vero&amp;detailed=" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/posts/2"
);

let params = {
    "embed": "vero",
    "detailed": "",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/posts/2',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'embed'=&gt; 'vero',
            'detailed'=&gt; '',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "message": null,
    "result": {
        "id": 2,
        "country_code": "US",
        "user_id": "3",
        "category_id": "74",
        "post_type_id": "1",
        "title": "ASAP: Editor\/Proofreader",
        "description": "Dicta libero non autem rem eum. Beatae et et odio qui. Aliquam qui laudantium nihil ut. Minus quae sequi eum neque ut.\n\nA molestias eius maiores in repellendus nisi placeat voluptates. Eius illo ut eum consectetur amet. Neque facilis quia qui quisquam corporis dolorem.",
        "tags": "non,nihil,atque",
        "price": "29999.00",
        "negotiable": "1",
        "contact_name": "Admin Demo",
        "email": "admin@demosite.com",
        "phone": "+3581876675678",
        "phone_hidden": "0",
        "address": null,
        "city_id": "46913",
        "lat": "43.22",
        "lon": "-78.39",
        "ip_addr": "49.24.194.161",
        "visits": 1341,
        "tmp_token": null,
        "email_token": null,
        "phone_token": "demoFaker",
        "verified_email": "1",
        "verified_phone": "1",
        "accept_terms": "1",
        "accept_marketing_offers": "0",
        "is_permanent": "0",
        "reviewed": "1",
        "featured": "0",
        "archived": "0",
        "archived_at": "2021-06-25T16:48:56.000000Z",
        "deletion_mail_sent_at": null,
        "fb_profile": null,
        "partner": null,
        "created_at": "2021-03-06T20:41:38.000000Z",
        "updated_at": "2021-06-25T16:48:56.000000Z",
        "slug": "asap-editor-proofreader",
        "created_at_formatted": "Mar 6th, 2021 at 15:41",
        "user_photo_url": "https:\/\/secure.gravatar.com\/avatar\/6c58d4583a9550a6e363976bc15caf67.jpg?s=150&amp;d=http%3A%2F%2Flaraclassified.bedigit.local%2Fimages%2Fuser.jpg&amp;r=g"
    },
    "extra": {
        "fields": {
            "headers": {},
            "original": {
                "success": true,
                "message": null,
                "result": [
                    {
                        "id": 18,
                        "belongs_to": "posts",
                        "name": "Start Date",
                        "type": "date",
                        "max": "50",
                        "default_value": "2021-03-22",
                        "required": "0",
                        "use_as_filter": "1",
                        "help": "",
                        "active": "1",
                        "options": []
                    },
                    {
                        "id": 19,
                        "belongs_to": "posts",
                        "name": "Company",
                        "type": "text",
                        "max": "100",
                        "default_value": "minus",
                        "required": "1",
                        "use_as_filter": "0",
                        "help": "",
                        "active": "1",
                        "options": []
                    },
                    {
                        "id": 20,
                        "belongs_to": "posts",
                        "name": "Work Type",
                        "type": "select",
                        "max": null,
                        "default_value": "160",
                        "required": "1",
                        "use_as_filter": "1",
                        "help": "",
                        "active": "1",
                        "options": [
                            {
                                "id": 159,
                                "field_id": "20",
                                "value": "Full-time",
                                "parent_id": null,
                                "lft": "317",
                                "rgt": "318",
                                "depth": null
                            },
                            {
                                "id": 160,
                                "field_id": "20",
                                "value": "Part-time",
                                "parent_id": null,
                                "lft": "319",
                                "rgt": "320",
                                "depth": null
                            },
                            {
                                "id": 161,
                                "field_id": "20",
                                "value": "Temporary",
                                "parent_id": null,
                                "lft": "321",
                                "rgt": "322",
                                "depth": null
                            },
                            {
                                "id": 162,
                                "field_id": "20",
                                "value": "Internship",
                                "parent_id": null,
                                "lft": "323",
                                "rgt": "324",
                                "depth": null
                            },
                            {
                                "id": 163,
                                "field_id": "20",
                                "value": "Permanent",
                                "parent_id": null,
                                "lft": "325",
                                "rgt": "326",
                                "depth": null
                            }
                        ]
                    }
                ]
            },
            "exception": null
        }
    }
}</code></pre>
<div id="execution-results-GETapi-posts--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-posts--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-posts--id-"></code></pre>
</div>
<div id="execution-error-GETapi-posts--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-posts--id-"></code></pre>
</div>
<form id="form-GETapi-posts--id-" data-method="GET" data-path="api/posts/{id}" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-posts--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-posts--id-" onclick="tryItOut('GETapi-posts--id-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-posts--id-" onclick="cancelTryOut('GETapi-posts--id-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-posts--id-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/posts/{id}</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="id" data-endpoint="GETapi-posts--id-" data-component="url"  hidden>
<br>
The post's ID.
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>embed</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="embed" data-endpoint="GETapi-posts--id-" data-component="query"  hidden>
<br>
Comma-separated list of the post relationships for Eager Loading. Possible values: user,category,postType,city,latestPayment,savedByLoggedUser,pictures
</p>
<p>
<b><code>detailed</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="GETapi-posts--id-" hidden><input type="radio" name="detailed" value="1" data-endpoint="GETapi-posts--id-" data-component="query" ><code>true</code></label>
<label data-endpoint="GETapi-posts--id-" hidden><input type="radio" name="detailed" value="0" data-endpoint="GETapi-posts--id-" data-component="query" ><code>false</code></label>
<br>
Allow to get the post's details with all its relationships (No need to set the 'embed' parameter).
</p>
</form>
<h2>Store post</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<p>For both types of post's creation (Single step or Multi steps).
Note: The field 'admin_code' is only available when the post's country's 'admin_type' column is set to 1 or 2 and the 'admin_field_active' column is set to 1.</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "https://laraclassified.bedigit.local/api/posts" \
    -H "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    -H "Content-Type: multipart/form-data" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs" \
    -F "category_id=1" \
    -F "post_type_id=1" \
    -F "title=John Doe" \
    -F "description=Beatae placeat atque tempore consequatur animi magni omnis." \
    -F "contact_name=John Doe" \
    -F "email=john.doe@domain.tld" \
    -F "phone=+17656766467" \
    -F "city_id=1" \
    -F "accept_terms=" \
    -F "country_code=US" \
    -F "admin_code=0" \
    -F "price=5000" \
    -F "negotiable=" \
    -F "phone_hidden=" \
    -F "ip_addr=dolorum" \
    -F "accept_marketing_offers=" \
    -F "is_permanent=" \
    -F "tags=car,automotive,tesla,cyber,truck" \
    -F "package_id=2" \
    -F "payment_method_id=5" \
    -F "captcha_key=qui" \
    -F "pictures[]=@/private/var/folders/r0/k0xbnx757k3fnz09_6g9rp6w0000gn/T/phpxJmqpB" </code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/posts"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

const body = new FormData();
body.append('category_id', '1');
body.append('post_type_id', '1');
body.append('title', 'John Doe');
body.append('description', 'Beatae placeat atque tempore consequatur animi magni omnis.');
body.append('contact_name', 'John Doe');
body.append('email', 'john.doe@domain.tld');
body.append('phone', '+17656766467');
body.append('city_id', '1');
body.append('accept_terms', '');
body.append('country_code', 'US');
body.append('admin_code', '0');
body.append('price', '5000');
body.append('negotiable', '');
body.append('phone_hidden', '');
body.append('ip_addr', 'dolorum');
body.append('accept_marketing_offers', '');
body.append('is_permanent', '');
body.append('tags', 'car,automotive,tesla,cyber,truck');
body.append('package_id', '2');
body.append('payment_method_id', '5');
body.append('captcha_key', 'qui');
body.append('pictures[]', document.querySelector('input[name="pictures[]"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://laraclassified.bedigit.local/api/posts',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {YOUR_AUTH_TOKEN}',
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'multipart' =&gt; [
            [
                'name' =&gt; 'category_id',
                'contents' =&gt; '1'
            ],
            [
                'name' =&gt; 'post_type_id',
                'contents' =&gt; '1'
            ],
            [
                'name' =&gt; 'title',
                'contents' =&gt; 'John Doe'
            ],
            [
                'name' =&gt; 'description',
                'contents' =&gt; 'Beatae placeat atque tempore consequatur animi magni omnis.'
            ],
            [
                'name' =&gt; 'contact_name',
                'contents' =&gt; 'John Doe'
            ],
            [
                'name' =&gt; 'email',
                'contents' =&gt; 'john.doe@domain.tld'
            ],
            [
                'name' =&gt; 'phone',
                'contents' =&gt; '+17656766467'
            ],
            [
                'name' =&gt; 'city_id',
                'contents' =&gt; '1'
            ],
            [
                'name' =&gt; 'accept_terms',
                'contents' =&gt; ''
            ],
            [
                'name' =&gt; 'country_code',
                'contents' =&gt; 'US'
            ],
            [
                'name' =&gt; 'admin_code',
                'contents' =&gt; '0'
            ],
            [
                'name' =&gt; 'price',
                'contents' =&gt; '5000'
            ],
            [
                'name' =&gt; 'negotiable',
                'contents' =&gt; ''
            ],
            [
                'name' =&gt; 'phone_hidden',
                'contents' =&gt; ''
            ],
            [
                'name' =&gt; 'ip_addr',
                'contents' =&gt; 'dolorum'
            ],
            [
                'name' =&gt; 'accept_marketing_offers',
                'contents' =&gt; ''
            ],
            [
                'name' =&gt; 'is_permanent',
                'contents' =&gt; ''
            ],
            [
                'name' =&gt; 'tags',
                'contents' =&gt; 'car,automotive,tesla,cyber,truck'
            ],
            [
                'name' =&gt; 'package_id',
                'contents' =&gt; '2'
            ],
            [
                'name' =&gt; 'payment_method_id',
                'contents' =&gt; '5'
            ],
            [
                'name' =&gt; 'captcha_key',
                'contents' =&gt; 'qui'
            ],
            [
                'name' =&gt; 'pictures[]',
                'contents' =&gt; fopen('/private/var/folders/r0/k0xbnx757k3fnz09_6g9rp6w0000gn/T/phpxJmqpB', 'r')
            ],
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (422):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "An error occurred while validating the data.",
    "errors": {
        "accept_terms": [
            "The terms must be accepted."
        ]
    }
}</code></pre>
<div id="execution-results-POSTapi-posts" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-posts"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-posts"></code></pre>
</div>
<div id="execution-error-POSTapi-posts" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-posts"></code></pre>
</div>
<form id="form-POSTapi-posts" data-method="POST" data-path="api/posts" data-authed="1" data-hasfiles="1" data-headers='{"Authorization":"Bearer {YOUR_AUTH_TOKEN}","Content-Type":"multipart\/form-data","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-posts', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-posts" onclick="tryItOut('POSTapi-posts');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-posts" onclick="cancelTryOut('POSTapi-posts');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-posts" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/posts</code></b>
</p>
<p>
<label id="auth-POSTapi-posts" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-posts" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>category_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="category_id" data-endpoint="POSTapi-posts" data-component="body" required  hidden>
<br>
The category's ID.
</p>
<p>
<b><code>post_type_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="post_type_id" data-endpoint="POSTapi-posts" data-component="body"  hidden>
<br>
The post type's ID.
</p>
<p>
<b><code>title</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="title" data-endpoint="POSTapi-posts" data-component="body" required  hidden>
<br>
The post's title.
</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="description" data-endpoint="POSTapi-posts" data-component="body" required  hidden>
<br>
The post's description.
</p>
<p>
<b><code>contact_name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="contact_name" data-endpoint="POSTapi-posts" data-component="body" required  hidden>
<br>
The post's author name.
</p>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="email" data-endpoint="POSTapi-posts" data-component="body"  hidden>
<br>
The post's author email address (required if mobile phone number doesn't exist).
</p>
<p>
<b><code>phone</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="phone" data-endpoint="POSTapi-posts" data-component="body"  hidden>
<br>
The post's author mobile number (required if email doesn't exist).
</p>
<p>
<b><code>city_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="city_id" data-endpoint="POSTapi-posts" data-component="body" required  hidden>
<br>
The city's ID.
</p>
<p>
<b><code>accept_terms</code></b>&nbsp;&nbsp;<small>boolean</small>  &nbsp;
<label data-endpoint="POSTapi-posts" hidden><input type="radio" name="accept_terms" value="true" data-endpoint="POSTapi-posts" data-component="body" required ><code>true</code></label>
<label data-endpoint="POSTapi-posts" hidden><input type="radio" name="accept_terms" value="false" data-endpoint="POSTapi-posts" data-component="body" required ><code>false</code></label>
<br>
Accept the website terms and conditions.
</p>
<p>
<b><code>country_code</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="country_code" data-endpoint="POSTapi-posts" data-component="body" required  hidden>
<br>
The code of the user's country.
</p>
<p>
<b><code>admin_code</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="admin_code" data-endpoint="POSTapi-posts" data-component="body"  hidden>
<br>
The administrative division's code.
</p>
<p>
<b><code>price</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="price" data-endpoint="POSTapi-posts" data-component="body" required  hidden>
<br>
The price.
</p>
<p>
<b><code>negotiable</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-posts" hidden><input type="radio" name="negotiable" value="true" data-endpoint="POSTapi-posts" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-posts" hidden><input type="radio" name="negotiable" value="false" data-endpoint="POSTapi-posts" data-component="body" ><code>false</code></label>
<br>
Negotiable price or no.
</p>
<p>
<b><code>phone_hidden</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-posts" hidden><input type="radio" name="phone_hidden" value="true" data-endpoint="POSTapi-posts" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-posts" hidden><input type="radio" name="phone_hidden" value="false" data-endpoint="POSTapi-posts" data-component="body" ><code>false</code></label>
<br>
Mobile phone number will be hidden in public or no.
</p>
<p>
<b><code>ip_addr</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="ip_addr" data-endpoint="POSTapi-posts" data-component="body"  hidden>
<br>
The post's author IP address.
</p>
<p>
<b><code>accept_marketing_offers</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-posts" hidden><input type="radio" name="accept_marketing_offers" value="true" data-endpoint="POSTapi-posts" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-posts" hidden><input type="radio" name="accept_marketing_offers" value="false" data-endpoint="POSTapi-posts" data-component="body" ><code>false</code></label>
<br>
Accept to receive marketing offers or no.
</p>
<p>
<b><code>is_permanent</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-posts" hidden><input type="radio" name="is_permanent" value="true" data-endpoint="POSTapi-posts" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-posts" hidden><input type="radio" name="is_permanent" value="false" data-endpoint="POSTapi-posts" data-component="body" ><code>false</code></label>
<br>
Is it permanent post or no.
</p>
<p>
<b><code>tags</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="tags" data-endpoint="POSTapi-posts" data-component="body"  hidden>
<br>
Comma-separated tags list.
</p>
<p>
<b><code>pictures</code></b>&nbsp;&nbsp;<small>file[]</small>  &nbsp;
<input type="file" name="pictures.0" data-endpoint="POSTapi-posts" data-component="body" required  hidden>
<input type="file" name="pictures.1" data-endpoint="POSTapi-posts" data-component="body" hidden>
<br>
The post's pictures.
</p>
<p>
<b><code>package_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="package_id" data-endpoint="POSTapi-posts" data-component="body" required  hidden>
<br>
The package's ID.
</p>
<p>
<b><code>payment_method_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="payment_method_id" data-endpoint="POSTapi-posts" data-component="body"  hidden>
<br>
The payment method's ID (required when the selected package's price is > 0).
</p>
<p>
<b><code>captcha_key</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="captcha_key" data-endpoint="POSTapi-posts" data-component="body"  hidden>
<br>
Key generated by the CAPTCHA endpoint calling (Required if the CAPTCHA verification is enabled from the Admin panel).
</p>

</form>
<h2>Update post</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<p>Note: The fields 'pictures', 'package_id' and 'payment_method_id' are only available with the single step post edition.
The field 'admin_code' is only available when the post's country's 'admin_type' column is set to 1 or 2 and the 'admin_field_active' column is set to 1.</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X PUT \
    "https://laraclassified.bedigit.local/api/posts/quo" \
    -H "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    -H "Content-Type: multipart/form-data" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs" \
    -F "category_id=1" \
    -F "post_type_id=1" \
    -F "title=John Doe" \
    -F "description=Beatae placeat atque tempore consequatur animi magni omnis." \
    -F "contact_name=John Doe" \
    -F "email=john.doe@domain.tld" \
    -F "phone=+17656766467" \
    -F "city_id=19" \
    -F "accept_terms=" \
    -F "country_code=US" \
    -F "admin_code=0" \
    -F "price=5000" \
    -F "negotiable=" \
    -F "phone_hidden=" \
    -F "ip_addr=accusamus" \
    -F "accept_marketing_offers=" \
    -F "is_permanent=1" \
    -F "tags=car,automotive,tesla,cyber,truck" \
    -F "package_id=2" \
    -F "payment_method_id=5" \
    -F "pictures[]=@/private/var/folders/r0/k0xbnx757k3fnz09_6g9rp6w0000gn/T/phpYQ3NZP" </code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/posts/quo"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

const body = new FormData();
body.append('category_id', '1');
body.append('post_type_id', '1');
body.append('title', 'John Doe');
body.append('description', 'Beatae placeat atque tempore consequatur animi magni omnis.');
body.append('contact_name', 'John Doe');
body.append('email', 'john.doe@domain.tld');
body.append('phone', '+17656766467');
body.append('city_id', '19');
body.append('accept_terms', '');
body.append('country_code', 'US');
body.append('admin_code', '0');
body.append('price', '5000');
body.append('negotiable', '');
body.append('phone_hidden', '');
body.append('ip_addr', 'accusamus');
body.append('accept_marketing_offers', '');
body.append('is_permanent', '1');
body.append('tags', 'car,automotive,tesla,cyber,truck');
body.append('package_id', '2');
body.append('payment_method_id', '5');
body.append('pictures[]', document.querySelector('input[name="pictures[]"]').files[0]);

fetch(url, {
    method: "PUT",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;put(
    'https://laraclassified.bedigit.local/api/posts/quo',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {YOUR_AUTH_TOKEN}',
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'multipart' =&gt; [
            [
                'name' =&gt; 'category_id',
                'contents' =&gt; '1'
            ],
            [
                'name' =&gt; 'post_type_id',
                'contents' =&gt; '1'
            ],
            [
                'name' =&gt; 'title',
                'contents' =&gt; 'John Doe'
            ],
            [
                'name' =&gt; 'description',
                'contents' =&gt; 'Beatae placeat atque tempore consequatur animi magni omnis.'
            ],
            [
                'name' =&gt; 'contact_name',
                'contents' =&gt; 'John Doe'
            ],
            [
                'name' =&gt; 'email',
                'contents' =&gt; 'john.doe@domain.tld'
            ],
            [
                'name' =&gt; 'phone',
                'contents' =&gt; '+17656766467'
            ],
            [
                'name' =&gt; 'city_id',
                'contents' =&gt; '19'
            ],
            [
                'name' =&gt; 'accept_terms',
                'contents' =&gt; ''
            ],
            [
                'name' =&gt; 'country_code',
                'contents' =&gt; 'US'
            ],
            [
                'name' =&gt; 'admin_code',
                'contents' =&gt; '0'
            ],
            [
                'name' =&gt; 'price',
                'contents' =&gt; '5000'
            ],
            [
                'name' =&gt; 'negotiable',
                'contents' =&gt; ''
            ],
            [
                'name' =&gt; 'phone_hidden',
                'contents' =&gt; ''
            ],
            [
                'name' =&gt; 'ip_addr',
                'contents' =&gt; 'accusamus'
            ],
            [
                'name' =&gt; 'accept_marketing_offers',
                'contents' =&gt; ''
            ],
            [
                'name' =&gt; 'is_permanent',
                'contents' =&gt; '1'
            ],
            [
                'name' =&gt; 'tags',
                'contents' =&gt; 'car,automotive,tesla,cyber,truck'
            ],
            [
                'name' =&gt; 'package_id',
                'contents' =&gt; '2'
            ],
            [
                'name' =&gt; 'payment_method_id',
                'contents' =&gt; '5'
            ],
            [
                'name' =&gt; 'pictures[]',
                'contents' =&gt; fopen('/private/var/folders/r0/k0xbnx757k3fnz09_6g9rp6w0000gn/T/phpYQ3NZP', 'r')
            ],
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Page Not Found."
}</code></pre>
<div id="execution-results-PUTapi-posts--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-posts--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-posts--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-posts--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-posts--id-"></code></pre>
</div>
<form id="form-PUTapi-posts--id-" data-method="PUT" data-path="api/posts/{id}" data-authed="1" data-hasfiles="1" data-headers='{"Authorization":"Bearer {YOUR_AUTH_TOKEN}","Content-Type":"multipart\/form-data","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-posts--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-PUTapi-posts--id-" onclick="tryItOut('PUTapi-posts--id-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-PUTapi-posts--id-" onclick="cancelTryOut('PUTapi-posts--id-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-PUTapi-posts--id-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/posts/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-posts--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-posts--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-posts--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>category_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="category_id" data-endpoint="PUTapi-posts--id-" data-component="body" required  hidden>
<br>
The category's ID.
</p>
<p>
<b><code>post_type_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="post_type_id" data-endpoint="PUTapi-posts--id-" data-component="body"  hidden>
<br>
The post type's ID.
</p>
<p>
<b><code>title</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="title" data-endpoint="PUTapi-posts--id-" data-component="body" required  hidden>
<br>
The post's title.
</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-posts--id-" data-component="body" required  hidden>
<br>
The post's description.
</p>
<p>
<b><code>contact_name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="contact_name" data-endpoint="PUTapi-posts--id-" data-component="body" required  hidden>
<br>
The post's author name.
</p>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="email" data-endpoint="PUTapi-posts--id-" data-component="body"  hidden>
<br>
The post's author email address (required if mobile phone number doesn't exist).
</p>
<p>
<b><code>phone</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="phone" data-endpoint="PUTapi-posts--id-" data-component="body"  hidden>
<br>
The post's author mobile number (required if email doesn't exist).
</p>
<p>
<b><code>city_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="city_id" data-endpoint="PUTapi-posts--id-" data-component="body" required  hidden>
<br>
The city's ID.
</p>
<p>
<b><code>accept_terms</code></b>&nbsp;&nbsp;<small>boolean</small>  &nbsp;
<label data-endpoint="PUTapi-posts--id-" hidden><input type="radio" name="accept_terms" value="true" data-endpoint="PUTapi-posts--id-" data-component="body" required ><code>true</code></label>
<label data-endpoint="PUTapi-posts--id-" hidden><input type="radio" name="accept_terms" value="false" data-endpoint="PUTapi-posts--id-" data-component="body" required ><code>false</code></label>
<br>
Accept the website terms and conditions.
</p>
<p>
<b><code>country_code</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="country_code" data-endpoint="PUTapi-posts--id-" data-component="body" required  hidden>
<br>
The code of the user's country.
</p>
<p>
<b><code>admin_code</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="admin_code" data-endpoint="PUTapi-posts--id-" data-component="body"  hidden>
<br>
The administrative division's code.
</p>
<p>
<b><code>price</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="price" data-endpoint="PUTapi-posts--id-" data-component="body" required  hidden>
<br>
The price.
</p>
<p>
<b><code>negotiable</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="PUTapi-posts--id-" hidden><input type="radio" name="negotiable" value="true" data-endpoint="PUTapi-posts--id-" data-component="body" ><code>true</code></label>
<label data-endpoint="PUTapi-posts--id-" hidden><input type="radio" name="negotiable" value="false" data-endpoint="PUTapi-posts--id-" data-component="body" ><code>false</code></label>
<br>
Negotiable price or no.
</p>
<p>
<b><code>phone_hidden</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="PUTapi-posts--id-" hidden><input type="radio" name="phone_hidden" value="true" data-endpoint="PUTapi-posts--id-" data-component="body" ><code>true</code></label>
<label data-endpoint="PUTapi-posts--id-" hidden><input type="radio" name="phone_hidden" value="false" data-endpoint="PUTapi-posts--id-" data-component="body" ><code>false</code></label>
<br>
Mobile phone number will be hidden in public or no.
</p>
<p>
<b><code>ip_addr</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="ip_addr" data-endpoint="PUTapi-posts--id-" data-component="body"  hidden>
<br>
The post's author IP address.
</p>
<p>
<b><code>accept_marketing_offers</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="PUTapi-posts--id-" hidden><input type="radio" name="accept_marketing_offers" value="true" data-endpoint="PUTapi-posts--id-" data-component="body" ><code>true</code></label>
<label data-endpoint="PUTapi-posts--id-" hidden><input type="radio" name="accept_marketing_offers" value="false" data-endpoint="PUTapi-posts--id-" data-component="body" ><code>false</code></label>
<br>
Accept to receive marketing offers or no.
</p>
<p>
<b><code>is_permanent</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="PUTapi-posts--id-" hidden><input type="radio" name="is_permanent" value="true" data-endpoint="PUTapi-posts--id-" data-component="body" ><code>true</code></label>
<label data-endpoint="PUTapi-posts--id-" hidden><input type="radio" name="is_permanent" value="false" data-endpoint="PUTapi-posts--id-" data-component="body" ><code>false</code></label>
<br>
Is it permanent post or no.
</p>
<p>
<b><code>tags</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="tags" data-endpoint="PUTapi-posts--id-" data-component="body"  hidden>
<br>
Comma-separated tags list.
</p>
<p>
<b><code>pictures</code></b>&nbsp;&nbsp;<small>file[]</small>  &nbsp;
<input type="file" name="pictures.0" data-endpoint="PUTapi-posts--id-" data-component="body" required  hidden>
<input type="file" name="pictures.1" data-endpoint="PUTapi-posts--id-" data-component="body" hidden>
<br>
The post's pictures.
</p>
<p>
<b><code>package_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="package_id" data-endpoint="PUTapi-posts--id-" data-component="body" required  hidden>
<br>
The package's ID.
</p>
<p>
<b><code>payment_method_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="payment_method_id" data-endpoint="PUTapi-posts--id-" data-component="body"  hidden>
<br>
The payment method's ID (required when the selected package's price is > 0).
</p>

</form>
<h2>Delete post(s)</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "https://laraclassified.bedigit.local/api/posts/odit" \
    -H "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/posts/odit"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;delete(
    'https://laraclassified.bedigit.local/api/posts/odit',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {YOUR_AUTH_TOKEN}',
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Page Not Found."
}</code></pre>
<div id="execution-results-DELETEapi-posts--ids-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-posts--ids-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-posts--ids-"></code></pre>
</div>
<div id="execution-error-DELETEapi-posts--ids-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-posts--ids-"></code></pre>
</div>
<form id="form-DELETEapi-posts--ids-" data-method="DELETE" data-path="api/posts/{ids}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_TOKEN}","Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-posts--ids-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-DELETEapi-posts--ids-" onclick="tryItOut('DELETEapi-posts--ids-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-DELETEapi-posts--ids-" onclick="cancelTryOut('DELETEapi-posts--ids-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-DELETEapi-posts--ids-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/posts/{ids}</code></b>
</p>
<p>
<label id="auth-DELETEapi-posts--ids-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-posts--ids-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="ids" data-endpoint="DELETEapi-posts--ids-" data-component="url" required  hidden>
<br>
The ID or comma-separated IDs list of post(s).
</p>
</form>
<h2>Email: Re-send link</h2>
<p>Re-send email verification link to the user</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/posts/quis/verify/resend/email?entitySlug=users" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/posts/quis/verify/resend/email"
);

let params = {
    "entitySlug": "users",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/posts/quis/verify/resend/email',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'entitySlug'=&gt; 'users',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Page Not Found."
}</code></pre>
<div id="execution-results-GETapi-posts--id--verify-resend-email" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-posts--id--verify-resend-email"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-posts--id--verify-resend-email"></code></pre>
</div>
<div id="execution-error-GETapi-posts--id--verify-resend-email" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-posts--id--verify-resend-email"></code></pre>
</div>
<form id="form-GETapi-posts--id--verify-resend-email" data-method="GET" data-path="api/posts/{id}/verify/resend/email" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-posts--id--verify-resend-email', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-posts--id--verify-resend-email" onclick="tryItOut('GETapi-posts--id--verify-resend-email');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-posts--id--verify-resend-email" onclick="cancelTryOut('GETapi-posts--id--verify-resend-email');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-posts--id--verify-resend-email" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/posts/{id}/verify/resend/email</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-posts--id--verify-resend-email" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>entitySlug</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="entitySlug" data-endpoint="GETapi-posts--id--verify-resend-email" data-component="query"  hidden>
<br>
The slug of the entity to verify ('users' or 'posts').
</p>
</form>
<h2>SMS: Re-send code</h2>
<p>Re-send mobile phone verification token by SMS</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/posts/sapiente/verify/resend/sms?entitySlug=users" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/posts/sapiente/verify/resend/sms"
);

let params = {
    "entitySlug": "users",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/posts/sapiente/verify/resend/sms',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'entitySlug'=&gt; 'users',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Page Not Found."
}</code></pre>
<div id="execution-results-GETapi-posts--id--verify-resend-sms" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-posts--id--verify-resend-sms"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-posts--id--verify-resend-sms"></code></pre>
</div>
<div id="execution-error-GETapi-posts--id--verify-resend-sms" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-posts--id--verify-resend-sms"></code></pre>
</div>
<form id="form-GETapi-posts--id--verify-resend-sms" data-method="GET" data-path="api/posts/{id}/verify/resend/sms" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-posts--id--verify-resend-sms', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-posts--id--verify-resend-sms" onclick="tryItOut('GETapi-posts--id--verify-resend-sms');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-posts--id--verify-resend-sms" onclick="cancelTryOut('GETapi-posts--id--verify-resend-sms');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-posts--id--verify-resend-sms" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/posts/{id}/verify/resend/sms</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-posts--id--verify-resend-sms" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>entitySlug</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="entitySlug" data-endpoint="GETapi-posts--id--verify-resend-sms" data-component="query"  hidden>
<br>
The slug of the entity to verify ('users' or 'posts').
</p>
</form>
<h2>Verification</h2>
<p>Verify the user's email address or mobile phone number</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/posts/verify/laborum/et?entitySlug=users" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/posts/verify/laborum/et"
);

let params = {
    "entitySlug": "users",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/posts/verify/laborum/et',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'entitySlug'=&gt; 'users',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Page Not Found."
}</code></pre>
<div id="execution-results-GETapi-posts-verify--field---token--" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-posts-verify--field---token--"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-posts-verify--field---token--"></code></pre>
</div>
<div id="execution-error-GETapi-posts-verify--field---token--" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-posts-verify--field---token--"></code></pre>
</div>
<form id="form-GETapi-posts-verify--field---token--" data-method="GET" data-path="api/posts/verify/{field}/{token?}" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-posts-verify--field---token--', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-posts-verify--field---token--" onclick="tryItOut('GETapi-posts-verify--field---token--');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-posts-verify--field---token--" onclick="cancelTryOut('GETapi-posts-verify--field---token--');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-posts-verify--field---token--" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/posts/verify/{field}/{token?}</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>field</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="field" data-endpoint="GETapi-posts-verify--field---token--" data-component="url" required  hidden>
<br>

</p>
<p>
<b><code>token</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="token" data-endpoint="GETapi-posts-verify--field---token--" data-component="url"  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>entitySlug</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="entitySlug" data-endpoint="GETapi-posts-verify--field---token--" data-component="query"  hidden>
<br>
The slug of the entity to verify ('users' or 'posts').
</p>
</form><h1>Saved Posts</h1>
<h2>List saved posts</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/savedPosts?country_code=US&amp;sort=quo" \
    -H "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/savedPosts"
);

let params = {
    "country_code": "US",
    "sort": "quo",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/savedPosts',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {YOUR_AUTH_TOKEN}',
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'country_code'=&gt; 'US',
            'sort'=&gt; 'quo',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (401):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Unauthenticated or Token Expired, Please Login",
    "result": null,
    "error_code": 1
}</code></pre>
<div id="execution-results-GETapi-savedPosts" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-savedPosts"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-savedPosts"></code></pre>
</div>
<div id="execution-error-GETapi-savedPosts" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-savedPosts"></code></pre>
</div>
<form id="form-GETapi-savedPosts" data-method="GET" data-path="api/savedPosts" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_TOKEN}","Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-savedPosts', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-savedPosts" onclick="tryItOut('GETapi-savedPosts');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-savedPosts" onclick="cancelTryOut('GETapi-savedPosts');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-savedPosts" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/savedPosts</code></b>
</p>
<p>
<label id="auth-GETapi-savedPosts" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-savedPosts" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>country_code</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="country_code" data-endpoint="GETapi-savedPosts" data-component="query" required  hidden>
<br>
The code of the user's country.
</p>
<p>
<b><code>sort</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="sort" data-endpoint="GETapi-savedPosts" data-component="query" required  hidden>
<br>
The sorting parameter. Sort by ascending with the prefix (-) or by descending without this prefix.
</p>
</form>
<h2>Delete saved post(s)</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "https://laraclassified.bedigit.local/api/savedPosts/distinctio" \
    -H "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/savedPosts/distinctio"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;delete(
    'https://laraclassified.bedigit.local/api/savedPosts/distinctio',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {YOUR_AUTH_TOKEN}',
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Page Not Found."
}</code></pre>
<div id="execution-results-DELETEapi-savedPosts--ids-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-savedPosts--ids-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-savedPosts--ids-"></code></pre>
</div>
<div id="execution-error-DELETEapi-savedPosts--ids-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-savedPosts--ids-"></code></pre>
</div>
<form id="form-DELETEapi-savedPosts--ids-" data-method="DELETE" data-path="api/savedPosts/{ids}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_TOKEN}","Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-savedPosts--ids-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-DELETEapi-savedPosts--ids-" onclick="tryItOut('DELETEapi-savedPosts--ids-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-DELETEapi-savedPosts--ids-" onclick="cancelTryOut('DELETEapi-savedPosts--ids-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-DELETEapi-savedPosts--ids-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/savedPosts/{ids}</code></b>
</p>
<p>
<label id="auth-DELETEapi-savedPosts--ids-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-savedPosts--ids-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="ids" data-endpoint="DELETEapi-savedPosts--ids-" data-component="url" required  hidden>
<br>
The ID or comma-separated IDs list of saved post(s).
</p>
</form><h1>Saved Searches</h1>
<h2>List saved searches</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/savedSearches" \
    -H "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/savedSearches"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/savedSearches',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {YOUR_AUTH_TOKEN}',
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (401):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Unauthenticated or Token Expired, Please Login",
    "result": null,
    "error_code": 1
}</code></pre>
<div id="execution-results-GETapi-savedSearches" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-savedSearches"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-savedSearches"></code></pre>
</div>
<div id="execution-error-GETapi-savedSearches" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-savedSearches"></code></pre>
</div>
<form id="form-GETapi-savedSearches" data-method="GET" data-path="api/savedSearches" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_TOKEN}","Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-savedSearches', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-savedSearches" onclick="tryItOut('GETapi-savedSearches');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-savedSearches" onclick="cancelTryOut('GETapi-savedSearches');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-savedSearches" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/savedSearches</code></b>
</p>
<p>
<label id="auth-GETapi-savedSearches" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-savedSearches" data-component="header"></label>
</p>
</form>
<h2>Delete saved search(es)</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "https://laraclassified.bedigit.local/api/savedSearches/nihil" \
    -H "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/savedSearches/nihil"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;delete(
    'https://laraclassified.bedigit.local/api/savedSearches/nihil',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {YOUR_AUTH_TOKEN}',
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Page Not Found."
}</code></pre>
<div id="execution-results-DELETEapi-savedSearches--ids-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-savedSearches--ids-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-savedSearches--ids-"></code></pre>
</div>
<div id="execution-error-DELETEapi-savedSearches--ids-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-savedSearches--ids-"></code></pre>
</div>
<form id="form-DELETEapi-savedSearches--ids-" data-method="DELETE" data-path="api/savedSearches/{ids}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_TOKEN}","Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-savedSearches--ids-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-DELETEapi-savedSearches--ids-" onclick="tryItOut('DELETEapi-savedSearches--ids-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-DELETEapi-savedSearches--ids-" onclick="cancelTryOut('DELETEapi-savedSearches--ids-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-DELETEapi-savedSearches--ids-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/savedSearches/{ids}</code></b>
</p>
<p>
<label id="auth-DELETEapi-savedSearches--ids-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-savedSearches--ids-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="ids" data-endpoint="DELETEapi-savedSearches--ids-" data-component="url" required  hidden>
<br>
The ID or comma-separated IDs list of saved search(es).
</p>
</form><h1>Settings</h1>
<h2>List settings</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/settings" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/settings"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/settings',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (429):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Too Many Requests,Please Slow Down",
    "result": null,
    "error_code": 1
}</code></pre>
<div id="execution-results-GETapi-settings" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-settings"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-settings"></code></pre>
</div>
<div id="execution-error-GETapi-settings" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-settings"></code></pre>
</div>
<form id="form-GETapi-settings" data-method="GET" data-path="api/settings" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-settings', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-settings" onclick="tryItOut('GETapi-settings');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-settings" onclick="cancelTryOut('GETapi-settings');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-settings" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/settings</code></b>
</p>
</form>
<h2>Get setting</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/settings/tenetur" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/settings/tenetur"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/settings/tenetur',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (429):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Too Many Requests,Please Slow Down",
    "result": null,
    "error_code": 1
}</code></pre>
<div id="execution-results-GETapi-settings--key-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-settings--key-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-settings--key-"></code></pre>
</div>
<div id="execution-error-GETapi-settings--key-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-settings--key-"></code></pre>
</div>
<form id="form-GETapi-settings--key-" data-method="GET" data-path="api/settings/{key}" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-settings--key-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-settings--key-" onclick="tryItOut('GETapi-settings--key-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-settings--key-" onclick="cancelTryOut('GETapi-settings--key-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-settings--key-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/settings/{key}</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>key</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="key" data-endpoint="GETapi-settings--key-" data-component="url" required  hidden>
<br>

</p>
</form><h1>Social Auth</h1>
<h2>Get target URL</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/auth/est" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/auth/est"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/auth/est',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Page Not Found."
}</code></pre>
<div id="execution-results-GETapi-auth--provider-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-auth--provider-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-auth--provider-"></code></pre>
</div>
<div id="execution-error-GETapi-auth--provider-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-auth--provider-"></code></pre>
</div>
<form id="form-GETapi-auth--provider-" data-method="GET" data-path="api/auth/{provider}" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-auth--provider-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-auth--provider-" onclick="tryItOut('GETapi-auth--provider-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-auth--provider-" onclick="cancelTryOut('GETapi-auth--provider-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-auth--provider-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/auth/{provider}</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>provider</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="provider" data-endpoint="GETapi-auth--provider-" data-component="url" required  hidden>
<br>

</p>
</form>
<h2>Get user info</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/auth/sunt/callback" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/auth/sunt/callback"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/auth/sunt/callback',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Page Not Found."
}</code></pre>
<div id="execution-results-GETapi-auth--provider--callback" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-auth--provider--callback"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-auth--provider--callback"></code></pre>
</div>
<div id="execution-error-GETapi-auth--provider--callback" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-auth--provider--callback"></code></pre>
</div>
<form id="form-GETapi-auth--provider--callback" data-method="GET" data-path="api/auth/{provider}/callback" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-auth--provider--callback', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-auth--provider--callback" onclick="tryItOut('GETapi-auth--provider--callback');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-auth--provider--callback" onclick="cancelTryOut('GETapi-auth--provider--callback');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-auth--provider--callback" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/auth/{provider}/callback</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>provider</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="provider" data-endpoint="GETapi-auth--provider--callback" data-component="url" required  hidden>
<br>

</p>
</form><h1>Threads</h1>
<h2>List threads</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<p>Get all logged user's threads.
Filters:</p>
<ul>
<li>unread: Get the logged user's unread threads</li>
<li>started: Get the logged user's started threads</li>
<li>important: Get the logged user's make as important threads</li>
</ul>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/threads?filter=rerum" \
    -H "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/threads"
);

let params = {
    "filter": "rerum",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/threads',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {YOUR_AUTH_TOKEN}',
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'filter'=&gt; 'rerum',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (401):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Unauthenticated or Token Expired, Please Login",
    "result": null,
    "error_code": 1
}</code></pre>
<div id="execution-results-GETapi-threads" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-threads"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-threads"></code></pre>
</div>
<div id="execution-error-GETapi-threads" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-threads"></code></pre>
</div>
<form id="form-GETapi-threads" data-method="GET" data-path="api/threads" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_TOKEN}","Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-threads', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-threads" onclick="tryItOut('GETapi-threads');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-threads" onclick="cancelTryOut('GETapi-threads');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-threads" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/threads</code></b>
</p>
<p>
<label id="auth-GETapi-threads" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-threads" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>filter</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter" data-endpoint="GETapi-threads" data-component="query"  hidden>
<br>
Filter for the list. Possible value: unread, started or important
</p>
</form>
<h2>Get thread</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<p>Get a thread (owned by the logged user) details</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/threads/libero" \
    -H "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/threads/libero"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/threads/libero',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {YOUR_AUTH_TOKEN}',
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Page Not Found."
}</code></pre>
<div id="execution-results-GETapi-threads--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-threads--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-threads--id-"></code></pre>
</div>
<div id="execution-error-GETapi-threads--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-threads--id-"></code></pre>
</div>
<form id="form-GETapi-threads--id-" data-method="GET" data-path="api/threads/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_TOKEN}","Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-threads--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-threads--id-" onclick="tryItOut('GETapi-threads--id-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-threads--id-" onclick="cancelTryOut('GETapi-threads--id-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-threads--id-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/threads/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-threads--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-threads--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-threads--id-" data-component="url" required  hidden>
<br>

</p>
</form>
<h2>Store thread</h2>
<p>Start a conversation. Creation of a new thread.</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "https://laraclassified.bedigit.local/api/threads" \
    -H "Content-Type: multipart/form-data" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs" \
    -H "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    -F "from_name=John Doe" \
    -F "from_email=john.doe@domain.tld" \
    -F "from_phone=est" \
    -F "body=Modi temporibus voluptas expedita voluptatibus voluptas veniam." \
    -F "post_id=2" \
    -F "captcha_key=non" \
    -F "filename=@/private/var/folders/r0/k0xbnx757k3fnz09_6g9rp6w0000gn/T/php9SFREP" </code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/threads"
);

let headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
};

const body = new FormData();
body.append('from_name', 'John Doe');
body.append('from_email', 'john.doe@domain.tld');
body.append('from_phone', 'est');
body.append('body', 'Modi temporibus voluptas expedita voluptatibus voluptas veniam.');
body.append('post_id', '2');
body.append('captcha_key', 'non');
body.append('filename', document.querySelector('input[name="filename"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://laraclassified.bedigit.local/api/threads',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
            'Authorization' =&gt; 'Bearer {YOUR_AUTH_TOKEN}',
        ],
        'multipart' =&gt; [
            [
                'name' =&gt; 'from_name',
                'contents' =&gt; 'John Doe'
            ],
            [
                'name' =&gt; 'from_email',
                'contents' =&gt; 'john.doe@domain.tld'
            ],
            [
                'name' =&gt; 'from_phone',
                'contents' =&gt; 'est'
            ],
            [
                'name' =&gt; 'body',
                'contents' =&gt; 'Modi temporibus voluptas expedita voluptatibus voluptas veniam.'
            ],
            [
                'name' =&gt; 'post_id',
                'contents' =&gt; '2'
            ],
            [
                'name' =&gt; 'captcha_key',
                'contents' =&gt; 'non'
            ],
            [
                'name' =&gt; 'filename',
                'contents' =&gt; fopen('/private/var/folders/r0/k0xbnx757k3fnz09_6g9rp6w0000gn/T/php9SFREP', 'r')
            ],
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (401):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Unauthenticated or Token Expired, Please Login",
    "result": null,
    "error_code": 1
}</code></pre>
<div id="execution-results-POSTapi-threads" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-threads"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-threads"></code></pre>
</div>
<div id="execution-error-POSTapi-threads" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-threads"></code></pre>
</div>
<form id="form-POSTapi-threads" data-method="POST" data-path="api/threads" data-authed="0" data-hasfiles="1" data-headers='{"Content-Type":"multipart\/form-data","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs","Authorization":"Bearer {YOUR_AUTH_TOKEN}"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-threads', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-threads" onclick="tryItOut('POSTapi-threads');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-threads" onclick="cancelTryOut('POSTapi-threads');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-threads" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/threads</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>from_name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="from_name" data-endpoint="POSTapi-threads" data-component="body" required  hidden>
<br>
The thread's creator name.
</p>
<p>
<b><code>from_email</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="from_email" data-endpoint="POSTapi-threads" data-component="body"  hidden>
<br>
The thread's creator email address (required if mobile phone number doesn't exist).
</p>
<p>
<b><code>from_phone</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="from_phone" data-endpoint="POSTapi-threads" data-component="body"  hidden>
<br>
The thread's creator mobile phone number (required if email doesn't exist).
</p>
<p>
<b><code>body</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="body" data-endpoint="POSTapi-threads" data-component="body" required  hidden>
<br>
The name of the user.
</p>
<p>
<b><code>post_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="post_id" data-endpoint="POSTapi-threads" data-component="body" required  hidden>
<br>
The related post ID.
</p>
<p>
<b><code>filename</code></b>&nbsp;&nbsp;<small>file</small>     <i>optional</i> &nbsp;
<input type="file" name="filename" data-endpoint="POSTapi-threads" data-component="body"  hidden>
<br>
The thread attached file.
</p>
<p>
<b><code>captcha_key</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="captcha_key" data-endpoint="POSTapi-threads" data-component="body"  hidden>
<br>
Key generated by the CAPTCHA endpoint calling (Required if the CAPTCHA verification is enabled from the Admin panel).
</p>

</form>
<h2>Update thread</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X PUT \
    "https://laraclassified.bedigit.local/api/threads/aut" \
    -H "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    -H "Content-Type: multipart/form-data" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs" \
    -F "body=Modi temporibus voluptas expedita voluptatibus voluptas veniam." \
    -F "filename=@/private/var/folders/r0/k0xbnx757k3fnz09_6g9rp6w0000gn/T/php7iaJFN" </code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/threads/aut"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

const body = new FormData();
body.append('body', 'Modi temporibus voluptas expedita voluptatibus voluptas veniam.');
body.append('filename', document.querySelector('input[name="filename"]').files[0]);

fetch(url, {
    method: "PUT",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;put(
    'https://laraclassified.bedigit.local/api/threads/aut',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {YOUR_AUTH_TOKEN}',
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'multipart' =&gt; [
            [
                'name' =&gt; 'body',
                'contents' =&gt; 'Modi temporibus voluptas expedita voluptatibus voluptas veniam.'
            ],
            [
                'name' =&gt; 'filename',
                'contents' =&gt; fopen('/private/var/folders/r0/k0xbnx757k3fnz09_6g9rp6w0000gn/T/php7iaJFN', 'r')
            ],
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Page Not Found."
}</code></pre>
<div id="execution-results-PUTapi-threads--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-threads--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-threads--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-threads--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-threads--id-"></code></pre>
</div>
<form id="form-PUTapi-threads--id-" data-method="PUT" data-path="api/threads/{id}" data-authed="1" data-hasfiles="1" data-headers='{"Authorization":"Bearer {YOUR_AUTH_TOKEN}","Content-Type":"multipart\/form-data","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-threads--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-PUTapi-threads--id-" onclick="tryItOut('PUTapi-threads--id-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-PUTapi-threads--id-" onclick="cancelTryOut('PUTapi-threads--id-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-PUTapi-threads--id-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/threads/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-threads--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-threads--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-threads--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>body</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="body" data-endpoint="PUTapi-threads--id-" data-component="body" required  hidden>
<br>
The name of the user.
</p>
<p>
<b><code>filename</code></b>&nbsp;&nbsp;<small>file</small>     <i>optional</i> &nbsp;
<input type="file" name="filename" data-endpoint="PUTapi-threads--id-" data-component="body"  hidden>
<br>
The thread attached file.
</p>

</form>
<h2>Delete thread(s)</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "https://laraclassified.bedigit.local/api/threads/consequatur" \
    -H "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/threads/consequatur"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;delete(
    'https://laraclassified.bedigit.local/api/threads/consequatur',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {YOUR_AUTH_TOKEN}',
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Page Not Found."
}</code></pre>
<div id="execution-results-DELETEapi-threads--ids-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-threads--ids-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-threads--ids-"></code></pre>
</div>
<div id="execution-error-DELETEapi-threads--ids-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-threads--ids-"></code></pre>
</div>
<form id="form-DELETEapi-threads--ids-" data-method="DELETE" data-path="api/threads/{ids}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_TOKEN}","Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-threads--ids-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-DELETEapi-threads--ids-" onclick="tryItOut('DELETEapi-threads--ids-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-DELETEapi-threads--ids-" onclick="cancelTryOut('DELETEapi-threads--ids-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-DELETEapi-threads--ids-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/threads/{ids}</code></b>
</p>
<p>
<label id="auth-DELETEapi-threads--ids-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-threads--ids-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="ids" data-endpoint="DELETEapi-threads--ids-" data-component="url" required  hidden>
<br>
The ID or comma-separated IDs list of thread(s).
</p>
</form>
<h2>Bulk updates</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "https://laraclassified.bedigit.local/api/threads/bulkUpdate/voluptatem?type=nihil" \
    -H "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/threads/bulkUpdate/voluptatem"
);

let params = {
    "type": "nihil",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://laraclassified.bedigit.local/api/threads/bulkUpdate/voluptatem',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {YOUR_AUTH_TOKEN}',
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'type'=&gt; 'nihil',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Page Not Found."
}</code></pre>
<div id="execution-results-POSTapi-threads-bulkUpdate--ids--" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-threads-bulkUpdate--ids--"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-threads-bulkUpdate--ids--"></code></pre>
</div>
<div id="execution-error-POSTapi-threads-bulkUpdate--ids--" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-threads-bulkUpdate--ids--"></code></pre>
</div>
<form id="form-POSTapi-threads-bulkUpdate--ids--" data-method="POST" data-path="api/threads/bulkUpdate/{ids?}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_TOKEN}","Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-threads-bulkUpdate--ids--', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-threads-bulkUpdate--ids--" onclick="tryItOut('POSTapi-threads-bulkUpdate--ids--');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-threads-bulkUpdate--ids--" onclick="cancelTryOut('POSTapi-threads-bulkUpdate--ids--');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-threads-bulkUpdate--ids--" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/threads/bulkUpdate/{ids?}</code></b>
</p>
<p>
<label id="auth-POSTapi-threads-bulkUpdate--ids--" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-threads-bulkUpdate--ids--" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="ids" data-endpoint="POSTapi-threads-bulkUpdate--ids--" data-component="url" required  hidden>
<br>
The ID or comma-separated IDs list of thread(s).
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-threads-bulkUpdate--ids--" data-component="query" required  hidden>
<br>
The type of action to execute (markAsRead, markAsUnread, markAsImportant, markAsNotImportant or markAllAsRead).
</p>
</form><h1>Users</h1>
<h2>List users</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/users" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/users"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/users',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (401):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Unauthorized",
    "result": null,
    "error_code": 1
}</code></pre>
<div id="execution-results-GETapi-users" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-users"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-users"></code></pre>
</div>
<div id="execution-error-GETapi-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-users"></code></pre>
</div>
<form id="form-GETapi-users" data-method="GET" data-path="api/users" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-users', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-users" onclick="tryItOut('GETapi-users');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-users" onclick="cancelTryOut('GETapi-users');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-users" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/users</code></b>
</p>
</form>
<h2>Get user</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/users/quasi" \
    -H "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/users/quasi"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/users/quasi',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {YOUR_AUTH_TOKEN}',
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Page Not Found."
}</code></pre>
<div id="execution-results-GETapi-users--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-users--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-users--id-"></code></pre>
</div>
<div id="execution-error-GETapi-users--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-users--id-"></code></pre>
</div>
<form id="form-GETapi-users--id-" data-method="GET" data-path="api/users/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_TOKEN}","Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-users--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-users--id-" onclick="tryItOut('GETapi-users--id-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-users--id-" onclick="cancelTryOut('GETapi-users--id-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-users--id-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/users/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-users--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-users--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-users--id-" data-component="url" required  hidden>
<br>

</p>
</form>
<h2>Store user</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "https://laraclassified.bedigit.local/api/users" \
    -H "Content-Type: multipart/form-data" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs" \
    -F "country_code=US" \
    -F "language_code=en" \
    -F "user_type_id=1" \
    -F "gender_id=1" \
    -F "name=John Doe" \
    -F "phone=+17656766467" \
    -F "phone_hidden=" \
    -F "email=john.doe@domain.tld" \
    -F "username=john_doe" \
    -F "password=js!X07$z61hLA" \
    -F "password_confirmation=js!X07$z61hLA" \
    -F "disable_comments=1" \
    -F "ip_addr=voluptas" \
    -F "accept_terms=1" \
    -F "accept_marketing_offers=" \
    -F "time_zone=America/New_York" \
    -F "captcha_key=non" \
    -F "photo=@/private/var/folders/r0/k0xbnx757k3fnz09_6g9rp6w0000gn/T/phpsAVdz4" </code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/users"
);

let headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

const body = new FormData();
body.append('country_code', 'US');
body.append('language_code', 'en');
body.append('user_type_id', '1');
body.append('gender_id', '1');
body.append('name', 'John Doe');
body.append('phone', '+17656766467');
body.append('phone_hidden', '');
body.append('email', 'john.doe@domain.tld');
body.append('username', 'john_doe');
body.append('password', 'js!X07$z61hLA');
body.append('password_confirmation', 'js!X07$z61hLA');
body.append('disable_comments', '1');
body.append('ip_addr', 'voluptas');
body.append('accept_terms', '1');
body.append('accept_marketing_offers', '');
body.append('time_zone', 'America/New_York');
body.append('captcha_key', 'non');
body.append('photo', document.querySelector('input[name="photo"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://laraclassified.bedigit.local/api/users',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'multipart' =&gt; [
            [
                'name' =&gt; 'country_code',
                'contents' =&gt; 'US'
            ],
            [
                'name' =&gt; 'language_code',
                'contents' =&gt; 'en'
            ],
            [
                'name' =&gt; 'user_type_id',
                'contents' =&gt; '1'
            ],
            [
                'name' =&gt; 'gender_id',
                'contents' =&gt; '1'
            ],
            [
                'name' =&gt; 'name',
                'contents' =&gt; 'John Doe'
            ],
            [
                'name' =&gt; 'phone',
                'contents' =&gt; '+17656766467'
            ],
            [
                'name' =&gt; 'phone_hidden',
                'contents' =&gt; ''
            ],
            [
                'name' =&gt; 'email',
                'contents' =&gt; 'john.doe@domain.tld'
            ],
            [
                'name' =&gt; 'username',
                'contents' =&gt; 'john_doe'
            ],
            [
                'name' =&gt; 'password',
                'contents' =&gt; 'js!X07$z61hLA'
            ],
            [
                'name' =&gt; 'password_confirmation',
                'contents' =&gt; 'js!X07$z61hLA'
            ],
            [
                'name' =&gt; 'disable_comments',
                'contents' =&gt; '1'
            ],
            [
                'name' =&gt; 'ip_addr',
                'contents' =&gt; 'voluptas'
            ],
            [
                'name' =&gt; 'accept_terms',
                'contents' =&gt; '1'
            ],
            [
                'name' =&gt; 'accept_marketing_offers',
                'contents' =&gt; ''
            ],
            [
                'name' =&gt; 'time_zone',
                'contents' =&gt; 'America/New_York'
            ],
            [
                'name' =&gt; 'captcha_key',
                'contents' =&gt; 'non'
            ],
            [
                'name' =&gt; 'photo',
                'contents' =&gt; fopen('/private/var/folders/r0/k0xbnx757k3fnz09_6g9rp6w0000gn/T/phpsAVdz4', 'r')
            ],
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "message": "Your account has been created.",
    "result": {
        "id": 2259,
        "name": "John Doe",
        "username": "john_doe",
        "created_at_formatted": "Jun 25th, 2021 at 12:48",
        "photo_url": "https:\/\/secure.gravatar.com\/avatar\/56c651b817a0b01e30f0c1dc44673bc6.jpg?s=150&amp;d=http%3A%2F%2Flaraclassified.bedigit.local%2Fimages%2Fuser.jpg&amp;r=g"
    },
    "extra": {
        "sendEmailVerification": {
            "success": true,
            "emailVerificationSent": true,
            "message": "An activation link has been sent to you to verify your email address."
        }
    }
}</code></pre>
<div id="execution-results-POSTapi-users" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-users"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-users"></code></pre>
</div>
<div id="execution-error-POSTapi-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-users"></code></pre>
</div>
<form id="form-POSTapi-users" data-method="POST" data-path="api/users" data-authed="0" data-hasfiles="1" data-headers='{"Content-Type":"multipart\/form-data","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-users', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-users" onclick="tryItOut('POSTapi-users');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-users" onclick="cancelTryOut('POSTapi-users');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-users" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/users</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>country_code</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="country_code" data-endpoint="POSTapi-users" data-component="body" required  hidden>
<br>
The code of the user's country.
</p>
<p>
<b><code>language_code</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="language_code" data-endpoint="POSTapi-users" data-component="body"  hidden>
<br>
The code of the user's spoken language.
</p>
<p>
<b><code>user_type_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="user_type_id" data-endpoint="POSTapi-users" data-component="body"  hidden>
<br>
The ID of user type.
</p>
<p>
<b><code>gender_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="gender_id" data-endpoint="POSTapi-users" data-component="body"  hidden>
<br>
The ID of gender.
</p>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-users" data-component="body" required  hidden>
<br>
The name of the user.
</p>
<p>
<b><code>photo</code></b>&nbsp;&nbsp;<small>file</small>     <i>optional</i> &nbsp;
<input type="file" name="photo" data-endpoint="POSTapi-users" data-component="body"  hidden>
<br>
The file of user photo.
</p>
<p>
<b><code>phone</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="phone" data-endpoint="POSTapi-users" data-component="body"  hidden>
<br>
The mobile phone number of the user (required if email doesn't exist).
</p>
<p>
<b><code>phone_hidden</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-users" hidden><input type="radio" name="phone_hidden" value="true" data-endpoint="POSTapi-users" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-users" hidden><input type="radio" name="phone_hidden" value="false" data-endpoint="POSTapi-users" data-component="body" ><code>false</code></label>
<br>
Field to hide or show the user phone number in public.
</p>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="email" data-endpoint="POSTapi-users" data-component="body"  hidden>
<br>
The user's email address (required if mobile phone number doesn't exist).
</p>
<p>
<b><code>username</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="username" data-endpoint="POSTapi-users" data-component="body"  hidden>
<br>
The user's username.
</p>
<p>
<b><code>password</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="password" name="password" data-endpoint="POSTapi-users" data-component="body" required  hidden>
<br>
The user's password.
</p>
<p>
<b><code>password_confirmation</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="password" name="password_confirmation" data-endpoint="POSTapi-users" data-component="body" required  hidden>
<br>
The confirmation of the user's password.
</p>
<p>
<b><code>disable_comments</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-users" hidden><input type="radio" name="disable_comments" value="true" data-endpoint="POSTapi-users" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-users" hidden><input type="radio" name="disable_comments" value="false" data-endpoint="POSTapi-users" data-component="body" ><code>false</code></label>
<br>
Field to disable or enable comments on the user's posts.
</p>
<p>
<b><code>ip_addr</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="ip_addr" data-endpoint="POSTapi-users" data-component="body" required  hidden>
<br>
The user's IP address.
</p>
<p>
<b><code>accept_terms</code></b>&nbsp;&nbsp;<small>boolean</small>  &nbsp;
<label data-endpoint="POSTapi-users" hidden><input type="radio" name="accept_terms" value="true" data-endpoint="POSTapi-users" data-component="body" required ><code>true</code></label>
<label data-endpoint="POSTapi-users" hidden><input type="radio" name="accept_terms" value="false" data-endpoint="POSTapi-users" data-component="body" required ><code>false</code></label>
<br>
Field to allow user to accept or not the website terms.
</p>
<p>
<b><code>accept_marketing_offers</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-users" hidden><input type="radio" name="accept_marketing_offers" value="true" data-endpoint="POSTapi-users" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-users" hidden><input type="radio" name="accept_marketing_offers" value="false" data-endpoint="POSTapi-users" data-component="body" ><code>false</code></label>
<br>
Field to allow user to accept or not marketing offers sending.
</p>
<p>
<b><code>time_zone</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="time_zone" data-endpoint="POSTapi-users" data-component="body"  hidden>
<br>
The user's time zone.
</p>
<p>
<b><code>captcha_key</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="captcha_key" data-endpoint="POSTapi-users" data-component="body"  hidden>
<br>
Key generated by the CAPTCHA endpoint calling (Required if the CAPTCHA verification is enabled from the Admin panel).
</p>

</form>
<h2>Update user</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X PUT \
    "https://laraclassified.bedigit.local/api/users/voluptatem" \
    -H "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    -H "Content-Type: multipart/form-data" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs" \
    -F "country_code=US" \
    -F "language_code=en" \
    -F "user_type_id=1" \
    -F "gender_id=1" \
    -F "name=John Doe" \
    -F "phone=+17656766467" \
    -F "phone_hidden=" \
    -F "email=john.doe@domain.tld" \
    -F "username=john_doe" \
    -F "password=js!X07$z61hLA" \
    -F "password_confirmation=js!X07$z61hLA" \
    -F "disable_comments=1" \
    -F "ip_addr=atque" \
    -F "accept_terms=1" \
    -F "accept_marketing_offers=" \
    -F "time_zone=America/New_York" \
    -F "photo=@/private/var/folders/r0/k0xbnx757k3fnz09_6g9rp6w0000gn/T/phpQVunWO" </code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/users/voluptatem"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

const body = new FormData();
body.append('country_code', 'US');
body.append('language_code', 'en');
body.append('user_type_id', '1');
body.append('gender_id', '1');
body.append('name', 'John Doe');
body.append('phone', '+17656766467');
body.append('phone_hidden', '');
body.append('email', 'john.doe@domain.tld');
body.append('username', 'john_doe');
body.append('password', 'js!X07$z61hLA');
body.append('password_confirmation', 'js!X07$z61hLA');
body.append('disable_comments', '1');
body.append('ip_addr', 'atque');
body.append('accept_terms', '1');
body.append('accept_marketing_offers', '');
body.append('time_zone', 'America/New_York');
body.append('photo', document.querySelector('input[name="photo"]').files[0]);

fetch(url, {
    method: "PUT",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;put(
    'https://laraclassified.bedigit.local/api/users/voluptatem',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {YOUR_AUTH_TOKEN}',
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'multipart' =&gt; [
            [
                'name' =&gt; 'country_code',
                'contents' =&gt; 'US'
            ],
            [
                'name' =&gt; 'language_code',
                'contents' =&gt; 'en'
            ],
            [
                'name' =&gt; 'user_type_id',
                'contents' =&gt; '1'
            ],
            [
                'name' =&gt; 'gender_id',
                'contents' =&gt; '1'
            ],
            [
                'name' =&gt; 'name',
                'contents' =&gt; 'John Doe'
            ],
            [
                'name' =&gt; 'phone',
                'contents' =&gt; '+17656766467'
            ],
            [
                'name' =&gt; 'phone_hidden',
                'contents' =&gt; ''
            ],
            [
                'name' =&gt; 'email',
                'contents' =&gt; 'john.doe@domain.tld'
            ],
            [
                'name' =&gt; 'username',
                'contents' =&gt; 'john_doe'
            ],
            [
                'name' =&gt; 'password',
                'contents' =&gt; 'js!X07$z61hLA'
            ],
            [
                'name' =&gt; 'password_confirmation',
                'contents' =&gt; 'js!X07$z61hLA'
            ],
            [
                'name' =&gt; 'disable_comments',
                'contents' =&gt; '1'
            ],
            [
                'name' =&gt; 'ip_addr',
                'contents' =&gt; 'atque'
            ],
            [
                'name' =&gt; 'accept_terms',
                'contents' =&gt; '1'
            ],
            [
                'name' =&gt; 'accept_marketing_offers',
                'contents' =&gt; ''
            ],
            [
                'name' =&gt; 'time_zone',
                'contents' =&gt; 'America/New_York'
            ],
            [
                'name' =&gt; 'photo',
                'contents' =&gt; fopen('/private/var/folders/r0/k0xbnx757k3fnz09_6g9rp6w0000gn/T/phpQVunWO', 'r')
            ],
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Page Not Found."
}</code></pre>
<div id="execution-results-PUTapi-users--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-users--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-users--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-users--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-users--id-"></code></pre>
</div>
<form id="form-PUTapi-users--id-" data-method="PUT" data-path="api/users/{id}" data-authed="1" data-hasfiles="1" data-headers='{"Authorization":"Bearer {YOUR_AUTH_TOKEN}","Content-Type":"multipart\/form-data","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-users--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-PUTapi-users--id-" onclick="tryItOut('PUTapi-users--id-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-PUTapi-users--id-" onclick="cancelTryOut('PUTapi-users--id-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-PUTapi-users--id-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/users/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-users--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-users--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-users--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>country_code</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="country_code" data-endpoint="PUTapi-users--id-" data-component="body" required  hidden>
<br>
The code of the user's country.
</p>
<p>
<b><code>language_code</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="language_code" data-endpoint="PUTapi-users--id-" data-component="body"  hidden>
<br>
The code of the user's spoken language.
</p>
<p>
<b><code>user_type_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="user_type_id" data-endpoint="PUTapi-users--id-" data-component="body"  hidden>
<br>
The ID of user type.
</p>
<p>
<b><code>gender_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="gender_id" data-endpoint="PUTapi-users--id-" data-component="body"  hidden>
<br>
The ID of gender.
</p>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-users--id-" data-component="body" required  hidden>
<br>
The name of the user.
</p>
<p>
<b><code>photo</code></b>&nbsp;&nbsp;<small>file</small>     <i>optional</i> &nbsp;
<input type="file" name="photo" data-endpoint="PUTapi-users--id-" data-component="body"  hidden>
<br>
The file of user photo.
</p>
<p>
<b><code>phone</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="phone" data-endpoint="PUTapi-users--id-" data-component="body"  hidden>
<br>
The mobile phone number of the user (required if email doesn't exist).
</p>
<p>
<b><code>phone_hidden</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="PUTapi-users--id-" hidden><input type="radio" name="phone_hidden" value="true" data-endpoint="PUTapi-users--id-" data-component="body" ><code>true</code></label>
<label data-endpoint="PUTapi-users--id-" hidden><input type="radio" name="phone_hidden" value="false" data-endpoint="PUTapi-users--id-" data-component="body" ><code>false</code></label>
<br>
Field to hide or show the user phone number in public.
</p>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="email" data-endpoint="PUTapi-users--id-" data-component="body" required  hidden>
<br>
The user's email address.
</p>
<p>
<b><code>username</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="username" data-endpoint="PUTapi-users--id-" data-component="body"  hidden>
<br>
The user's username.
</p>
<p>
<b><code>password</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="password" name="password" data-endpoint="PUTapi-users--id-" data-component="body" required  hidden>
<br>
The user's password.
</p>
<p>
<b><code>password_confirmation</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="password" name="password_confirmation" data-endpoint="PUTapi-users--id-" data-component="body" required  hidden>
<br>
The confirmation of the user's password.
</p>
<p>
<b><code>disable_comments</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="PUTapi-users--id-" hidden><input type="radio" name="disable_comments" value="true" data-endpoint="PUTapi-users--id-" data-component="body" ><code>true</code></label>
<label data-endpoint="PUTapi-users--id-" hidden><input type="radio" name="disable_comments" value="false" data-endpoint="PUTapi-users--id-" data-component="body" ><code>false</code></label>
<br>
Field to disable or enable comments on the user's posts.
</p>
<p>
<b><code>ip_addr</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="ip_addr" data-endpoint="PUTapi-users--id-" data-component="body" required  hidden>
<br>
The user's IP address.
</p>
<p>
<b><code>accept_terms</code></b>&nbsp;&nbsp;<small>boolean</small>  &nbsp;
<label data-endpoint="PUTapi-users--id-" hidden><input type="radio" name="accept_terms" value="true" data-endpoint="PUTapi-users--id-" data-component="body" required ><code>true</code></label>
<label data-endpoint="PUTapi-users--id-" hidden><input type="radio" name="accept_terms" value="false" data-endpoint="PUTapi-users--id-" data-component="body" required ><code>false</code></label>
<br>
Field to allow user to accept or not the website terms.
</p>
<p>
<b><code>accept_marketing_offers</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="PUTapi-users--id-" hidden><input type="radio" name="accept_marketing_offers" value="true" data-endpoint="PUTapi-users--id-" data-component="body" ><code>true</code></label>
<label data-endpoint="PUTapi-users--id-" hidden><input type="radio" name="accept_marketing_offers" value="false" data-endpoint="PUTapi-users--id-" data-component="body" ><code>false</code></label>
<br>
Field to allow user to accept or not marketing offers sending.
</p>
<p>
<b><code>time_zone</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="time_zone" data-endpoint="PUTapi-users--id-" data-component="body"  hidden>
<br>
The user's time zone.
</p>

</form>
<h2>Delete user</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "https://laraclassified.bedigit.local/api/users/fugit" \
    -H "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/users/fugit"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;delete(
    'https://laraclassified.bedigit.local/api/users/fugit',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {YOUR_AUTH_TOKEN}',
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Page Not Found."
}</code></pre>
<div id="execution-results-DELETEapi-users--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-users--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-users--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-users--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-users--id-"></code></pre>
</div>
<form id="form-DELETEapi-users--id-" data-method="DELETE" data-path="api/users/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_TOKEN}","Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-users--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-DELETEapi-users--id-" onclick="tryItOut('DELETEapi-users--id-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-DELETEapi-users--id-" onclick="cancelTryOut('DELETEapi-users--id-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-DELETEapi-users--id-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/users/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-users--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-users--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-users--id-" data-component="url" required  hidden>
<br>

</p>
</form>
<h2>Email: Re-send link</h2>
<p>Re-send email verification link to the user</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/users/impedit/verify/resend/email?entitySlug=users" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/users/impedit/verify/resend/email"
);

let params = {
    "entitySlug": "users",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/users/impedit/verify/resend/email',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'entitySlug'=&gt; 'users',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Page Not Found."
}</code></pre>
<div id="execution-results-GETapi-users--id--verify-resend-email" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-users--id--verify-resend-email"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-users--id--verify-resend-email"></code></pre>
</div>
<div id="execution-error-GETapi-users--id--verify-resend-email" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-users--id--verify-resend-email"></code></pre>
</div>
<form id="form-GETapi-users--id--verify-resend-email" data-method="GET" data-path="api/users/{id}/verify/resend/email" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-users--id--verify-resend-email', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-users--id--verify-resend-email" onclick="tryItOut('GETapi-users--id--verify-resend-email');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-users--id--verify-resend-email" onclick="cancelTryOut('GETapi-users--id--verify-resend-email');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-users--id--verify-resend-email" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/users/{id}/verify/resend/email</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-users--id--verify-resend-email" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>entitySlug</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="entitySlug" data-endpoint="GETapi-users--id--verify-resend-email" data-component="query"  hidden>
<br>
The slug of the entity to verify ('users' or 'posts').
</p>
</form>
<h2>SMS: Re-send code</h2>
<p>Re-send mobile phone verification token by SMS</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/users/rerum/verify/resend/sms?entitySlug=users" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/users/rerum/verify/resend/sms"
);

let params = {
    "entitySlug": "users",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/users/rerum/verify/resend/sms',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'entitySlug'=&gt; 'users',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Page Not Found."
}</code></pre>
<div id="execution-results-GETapi-users--id--verify-resend-sms" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-users--id--verify-resend-sms"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-users--id--verify-resend-sms"></code></pre>
</div>
<div id="execution-error-GETapi-users--id--verify-resend-sms" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-users--id--verify-resend-sms"></code></pre>
</div>
<form id="form-GETapi-users--id--verify-resend-sms" data-method="GET" data-path="api/users/{id}/verify/resend/sms" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-users--id--verify-resend-sms', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-users--id--verify-resend-sms" onclick="tryItOut('GETapi-users--id--verify-resend-sms');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-users--id--verify-resend-sms" onclick="cancelTryOut('GETapi-users--id--verify-resend-sms');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-users--id--verify-resend-sms" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/users/{id}/verify/resend/sms</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-users--id--verify-resend-sms" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>entitySlug</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="entitySlug" data-endpoint="GETapi-users--id--verify-resend-sms" data-component="query"  hidden>
<br>
The slug of the entity to verify ('users' or 'posts').
</p>
</form>
<h2>Verification</h2>
<p>Verify the user's email address or mobile phone number</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://laraclassified.bedigit.local/api/users/verify/ut/omnis?entitySlug=users" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Content-Language: en" \
    -H "X-AppApiToken: Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=" \
    -H "X-AppType: docs"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://laraclassified.bedigit.local/api/users/verify/ut/omnis"
);

let params = {
    "entitySlug": "users",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Content-Language": "en",
    "X-AppApiToken": "Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=",
    "X-AppType": "docs",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://laraclassified.bedigit.local/api/users/verify/ut/omnis',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Content-Language' =&gt; 'en',
            'X-AppApiToken' =&gt; 'Uk1DSFlVUVhIRXpHbWt6d2pIZjlPTG15akRPN2tJTUs=',
            'X-AppType' =&gt; 'docs',
        ],
        'query' =&gt; [
            'entitySlug'=&gt; 'users',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "success": false,
    "message": "Page Not Found."
}</code></pre>
<div id="execution-results-GETapi-users-verify--field---token--" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-users-verify--field---token--"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-users-verify--field---token--"></code></pre>
</div>
<div id="execution-error-GETapi-users-verify--field---token--" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-users-verify--field---token--"></code></pre>
</div>
<form id="form-GETapi-users-verify--field---token--" data-method="GET" data-path="api/users/verify/{field}/{token?}" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Content-Language":"en","X-AppApiToken":"OGRCaUxleW9yVGxtNG00SUxDbHhKOHdWR1V6RDBGRUg=","X-AppType":"docs"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-users-verify--field---token--', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-users-verify--field---token--" onclick="tryItOut('GETapi-users-verify--field---token--');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-users-verify--field---token--" onclick="cancelTryOut('GETapi-users-verify--field---token--');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-users-verify--field---token--" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/users/verify/{field}/{token?}</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>field</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="field" data-endpoint="GETapi-users-verify--field---token--" data-component="url" required  hidden>
<br>

</p>
<p>
<b><code>token</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="token" data-endpoint="GETapi-users-verify--field---token--" data-component="url"  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>entitySlug</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="entitySlug" data-endpoint="GETapi-users-verify--field---token--" data-component="query"  hidden>
<br>
The slug of the entity to verify ('users' or 'posts').
</p>
</form>
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                    <a href="#" data-language-name="bash">bash</a>
                                    <a href="#" data-language-name="javascript">javascript</a>
                                    <a href="#" data-language-name="php">php</a>
                            </div>
            </div>
</div>
<script>
    $(function () {
        var languages = ["bash","javascript","php"];
        setupLanguages(languages);
    });
</script>
</body>
</html>