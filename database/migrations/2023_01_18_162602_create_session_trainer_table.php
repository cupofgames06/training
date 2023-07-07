<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionTrainerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session_trainer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('sessions');
            $table->foreignId('trainer_id')->constrained('users','id');
            $table->string('via_of')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('session_trainer');
    }
}
