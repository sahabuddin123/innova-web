<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetRegistrationsTable extends Migration
{
    public function up()
    {
        Schema::create('asset_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('course');
            $table->string('full_name');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('mobile');
            $table->string('email');
            $table->string('religion');
            $table->string('gender');
            $table->date('dob');
            $table->string('nid');
            $table->string('employment_status');
            $table->longText('address');
            $table->string('education');
            $table->string('board');
            $table->string('subject');
            $table->string('passing_year');
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asset_registrations');
    }
}
