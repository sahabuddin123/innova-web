<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('asset_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('asset_courses')->onDelete('cascade');
            $table->string('full_name');
            $table->string('email')->unique();
            $table->text('address');
            $table->string('phone');
            $table->string('whatsapp')->nullable();
            $table->date('date_of_birth');
            $table->string('educational_qualification');
            $table->string('educational_organization');
            $table->string('current_status');
            $table->boolean('has_bank_account')->default(false);
            $table->string('nid_file');
            $table->string('certificate_file');
            $table->string('passport_image');
            $table->string('registration_status')->default('Pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asset_students');
    }
}
