<?php

use App\Models\Session;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class
CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->nullable()->constrained('courses');
            $table->foreignId('classroom_id')->nullable()->constrained('classrooms');
            //$table->unsignedSmallInteger('max_learners')->nullable();
            $table->json('psh_accessibility')->nullable();
            $table->float('cost')->nullable();
            $table->enum('status', Session::STATUS);
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
        Schema::dropIfExists('sessions');
    }
}
