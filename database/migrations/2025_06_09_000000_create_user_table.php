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
        Schema::create('user', function (Blueprint $table) {
            $table->string('User_ID', 10)->primary();
            $table->string('Name', 200);
            $table->string('Email', 100)->unique();
            $table->string('Password', 100);
            $table->string('Contact_Number', 11);
            $table->enum('User_Type', ['Public User', 'MCMC', 'Agency']);
            $table->enum('Status', ['Active', 'Inactive']);
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
