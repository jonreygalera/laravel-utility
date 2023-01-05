# <span id="top">[NMS Laravel Utility](../)</span>

## [#](#nms-api-helper) <span id="nms-api-helper">NmsApiHelper</span>
API request validation and response. You may used `NmsApiHelper` facade to use it.
## [#](#nms-api-helper-methods) <span id="nms-api-helper-methods">Methods</span>

### [#](#unauthorized) <span id="unauthorized">Unauthorized</span>
Unauthorized response.
#### [#](#unauthorized-syntax) <span id="unauthorized-syntax">Syntax</span>

```php 
unauthorized(string $message = 'Unauthorized')
```
#### [#](#unauthorized-usage) <span id="unauthorized-usage">Usage</span>
```php
return \NmsApiHelper::unauthorized(); // {"message":"Unauthorized","code":401}
```

### [#](#onqueued) <span id="onqueued">On Queued</span>
On queued response.
#### [#](#onqueued-syntax) <span id="onqueued-syntax">Syntax</span>

```php 
onQueued()
```
#### [#](#onqueued-usage) <span id="onqueued-usage">Usage</span>
```php
return \NmsApiHelper::onQueued(); // {"message":"Queued.","code":200}
```

### [#](#ping) <span id="ping">Ping</span>
ping response.
#### [#](#ping-syntax) <span id="ping-syntax">Syntax</span>

```php 
ping()
```
#### [#](#ping-usage) <span id="ping-usage">Usage</span>
```php
return \NmsApiHelper::ping(); // {"message":"Pong","code":200}
```
### [#](#response-success) <span id="response-success">Response Success</span>
Success response.
#### [#](#response-success-syntax) <span id="response-success-syntax">Syntax</span>

```php 
responseSuccess(string $message = 'Success')
```
#### [#](#response-success-usage) <span id="response-success-usage">Usage</span>
```php
return \NmsApiHelper::responseSuccess(); // {"message":"Success","code":200}
```
### [#](#response-error) <span id="response-error">Response Error</span>
Error response.
#### [#](#response-error-syntax) <span id="response-error-syntax">Syntax</span>

```php 
responseError(string $message = 'Internal Server Error')
```
#### [#](#response-error-usage) <span id="response-error-usage">Usage</span>
##### [#](#response-error-usage-default) <span id="response-error-usage-default">Default</span>
```php
return \NmsApiHelper::responseError(); // {"message":"Internal Server Error","code":500}
```
##### [#](#response-error-usage-encode) <span id="response-error-usage-encode">JSON Encoded Array Message</span>
```php
try {
  throw new \Exception(json_encode([ 'message' => 'Name is required.', 'code' => 403]));
} catch (\Throwable $throwable) {
  return \NmsApiHelper::responseError($throwable->getMessage()); // {"message":"Name is required.","code":403}
}
```

### [#](#response-data) <span id="response-error">Response Data</span>
Response with data.
#### [#](#response-data-syntax) <span id="response-data-syntax">Syntax</span>

```php 
responseData(array $data, $messageOrBoolean = 'Success', int $code = Response::HTTP_OK)
```
#### [#](#response-data-usage) <span id="response-data-usage">Usage</span>
##### [#](#response-data-usage-default) <span id="response-data-usage-default">Default</span>
```php
$data = [
        [ 'name' => 'Jon', 'age' => 85],
        [ 'name' => 'Fred', 'age' => 18],
    ];
return \NmsApiHelper::responseData($data); // {"message":"Success","code":200,"data":[{"name":"Jon","age":85},{"name":"Fred","age":18}]}
```
##### [#](#response-data-usage-data-only) <span id="response-data-usage-data-only">Data Only</span>
```php
$data = [
        [ 'name' => 'Jon', 'age' => 85],
        [ 'name' => 'Fred', 'age' => 18],
    ];
    return \NmsApiHelper::responseData($data, TRUE); // [{"name":"Jon","age":85},{"name":"Fred","age":18}]
```
### [#](#validate-request) <span id="validate-request">Validate Request</span>
This method is using the [Laravel Validation](https://laravel.com/docs/9.x/validation). It **MUST** be wrap inside `try catch` using `responseError` method to catch the errors.
#### [#](#validate-request-syntax) <span id="validate-request-syntax">Syntax</span>

```php 
validateRequest(array $data, array $rules, array $rename = [])
```
#### [#](#unauthorized-usage) <span id="unauthorized-usage">Usage</span>
```php
function save(Request $request) {
    try {
        $rules = [
            'name' => 'required'
        ];
       \NmsApiHelper::validateRequest($request->all(), $rules);
    } catch (\Throwable $throwable) {
        return \NmsApiHelper::responseError($throwable->getMessage()); // {"message":"The name field is required.","code":400}
    }
};
```

## [#](#overlords) <span id="overlords">Overlords</span>
- [Jon Rey Galera](@jonrey.galera)
- [Frederick Layus Jr.](@frederick.layusjr)

[Back to Top](#top)