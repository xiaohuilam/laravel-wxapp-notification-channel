<?php
namespace Xiaohuilam\Laravel\WxappNotificationChannel\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Xiaohuilam\Laravel\WxappNotificationChannel\Models\Formid;

class DeleteExpiredFormid extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'formid:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean expired formid';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Formid::where('created_at', '<', Carbon::now()->copy()->subDays(7))->delete();
    }
}
