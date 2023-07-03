<?php

namespace Database\Seeders;

use App\Models\unitsType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class unitsTypeSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('units_types')->delete();

        $types = [
            [
                'name' => 'سكنى',
            ],
            [
                'name' => 'تجارى',
            ],
            [
                'name' => 'إدارى'
            ]
        ];

        foreach($types as $type){
            unitsType::create([
                'name' => $type['name'],
                ]); 
            }
    }
}
