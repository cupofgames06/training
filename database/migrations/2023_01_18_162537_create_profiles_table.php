<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('title',['male', 'female','neutral']);
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone_1')->nullable();
            $table->string('phone_2')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_zipcode')->nullable();
            $table->foreignId('birth_country_id')->nullable()->constrained('countries');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
           $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
