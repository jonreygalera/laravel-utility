<?php

namespace Nms\LaravelUtility\Drivers;

use Nms\LaravelUtility\Abstracts\DriverAbstract;
use Illuminate\Support\Facades\DB;
use Nms\LaravelUtility\Jobs\PublishLog;
use Nms\LaravelUtility\Facades\NmsLogHelper;
use Throwable;

class DatabaseDriver extends DriverAbstract
{
  protected $channelConfig = 'nmsdatabase';

  public function build()
  {
    if ($this->jobQueue) {
      $this->channelResponse = 'onQueued';
      PublishLog::dispatch($this)->delay($this->jobQueueDelay);
    } else {
      $channelConfig = $this->channelConfig();
      DB::table($channelConfig['table'])->insert($this->context);
    }
    return $this;
  }

  public function publish($channel = null, string $level = 'info', array $context = [], bool $logJobQueue = false)
  {
    $response = 'Done';
    
    try {
      $channelConfig = $this->channelConfig();
      DB::table($channelConfig['table'])->insert($this->context);
    } catch (Throwable $throwable) {
      $response = $throwable;
    }

    if ($logJobQueue) NmsLogHelper::channel()->info($channel, [ 'channelResponse' => $response]);
    
    return $this;
  }
}
