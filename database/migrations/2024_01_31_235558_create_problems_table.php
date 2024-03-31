<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProblemsTable extends Migration
{
    public function up()
    {
        Schema::create('problems', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // You can add more columns as needed for additional information about the problem
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('problems');
    }
}

