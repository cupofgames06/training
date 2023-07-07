<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {

        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->nullable()->constrained('users');
            $table->foreignId('price_level_id')->nullable()->constrained('price_levels');
            $table->foreignId('mandate_id')->nullable()->constrained('mandates');
            $table->foreignId('subscription_id')->nullable()->constrained('subscriptions');
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
        Schema::dropIfExists('companies');
    }
}
