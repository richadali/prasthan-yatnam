<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create a test user
        User::create([
            'first_name' => 'Test',
            'middle_name' => '',
            'last_name' => 'User',
            'gender' => 'male',
            'age_group' => '32_to_45',
            'email' => 'test@example.com',
            'country_code' => '+1',
            'phone' => '5551234567',
            'organization' => 'Test Organization',
            'password' => Hash::make('Password123'),
            'role' => 'user',
        ]);

        // Seed admin user
        $this->call(AdminSeeder::class);

        // Seed testimonials
        $this->call(TestimonialSeeder::class);
    }
}
