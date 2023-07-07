<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('conditionables', function (Blueprint $table) {
            $table->morphs('conditionable');
            $table->json('cancel')->nullable();
            $table->json('required')->nullable();
            $table->json('remove')->nullable();
            $table->json('new')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conditionables');
    }
};
