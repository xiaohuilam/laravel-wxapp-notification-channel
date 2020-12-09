<?php
namespace Xiaohuilam\Laravel\WxappNotificationChannel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Console\Application as Artisan;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Notifications\Dispatcher;
use Xiaohuilam\Laravel\WxappNotificationChannel\Console\Commands\DeleteExpiredFormid;
use Xiaohuilam\Laravel\WxappNotificationChannel\Broadcasting\WechatAppNotificationChannel;
use Xiaohuilam\Laravel\WxappNotificationChannel\Broadcasting\WechatOfficialNotificationChannel;

class WxappNotificationServiceProvider extends ServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $this->registerChannel();
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

        /**
         * @deprecated v0.12 不推荐使用，仅为兼容老版本
         */
        $dispatcher->extend('wechat', function (Application $app) {
            return $app->make(WechatAppNotificationChannel::class);
        });

        /**
         * 小程序
         * @link https://www.easywechat.com/docs/4.1/mini-program/template_message
         * @link https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/template-message/templateMessage.send.html
         */
        $dispatcher->extend('wechat-app', function (Application $app) {
            return $app->make(WechatAppNotificationChannel::class);
        });

        /**
         * 公众号
         * @link https://www.easywechat.com/docs/4.1/official-account/template_message
         * @link https://developers.weixin.qq.com/doc/offiaccount/Message_Management/Template_Message_Interface.html#5
         */
        $dispatcher->extend('wechat-offcial', function (Application $app) {
            return $app->make(WechatOfficialNotificationChannel::class);
        });
    }

    /**
     * 注册命令
     *
     * @return void
     */
    public function bootCommand()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->app->booted(function () {
            Artisan::starting(function (Artisan $artisan) {
                $artisan->resolve(DeleteExpiredFormid::class);
            });

            /**
             * @todo makes delete executing time to be configration
             * @var Schedule $schedule
             */
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('formid:clear')->dailyAt('01:00');
        });
    }
}
