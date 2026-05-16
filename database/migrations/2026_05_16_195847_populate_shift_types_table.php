<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('shift_types')->insert([
            [
                'name' => 'Day',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Night',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Late',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('shift_types')->whereIn('name', ['Day', 'Night', 'Late']) ->delete();
    }
};
