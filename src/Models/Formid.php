<?php
namespace Xiaohuilam\Laravel\WxappNotificationChannel\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * \Xiaohuilam\Laravel\WxappNotificationChannel\Models\Formid
 *
 * @property int $id
 * @property int $user_id 用户id
 * @property string $formid formid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Foundation\Auth\User|\Xiaohuilam\Laravel\WxappNotificationChannel\Interfaces\Formidable $user
 * @method static \Illuminate\Database\Eloquent\Builder|\Xiaohuilam\Laravel\WxappNotificationChannel\Models\Formid newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xiaohuilam\Laravel\WxappNotificationChannel\Models\Formid newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xiaohuilam\Laravel\WxappNotificationChannel\Models\Formid query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xiaohuilam\Laravel\WxappNotificationChannel\Models\Formid whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xiaohuilam\Laravel\WxappNotificationChannel\Models\Formid whereFormid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xiaohuilam\Laravel\WxappNotificationChannel\Models\Formid whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xiaohuilam\Laravel\WxappNotificationChannel\Models\Formid whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xiaohuilam\Laravel\WxappNotificationChannel\Models\Formid whereUserId($value)
 * @mixin \Eloquent
 */
class Formid extends Model
{
    protected $fillable = ['formid',];

    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }
}
