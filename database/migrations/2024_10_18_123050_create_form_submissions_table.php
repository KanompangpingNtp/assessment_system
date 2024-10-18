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
        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id(); // รหัสการทำแบบประเมิน
            $table->foreignId('agency_id')->constrained('agencies')->onDelete('cascade'); // FK เชื่อมกับหน่วยงาน
            $table->integer('submission_count')->default(0); // จำนวนการทำแบบประเมิน
            $table->timestamp('submitted_at'); // เวลาที่ทำแบบประเมิน
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_submissions');
    }
};
