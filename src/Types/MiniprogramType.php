<?php
namespace Xiaohuilam\Laravel\WxappNotificationChannel\Types;

use Illuminate\Contracts\Support\Arrayable;

class MiniprogramType implements Arrayable
{
    protected $appid = null;
    protected $pagepath = null;

    /**
     * __construct
     *
     * @param string|null $appid
     * @param string|null $pagepath
     */
    public function __construct($appid = null, $pagepath = null)
    {
        $this->appid = $appid;
        $this->pagepath = $pagepath;
    }

    public function toArray()
    {
        return [
            'appid' => $this->appid,
            'pagepath' => $this->pagepath,
        ];
    }
}
