<?php

namespace Nms\LaravelUtility\Abstracts;

use Nms\LaravelUtility\Contracts\LogContract;
use Nms\LaravelUtility\Contracts\DriverContract;
use Illuminate\Support\Facades\Log;
use Exception;

abstract class DriverAbstract implements LogContract,DriverContract
{
  protected $channelConfig = null;
  protected $jobQueue = false;
  protected $jobQueueDelay = 5;
  public $channelResponse = 'Done';
  public $logJobQueue = false;
  public $level = '';
  public $context = [];
  public $channel = null;

  public function channelConfig()
  {
    if(is_null($this->channelConfig)) return [];
    
    $channelConfig = config("logging.channels.{$this->channelConfig}", []);
    if(empty($channelConfig)) throw new Exception("logging.channels.{$this->channelConfig} is required.");

    return $channelConfig;
  }

  public function driver($channel = null)
  {
    $this->channel = $channel;
    return $this;
  }

  public function queue(int $jobQueueDelay = 5, bool $logJobQueue = false)
  {
    $this->logJobQueue = $logJobQueue;
    $this->jobQueueDelay = $jobQueueDelay;
    $this->jobQueue = true;
    return $this;
  }

  public function info($message, array $context = [])
  {
    $this->level = __FUNCTION__;
    $this->context = array_merge([
      'level' => $this->level, 
      'message' => $message
    ], $context);

    return $this->build();
  }

  public function emergency($message, array $context = [])
  {
    $this->level = __FUNCTION__;
    $this->context = array_merge([
      'level' => $this->level, 
      'message' => $message
    ], $context);

    return $this->build();
  }

  public function alert($message, array $context = [])
  {
    $this->level = __FUNCTION__;
    $this->context = array_merge([
      'level' => $this->level, 
      'message' => $message
    ], $context);

    return $this->build();
  }

  public function error($message, array $context = [])
  {
    $this->level = __FUNCTION__;
    $this->context = array_merge([
      'level' => $this->level, 
      'message' => $message
    ], $context);

    return $this->build();
  }

  public function warning($message, array $context = [])
  {
    $$this->level = __FUNCTION__;
    $this->context = array_merge([
      'level' => $this->level, 
      'message' => $message
    ], $context);

    return $this->build();
  }

  public function notice($message, array $context = [])
  {
    $this->level = __FUNCTION__;
    $this->context = array_merge([
      'level' => $this->level, 
      'message' => $message
    ], $context);

    return $this->build();
  }

  public function debug($message, array $context = [])
  {
    $this->level = __FUNCTION__;
    $this->context = array_merge([
      'level' => $this->level, 
      'message' => $message
    ], $context);

    return $this->build();
  }

  abstract public function build();
  abstract public function publish($channel = null, string $level = 'info', array $context = [], bool $logJobQueue = false);

}
