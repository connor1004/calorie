<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_entries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('calorie', 10, 3);
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('taken_at');
            $table->unsignedBigInteger('taken_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food_entries');
    }
}
