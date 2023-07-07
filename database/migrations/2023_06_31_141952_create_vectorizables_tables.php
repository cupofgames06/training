<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vectorizables', function (Blueprint $table) {
            $table->morphs('vectorizable');
            $table->unsignedBigInteger('vector_id')->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vectorizables');
    }
};
