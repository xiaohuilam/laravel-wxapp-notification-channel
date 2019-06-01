<?php
namespace Xiaohuilam\Laravel\WxappNotificationChannel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Console\Application as Artisan;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Notifications\Dispatcher;
use Xiaohuilam\Laravel\WxappNotificationChannel\Console\Commands\DeleteExpiredFormid;
use Xiaohuilam\Laravel\WxappNotificationChannel\Broadcasting\WxappNotificationChannel;

class WxappNotificationServiceProvider extends ServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $this->registerChannel();
        $this->registerMigration();
    }

    /**
     * {@inheritDoc}
     */
    public function boot()
    {
        $this->bootCommand();
    }

    /**
     * 注册模板消息通道
     *
     * @return void
     */
    public function registerChannel()
    {
        /**
         * @var \Illuminate\Notifications\ChannelManager $dispatcher
         */
        $dispatcher = app(Dispatcher::class);
        $dispatcher->extend('wechat', function (Application $app) {
            return $app->make(WxappNotificationChannel::class);
        });
    }

    /**
     * 加载数据库迁移文件
     *
     * @return void
     */
    public function registerMigration()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations/');
    }

    /**
     * 注册命令
     *
     * @return void
     */
    public function bootCommand()
    {
        $this->app->booted(function () {
            Artisan::starting(function (Artisan $artisan) {
                $artisan->resolve(DeleteExpiredFormid::class);
            });

            /**
             * @var Schedule $schedule
             */
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('formid:clear')->dailyAt('01:00');
        });
    }
}
