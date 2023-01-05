<?php

namespace Nms\LaravelUtility\Drivers;

use Nms\LaravelUtility\Abstracts\DriverAbstract;
use Illuminate\Support\Facades\Log;
use Nms\LaravelUtility\Jobs\PublishLog;
use Nms\LaravelUtility\Facades\NmsLogHelper;
use Throwable;

class LogDriver extends DriverAbstract
{
  public function build()
  {
    if ($this->jobQueue) {
      $this->channelResponse = 'onQueued';
      PublishLog::dispatch($this)->delay($this->jobQueueDelay);
    } else {
      Log::channel($this->channel)->{$this->level}($this->level, $this->context);
    }
    return $this;
  }

  public function publish($channel = null, string $level = 'info', array $context = [], bool $logJobQueue = false)
  {
    $response = 'Done';
    try {
      Log::channel($channel)->{$level}($level, $context);
    } catch(Throwable $throwable) {
      $response = $throwable;
    }

    if ($logJobQueue) NmsLogHelper::channel()->info($channel, [ 'channelResponse' => $response]);
    
    return $this;
  }
}
