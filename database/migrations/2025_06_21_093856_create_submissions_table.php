<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The student who submitted
            $table->foreignId('reviewer_id')->nullable()->constrained('users')->onDelete('set null'); // The assigned reviewer
            
            $table->string('title');
            $table->text('problem_statement');
            $table->text('solution_description');
            $table->string('technologies_used');
            $table->string('video_link')->nullable();
            $table->string('file_path')->nullable();
            
            // Statuses: Submitted, Under Review, Shortlisted, Rejected, Internship Offered
            $table->string('status')->default('Submitted');
            $table->boolean('is_shortlisted_for_internship')->default(false);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};