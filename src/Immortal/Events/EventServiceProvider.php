<?php
/**
 * 事件服务提供者
 */
namespace Immortal\Events;

use Immortal\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * 注册服务
     * @return void
     */
    public function register()
    {
        $this->app->singleton('events', function ($app) {
            return (new Dispatcher($app))->setQueueResolver(function () use ($app) {
                return $app->make('Immortal\Contracts\Queue\Factory');
            });
        });
    }
}
