<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_descriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('describable_id');
            $table->string('describable_type');
            $table->string('reference')->nullable();
            $table->string('code')->nullable();
            $table->unsignedSmallInteger('max_learners')->nullable();
            $table->json('name')->nullable();
            $table->json('objectives')->nullable();
            $table->json('program')->nullable();
            $table->json('pre_requisite')->nullable();
            $table->json('pedago')->nullable();
            $table->json('public')->nullable();
            $table->json('eval')->nullable();
            $table->json('equipment')->nullable();
            $table->json('promo_message')->nullable();
            $table->json('learner_message')->nullable();
            $table->text('internal_comment')->nullable();
            $table->json('psh_accessibility')->nullable();
            $table->text('video')->nullable();
            $table->boolean('pre_requisite_quiz')->default(0);
            $table->boolean('intra')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer_descriptions');
    }
};
