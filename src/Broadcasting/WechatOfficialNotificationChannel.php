<?php
namespace Xiaohuilam\Laravel\WxappNotificationChannel\Broadcasting;

use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notification;
use Xiaohuilam\Laravel\WxappNotificationChannel\Interfaces\WechatOfficialNotificationable;

/**
 * 微信公众号模板消息通知通道
 */
class WechatOfficialNotificationChannel
{
    /**
     * Send the given notification.
     *
     * @param  Formidable  $notifiable
     * @param  WechatOfficialNotificationable|\Illuminate\Notifications\Notification $notification
     * @return void
     */
    public function send(User $notifiable, WechatOfficialNotificationable $notification)
    {
        $openid = $notifiable->openid;

        $message = [
            'touser' => $openid,
            'template_id' => $notification->getTemplateId(),
            'data' => $notification->getTemplateMessageData(),
        ];

        if (method_exists($notification, 'getTemplateMessageUrl')) {
            $message['url'] = $notification->getTemplateMessageUrl();
        }

        if (method_exists($notification, 'miniprogram')) {
            $message['miniprogram'] = $notification->miniprogram()->toArray();
        }

        if (app()->isAlias('wechat.official_account')) {
            /**
             * @var \EasyWeChat\OfficialAccount\Application $wechat
             */
            $wechat = app('wechat.official_account');
            $pusher = $wechat->template_message;
        } else {
            /**
             * @var \EasyWeChat\Foundation\Application $wechat
             */
            $wechat = app('wechat');
            $pusher = $wechat->notice;
        }

        $result = $pusher->send($message);
        if (data_get($result, 'errcode') != 0) {
            // log
            logger()->error('WECHAT_OFFICIAL_NOTIFICATION_ERROR', ['result' => $result, 'message' => $message]);
        }
        return $result;
    }
}
