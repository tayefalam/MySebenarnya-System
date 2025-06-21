<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgencyResponseTable extends Migration
{
    public function up()
    {
        Schema::create('AgencyResponse', function (Blueprint $table) {
            $table->id('Response_ID'); // Primary Key

            $table->unsignedBigInteger('Assignment_ID'); // FK to Assignment
            $table->date('Response_Date');
            $table->string('Agency_Comments', 100);
            $table->string('Rejection_Reason', 100);
            $table->enum('Jurisdiction_Status', ['Within', 'Out of Jurisdiction']);

            // Foreign key constraint
            $table->foreign('Assignment_ID')->references('Assignment_ID')->on('Assignment')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('AgencyResponse');
    }
}
