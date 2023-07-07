<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelHasCourseIndicatorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_has_course_indicator', function (Blueprint $table) {
            $table->unsignedBigInteger('modelable_id');
            $table->string('modelable_type');
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('indicator_id')->constrained('indicators')->cascadeOnDelete();
            $table->integer('value')->nullable();
            $table->timestamp('created_at');

            $table->primary(['course_id','indicator_id', 'modelable_type', 'modelable_id'],'model_has_indicators_primary');
            $table->index(['modelable_type', 'modelable_id'], 'model_has_indicators_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_has_course_indicator');
    }
}
