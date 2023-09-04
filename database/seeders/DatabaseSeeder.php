<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->insert([
            'id'                      => 2,
            'user_id'                 => null,
            'name'                    => 'Laravel Password Grant Client',
            'secret'                  => 'Ehib1hpUrrhYbyVmxIfs3mV1Y6Ey66NQLFDR5rJr',
            'provider'                => 'users',
            'redirect'                => env('APP_URL', 'http://localhost'),
            'personal_access_client'  => 0,
            'password_client'         => 1,
            'revoked'                 => 0,
            'created_at'              => Carbon::now()->sub('hour', 6),
            'updated_at'              => Carbon::now()->sub('hour', 6)
        ]);

        $this->call([
            UserSeeder::class,
            FoodEntrySeeder::class,
        ]);
    }
}
