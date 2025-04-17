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
        Schema::create('employees', function (Blueprint $table) {
            $table->id('idEmployee');
            $table->string('employeeNumber')->nullable();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('ssn')->nullable();
            $table->integer('vacationDays')->default(0);
            $table->decimal('payRate',10,2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
