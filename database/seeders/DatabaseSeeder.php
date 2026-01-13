<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Submission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create the POSTGRADUATE MANAGER (Admin)
        // Login with this account to validate others
        User::create([
            'name' => 'Dr. Azlan (Manager)',
            'email' => 'manager@fk.ump.edu.my',
            'password' => Hash::make('password'), // password is 'password'
            'role' => 'manager',
            'status' => 'active',
            'phone' => '012-3456789'
        ]);

        // 2. Create SUPERVISORS & EXAMINERS

        // Supervisor 1 (The one supervising the student)
        $sup1 = User::create([
            'name' => 'Dr. Fauzi (Supervisor)',
            'email' => 'fauzi@fk.ump.edu.my',
            'password' => Hash::make('password'),
            'role' => 'supervisor',
            'status' => 'active',
            'phone' => '013-4445555'
        ]);

        // Supervisor 2 (Examiner 1)
        $sup2 = User::create([
            'name' => 'Dr. Hidayah (Examiner 1)',
            'email' => 'hidayah@fk.ump.edu.my',
            'password' => Hash::make('password'),
            'role' => 'supervisor',
            'status' => 'active',
            'phone' => '014-5556666'
        ]);

        // Supervisor 3 (Examiner 2) - ADDED THIS
        $sup3 = User::create([
            'name' => 'Dr. Kamal (Examiner 2)',
            'email' => 'kamal@fk.ump.edu.my',
            'password' => Hash::make('password'),
            'role' => 'supervisor',
            'status' => 'active',
            'phone' => '017-3334444'
        ]);

        // 3. Create STUDENTS

        // Student A: Active and ready to submit
        $studentA = User::create([
            'name' => 'Ahmad Albab',
            'email' => 'ahmad@student.ump.edu.my',
            'password' => Hash::make('password'),
            'role' => 'student',
            'status' => 'active',
            'phone' => '019-8889999'
        ]);

        // Student B: Pending (Use Manager account to approve him)
        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@student.ump.edu.my',
            'password' => Hash::make('password'),
            'role' => 'student',
            'status' => 'pending',
            'phone' => '019-7778888'
        ]);

        // 4. Create a SAMPLE SUBMISSION (For Module 2 & 3 Testing)
        // This submission is already approved by Supervisor, ready for Manager to Finalize/Schedule
        Submission::create([
            'student_id' => $studentA->id,
            'title' => 'AI-Based Traffic Light System for Kuantan',
            'document_path' => 'dummy.pdf', // Ensure you don't actually click download unless file exists
            'presentation_type' => 'proposal',

            // Supervisor Approval Details
            'supervisor_id' => $sup1->id,
            'supervisor_status' => 'approved',

            // Assigning the two different examiners created above
            'examiner_1_id' => $sup2->id,
            'examiner_2_id' => $sup3->id,

            // Manager Status (Pending means it appears in Manager's dashboard)
            'manager_status' => 'pending'
        ]);
    }
}
