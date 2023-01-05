# <span id="top">[NMS Laravel Utility](../)</span>

## NmsQueryPaginationTrait
- Paginate your queries with complete information. Add the
`Nms\LaravelUtility\Traits\NmsQueryPaginationTrait` trait to your `Models`. This trait will provide a few helper methods to your model which allow you to use the trait.
If your model is already using the same methods in the trait, please remove it to avoid any conflict:

### [#](#syntax) <span id="syntax">Usage</span>
#### [#](#controller) <span id="controller">Controller</span>
```php
use App\Models\UsersModel;
class UsersController extends Controller 
{
  public function getUsers(Request $request)
    {
        try {
            $search = $request->search ?? null;
            $order_by = $request->order_by ?? 'last_name';
            $sort_by = $request->sort_by ?? 'asc';
            $limit = $request->limit ?? 15;
            $page = $request->page ?? 0;

            $user_model = new UsersModel;
            $user_model->setDataSearch($search);
            $user_model->setDataOrderBy($order_by, $sort_by);
            $user_model->setDataLimitOffset($limit, $page);
            return $user_model->getUsers('active');
        } catch (\Throwable $throwable) {
            return \NmsApiHelper::responseError($throwable->getMessage());
        }
    }
}
```

#### [#](#models) <span id="model">Model</span>
```php
use Nms\LaravelUtility\Traits\NmsQueryPaginationTrait;

class UsersModel extends Models 
{
  use NmsQueryPaginationTrait;

  public function getUsers($status)
  {
    $query = self::select('*');
    if(!$this->data_search_empty) {
      $query->where(function($query) {
          $search = $this->data_search;
          $query->orWhere('users.email', 'LIKE', "%{$search}%");
      });
    }
    $this->addDataOption('status', $status);
    $query->orderBy('users.' . $this->data_order_by, $this->data_sort_by);
    return $this->toDataTable($query);
  }
}
```
#### [#](#response) <span id="response">Response</span>
```json
{
  "order_by" : "last_name",
  "sort_by" : "asc",
  "limit" : 2,
  "page" : 0,
  "total" : 3,
  "previous_page" : null,
  "next_page" : 2,
  "has_next_page" : true,
  "has_previous_page" : false,
  "status": "active", // this is optional
  "data": [
    { "last_name": "Jon", "first_name": "Rey" },
    { "last_name": "Rey", "first_name": "Jon" },
    { "last_name": "Fred", "first_name": "Derick" },
  ]
}
```

## [#](#overlords) <span id="overlords">Overlords</span>
- [Jon Rey Galera](@jonrey.galera)
- [Frederick Layus Jr.](@frederick.layusjr)

[Back to Top](#top)