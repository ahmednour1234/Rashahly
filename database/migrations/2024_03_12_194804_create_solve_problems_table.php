<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolveProblemsTable extends Migration
{
    public function up()
    {
        Schema::create('solveproblems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('file')->nullable(); // Assuming the file path will be stored
            $table->string('pdf')->nullable(); // Assuming the PDF file path will be stored
            $table->foreignId('problem_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('solveproblems');
    }
}
