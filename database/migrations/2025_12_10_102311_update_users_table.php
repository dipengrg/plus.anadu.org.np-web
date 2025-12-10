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
        // Drop the password_reset_tokens table if it exists
        Schema::dropIfExists('password_reset_tokens');

        // Remove unnecessary columns from the users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['email', 'email_verified_at', 'password', 'remember_token']);
        });

        // Add new columns to the users table
        Schema::table('users', function (Blueprint $table) {
            // Add new columns
            $table->string('role')->default('general')->index()->after('id');
            $table->string('photo')->nullable()->after('name');
            $table->date('dob')->nullable()->after('photo');
            $table->string('phone')->unique()->after('dob');
            $table->string('otp')->nullable()->after('phone');
            $table->timestamp('otp_created_at')->nullable()->after('otp');
            $table->boolean('status')->default(1)->after('otp_created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate the password_reset_tokens table
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Remove the newly added columns from the users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'photo', 'dob', 'phone', 'otp', 'otp_created_at', 'status']);
        });

        Schema::table('users', function (Blueprint $table) {
            // Re-add the removed columns
            $table->string('email')->unique()->after('name');
            $table->timestamp('email_verified_at')->nullable()->after('email');
            $table->string('password')->after('email_verified_at');
            $table->rememberToken()->after('password');
        });
    }
};
