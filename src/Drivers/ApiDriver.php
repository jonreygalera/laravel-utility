<?php

namespace Nms\LaravelUtility\Drivers;

use Nms\LaravelUtility\Abstracts\DriverAbstract;
use Nms\LaravelUtility\Helpers\NmsHttpHelper;
use Nms\LaravelUtility\Jobs\PublishLog;
use Nms\LaravelUtility\Facades\NmsLogHelper;
use Throwable;

class ApiDriver extends DriverAbstract
{
  protected $channelConfig = 'nmsapi';

  public function build()
  {
    if ($this->jobQueue) {
      $this->channelResponse = 'onQueued';
      PublishLog::dispatch($this)->delay($this->jobQueueDelay);
    } else {
      $channelConfig = $this->channelConfig();

      $url = $channelConfig['url'];
      $headers = $channelConfig['headers'] ?? [];
      $options = $channelConfig['options'] ?? [];
      $retryPolicy = filter_var($channelConfig['retry_policy'] ?? false, FILTER_VALIDATE_BOOLEAN);
      $verifySsl = filter_var($channelConfig['verify_ssl'] ?? false, FILTER_VALIDATE_BOOLEAN);
      $attempts = $channelConfig['attempts'] ?? 3;
      $attemptTime = $channelConfig['attempt_time'] ?? 100;
      $timeouts = $channelConfig['timeouts'] ?? 60;

      $nmsHttpHelper = new NmsHttpHelper;

      if($retryPolicy) $nmsHttpHelper->retryPolicy($attempts, $attemptTime, $timeouts);
      if($verifySsl) $nmsHttpHelper->verifySSL();

      $response = $nmsHttpHelper->post($url, $this->context, $headers, $options);
      $this->channelResponse = $response;
    }
    return $this;
  }

  public function publish($channel = null, string $level = 'info', array $context = [], bool $logJobQueue = false)
  {
    $channelConfig = $this->channelConfig();

    $url = $channelConfig['url'];
    $headers = $channelConfig['headers'] ?? [];
    $options = $channelConfig['options'] ?? [];
    $retryPolicy = filter_var($channelConfig['retry_policy'] ?? false, FILTER_VALIDATE_BOOLEAN);
    $verifySsl = filter_var($channelConfig['verify_ssl'] ?? false, FILTER_VALIDATE_BOOLEAN);
    $attempts = $channelConfig['attempts'] ?? 3;
    $attemptTime = $channelConfig['attempt_time'] ?? 100;
    $timeouts = $channelConfig['timeouts'] ?? 60;

    $nmsHttpHelper = new NmsHttpHelper;

    if($retryPolicy) $nmsHttpHelper->retryPolicy($attempts, $attemptTime, $timeouts);
    if($verifySsl) $nmsHttpHelper->verifySSL();

    $response = $nmsHttpHelper->post($url, $context, $headers, $options);
    
    if ($logJobQueue) NmsLogHelper::channel()->info($channel, [ 'channelResponse' => $response]);

    return $this;
  }

}
