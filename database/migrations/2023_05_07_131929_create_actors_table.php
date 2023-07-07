<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('actors', function (Blueprint $table) {
            $table->id();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->json('name');
            $table->json('description');
            $table->timestamps();
        });

        Schema::create('closeups', function (Blueprint $table) {
            $table->id();
            $table->json('name')->comment('permet de trouver la caméra dans le persistent level + actor à cliquer pour téléportation');
            $table->boolean('active')->default(1);
        });

        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('actor_id')->nullable();
            $table->foreign('actor_id')->references('id')->on('actors');
            $table->json('name');
            $table->json('description');
        });

        Schema::create('clues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->json('name');
            $table->json('short_description');
            $table->json('description');
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('actor_id');
            $table->foreign('actor_id')->references('id')->on('actors');
            $table->text('question');
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreign('actor_id')->references('id')->on('actors');
            $table->foreign('question_id')->references('id')->on('actors');
            $table->json('text');
            $table->json('audio_filename');
        });

        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->unsignedBigInteger('closeup_id')->nullable();
            $table->foreign('closeup_id')->references('id')->on('closeups');
            $table->unsignedSmallInteger('money')->nullable();
            $table->boolean('revealable')->default(0);
            $table->boolean('readable')->default(0);
            $table->boolean('takable')->default(0);
            $table->boolean('examinable')->default(0);
            $table->boolean('crypted')->default(0);
            $table->json('use_with')->nullable();
            $table->boolean('active')->default(1);
            $table->json('readable_content')->nullable();
        });

        Schema::create('labels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('model_id');
            $table->unsignedBigInteger('model_type')->comment('item,actor,place');
            $table->json('name');
            $table->json('description');
        });

        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('actionnable_id');
            $table->unsignedBigInteger('actionnable_type')->comment('examine,take,');
        });

        //A priori, chunks de documents tokenisable
        Schema::create('knowledges', function (Blueprint $table) {
            $table->id();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->text('text');
        });

        Schema::create('contexts', function (Blueprint $table) {
            $table->id();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->dateTime('date_start');
            $table->dateTime('date_end');
            $table->text('where');
            $table->text('what');
            $table->text('player');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actors');
        Schema::dropIfExists('places');
        Schema::dropIfExists('plannings');
        Schema::dropIfExists('clues');
        Schema::dropIfExists('objects');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('answers');
        Schema::dropIfExists('items');
        Schema::dropIfExists('contexts');
        Schema::dropIfExists('knowledges');
        Schema::dropIfExists('labels');
        Schema::dropIfExists('closeups');
        Schema::dropIfExists('actions');
    }

};
