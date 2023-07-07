<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('quiz_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('quiz_pages')->cascadeOnDelete();
            $table->smallInteger('position')->default(0);
            $table->smallInteger('columns')->default(12);
            $table->json('name');
            $table->enum('type', ['content', 'question']);
            $table->enum('subtype', array_merge(array_keys(config('quiz.module.type.content')) , array_keys(config('quiz.module.type.question'))));
            $table->json('content')->nullable();
            $table->smallInteger('min_score')->nullable();
            $table->boolean('certificate')->default(0);
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
        Schema::dropIfExists('quiz_modules');
    }
}
