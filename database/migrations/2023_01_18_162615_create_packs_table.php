<?php

use App\Models\Course;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('packs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('of_id')->constrained('ofs')->cascadeOnDelete();
            $table->enum('type',['pack','blended']);
            $table->enum('status', Course::STATUS);
            $table->timestamps();
        });

        Schema::create('packables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pack_id')->constrained('packs')->cascadeOnDelete();
            $table->morphs('packable');
            $table->smallInteger('position')->nullable()->default(0);
            $table->unique(['pack_id', 'packable_id', 'packable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('packables');
        Schema::dropIfExists('packs');
    }
}
