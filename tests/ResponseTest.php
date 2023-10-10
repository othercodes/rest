<?phpuse OtherCode\Rest\Payloads\Response;use OtherCode\Rest\Core\Error;test('instantiation response only', function () {    $rawResponse = "HTTP/1.1 200 OKDate: Sun, 15 Oct 2017 09:08:45 GMTContent-Type: application/json; charset=utf-8Content-Length: 292Connection: keep-aliveSet-Cookie: __cfduid=da3394200e70ef444ffd875ddc251a6e41508058525; expires=Mon, 15-Oct-18 09:08:45 GMT; path=/; domain=.typicode.com; HttpOnlyX-Powered-By: ExpressVary: Origin, Accept-EncodingAccess-Control-Allow-Credentials: trueCache-Control: public, max-age=14400Pragma: no-cacheExpires: Sun, 15 Oct 2017 13:08:45 GMTX-Content-Type-Options: nosniffEtag: W/\"124-yiKdLzqO5gfBrJFrcdJ8Yq0LGnU\"Via: 1.1 vegurCF-Cache-Status: HITServer: cloudflare-nginxCF-RAY: 3ae1a2b842f90dc3-MAD\r\n\r\n{  \"userId\": 1,  \"id\": 1,  \"title\": \"sunt aut facere repellat provident occaecati excepturi optio reprehenderit\",  \"body\": \"quia et suscipit\nsuscipit recusandae consequuntur expedita et cum\nreprehenderit molestiae ut ut quas totam\nnostrum rerum est autem sunt rem eveniet architecto\"}";    $response = new Response($rawResponse);    expect($response->content_type)->toEqual('application/json');    expect($response->charset)->toEqual('utf-8');    expect($response->body)->toEqual("{  \"userId\": 1,  \"id\": 1,  \"title\": \"sunt aut facere repellat provident occaecati excepturi optio reprehenderit\",  \"body\": \"quia et suscipit\nsuscipit recusandae consequuntur expedita et cum\nreprehenderit molestiae ut ut quas totam\nnostrum rerum est autem sunt rem eveniet architecto\"}");    expect($response->headers)->toBeInstanceOf('\OtherCode\Rest\Payloads\Headers');    expect($response->headers)->toHaveCount(17);});test('instantiation with error', function () {    $response = new Response(null, new Error(500, "Server Error"));    expect($response->error)->toBeInstanceOf('\OtherCode\Rest\Core\Error');    expect($response->error->code)->toEqual(500);    expect($response->error->message)->toEqual('Server Error');});test('instantiation with metadata', function () {    $response = new Response(null, null, array(        'http_code' => 200    ));    expect($response->metadata)->toBeArray();    expect($response->metadata)->toHaveCount(1);    expect($response->metadata['http_code'])->toEqual(200);    expect($response->code)->toEqual(200);});