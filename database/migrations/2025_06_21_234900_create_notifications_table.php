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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inquiry_id'); // links to inquiry table
            $table->string('message');                // notification text
            $table->boolean('is_read')->default(false); // has the user read it?
            $table->timestamps();

            // Define foreign key relationship
            $table->foreign('inquiry_id')
                  ->references('id')
                  ->on('inquiries')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
