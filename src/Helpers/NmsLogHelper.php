<?php

namespace Nms\LaravelUtility\Helpers;

use Illuminate\Support\Facades\Log;
use Nms\LaravelUtility\Drivers\LogDriver;
use Nms\LaravelUtility\Drivers\DatabaseDriver;
use Nms\LaravelUtility\Drivers\ApiDriver;
use Exception;
use Throwable;

class NmsLogHelper
{
  protected $logData = [];
  protected $channel = null;

  const API = 'api';
  const DATABASE = 'database';

  public function __construct($app) 
  {

  }

  public function channel($channel = null)
  {
    $this->channel = $channel;
    switch ($this->channel) {
      case self::API: return $this->apiDriver();
      case self::DATABASE: return $this->databaseDriver();
      default: return $this->logDriver();
    }
  }

  public function apiDriver()
  {
    return (new ApiDriver)->driver($this->channel);
  }

  public function databaseDriver()
  {
    return (new DatabaseDriver)->driver($this->channel);
  }

  public function logDriver()
  {
    return (new LogDriver)->driver($this->channel);
  }
}