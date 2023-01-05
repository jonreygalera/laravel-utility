# <span id="top">[NMS Laravel Utility](../)</span>
![php](https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white)
![laravel](https://img.shields.io/badge/Laravel-FF2D20?style=flat&logo=laravel&logoColor=white)
<br/>
Collection of NMS Helpers/Traits.

## [#](#prerequisites) <span id="prerequisites">Prerequisites</span>
- [Laravel Framework](https://laravel.com) 9+ support
- [PHP](https://www.php.net) 8+ support
## [#](#installation) <span id="installation">Installation</span>

1. Install the package via composer.
```bash
composer require nms/laravel-utility
```
2. Publish provider.
```bash
php artisan vendor:publish --provider="Nms\LaravelUtility\LaravelUtilityServiceProvider"
```
3. Clear your config cache. 
```bash
php artisan optimize:clear 
```
## [#](#helpers) <span id="helper">Helpers</span>
### [#](#) [NmsLogHelper](/docs/NmsLogHelper)
- log the message or data through Database, API or File (using Laravel Log Facade). You may use the laravel queueing to run the logs in the background.

### [#](#) [NmsApiHelper](/docs/NmsApiHelper)
- API request validation and reponse.
## [#](#) Traits
### [#](#) [NmsQueryPaginationTrait](/docs/NmsQueryPaginationTrait)
- Paginate your data queries with complete information.

# [#](#)Overlords
- [Jon Rey Galera](@jonrey.galera)
- [Frederick Layus Jr.](@frederick.layusjr)

[Back to Top](#top)