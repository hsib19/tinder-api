<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Models\AdminNotification;

class NotifyPopularUsers extends Command
{
    protected $signature = 'notify:popular-users';
    protected $description = 'Send email to admin if any user is liked by more than 50 people';

    public function handle()
    {
        $popularUsers = User::whereHas('likesReceived', function ($query) {
            $query->where('is_liked', true);
        }, '>', 50)->get();

        if ($popularUsers->isEmpty()) {
            $this->info('No popular users found.');
            return;
        }

        foreach ($popularUsers as $user) {
            $alreadyNotified = AdminNotification::where('user_id', $user->id)->exists();

            if (!$alreadyNotified) {
                AdminNotification::create([
                    'user_id'       => $user->id,
                    'email_sent_to' => 'admin@example.com',
                    'status'        => 'pending',
                    'created_at'    => now(),
                ]);
            }
        }

        $userList = $popularUsers->map(function ($user) {
            return "{$user->name} (ID: {$user->id})";
        })->implode(", ");

        Mail::raw("Popular users liked by >50 people: {$userList}", function ($message) {
            $message->to('admin@example.com')
                    ->subject('Popular Users Notification');
        });        

        $this->info('Notification sent to admin.');
    }
}
