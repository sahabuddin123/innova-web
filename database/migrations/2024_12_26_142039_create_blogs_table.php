<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreign('category_id')->references('id')->on('blog_categoris');/*blog_categoris table id join */
            $table->unsignedBigInteger('category_id')->nullable();/*blog_categoris table id */
            $table->string('heading')->nullable();
            $table->string('summary')->nullable();
            $table->text('details')->nullable();
            $table->string('writerName')->nullable();
            $table->timestamp('postDate')->nullable();
            $table->unsignedInteger('IsActive')->default(0)->nullable();
            $table->unsignedInteger('featured')->default(0)->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('views')->default(0);
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
        Schema::dropIfExists('blogs');
    }
}
