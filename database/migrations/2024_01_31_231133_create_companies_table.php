<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('site')->nullable();
            $table->string('country')->nullable();
            $table->date('founded_at')->nullable();
            $table->integer('number_of_employees')->nullable();
            $table->text('description')->nullable();
            // You can add more columns as needed for additional information about the company
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
