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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('price_level_id')->constrained('price_levels');
            $table->morphs('priceable');
            $table->float('price_ht');
            $table->float('price_ttc');
            $table->unsignedFloat('vat_rate')->default(20);
            $table->bigInteger('vat_amount')->default(0);
            $table->float('charge');
            $table->enum('type',['default','forfeit']);
            $table->json('options')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices');
    }
};
