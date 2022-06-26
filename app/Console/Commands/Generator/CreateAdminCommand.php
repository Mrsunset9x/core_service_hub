<?php

namespace App\Console\Commands\Generator;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = new User();
        $user->password = Hash::make('admin@123');
        $user->email = 'admin1@admin.com';
        $user->name = 'Admin';
        $user->api_token = hash('sha256', \Str::random(80));
        $user->save();
        return 0;
    }
}
