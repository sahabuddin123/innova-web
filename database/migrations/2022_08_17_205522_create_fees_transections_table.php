<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeesTransectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees_transections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();/*user table id */
            $table->foreign('user_id')->references('id')->on('users');/*users table id join */
            $table->unsignedBigInteger('student_id');/*student table id */
            $table->foreign('student_id')->references('id')->on('students');/*student table id join */
            $table->string('paidamount');
            $table->string('paymentType')->default(1);
            $table->date('paiddate');
            $table->text('paidremark');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fees_transections');
    }
}
