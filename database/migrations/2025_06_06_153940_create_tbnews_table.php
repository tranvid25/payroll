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
        Schema::create('tbnews', function (Blueprint $table) {
            $table->id('maBaiViet');
            $table->string('tieuDe');
            $table->string('tacGia');
            $table->string('noiDungPhu');
            $table->string('noidung');
            $table->string('hinhAnh');
            $table->string('fileName')->nullable();
            $table->string('theLoai');
            $table->unsignedBigInteger('maPhim')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbnews');
    }
};
