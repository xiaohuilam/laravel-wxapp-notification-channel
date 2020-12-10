<?php
namespace Xiaohuilam\Laravel\WxappNotificationChannel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Notifications\Dispatcher;
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
         * @link https://www.easywechat.com/docs/5.x/mini-program/subscribe_message
         * @link https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/subscribe-message/subscribeMessage.send.html
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
}
