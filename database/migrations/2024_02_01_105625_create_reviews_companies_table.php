<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsCompaniesTable extends Migration
{
    public function up()
    {
        Schema::create('reviews_companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->text('feedback');
            $table->unsignedInteger('rate'); // Assuming rate is an integer, you can adjust the type accordingly
            // You can add more columns as needed for additional information about the review
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews_companies');
    }
}
