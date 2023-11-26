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
        Schema::table('staff_company_total_hours', function (Blueprint $table) {
            $table->after('total_hours', function(Blueprint $table){
                $table->decimal('rate', 10,2);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff_company_total_hours', function (Blueprint $table) {
            //
        });
    }
};
