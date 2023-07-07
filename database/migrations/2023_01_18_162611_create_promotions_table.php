<?php

use App\Models\Promotion;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('of_id')->nullable()->constrained('ofs')->cascadeOnDelete();
            $table->string('code');
            $table->float('amount');
            $table->boolean('percent');
            $table->date('date_start');
            $table->date('date_end');
            $table->json('name');
            $table->enum('status',Promotion::STATUS);
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
        Schema::dropIfExists('promotions');
    }
}
