<?php

use App\Models\Course;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('of_id')->constrained('ofs')->cascadeOnDelete();
            $table->json('name');
            $table->integer('max_learners');
            $table->string('url')->nullable();
            $table->boolean('pmr')->default(0);
            $table->enum('status', Course::STATUS);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classrooms');
    }
}
