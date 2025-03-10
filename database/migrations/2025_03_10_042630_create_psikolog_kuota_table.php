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
        Schema::create('psikolog_kuota', function (Blueprint $table) {
            $table->id('id');
            $table->string('kuota_hari')->default(1);
            $table->string('kuota_bulan')->default(2);
            $table->string('kuota_tahun')->default(10);
            $table->integer('bulan')->nullable();
            $table->integer('psikolog_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psikolog_kuota');
    }
};
