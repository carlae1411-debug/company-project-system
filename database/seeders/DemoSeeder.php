<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | DEMO USERS
        |--------------------------------------------------------------------------
        */

        User::firstOrCreate(
            [
                'email' => 'demo.admin@company.local',
            ],
            [
                'name' => 'Demo Administrator',
                'role' => 'administrator',
                'password' => Hash::make('DemoAdmin123!'),
            ]
        );

        User::firstOrCreate(
            [
                'email' => 'demo.manager@company.local',
            ],
            [
                'name' => 'Demo Manager',
                'role' => 'manager',
                'password' => Hash::make('DemoManager123!'),
            ]
        );

        User::firstOrCreate(
            [
                'email' => 'demo.staff@company.local',
            ],
            [
                'name' => 'Demo Staff',
                'role' => 'staff',
                'password' => Hash::make('DemoStaff123!'),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | DEMO PROJECTS
        |--------------------------------------------------------------------------
        */

        Project::firstOrCreate(
            [
                'project_code' => 'DEMO-001',
            ],
            [
                'name' => 'Office Renovation',
                'client' => 'ABC Corporation',
                'description' => 'Sample office renovation project for demonstration.',
                'status' => 'pending',
                'start_date' => '2026-09-01',
                'end_date' => '2026-12-15',
            ]
        );

        Project::firstOrCreate(
            [
                'project_code' => 'DEMO-002',
            ],
            [
                'name' => 'Residential Building',
                'client' => 'XYZ Properties',
                'description' => 'Sample residential building project for demonstration.',
                'status' => 'ongoing',
                'start_date' => '2026-07-15',
                'end_date' => '2027-02-28',
            ]
        );

        Project::firstOrCreate(
            [
                'project_code' => 'DEMO-003',
            ],
            [
                'name' => 'Warehouse Project',
                'client' => 'Global Logistics',
                'description' => 'Sample warehouse construction project for demonstration.',
                'status' => 'completed',
                'start_date' => '2026-01-10',
                'end_date' => '2026-08-30',
            ]
        );
    }
}