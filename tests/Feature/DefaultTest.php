<?php

namespace Nms\LaravelUtility\Tests\Feature;

use Nms\LaravelUtility\Tests\Unit\TestCase;
use Nms\LaravelUtility\Facades\HttpHelper;

class DefaultTest extends TestCase
{

  function test_process()
  {
    HttpHelper::setUrl("http://www.google.com");
    $this->assertTrue(true);
  }
}