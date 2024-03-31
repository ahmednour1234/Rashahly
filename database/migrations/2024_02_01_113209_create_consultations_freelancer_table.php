<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultationsFreelancerTable extends Migration
{
    public function up()
    {
        Schema::create('consultations_freelancer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained('consultant_freelancers')->onDelete('cascade');
            $table->foreignId('freelancer_id')->constrained('consultant_freelancers')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('appointment');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consultations_freelancer');
    }
}

