<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelHasPromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_has_promotions', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('model_id');
            $table->string('model_type');
            $table->foreignId('promotion_id')->nullable()->constrained('promotions')->cascadeOnDelete();
            /*
                        $table->primary(['model_type', 'model_id'],
                            'model_access_rules_primary');
            */
            $table->index(['model_type', 'model_id'], 'model_has_promotions_model_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_has_promotions');
    }
}
