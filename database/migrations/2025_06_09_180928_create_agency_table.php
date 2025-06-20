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
        Schema::create('agency', function (Blueprint $table) {
            $table->string('Agency_ID', 10)->primary();           // Primary key
            $table->string('Agency_Section', 100);                // NOT NULL
            $table->string('Address', 200);                       // NOT NULL
            $table->string('Website', 100);                       // NOT NULL
            $table->dateTime('Register_Date');                    // DATETIME, NOT NULL
            $table->string('Verification_Code', 10);              // NOT NULL
            $table->string('Temp_Password', 20);                  // NOT NULL
            $table->string('User_ID', 10);                        // FK to user table

            $table->foreign('User_ID')
                  ->references('User_ID')
                  ->on('user')   // Must match the exact name of your 'user' table
                  ->onDelete('cascade');

            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency');
    }
};
