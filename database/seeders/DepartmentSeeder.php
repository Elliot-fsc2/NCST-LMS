<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create(['name' => 'Computer Studies', 'code' => 'CSD']);
        Department::create(['name' => 'Business Administration', 'code' => 'BAD']);
        Department::create(['name' => 'Education', 'code' => 'EDU']);
        Department::create(['name' => 'Engineering', 'code' => 'ENG']);
    }
}
