<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_course', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('grade')->nullable();
            $table->dateTime('enrolled_at')->useCurrent(); // Sets default to CURRENT_TIMESTAMP
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->timestamps(); // Adds created_at and updated_at columns
            $table->unique(['student_id', 'course_id']); // Prevents duplicate student-course pairs
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_course');
    }
};
