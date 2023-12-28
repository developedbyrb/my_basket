<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionsCount = Permission::count();
        RolePermission::where('role_id', 1)->delete();
        for ($i = 1; $i <= $permissionsCount; $i++) {
            RolePermission::create([
                'role_id' => 1,
                'permission_id' => $i
            ]);
        }
    }
}
