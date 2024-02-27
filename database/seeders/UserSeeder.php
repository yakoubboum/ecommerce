<?php

namespace Database\Seeders;



use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        for ($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                'name' => Str::random(10),
                'email' => Str::random(10) . '@example.com',
                'password' => Hash::make('password'),
            ]);

            DB::table('admins')->insert([
                'name' => Str::random(10),
                'email' => Str::random(10) . '@example.com',
                'password' => Hash::make('password'),
            ]);
        }

        DB::table('users')->insert([
            'name' => 'ahmed',
            'email' =>  'user@email.com',
            'password' => Hash::make('123456789'),
        ]);

        DB::table('admins')->insert([
            'name' => 'mohamed',
            'email' => 'admin@email.com',
            'password' => Hash::make('123456789'),
        ]);
    }
}
