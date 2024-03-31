<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhyWorkWithUsTable extends Migration
{
    public function up()
    {
        Schema::create('why_work_with_us', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->unique()->constrained('companies')->onDelete('cascade');
            $table->json('data'); // Assuming you want to store JSON data
            // You can add more columns as needed for additional information about why to work with the company
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('why_work_with_us');
    }
}
