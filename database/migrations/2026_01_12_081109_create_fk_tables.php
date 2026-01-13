<?php
// database/migrations/xxxx_xx_xx_create_fk_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('student');
            $table->string('status')->default('pending');
            $table->string('phone')->nullable();
        });

        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users');
            $table->string('title');
            $table->string('document_path');
            $table->string('presentation_type');

            $table->foreignId('supervisor_id')->nullable()->constrained('users');
            $table->string('supervisor_status')->default('pending');
            $table->foreignId('examiner_1_id')->nullable()->constrained('users');
            $table->foreignId('examiner_2_id')->nullable()->constrained('users');

            $table->string('manager_status')->default('pending');
            $table->timestamps();
        });

        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('submissions');
            $table->date('presentation_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('venue');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('submissions');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'status', 'phone']);
        });
    }
};