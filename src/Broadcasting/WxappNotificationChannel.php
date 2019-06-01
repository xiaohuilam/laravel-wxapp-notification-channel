<?php
namespace Xiaohuilam\Laravel\WxappNotificationChannel\Broadcasting;

use Illuminate\Notifications\Notification;
use Xiaohuilam\Laravel\WxappNotificationChannel\Interfaces\WechatNotificationable;
use Xiaohuilam\Laravel\WxappNotificationChannel\Interfaces\Formidable;

class WxappNotificationChannel
{
    /**
     * Send the given notification.
     *
     * @param  Formidable  $notifiable
     * @param  WechatNotificationable|\Illuminate\Notifications\Notification $notification
     * @return void
     */
    public function send(Formidable $notifiable, WechatNotificationable $notification)
    {
        $openid = $notifiable->openid;
        $credential = $notifiable->popCredentialOrFail();

        if (!$openid || !$credential) {
            return;
        }

        $message = [
            'touser' => $openid,
            'template_id' => $notification->getTemplateId(),
            'form_id' => $credential->formid,
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
        $wechat->template_message->send($message);

        $credential->delete();
    }
}
