<?php

namespace Nms\LaravelUtility\Facades;

use Illuminate\Support\Facades\Facade;

class NmsHttpHelper extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'nms_http_helper';
    }
}
