<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\UserEmailNotification;
use App\Notifications\AdminEmailNotification;
use App\Expected;
use App\Admin;
use Carbon\Carbon;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:mails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminder to users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $expected = Expected::where(function($query){
            $query->where("is_user_sent",0)->where("next_test_date","<=", Carbon::now()->addDays(7));
        })->get();
        if($expected){
            foreach($expected as $expect){
                $expect->user->notify((new UserEmailNotification($expect)));
                $expect->is_user_sent = 1;
                $expect->save();
            }
        }
    }
}
