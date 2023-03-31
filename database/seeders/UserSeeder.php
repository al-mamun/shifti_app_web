<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['name'=>'Admin', 'email'=>'admin@orponbd.com', 'role_id'=>1, 'password'=>Hash::make('12345678')],
            ['name'=>'Dev Innovative IT', 'email'=>'dev@iithost.com', 'role_id'=>1, 'password'=>Hash::make('12345678')],
            ['name'=>'Zakaria Ahmed Zahid', 'email'=>'zahidfact@gmail.com', 'role_id'=>1, 'password'=>Hash::make('12345678')],
            ['name'=>'Naimul Hasan', 'email'=>'naim.iithost@gmail.com', 'role_id'=>1, 'password'=>Hash::make('12345678')],
        ];


        foreach ($users as $user){
            User::create($user);
        }
    }
    .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused){
        20px
    }
}
