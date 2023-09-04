<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id'                => 1,
            'name'              => 'Guangxi Jin',
            'email'             => 'guangxijin0518@gmail.com',
            'email_verified_at' => Carbon::now()->sub('hour', 6),
            'password'          => \Hash::make('Calorie!'),
            'remember_token'    => Str::random(10),
            'role'              => 'admin',
            'timezone'          => 'Asia/Shanghai',
            'created_at'        => Carbon::now()->sub('hour', 6),
            'updated_at'        => Carbon::now()->sub('hour', 6),
        ]);

        DB::table('users')->insert([
            'id'                => 2,
            'name'              => 'George Smith',
            'email'             => 'georgesmith@outlook.com',
            'email_verified_at' => Carbon::now()->sub('hour', 6),
            'password'          => \Hash::make('Calorie!'),
            'remember_token'    => Str::random(10),
            'timezone'          => 'Asia/Chicago',
            'created_at'        => Carbon::now()->sub('hour', 6),
            'updated_at'        => Carbon::now()->sub('hour', 6),
        ]);

        DB::table('users')->insert([
            'id'                => 3,
            'name'              => 'John Gates',
            'email'             => 'johngates@outlook.com',
            'email_verified_at' => Carbon::now()->sub('hour', 6),
            'password'          => \Hash::make('Calorie!'),
            'remember_token'    => Str::random(10),
            'timezone'          => 'Asia/Chicago',
            'created_at'        => Carbon::now()->sub('hour', 6),
            'updated_at'        => Carbon::now()->sub('hour', 6),
        ]);
    }
}
