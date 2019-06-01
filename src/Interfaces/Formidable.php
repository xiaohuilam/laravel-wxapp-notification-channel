<?php
namespace Xiaohuilam\Laravel\WxappNotificationChannel\Interfaces;

/**
 * 这是给用户模型使用的接口
 *
 * @property string $name
 * @property string $openid
 */
interface Formidable
{
    /**
     * 获取发送模板消息的formid
     *
     * @return Xiaohuilam\Laravel\WxappNotificationChannel\Models\Formid|null
     */
    public function popCredentialOrFail();
}
