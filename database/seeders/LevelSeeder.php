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
        // DB::table('levels')->delete();

        $levels = [
            // 'الدور الاول',
            // 'الدور الثانى',
            // 'الدور الثالث',
            // 'الدور الرابع',
            // 'الدور الخامس',
            // 'الدور السادس',
            // 'الدور السابع',
            // 'الدور الثامن',
            // 'الدور التاسع',
            'ارضى', 
            'اول علوى', 
            'تانى علوى',
            
        ];

        foreach($levels as $level){
            Level::create([
                'name' =>$level,
            ]);
        }
        

       
    }
}
