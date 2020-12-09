<?php
namespace Xiaohuilam\Laravel\WxappNotificationChannel\Broadcasting;

use Illuminate\Notifications\Notifiable;
use Xiaohuilam\Laravel\WxappNotificationChannel\Interfaces\WechatNotificationable;

/**
 * 微信小程序模板消息通知通道
 */
class WechatAppNotificationChannel
{
    /**
     * Send the given notification.
     *
     * @param  Notifiable  $notifiable
     * @param  WechatNotificationable|\Illuminate\Notifications\Notification $notification
     * @return void
     */
    public function send($notifiable, $notification)
    {
        $openid = $notifiable->openid;

        if (!$openid) {
            return;
        }

        $message = [
            'touser' => $openid,
            'template_id' => $notification->getTemplateId(),
            'data' => $notification->getTemplateMessageData(),
        ];
        if (method_exists($notification, 'getTemplateMessagePath')) {
            $message['page'] = $notification->getTemplateMessagePath();
        }
        if (method_exists($notification, 'getTemplateMessageEmphasisKeyword')) {
            $message['emphasis_keyword'] = $notification->getTemplateMessageEmphasisKeyword();
        }

        /**
         * @var \EasyWeChat\MiniProgram\Application $wechat
         */
        $wechat = app('wechat.mini_program');
        $wechat->subscribe_message->send($message);
    }
}
