<?php

namespace App\Jobs;

use App\Services\Samaya;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MessageMember implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;

    // Create a new job instance.
    public function __construct(String $message)
    {
        $this->message = $message;
    }

    // Execute the job.
    public function handle(): void
    {
        $sms = new Samaya;
        $members = new Member;

        // Fetch active members
        $members = $members->where('status', 1)->get();

        foreach($members as $member) {
            // Check if member has associated user with mobile number
            if($member->user && $member->user->mobile) {
                $message = sprintf(
                    "आदर्निय %s ज्यू, %s\n- %s", 
                    $member->name,
                    $this->message,
                    config('organization.name')
                );

                // Send the message
                $sms->send($member->user->mobile, $message);
            }
        }
    }
}
