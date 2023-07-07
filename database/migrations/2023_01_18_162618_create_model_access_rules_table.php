<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelAccessRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_access_rules', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('model_id');
            $table->string('model_type');
            $table->json('rule');
            /*
                        $table->primary(['model_type', 'model_id'],
                            'model_access_rules_primary');
            */
            $table->index(['model_type', 'model_id'], 'model_has_indicators_model_id_model_type_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_access_rules');
    }
}
