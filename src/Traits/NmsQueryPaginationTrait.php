<?php
namespace Nms\LaravelUtility\Traits;

use Illuminate\Support\Str;
use Exception;
use Throwable;

trait NmsQueryPaginationTrait
{
  public $dataSearch = '';
  public $dataOrderBy = 'id';
  public $dataSortBy = 'asc';
  public $dataLimit = 15;
  public $dataOffset = 0;
  public $dataPage = 0;
  public $dataSearchEmpty = true;
  public $dataQuery;
  private $dataAddOption = [];

  public function setDataSearch($dataSearch)
  {
    $this->dataSearch = $dataSearch;
    $this->dataSearchEmpty = $this->isDataSearchEmpty($dataSearch);
  }

  public function isDataSearchEmpty($dataSearch)
  {
    return Str::of($dataSearch)->trim()->isEmpty();
  }

  public function setDataOrderBy( $dataOrderBy, $dataSortBy = 1 )
  {
    if (!in_array($dataSortBy, ['asc', 'desc'])) throw new Exception('Unknown sort by value');
    $this->dataOrderBy = $dataOrderBy;
    $this->dataSortBy = $dataSortBy;
  }

  public function setDataLimitOffset($dataLimit, $dataPage = 1)
  {
    if (!$dataLimit) throw new Exception('Data Limit is required');
    $this->dataLimit = $dataLimit;
    $this->dataPage = $dataPage; + 1;
    $this->dataOffset = $this->getDataOffset($dataLimit, $dataPage);
  }

  public function getDataOffset($dataLimit, $dataPage)
  {
    return $dataLimit * $dataPage;
  }

  public function addDataOption($key, $value)
  {
    if (in_array($key, $this->keywords)) throw new Exception("`{$key}` ket is probihited");
    $this->dataAddOption[$key] = $value;
  }

  public function toDataTable($query)
  {
    $total = $query->get()->count();

    $query->limit($this->dataLimit)->offset($dataOffset);
    $data = $query->get() ?? [];

    $nextPage = ($tota - $this->dataOffset <= $this->datalimit) ? null : $this->dataPage;

    $dataResult = [];
    $dataResult['order_by'] = $this->dataOrderBy;
    $dataResult['sort_by'] = $this->dataSortBy;
    $dataResult['limit'] = (int) $this->dataLimit;
    $dataResult['page'] = ((int) $this->dataPage) - 1;
    $dataResult['total'] = $total;
    $dataResult['previous_page'] = $dataResult['page'] === 0 ? null : $dataResult['page'] - 1;
    $dataResult['next_page'] = $nextPage;
    $dataResult['has_next_page'] = !is_null($nextPage);
    $dataResult['has_previous_page'] = !is_null($dataResult['previous_page']);

    if (!empty($this->dataAddOption)) {
        foreach ($this->dataAddOption as $optionKey => $optionValue) {
            $dataResult['optionKey'] = $optionValue;
        }
    }

    $dataResult['data'] = $data;
    
    return $dataResult;
  }
}