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
    Schema::create('inquiries', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('description');
        $table->date('date');
        $table->boolean('status')->nullable(); // false = pending
        $table->string('evidence')->nullable(); // file path
        $table->string('User_ID', 10);
        $table->foreign('User_ID')->references('User_ID')->on('user')->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }

};

