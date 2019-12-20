# Laravel 微信小程序模板消息通知
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fxiaohuilam%2Flaravel-wxapp-notification-channel.svg?type=shield)](https://app.fossa.io/projects/git%2Bgithub.com%2Fxiaohuilam%2Flaravel-wxapp-notification-channel?ref=badge_shield)

---

## 安装
```bash
composer require xiaohuilam/laravel-wxapp-notification-channel -vvv
```

## 发布
执行以下命令创建 `formids` 数据表
```bash
php artisan migrate
```

## 模型改动

打开 `app\User.php` （如果你修改过模型位置，请以自己项目实际位置为准）
```php
namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Xiaohuilam\Laravel\WxappNotificationChannel\Traits\UserTrait;
use Xiaohuilam\Laravel\WxappNotificationChannel\Interfaces\Formidable;

class User extends Authenticatable implements Formidable // 实现 Formidable
{
    use UserTrait; // 使用 UserTrait
```

## 配置
```env
WECHAT_MINI_PROGRAM_APPID=#小程序的appid
WECHAT_MINI_PROGRAM_SECRET=#小程序的secret
```

## 使用

### 定义消息模板

新建 `app/Notifications/WechatTemplateTestNotification.php`

根据不通类型走不同 notification 类
>* **公众号模板通知**
>* **小程序模板通知**

**公众号模板通知**
```php
<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Xiaohuilam\Laravel\WxappNotificationChannel\Types\MiniprogramType;
use Xiaohuilam\Laravel\WxappNotificationChannel\Interfaces\WechatOfficialNotificationable;

class WechatTemplateTestNotification extends Notification implements WechatOfficialNotificationable
{
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['wechat-official'];
    }

    /**
     * 获取模板id
     *
     * @return string
     */
    public function getTemplateId()
    {
        return 'iL4c0FHJFIIUIDfNH-gMXgkGHRwlP-lvh1Emfl4d3pg';
    }

    /**
     * 获取模板消息跳转链接
     *
     * @return string
     */
    public function getTemplateMessageUrl()
    {
        return 'https://www.baidu.com/';
    }

    /**
     * 跳转到小程序， 与getTemplateMessageUrl二选一
     *
     * @return \Xiaohuilam\Laravel\WxappNotificationChannel\Types\MiniprogramType
     */
    public function miniprogram()
    {
        return new MiniprogramType('APPID...', 'PATH路径...');
    }

    /**
     * 获取模板消息数据
     *
     * @return array
     */
    public function getTemplateMessageData()
    {
        return [
            'keyword1' => '审核通过',
            'keyword2' => 'ORDER-9112212',
            'keyword3' => '点击查看订单详情',
        ];
    }
}
```

**小程序模板通知**
```php
<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Xiaohuilam\Laravel\WxappNotificationChannel\Interfaces\WechatAppNotificationable;

class WechatTemplateTestNotification extends Notification implements WechatAppNotificationable
{
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['wechat-app'];
    }

    /**
     * 获取模板id
     *
     * @return string
     */
    public function getTemplateId()
    {
        return 'iL4c0FHJFIIUIDfNH-gMXgkGHRwlP-lvh1Emfl4d3pg';
    }

    /**
     * 获取模板消息跳转链接
     *
     * @return string
     */
    public function getTemplateMessagePath()
    {
        return '/app/order/detail?id=11';
    }

    /**
     * 获取模板消息数据
     *
     * @return array
     */
    public function getTemplateMessageData()
    {
        return [
            'keyword1' => '审核通过',
            'keyword2' => 'ORDER-9112212',
            'keyword3' => '点击查看订单详情',
        ];
    }

    /**
     * 需要放大的词
     *
     * @return string
     */
    public function getTemplateMessageEmphasisKeyword()
    {
        return 'keyword1.DATA';
    }
}
```

### 如果是小程序，还需要开API来记录 FormId
```php
use Xiaohuilam\Laravel\WxappNotificationChannel\Models\Formid;

// ...
$formid = request()->input('formid'); // 小程序前端post 过来的 formid

$user = User::find(1);
$user->formids()->saveMany([new FormId(['formid' => $formid])]);
```

### 发送模板消息

```php
use App\Notifications\FriendshipRequestNotification;

$user = User::find(1);
$user->notify(new WechatTemplateTestNotification());
```

## 授权
MIT

## 鸣谢
- Overtrue's [laravel-easywechat](https://github.com/overtrue/laravel-wechat)

## License
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fxiaohuilam%2Flaravel-wxapp-notification-channel.svg?type=large)](https://app.fossa.io/projects/git%2Bgithub.com%2Fxiaohuilam%2Flaravel-wxapp-notification-channel?ref=badge_large)