<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Document;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            
            DepartmentSeeder::class,
            UnitSeeder::class,
            StageSeeder::class,
            StatusSeeder::class,
        ]);
    }
}
