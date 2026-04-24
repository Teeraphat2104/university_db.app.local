<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->constrained('activities')->onDelete('cascade');
            $table->string('student_id', 20);          // รหัสนักศึกษา เช่น 6601234567
            $table->string('name', 255);               // ชื่อ-นามสกุล
            $table->string('faculty', 255)->nullable(); // คณะ
            $table->string('major', 255)->nullable();   // สาขา
            $table->tinyInteger('year')->nullable();    // ชั้นปี
            $table->json('extra_data')->nullable();     // คอลัมน์เพิ่มเติมอื่นๆ
            $table->timestamps();

            $table->index('student_id');
            $table->index('name');
            $table->index(['activity_id', 'student_id']);
            $table->unique(['activity_id', 'student_id']); // ป้องกัน import ซ้ำ
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_participants');
    }
};
