<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            [
                'name'   => 'Juan Dela Cruz',
                'email'  => 'juan.delacruz@psu.edu.ph',
                'age'    => 21,
                'phone'  => '09123456789',
                'status' => 'active',
            ],
            [
                'name'   => 'Maria Santos',
                'email'  => 'maria.santos@psu.edu.ph',
                'age'    => 20,
                'phone'  => '09234567890',
                'status' => 'pending',
            ],
            [
                'name'   => 'Carlos Reyes',
                'email'  => 'carlos.reyes@psu.edu.ph',
                'age'    => 22,
                'phone'  => '09345678901',
                'status' => 'completed',
            ],
            [
                'name'   => 'Ana Garcia',
                'email'  => 'ana.garcia@psu.edu.ph',
                'age'    => 19,
                'phone'  => '09456789012',
                'status' => 'active',
            ],
            [
                'name'   => 'Pedro Mendoza',
                'email'  => 'pedro.mendoza@psu.edu.ph',
                'age'    => 23,
                'phone'  => '09567890123',
                'status' => 'inactive',
            ],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
