<?php
namespace Xiaohuilam\Laravel\WxappNotificationChannel\Interfaces;

use Xiaohuilam\Laravel\WxappNotificationChannel\Types\MiniprogramType;

/**
 * 这是服务号通知类型使用的接口
 *
 * @method string getTemplateMessageUrl() 需要跳转到, 若不提供, 则表示此模板消息不可跳转
 * @method MiniprogramType miniprogram() 返回跳转到小程序，若不提供则表示与小程序无关
 */
interface WechatOfficialNotificationable
{
    /**
     * 模板消息id
     *
     * @return string
     */
    public function getTemplateId();

    /**
     * 获取模板消息keywords数据
     *
     * @return array ['keyword1' => '字段1', 'keyword2' => '字段2'...]
     */
    public function getTemplateMessageData();
}
