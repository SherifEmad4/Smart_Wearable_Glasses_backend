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
        Schema::create('users_guardians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // References user with role 'user'
            $table->unsignedBigInteger('guardian_id'); // References user with role 'guardian'
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('guardian_id')->references('id')->on('users')->onDelete('cascade');

            // Ensure uniqueness of the user-guardian relationship
            $table->unique(['user_id', 'guardian_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_guardians');
    }
};
