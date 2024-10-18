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
        Schema::table('responses', function (Blueprint $table) {
            //
            $table->foreignId('agency_id')->constrained('agencies')->onDelete('cascade'); // FK เชื่อมกับตาราง agencies
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('responses', function (Blueprint $table) {
            //
            $table->dropForeign(['agency_id']); // ลบ FK
            $table->dropColumn('agency_id'); // ลบคอลัมน์
        });
    }
};
