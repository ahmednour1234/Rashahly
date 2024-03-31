<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultantFreelancersTable extends Migration
{
    public function up()
    {
        Schema::create('consultant_freelancers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('type');
            $table->text('description');
            $table->decimal('price', 10, 2); // Assuming price is a decimal, adjust the precision and scale accordingly
            // You can add more columns as needed for additional information about the consultant freelancer
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consultant_freelancers');
    }
}
