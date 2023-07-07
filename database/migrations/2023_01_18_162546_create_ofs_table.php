<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ofs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mandate_id')->nullable()->constrained('mandates');
            $table->foreignId('subscription_id')->nullable()->constrained('subscriptions');
            $table->uuid('agreement_number');
            $table->integer('licence_percent');
            $table->integer('charge_percent');
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
        Schema::dropIfExists('ofs');
    }
}
