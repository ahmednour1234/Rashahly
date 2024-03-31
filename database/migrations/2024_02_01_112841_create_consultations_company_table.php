<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultationsCompanyTable extends Migration
{
    public function up()
    {
        Schema::create('consultations_company', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultants_id')->constrained('consultant_companies')->onDelete('cascade');
            $table->foreignId('company_id')->constrained('consultant_companies')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('appointment');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consultations_company');
    }
}

