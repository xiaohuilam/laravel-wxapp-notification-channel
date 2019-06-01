<?php
namespace Xiaohuilam\Laravel\WxappNotificationChannel\Interfaces;

/**
 * 这是通知类型使用的接口
 *
 * @method string getTemplateMessagePath() 需要跳转到, 若不提供, 则表示此模板消息不可跳转
 * @method string getTemplateMessageEmphasisKeyword() 需要放大的词, 不提供则表示此消息不放大任何字段
 */
interface WechatNotificationable
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
