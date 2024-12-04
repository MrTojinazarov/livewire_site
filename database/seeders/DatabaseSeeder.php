<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  
    public function run(): void
    {
        for($i = 1; $i <= 10; $i++){
            Student::create([
                'name' => 'Talaba ' . $i,
                'sort' => $i,
            ]);
        }
    }
}
