<?php

use App\Models\Category;
use App\Models\Course;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('of_id')->constrained('ofs')->cascadeOnDelete();
            $table->enum('type', Course::COURSE_TYPE);
            $table->smallInteger('duration');
            $table->enum('status', Course::STATUS);

            //$table->json('languages');
            //$table->enum('priority',['xx','yy']); //todo : référentiel?
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
}
