<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name'=> 'Admin','status'=>1,'order_by'=>1,'updated_by'=>1],
            ['name'=> 'Moderator','status'=>1,'order_by'=>2,'updated_by'=>2],
            ['name'=> 'Editor','status'=>1,'order_by'=>3,'updated_by'=>3],

        ];

        Role::truncate();
        foreach($roles as $role){
            Role::create($role);
        }
    }
}
