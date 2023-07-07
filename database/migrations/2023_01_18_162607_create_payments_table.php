<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mandate_id');
            $table->foreign('mandate_id')->references('id')->on('mandates');
            $table->unsignedBigInteger('invoice_number');
            $table->float('amount');
            $table->enum('status',['pending','paid','error']);
            $table->date('d_due');
            $table->dateTime('d_paid');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
