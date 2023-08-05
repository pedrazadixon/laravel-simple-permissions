<?php

// namespace App\Console\Commands;
namespace Pedrazadixon\LaravelSimplePermissions\Console\Commands;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-simple-permissions:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finish install of Laravel Simple Permissions package.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!class_exists('App\Http\Controllers\Auth\AuthenticatedSessionController')) {
            return $this->error('Laravel\'s auth is not installed. pleace check https://laravel.com/docs/10.x/starter-kits#laravel-breeze');
        }

        Artisan::call('migrate');

        $this->line(Artisan::output());

        $this->line('Creating Super Admin role');

        if (DB::table('roles')->insertOrIgnore([
            'id' => 1,
            'name' => 'Super Admin',
            'description' => 'Has all permissions',
        ])) {
            $this->info('Install successful');
        } else {
            $this->warn('Already Installed or Install failed');
        }
    }
}
