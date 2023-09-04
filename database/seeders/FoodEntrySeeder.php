<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FoodEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('food_entries')->insert([
            'id'                => 1,
            'name'              => 'Sandwitch',
            'calorie'           => 500,
            'price'             => 2,
            'taken_at'          => Carbon::now()->sub('hour', 6)->timestamp,
            'taken_by'          => 1,
            'created_at'        => Carbon::now()->sub('hour', 6),
            'updated_at'        => Carbon::now()->sub('hour', 6),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 2,
            'name'              => 'Salad',
            'calorie'           => 400,
            'price'             => 1.5,
            'taken_at'          => Carbon::now()->sub('hour', 6)->timestamp,
            'taken_by'          => 1,
            'created_at'        => Carbon::now()->sub('hour', 6),
            'updated_at'        => Carbon::now()->sub('hour', 6),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 3,
            'name'              => 'Milk',
            'calorie'           => 500,
            'price'             => 0.5,
            'taken_at'          => Carbon::now()->sub('hour', 6)->timestamp,
            'taken_by'          => 1,
            'created_at'        => Carbon::now()->sub('hour', 6),
            'updated_at'        => Carbon::now()->sub('hour', 6),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 4,
            'name'              => 'Hotdog',
            'calorie'           => 400,
            'price'             => 2,
            'taken_at'          => Carbon::now()->sub('hour', 12)->timestamp,
            'taken_by'          => 1,
            'created_at'        => Carbon::now()->sub('hour', 12),
            'updated_at'        => Carbon::now()->sub('hour', 12),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 5,
            'name'              => 'Ham',
            'calorie'           => 500,
            'price'             => 1.5,
            'taken_at'          => Carbon::now()->sub('day', 2)->timestamp,
            'taken_by'          => 1,
            'created_at'        => Carbon::now()->sub('day', 2),
            'updated_at'        => Carbon::now()->sub('day', 2),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 6,
            'name'              => 'Milk',
            'calorie'           => 400,
            'price'             => 0.5,
            'taken_at'          => Carbon::now()->sub('hour', 26)->timestamp,
            'taken_by'          => 1,
            'created_at'        => Carbon::now()->sub('hour', 26),
            'updated_at'        => Carbon::now()->sub('hour', 26),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 7,
            'name'              => 'Sandwitch',
            'calorie'           => 700,
            'price'             => 2,
            'taken_at'          => Carbon::now()->sub('day', 1)->timestamp,
            'taken_by'          => 1,
            'created_at'        => Carbon::now()->sub('day', 1),
            'updated_at'        => Carbon::now()->sub('day', 1),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 8,
            'name'              => 'Salad',
            'calorie'           => 400,
            'price'             => 1.5,
            'taken_at'          => Carbon::now()->sub('day', 1)->timestamp,
            'taken_by'          => 1,
            'created_at'        => Carbon::now()->sub('day', 1),
            'updated_at'        => Carbon::now()->sub('day', 1),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 9,
            'name'              => 'Milk',
            'calorie'           => 500,
            'price'             => 0.5,
            'taken_at'          => Carbon::now()->sub('day', 1)->timestamp,
            'taken_by'          => 1,
            'created_at'        => Carbon::now()->sub('day', 1),
            'updated_at'        => Carbon::now()->sub('day', 1),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 10,
            'name'              => 'Hotdog',
            'calorie'           => 400,
            'price'             => 2,
            'taken_at'          => Carbon::now()->sub('day', 2)->timestamp,
            'taken_by'          => 1,
            'created_at'        => Carbon::now()->sub('day', 2),
            'updated_at'        => Carbon::now()->sub('day', 2),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 11,
            'name'              => 'Ham',
            'calorie'           => 1000,
            'price'             => 1.5,
            'taken_at'          => Carbon::now()->sub('day', 2)->timestamp,
            'taken_by'          => 1,
            'created_at'        => Carbon::now()->sub('day', 2),
            'updated_at'        => Carbon::now()->sub('day', 2),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 12,
            'name'              => 'Milk',
            'calorie'           => 500,
            'price'             => 0.5,
            'taken_at'          => Carbon::now()->sub('day', 2)->timestamp,
            'taken_by'          => 1,
            'created_at'        => Carbon::now()->sub('day', 2),
            'updated_at'        => Carbon::now()->sub('day', 2),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 13,
            'name'              => 'Sandwitch',
            'calorie'           => 700,
            'price'             => 2,
            'taken_at'          => Carbon::now()->sub('day', 8)->timestamp,
            'taken_by'          => 1,
            'created_at'        => Carbon::now()->sub('day', 8),
            'updated_at'        => Carbon::now()->sub('day', 8),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 14,
            'name'              => 'Salad',
            'calorie'           => 700,
            'price'             => 1.5,
            'taken_at'          => Carbon::now()->sub('day', 8)->timestamp,
            'taken_by'          => 1,
            'created_at'        => Carbon::now()->sub('day', 8),
            'updated_at'        => Carbon::now()->sub('day', 8),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 15,
            'name'              => 'Milk',
            'calorie'           => 500,
            'price'             => 0.5,
            'taken_at'          => Carbon::now()->sub('day', 8)->timestamp,
            'taken_by'          => 1,
            'created_at'        => Carbon::now()->sub('day', 8),
            'updated_at'        => Carbon::now()->sub('day', 8),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 16,
            'name'              => 'Hotdog',
            'calorie'           => 400,
            'price'             => 2,
            'taken_at'          => Carbon::now()->sub('day', 9)->timestamp,
            'taken_by'          => 1,
            'created_at'        => Carbon::now()->sub('day', 9),
            'updated_at'        => Carbon::now()->sub('day', 9),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 17,
            'name'              => 'Ham',
            'calorie'           => 1500,
            'price'             => 1.5,
            'taken_at'          => Carbon::now()->sub('day', 9)->timestamp,
            'taken_by'          => 1,
            'created_at'        => Carbon::now()->sub('day', 9),
            'updated_at'        => Carbon::now()->sub('day', 9),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 18,
            'name'              => 'Milk',
            'calorie'           => 500,
            'price'             => 0.5,
            'taken_at'          => Carbon::now()->sub('day', 9)->timestamp,
            'taken_by'          => 1,
            'created_at'        => Carbon::now()->sub('day', 9),
            'updated_at'        => Carbon::now()->sub('day', 9),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 19,
            'name'              => 'Sandwitch',
            'calorie'           => 1000,
            'price'             => 2,
            'taken_at'          => Carbon::now()->sub('day', 10)->timestamp,
            'taken_by'          => 1,
            'created_at'        => Carbon::now()->sub('day', 10),
            'updated_at'        => Carbon::now()->sub('day', 10),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 20,
            'name'              => 'Salad',
            'calorie'           => 700,
            'price'             => 1.5,
            'taken_at'          => Carbon::now()->sub('day', 10)->timestamp,
            'taken_by'          => 1,
            'created_at'        => Carbon::now()->sub('day', 10),
            'updated_at'        => Carbon::now()->sub('day', 10),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 21,
            'name'              => 'Milk',
            'calorie'           => 500,
            'price'             => 0.5,
            'taken_at'          => Carbon::now()->sub('day', 10)->timestamp,
            'taken_by'          => 1,
            'created_at'        => Carbon::now()->sub('day', 10),
            'updated_at'        => Carbon::now()->sub('day', 10),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 22,
            'name'              => 'Hotdog',
            'calorie'           => 400,
            'price'             => 2,
            'taken_at'          => Carbon::now()->sub('day', 10)->timestamp,
            'taken_by'          => 1,
            'created_at'        => Carbon::now()->sub('day', 10),
            'updated_at'        => Carbon::now()->sub('day', 10),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 23,
            'name'              => 'Ham',
            'calorie'           => 1500,
            'price'             => 1.5,
            'taken_at'          => Carbon::now()->sub('day', 11)->timestamp,
            'taken_by'          => 1,
            'created_at'        => Carbon::now()->sub('day', 11),
            'updated_at'        => Carbon::now()->sub('day', 11),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 24,
            'name'              => 'Milk',
            'calorie'           => 500,
            'price'             => 0.5,
            'taken_at'          => Carbon::now()->sub('day', 11)->timestamp,
            'taken_by'          => 1,
            'created_at'        => Carbon::now()->sub('day', 11),
            'updated_at'        => Carbon::now()->sub('day', 11),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 25,
            'name'              => 'Sandwitch #2',
            'calorie'           => 1000,
            'price'             => 2,
            'taken_at'          => Carbon::now()->sub('hour', 7)->timestamp,
            'taken_by'          => 2,
            'created_at'        => Carbon::now()->sub('hour', 7),
            'updated_at'        => Carbon::now()->sub('hour', 7),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 26,
            'name'              => 'Salad #2',
            'calorie'           => 700,
            'price'             => 1.5,
            'taken_at'          => Carbon::now()->sub('hour', 7)->timestamp,
            'taken_by'          => 2,
            'created_at'        => Carbon::now()->sub('hour', 7),
            'updated_at'        => Carbon::now()->sub('hour', 7),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 27,
            'name'              => 'Milk #2',
            'calorie'           => 500,
            'price'             => 0.5,
            'taken_at'          => Carbon::now()->sub('hour', 7)->timestamp,
            'taken_by'          => 2,
            'created_at'        => Carbon::now()->sub('hour', 7),
            'updated_at'        => Carbon::now()->sub('hour', 7),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 28,
            'name'              => 'Hotdog #2',
            'calorie'           => 400,
            'price'             => 2,
            'taken_at'          => Carbon::now()->sub('hour', 14)->timestamp,
            'taken_by'          => 2,
            'created_at'        => Carbon::now()->sub('hour', 14),
            'updated_at'        => Carbon::now()->sub('hour', 14),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 29,
            'name'              => 'Ham #2',
            'calorie'           => 1500,
            'price'             => 1.5,
            'taken_at'          => Carbon::now()->sub('day', 1)->timestamp,
            'taken_by'          => 2,
            'created_at'        => Carbon::now()->sub('day', 1),
            'updated_at'        => Carbon::now()->sub('day', 1),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 30,
            'name'              => 'Milk #2',
            'calorie'           => 500,
            'price'             => 0.5,
            'taken_at'          => Carbon::now()->sub('day', 2)->timestamp,
            'taken_by'          => 2,
            'created_at'        => Carbon::now()->sub('day', 2),
            'updated_at'        => Carbon::now()->sub('day', 2),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 31,
            'name'              => 'Sandwitch #3',
            'calorie'           => 1000,
            'price'             => 2,
            'taken_at'          => Carbon::now()->sub('hour', 10)->timestamp,
            'taken_by'          => 3,
            'created_at'        => Carbon::now()->sub('hour', 10),
            'updated_at'        => Carbon::now()->sub('hour', 10),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 32,
            'name'              => 'Salad #3',
            'calorie'           => 700,
            'price'             => 1.5,
            'taken_at'          => Carbon::now()->sub('hour', 10)->timestamp,
            'taken_by'          => 3,
            'created_at'        => Carbon::now()->sub('hour', 10),
            'updated_at'        => Carbon::now()->sub('hour', 10),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 33,
            'name'              => 'Milk #3',
            'calorie'           => 500,
            'price'             => 0.5,
            'taken_at'          => Carbon::now()->sub('hour', 19)->timestamp,
            'taken_by'          => 3,
            'created_at'        => Carbon::now()->sub('hour', 19),
            'updated_at'        => Carbon::now()->sub('hour', 19),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 34,
            'name'              => 'Hotdog #3',
            'calorie'           => 400,
            'price'             => 2,
            'taken_at'          => Carbon::now()->sub('hour', 19)->timestamp,
            'taken_by'          => 3,
            'created_at'        => Carbon::now()->sub('hour', 19),
            'updated_at'        => Carbon::now()->sub('hour', 19),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 35,
            'name'              => 'Ham #3',
            'calorie'           => 1500,
            'price'             => 1.5,
            'taken_at'          => Carbon::now()->sub('day', 2)->timestamp,
            'taken_by'          => 3,
            'created_at'        => Carbon::now()->sub('day', 2),
            'updated_at'        => Carbon::now()->sub('day', 2),
        ]);

        DB::table('food_entries')->insert([
            'id'                => 36,
            'name'              => 'Milk #3',
            'calorie'           => 500,
            'price'             => 0.5,
            'taken_at'          => Carbon::now()->sub('day', 2)->timestamp,
            'taken_by'          => 3,
            'created_at'        => Carbon::now()->sub('day', 2),
            'updated_at'        => Carbon::now()->sub('day', 2),
        ]);
    }
}
