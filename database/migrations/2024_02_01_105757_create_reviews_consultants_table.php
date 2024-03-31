<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsConsultantsTable extends Migration
{
    public function up()
    {
        Schema::create('reviews_consultants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('consult_id');
            $table->string('consult_type'); // This column will store the model type (e.g., App\Models\ConsultantCompany or App\Models\ConsultantFreelancer)
            $table->text('feedback');
            $table->unsignedInteger('rate');
            $table->timestamps();

            $table->index(['consult_id', 'consult_type']); // Index for polymorphic relationship
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews_consultants');
    }
}
