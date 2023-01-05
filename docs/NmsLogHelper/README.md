# <span id="top">[NMS Laravel Utility](../)</span>
# NMS Logging
## [#](#introduction) <span id="#introduction">Introduction</span>
Log the message or data through Database, API or File (using Laravel Log Facade). You may use the laravel queueing to run the logs in the background. The logger provides the eight(8) logging levels defined in the [RFC 5424 specification:](https://www.rfc-editor.org/rfc/rfc5424)
  - **emergency**
  - **alert**
  - **warning**  
  - **debug**
  - **warning** 
  - **notice** 
  - **info**
  - **debug**
## [#](#usage) <span id="usage">Usage</span>
You may write information to the logs using the **NmsLogHelper** facade:
  ```php
  $data = [
        'where' => '127.0.0.1',
        'who' => 'Jon',
        'when' => '13:00',
        'how' => 'select',
    ];
    
  \NmsLogHelper::channel()->info('info message', $data);
  ```
## [#](#writing-logs) <span id="writing-logs">Writing Logs</span>

> You may [queue](#queue-logs) your logs action and run it in the background using the [Laravel Queues](https://laravel.com/docs/9.x/queues).

### <a href="#writing-file-logs">#</a> <span id="writing-file-logs">File Logs</span>
By default, it will store the logs message through file and it will live in `/storage/logs` directory. You may define your [own file logs channel](https://laravel.com/docs/9.x/logging#writing-to-specific-channels) and log to defined channel in your configuration file:
 ```php
  \NmsLogHelper::channel()->info('info message', $data);
  ```
### [#](#writing-database-logs) <span id="writing-database-logs">Database Logs</span>
It will store the logs message through database. You can used it by setting the `channel` method argument to `database`:
 ```php
  \NmsLogHelper::channel('database')->info('info message', $data);
  ```
#### [#](#writing-database-logs-config) <span id="writing-database-logs-config">Database Configuration</span>
  In your application's `config/logging.php` configuration file, you should add the `nmsdatabase` channels and set the table name from the application database:
  ```php
  'channels' => [
    ...
    'nmsdatabase' => [
      'table' => env('NMS_DATABASE_LOG_CHANNEL_TABLE', 'nms_activity_logs'),
    ]
  ]
    
  ```
### [#](#writing-api-logs) <span id="writing-api-logs">API Logs</span>
You may store the logs message through API request. You can used it by setting the `channel` method argument to `api`:
 ```php
  \NmsLogHelper::channel('api')->info('info message', $data);
  ```
  #### [#](#writing-api-logs) <span id="writing-api-logs">API Configuration</span>
  In your application's `config/logging.php` configuration file, you should add the `nmsapi` channels and set the value of available configurations:

  ```php

  'channels' => [
    ...
      'nmsapi' => [
              'url' => env('NMS_API_LOG_CHANNEL_URL', 'localhost'),
              'headers' => [],
              'options' => [],
              'retry_policy' => true,
              'verify_ssl' => false,
              'attempts' => 3,
              'attempt_time' => 100,
              'timeouts' => 60,
          ],
  ]
  ```

###  [#](#queue-logs) <span id="queue-logs">Queue Logs</span>
Logs the message in the background using [Laravel Queues](https://laravel.com/docs/9.x/queues). You can used it by calling the `queue` method with default parameters:
```php 
queue(int $jobQueueDelay = 5, bool $logJobQueue = false)
```
<h5>Params:</h5>
<ul>
<li> jobQueueDelay </li>
<dl> - set the delay time.</dl>
<li> logJobQueue </li>
<dl> - set the value to `true` to log the queue reponse to <code>laravel.log</code></dl>
</ul>
#### [#](#queue-logs-usage) <span id="queue-logs-usage">Usage</span>
 ```php
  \NmsLogHelper::channel()->queue()->info('info message', $data);
  ```

## [#](#overlords) <span id="overlords">Overlords</span>
- [Jon Rey Galera](@jonrey.galera)
- [Frederick Layus Jr.](@frederick.layusjr)

[Back to Top](#top)
