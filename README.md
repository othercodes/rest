# Rest Client

[![Build Status](https://travis-ci.org/othercodes/rest.svg?branch=master)](https://travis-ci.org/othercodes/rest) [![Latest Stable Version](https://poser.pugx.org/othercode/rest/v/stable)](https://packagist.org/packages/othercode/rest) [![License](https://poser.pugx.org/othercode/rest/license)](https://packagist.org/packages/othercode/rest)

[Rest client](http://othercode.es/packages/rest-client.html) to make GET, POST, PUT, DELETE, PATCH, etc calls.

## Installation

To install the package we only have to add the dependency to ***scripts/composer.json*** file:

```javascript
"require": {
  "othercode/rest": "*"
}
```

And run the following command:

```bash
composer update
```

### Install without Composer

Also we can use this library without Composer, we only have to include in our script the **"rest/autoload.php"** file.
```php
require_once "rest/autoload.php".
```

## Usage

To use the Rest we only have to instantiate it and configure the params we want. We can 
establish the configuration accessing to the `->configuration->configure_property`, for example 
to configure the url of the call we only have to set the `->configuration->url parameter` like we can see as follows:

```php
$api = new \OtherCode\Rest\Rest();
$api->configuration->url = "http://jsonplaceholder.typicode.com/";
```

or

```php
$api = new \OtherCode\Rest\Rest(new \OtherCode\Rest\Core\Configuration(array(
    'url' => 'http://jsonplaceholder.typicode.com/',
)));
```

After this we have to set the type of call and the parameters that we wil use, in this case we are
going to perform a **GET** request to the **"posts/1"** endpoint:

```php
$response = $api->get("posts/1");
```

The rest client will throw a `ConnectionException` if there any problem related to the connection.

**NOTE: These errors are related to the session cURL, here is the [complete list](https://curl.haxx.se/libcurl/c/libcurl-errors.html)**

## Methods 

The available methods to work with are:

#### `get()`

Perform a GET request.

Parameters                    | Type    | Description
----------------------------- | ------- | -------------------------------------------
`$url`                        | String  | Required. The URL to which the request is made
`$data`                       | Array   | Optional. Associative array of data parameters

**Return**: Response object

#### `head()`

Perform a HEAD request.

Parameters                    | Type    | Description
----------------------------- | ------- | -------------------------------------------
`$url`                        | String  | Required. The URL to which the request is made

**Return**: Response object (no body)

#### `post()`

Perform a POST request.

Parameters                    | Type    | Description
----------------------------- | ------- | -------------------------------------------
`$url`                        | String  | Required. The URL to which the request is made
`$data`                       | Array   | Optional. Associative array of data parameters

**Return**: Response object

#### `delete()`

Perform a DELETE request.

Parameters                    | Type    | Description
----------------------------- | ------- | -------------------------------------------
`$url`                        | String  | Required. The URL to which the request is made
`$data`                       | Array   | Optional. Associative array of data parameters

**Return**: Response object

#### `put()`

Perform a PUT request.

Parameters                    | Type    | Description
----------------------------- | ------- | -------------------------------------------
`$url`                        | String  | Required. The URL to which the request is made
`$data`                       | Array   | Optional. Associative array of data parameters

**Return**: Response object

#### `patch()`

Perform a PATCH request.

Parameters                    | Type    | Description
----------------------------- | ------- | -------------------------------------------
`$url`                        | String  | Required. The URL to which the request is made
`$data`                       | Array   | Optional. Associative array of data parameters

**Return**: Response object

#### `getMetadata()`

Return the metadata of the request.

**Return**: Array

#### `getError()`

Return the last known error.

**Return**: `Error` object

#### `getPayloads()`

Return an array with the `Response` and `Request` objects.

**Return**: Array

#### `setDecoder()`

Set a new Decoder.

Parameters                    | Type    | Description
----------------------------- | ------- | -------------------------------------------
`$name`                       | String  | Required. The unique name of the decoder.
`$decoder`                    | String  | Optional. The class name with namespace of the new decoder.

**Return**: Rest object

#### `setEncoder()`

Set a new Encoder.

Parameters                    | Type    | Description
----------------------------- | ------- | -------------------------------------------
`$name`                       | String  | Required. The unique name of the encoder.
`$encoder`                    | String  | Optional. The class name with namespace of the new encoder.

**Return**: Rest object

#### `setModule()`

Set a new Module.

Parameters                    | Type    | Description
----------------------------- | ------- | -------------------------------------------
`$name`                       | String  | Required. The unique name of the module.
`$module`                     | String  | Required. The class name with namespace of the new module.
`$hook`                       | String  | Optional. The hook name (after/before) that will trigger the module, 'after' by default.

**Return**: Rest object

#### `unsetModule()`

Unregister a module.

Parameters                    | Type   | Description
----------------------------- | ------ | -------------------------------------------
`$moduleName`                 | String | Required. The unique name of the decoder.
`$hook`                       | String | Optional. The hook name (after/before) from where delete the module.

**Return**: Rest object

#### `addHeader()`

Add a new header.

Parameters                    | Type   | Description
----------------------------- | ------ | -------------------------------------------
`$header`                     | String | Required. The unique name of the header.
`$value`                      | String | Requires. The value of the header.

**Return**: Rest object

#### `addHeaders()`

Add an array of headers.

Parameters                    | Type   | Description
----------------------------- | ------ | -------------------------------------------
`$headers`                    | String | Required. An array of headers.

**Return**: Rest object

**NOTE: We can use the `addHeader()` and `addHeaders()` methods with the `Rest` instance or with the `configuration` object**

```php
$api->addHeader('some_header','some_value');
$api->addHeaders(array('some_header' => 'some_value','other_header' => 'other_value'));
```

is the same as

```php
$api->configuration->addHeader('some_header','some_value');
$api->configuration->addHeaders(array('some_header' => 'some_value','other_header' => 'other_value'));
```

#### `removeHeader()`

Remove a header offset.

Parameters                    | Type   | Description
----------------------------- | ------ | -------------------------------------------
`$header`                     | String | Required. The unique name of the header.

**Return**: Rest object

#### `removeHeaders()`

Remove an array of headers.

Parameters                    | Type   | Description
----------------------------- | ------ | -------------------------------------------
`$headers`                    | String | Required. An array of headers to remove.

**Return**: Rest object

## Modules

This package allow you to create modules to perform task before and after the request..
To create a new module we only have to use this template:

```php
class CustomModule extends BaseModule
{
    public function run()
    {
        // do something
    }
}
```

**IMPORTANT: Any module MUST extends BaseModule**

The only method that is mandatory is `->run()`, this method execute your custom code of the module.

Once we have our module we can register it with the `->setModule()` method. This method needs three parameters,
the first one is the name of the module, the second one is the complete namespace of the module, and the third one 
is the hook name for our module, it can be "before" and "after" depends when we want to launch our module.
 
```php
$api->setModule('module_name','Module\Complete\Namespace','after');
```

For "before" modules you can use all the properties of the Request object.

* `method`
* `url` 
* `headers`
* `body`

For "after" modules you can use all the properties of the Response object.

* `code`
* `content_type`
* `charset`
* `body`
* `headers`
* `error`
* `metadata`

All modules are executed in the order that we register them into the Rest client, this also affect 
to Decoders and Encoders.

## Decoders

A decoder is a kind of module that allows you to automatically decode de response in xml or json, to use them 
we only have to set the decoder we want with the `->setDecoder()` method:

```php
$api->setDecoder("json");
```

The default allowed values for this method are: ***json***, ***xml*** and ***xmlrpc***. All the decoders are always executed 
in the "after" hook. 

###Custom Decoders

To create a new decoder we only have to use this template:

```php
class CustomDecoder extends BaseDecoder
{
	protected $contentType = 'application/json';

	protected function decode()
	{
		// decode $this->body
	}
}
```

Like in modules, we have the Response object available to work. The $contentType property is the content-type 
that will trigger the decoder, in the example above all responses with content-type "application/json" will 
trigger this decoder.

## Complete Example

```php
require_once '../autoload.php';

try {

    $api = new \OtherCode\Rest\Rest(new \OtherCode\Rest\Core\Configuration(array(
        'url' => 'http://jsonplaceholder.typicode.com/',
        'httpheader' => array(
            'some_header' => 'some_value',
        )
    )));
    $api->setDecoder("json");
    
    $response = $api->get("posts/1");
    var_dump($response);
    
} catch (\Exception $e) {
    print "> " . $e->getMessage() . "\n"
}
```
