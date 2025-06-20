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
        Schema::create('publicuser', function (Blueprint $table) {
            $table->string('PublicUser_ID', 10)->primary();  // Primary key
            $table->string('Ic_Number', 12);                  // NOT NULL by default
            $table->binary('Profile_Picture');                // BLOB, NOT NULL
            $table->string('User_ID', 10);                    

            // Define foreign key constraint (make sure 'users' table and User_ID exists)
            $table->foreign('User_ID')->references('User_ID')->on('user')->onDelete('cascade');

            $table->timestamps();  // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicuser');
    }
};
