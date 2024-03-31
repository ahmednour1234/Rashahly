<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeyResponsibilitiesTable extends Migration
{
    public function up()
    {
        Schema::create('key_responsibilities', function (Blueprint $table) {
            $table->id();
            $table->json('data'); // Assuming you want to store JSON data
            $table->string('name');
            $table->foreignId('job_id')->constrained('jobs')->onDelete('cascade');
            // You can add more columns as needed for additional information about key responsibilities
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('key_responsibilities');
    }
}

