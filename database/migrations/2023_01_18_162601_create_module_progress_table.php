<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('module_progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quiz_version_id');
            $table->foreign('quiz_version_id')->references('id')->on('quiz_versions');
            $table->json('datas');
            $table->dateTime('first_login');
            $table->dateTime('last_login');
            $table->integer('score');
            $table->unsignedBigInteger('status');
            $table->string('last_token')->nullable()->comment('seulement utilisé si sparksone');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_progress');
    }
}
