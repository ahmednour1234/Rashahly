<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileTypesTable extends Migration
{
    public function up()
    {
        Schema::create('profile_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('type_id');
            $table->text('bio')->nullable();
            $table->string('full_name')->nullable();
            $table->string('profession')->nullable(); // Added profession column
            // You can add more columns as needed for additional information about the user's profile
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profile_types');
    }
}


