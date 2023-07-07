<?php

namespace App\Console\Commands;

use App\Mail\LinkVisitsReportMail;
use App\Models\Link;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendLinkVisits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-link-visits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        User::has('links')
            ->with('links')
            ->chunk(100, function($users) {
                foreach ($users as $user) {
                    Mail::to($user)->send(new LinkVisitsReportMail($user));
                }
            });
    }
}
