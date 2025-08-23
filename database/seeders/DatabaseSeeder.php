<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // \App\Models\Dashboard\Student::factory(100000)->create();

        $this->call([
            RolesAndPermissionsSeeder::class,
            AdminSeeder::class,
            BannerSeeder::class,
            ContactInfoSeeder::class,
            CardSeeder::class,
            MainSystemSeeder::class,
            GallerySeeder::class,
            PackagesSeeder::class,
            PartnerSeeder::class,
            TestimonialsSeeder::class,
         ]);
    }
}
