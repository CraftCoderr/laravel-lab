<?php

namespace App\Console\Commands;

use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\Console\Command;

class AssignRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:assign {user} {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $user = User::firstWhere('name', $this->argument('user'));
        if ($user == null) {
            $this->error('User not found!');
            return 0;
        }
        $role = Role::findByName($this->argument('role'));
        if ($role == null) {
            $this->error('Role not found!');
            return 0;
        }
        $user->assignRole($role);
        $this->info("Role {$this->argument('role')} assign to {$this->argument('user')}!");
        return 0;
    }
}
