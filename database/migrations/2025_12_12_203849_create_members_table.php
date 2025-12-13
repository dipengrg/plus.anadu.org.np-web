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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
			$table->tinyInteger('user_id');
			$table->string('title')->nullable();
			$table->string('name');
			$table->char('gender', 1);
			$table->date('dob')->nullable();
			$table->string('photo')->nullable();
			$table->string('address')->nullable();
			$table->string('current_residence')->default('local');
			$table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
