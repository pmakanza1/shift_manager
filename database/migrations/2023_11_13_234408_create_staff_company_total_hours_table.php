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
        Schema::create('staff_company_total_hours', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('staff_id');
            $table->bigInteger('company_id');
            $table->bigInteger('shift_type_id');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->float('total_hours');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_company_total_hours');
    }
};
