<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        DB::table("users")->insert([
            [
                'name'              => "Admin",
                'email'             => "admin@gmail.com",
                'role'              => User::ADMIN,
                'email_verified_at' => now(),
                'password'          => Hash::make("password"),
                'remember_token'    => Str::random(10),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'name'              => "Ridho",
                'email'             => "ridho@spk.com",
                'role'              => User::ASSESSOR,
                'email_verified_at' => now(),
                'password'          => Hash::make("password"),
                'remember_token'    => Str::random(10),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'name'              => "Vickry",
                'email'             => "vickry@spk.com",
                'role'              => User::ASSESSOR,
                'email_verified_at' => now(),
                'password'          => Hash::make("password"),
                'remember_token'    => Str::random(10),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'name'              => "Bagas",
                'email'             => "bagas@spk.com",
                'role'              => User::ASSESSOR,
                'email_verified_at' => now(),
                'password'          => Hash::make("password"),
                'remember_token'    => Str::random(10),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'name'              => "Gani",
                'email'             => "gani@spk.com",
                'role'              => User::ASSESSOR,
                'email_verified_at' => now(),
                'password'          => Hash::make("password"),
                'remember_token'    => Str::random(10),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'name'              => "Julkar",
                'email'             => "julkar@spk.com",
                'role'              => User::ASSESSOR,
                'email_verified_at' => now(),
                'password'          => Hash::make("password"),
                'remember_token'    => Str::random(10),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ]
        ]);
    }
}