<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('value');
        });

        DB::table('cards')->insert(
            [
                ['value' => 1],
                ['value' => 2],
                ['value' => 3],
                ['value' => 5],
                ['value' => 8],
                ['value' => 13],
                ['value' => 21],
                ['value' => 34],
                ['value' => 55],
                ['value' => 89]
                ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
