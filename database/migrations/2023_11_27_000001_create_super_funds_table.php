<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('super_funds', function (Blueprint $table) {
            $table->id();
            $table->string('usi')->unique();
            $table->string('abn')->nullable();
            $table->string('fund_name')->nullable();
            $table->string('product_name')->nullable();
            $table->boolean('restricts_contributions')->default(false);
            $table->boolean('valid')->default(true)->index();
            $table->date('valid_from');
            $table->date('valid_to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('super_funds');
    }
};
