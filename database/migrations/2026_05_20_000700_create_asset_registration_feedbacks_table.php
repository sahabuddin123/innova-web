<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetRegistrationFeedbacksTable extends Migration
{
    public function up()
    {
        Schema::create('asset_registration_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_registration_id')->constrained('asset_registrations')->cascadeOnDelete();
            $table->unsignedTinyInteger('feedback_step');
            $table->longText('feedback');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asset_registration_feedbacks');
    }
}
