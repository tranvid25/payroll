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
        Schema::create('seats', function (Blueprint $table) {
            $table->id('maGhe');
            $table->string('tenGhe');
            $table->string('loaiGhe');
            $table->string('nguoiDat')->nullable();
            $table->string('nguoiChon')->nullable();
            $table->unsignedBigInteger('maLichChieu');
            $table->foreign('maLichChieu')->references('maLichChieu')->on('showtime')->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
