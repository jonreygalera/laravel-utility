<?php

namespace Nms\LaravelUtility\Facades;

use Illuminate\Support\Facades\Facade;

class NmsApiHelper extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'nms_api_helper';
    }
}
