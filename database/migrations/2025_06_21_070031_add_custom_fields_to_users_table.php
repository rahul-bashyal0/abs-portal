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
        Schema::table('users', function (Blueprint $table) {
            // The role of the user in the system.
            $table->string('role')->default('student');

            // Foreign key for the college. Nullable because Super Admins/Reviewers aren't tied to one.
            $table->unsignedBigInteger('college_id')->nullable();

            // Determines if a student or college admin is approved and can log in.
            $table->boolean('is_approved')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'college_id', 'is_approved']);
        });
    }
};