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
        User::create([
            'name' => 'admin',
            'phone'=>'01025248183',
            'password' =>bcrypt('marwa123'),
        ]);
    }
}
