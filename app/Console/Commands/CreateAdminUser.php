<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Member;
use Illuminate\Support\Facades\DB;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates an administrative user.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Admin name?');
        $gender = $this->ask('Gender? (M/F)');
        $phone = $this->ask('Phone number?');

        try {
            DB::transaction(function () use ($name, $gender, $phone) {
                // Create user with admin role
                $user = User::create([
                    'role' => 'admin',
                    'phone' => $phone,
                ]);

                // Create member profile linked to the user
                Member::create([
                    'user_id' => $user->id,
                    'name' => $name,
                    'gender' => $gender
                ]);
            });

            // Success message
            $this->info("Administrative account created successfully!");
        } catch (\Exception $e) {
            // Error message
            $this->error("Failed to create administrative account: " . $e->getMessage());
        }
    }
}
