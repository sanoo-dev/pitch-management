<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Lê Đức Hiển',
            'email' => '0750080160@sv.hcmunre.edu.vn',
            'birthday' => '1999-07-08',
            'phone' => '0388883533',
            'address' => 'HCM',
            'identity' => '123456789',
            'active' => '1',
            'password' => bcrypt('123123123')
        ]);

        $role = Role::create(['name' => 'Admin']);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
