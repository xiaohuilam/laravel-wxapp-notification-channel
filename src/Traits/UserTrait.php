<?php
namespace Xiaohuilam\Laravel\WxappNotificationChannel\Traits;

use Xiaohuilam\Laravel\WxappNotificationChannel\Models\Formid;

/**
 * 用户模型 trait
 *
 * @property-read Formid[]|\Illuminate\Database\Eloquent\Collection $formids 微信小程序的formid
 */
trait UserTrait
{
    abstract public function getAuthIdentifierName();

    /**
     * 微信小程序的formid
     *
     * @return Formid|\Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function formids()
    {
        return $this->hasMany(Formid::class);
    }

    /**
     * 获取有效的formid
     *
     * @return Formid|null
     */
    public function popCredentialOrFail()
    {
        return $this->formids->first();
    }
}
