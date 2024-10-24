<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'PJM']);
        Role::create(['name' => 'Auditee']);
        Role::create(['name' => 'Auditor']);
    }
}