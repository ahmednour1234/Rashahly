<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCvTable extends Migration
{
    public function up()
    {
        Schema::create('user_cv', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->string('pdf'); // Assuming the pdf file path will be stored
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_cv');
    }
}
