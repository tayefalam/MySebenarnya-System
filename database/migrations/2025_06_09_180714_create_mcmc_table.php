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
        Schema::create('mcmc', function (Blueprint $table) {
            $table->string('MCMC_ID', 10)->primary();     // Primary key
            $table->string('Department', 12);             // NOT NULL
            $table->string('Position', 200);              // NOT NULL
            $table->string('User_ID', 10);                // FK to user table

            $table->foreign('User_ID')
                  ->references('User_ID')
                  ->on('user')   // Make sure this matches the table name in your DB
                  ->onDelete('cascade');

            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mcmc');
    }
};
