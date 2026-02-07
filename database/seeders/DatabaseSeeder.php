<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use App\Models\Lead;
use App\Models\Organization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Organizations
        $org1 = Organization::create(['name' => 'Acme Corp']);
        $org2 = Organization::create(['name' => 'Globex Ltd']);

        // Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'super@admin.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'org_id' => null
        ]);

        foreach ([$org1, $org2] as $org) {

            User::create([
                'name' => 'Org Admin',
                'email' => "admin{$org->id}@org.com",
                'password' => Hash::make('password'),
                'role' => 'org_admin',
                'org_id' => $org->id
            ]);

            User::create([
                'name' => 'HR',
                'email' => "hr{$org->id}@org.com",
                'password' => Hash::make('password'),
                'role' => 'org_hr',
                'org_id' => $org->id
            ]);

            User::create([
                'name' => 'Sales',
                'email' => "sales{$org->id}@org.com",
                'password' => Hash::make('password'),
                'role' => 'org_sales',
                'org_id' => $org->id
            ]);

            Employee::create([
                'org_id' => $org->id,
                'name' => 'John Doe',
                'designation' => 'Developer',
                'phone' => '9999999999'
            ]);

            Lead::create([
                'org_id' => $org->id,
                'lead_name' => 'Client A',
                'company' => 'ABC Pvt Ltd',
                'phone' => '8888888888',
                'status' => 'new'
            ]);
        }
    }
}
