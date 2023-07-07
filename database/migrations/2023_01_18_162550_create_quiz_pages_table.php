<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('quiz_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('version_id')->nullable()->constrained('quiz_versions')->cascadeOnDelete();
            $table->json('name');
            $table->smallInteger('min_score')->nullable();
            $table->smallInteger('position')->default(0);

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
        Schema::dropIfExists('quiz_pages');
    }
}
