<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

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
        // register the ClassesSeeder class
        try {
            $this->call([
                UserTableSeeder::class,
                ClassesSeeder::class
            ]);
        } catch (\Throwable $th) {
            Log::error("failed to run seed with : " . $th->getMessage());
        }
    }
}
