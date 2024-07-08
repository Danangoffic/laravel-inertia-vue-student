<?php

namespace Database\Seeders;

use App\Models\Classes;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
         // Create 10 Classes
         Classes::factory()->count(10)
         ->sequence(function ($sequence) {
             return ['name' => 'Class ' . ($sequence->index + 1)];
         })
         ->has(
             // For each Class, create 2 Sections
             Section::factory()->count(2)->has(
                 // For each Section, create 5 Students
                 Student::factory()->count(5)->state(
                     function (array $attributes, Section $section) {
                         return ['class_id' => $section->class_id];
                     }
                 )
             )
         )
         ->create();
    }
}
