<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LevelSeeder extends Seeder
{
   
    public function run(): void
    {
        DB::table('levels')->delete();

        $levels = [
            'الدور الاول',
            'الدور الثانى',
            'الدور الثالث',
            'الدور الرابع',
            'الدور الخامس',
            'الدور السادس',
            'الدور السابع',
            'الدور الثامن',
            'الدور التاسع',
            'الدور العاشر',
            'الدور الحادى عشر',
            'الدور الثانى عشر',
            'الدور الثالث عشر',
            'الدور الرابع عشر',
            'الدور الخامس عشر',
            'الدور السابع عشر',
            'الدور الثامن عشر',
            'الدور التاسع عشر',
            'الدور العشرون',
        ];

        foreach($levels as $level){
            Level::create([
                'name' =>$level,
            ]);
        }
        

       
    }
}
