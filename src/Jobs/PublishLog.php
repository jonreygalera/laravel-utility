<?php

namespace Nms\LaravelUtility\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Nms\LaravelUtility\Abstracts\DriverAbstract;

class PublishLog implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public $driverLog;
  public $channel;
  public $level;
  public $context;
  public $logJobQueue;

  public function __construct(DriverAbstract $driverLog)
  {
    $this->driverLog = $driverLog;
    $this->channel = $driverLog->channel;
    $this->level = $driverLog->level;
    $this->context = $driverLog->context;
    $this->logJobQueue = $driverLog->logJobQueue;
  }

  public function handle()
  {
    $this->driverLog->publish($this->channel, $this->level, $this->context, $this->logJobQueue);
  }
}