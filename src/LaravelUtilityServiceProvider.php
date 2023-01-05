<?php

namespace Nms\LaravelUtility;

use Illuminate\Support\ServiceProvider;
use Nms\LaravelUtility\Helpers\NmsApiHelper;
use Nms\LaravelUtility\Helpers\NmsLogHelper;

class LaravelUtilityServiceProvider extends ServiceProvider
{
  public function register()
  {
    $this->registerFacade();
    $this->registerBindFacade();
  }

  public function boot()
  {

  }

  protected function registerFacade()
  {
    $facades = [
      'NmsApiHelper',
      'NmsLogHelper',
    ];
    $loader = \Illuminate\Foundation\AliasLoader::getInstance();
    
    foreach($facades as $facade) {
      $loader->alias($facade, "Nms\\LaravelUtility\\Facades\\{$facade}");
    }
  }

  protected function registerBindFacade()
  {
    
    $this->app->bind('nms_api_helper', function($app) {
      return new NmsApiHelper($app);
    });
    
    $this->app->bind('nms_log_helper', function($app) {
      return new NmsLogHelper($app);
    });
    
  }
}