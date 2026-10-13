<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCourseOutlineToAssetCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_courses', function (Blueprint $table) {
            $table->string('course_outline')->nullable()->after('button_color');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset_courses', function (Blueprint $table) {
            $table->dropColumn('course_outline');
        });
    }
}
