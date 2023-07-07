<?php

use App\Models\Quiz;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->enum('type', QUIZ::QUIZ_TYPE);
            //$table->json('name');
            //$table->json('description');
            $table->timestamps();
        });

        Schema::create('quizzesables', function (Blueprint $table) {
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->morphs('quizzesable');
            $table->unique(['quiz_id', 'quizzesable_id', 'quizzesable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
}
