<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelHasUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_has_users', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('model_id');
            $table->string('model_type');
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();

            $table->index(['model_type', 'model_id'], 'model_has_user_model_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_has_users');
    }
}
