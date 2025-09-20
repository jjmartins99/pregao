<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearPermissionsCommand extends Command
{
    protected $signature = 'clear:permissions';
    protected $description = 'Clear all permissions and roles safely';

    public function handle()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        DB::table('model_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->info('All permissions and roles cleared successfully!');
        return 0;
    }
}