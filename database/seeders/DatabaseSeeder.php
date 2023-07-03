<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\unitsTypeSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(unitsTypeSeeder::class);
        $this->call(UserSeeder::class);


    }
}
