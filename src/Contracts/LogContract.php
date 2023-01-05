<?php

namespace Nms\LaravelUtility\Contracts;

interface LogContract
{
  public function info($message, array $context = []);
  public function emergency($message, array $context = []);
  public function alert($message, array $context = []);
  public function error($message, array $context = []);
  public function warning($message, array $context = []);
  public function notice($message, array $context = []);
  public function debug($message, array $context = []);

}
