<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
   
    public function run(): void
    {

        DB::table('users')->delete();

        $users = [
        [
            'name'     => 'admin',
            'phone'    => '01095425447',
            'password' => bcrypt('123456') ,
            'role'     => "admin"
        ],
        [
            'name'     => 'ashrakt',
            'phone'    => '01095425446',
            'password' => bcrypt('123456') ,
            'role'     => "مسؤل مبيعات"
           ]
        ];

        foreach($users as $user){
            User::create([
                'name'     => $user['name'],
                'phone'    => $user['phone'],
                'password' => $user['password'],
                'role'     => $user['role'],

            ]);
        }

        // DB::table('users')->delete();
        // User::create([
        //     'name'     => 'admin',
        //     'phone'    => '01025248183',
        //     'password' => bcrypt('marwa123')
        // ]);

    }
    
}