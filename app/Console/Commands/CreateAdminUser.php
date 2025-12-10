<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

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
        $phone = $this->ask('Phone number?');

        User::create([
            'name' => $name,
            'phone' => $phone,
        ]);

        $this->info("Admin created successfully.");
    }
}
