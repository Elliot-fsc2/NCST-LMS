<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            // Computer Studies Department (ID: 1)
            ['name' => 'Bachelor of Science in Computer Science', 'code' => 'BSCS', 'department_id' => 1],
            ['name' => 'Bachelor of Science in Information Technology', 'code' => 'BSIT', 'department_id' => 1],

            // Business Administration Department (ID: 2)
            ['name' => 'Bachelor of Business Administration', 'code' => 'BBA', 'department_id' => 2],
            ['name' => 'Bachelor of Commerce', 'code' => 'BCOM', 'department_id' => 2],

            // Education Department (ID: 3)
            ['name' => 'Bachelor of Education', 'code' => 'BED', 'department_id' => 3],
            ['name' => 'Diploma in Primary Education', 'code' => 'DPE', 'department_id' => 3],
            ['name' => 'Diploma in Secondary Education', 'code' => 'DSE', 'department_id' => 3],

            // Engineering Department (ID: 4)
            ['name' => 'Bachelor of Engineering in Civil Engineering', 'code' => 'BECE', 'department_id' => 4],
            ['name' => 'Bachelor of Engineering in Electrical Engineering', 'code' => 'BEEE', 'department_id' => 4],
        ];

        foreach ($courses as $course) {
            \App\Models\Course::create($course);
        }
    }
}
