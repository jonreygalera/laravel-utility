<?php

namespace Nms\LaravelUtility\Facades;

use Illuminate\Support\Facades\Facade;

class NmsLogHelper extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'nms_log_helper';
    }
}
