<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvesmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invesments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shareholder_id');/*shareholders table id */
            $table->foreign('shareholder_id')->references('id')->on('shareholders');/*shareholders table id join */
            $table->string('amount')->nullable();
            $table->string('recevedBy')->nullable();
            $table->date('recevedDate')->nullable();
            $table->text('paidremark')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('isActive')->default(0)->nullable();
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
        Schema::dropIfExists('invesments');
    }
}
