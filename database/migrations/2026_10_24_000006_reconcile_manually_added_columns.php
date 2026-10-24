<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Forward Reconciliation Migration: Manually Added Columns
 *
 * Reconciles 23 columns added manually to live MySQL database
 * across users, fees_transections, courses, course_categories, and teachers.
 *
 * Idempotent: Only adds each column if it does not already exist.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. users table
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'name')) {
                    $table->string('name', 255)->nullable()->after('id');
                }
            });
        }

        // 2. fees_transections table
        if (Schema::hasTable('fees_transections')) {
            Schema::table('fees_transections', function (Blueprint $table) {
                if (!Schema::hasColumn('fees_transections', 'channel')) {
                    $table->integer('channel')->default(1)->after('paymentType');
                }
                if (!Schema::hasColumn('fees_transections', 'trxID')) {
                    $table->string('trxID', 255)->nullable()->after('channel');
                }
                if (!Schema::hasColumn('fees_transections', 'paymentID')) {
                    $table->string('paymentID', 255)->nullable()->after('trxID');
                }
                if (!Schema::hasColumn('fees_transections', 'status')) {
                    $table->integer('status')->default(0)->after('paymentID');
                }
            });
        }

        // 3. courses table
        if (Schema::hasTable('courses')) {
            Schema::table('courses', function (Blueprint $table) {
                if (!Schema::hasColumn('courses', 'IsCourse')) {
                    $table->boolean('IsCourse')->default(0)->after('status');
                }
                if (!Schema::hasColumn('courses', 'courseFor')) {
                    $table->string('courseFor', 255)->nullable()->after('IsCourse');
                }
                if (!Schema::hasColumn('courses', 'Instructor')) {
                    $table->integer('Instructor')->nullable()->after('courseFor');
                }
                if (!Schema::hasColumn('courses', 'Rating')) {
                    $table->decimal('Rating', 2, 1)->nullable()->after('Instructor');
                }
                if (!Schema::hasColumn('courses', 'TotalReview')) {
                    $table->string('TotalReview', 255)->nullable()->after('Rating');
                }
                if (!Schema::hasColumn('courses', 'Discount')) {
                    $table->string('Discount', 255)->nullable()->after('TotalReview');
                }
                if (!Schema::hasColumn('courses', 'views')) {
                    $table->string('views', 11)->default('0')->after('Discount');
                }
            });
        }

        // 4. course_categories table
        if (Schema::hasTable('course_categories')) {
            Schema::table('course_categories', function (Blueprint $table) {
                if (!Schema::hasColumn('course_categories', 'fontawesome')) {
                    $table->string('fontawesome', 255)->nullable()->after('icon');
                }
                if (!Schema::hasColumn('course_categories', 'isFeature')) {
                    $table->integer('isFeature')->default(0)->after('fontawesome');
                }
                if (!Schema::hasColumn('course_categories', 'tabId')) {
                    $table->string('tabId', 255)->nullable()->after('isFeature');
                }
            });
        }

        // 5. teachers table
        if (Schema::hasTable('teachers')) {
            Schema::table('teachers', function (Blueprint $table) {
                if (!Schema::hasColumn('teachers', 'email')) {
                    $table->string('email', 255)->nullable()->after('name');
                }
                if (!Schema::hasColumn('teachers', 'ComCourse')) {
                    $table->string('ComCourse', 255)->nullable()->after('qualification');
                }
                if (!Schema::hasColumn('teachers', 'nStd')) {
                    $table->string('nStd', 255)->nullable()->after('ComCourse');
                }
                if (!Schema::hasColumn('teachers', 'rating')) {
                    $table->string('rating', 255)->nullable()->after('nStd');
                }
                if (!Schema::hasColumn('teachers', 'review')) {
                    $table->string('review', 255)->nullable()->after('rating');
                }
                if (!Schema::hasColumn('teachers', 'isTeacher')) {
                    $table->integer('isTeacher')->default(0)->after('review');
                }
                if (!Schema::hasColumn('teachers', 'IsFeatured')) {
                    $table->integer('IsFeatured')->default(0)->after('isTeacher');
                }
                if (!Schema::hasColumn('teachers', 'bio')) {
                    $table->text('bio')->nullable()->after('IsFeatured');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'name')) {
                    $table->dropColumn('name');
                }
            });
        }

        if (Schema::hasTable('fees_transections')) {
            Schema::table('fees_transections', function (Blueprint $table) {
                $cols = array_filter(['channel', 'trxID', 'paymentID', 'status'], fn($c) => Schema::hasColumn('fees_transections', $c));
                if (!empty($cols)) {
                    $table->dropColumn($cols);
                }
            });
        }

        if (Schema::hasTable('courses')) {
            Schema::table('courses', function (Blueprint $table) {
                $cols = array_filter(['IsCourse', 'courseFor', 'Instructor', 'Rating', 'TotalReview', 'Discount', 'views'], fn($c) => Schema::hasColumn('courses', $c));
                if (!empty($cols)) {
                    $table->dropColumn($cols);
                }
            });
        }

        if (Schema::hasTable('course_categories')) {
            Schema::table('course_categories', function (Blueprint $table) {
                $cols = array_filter(['fontawesome', 'isFeature', 'tabId'], fn($c) => Schema::hasColumn('course_categories', $c));
                if (!empty($cols)) {
                    $table->dropColumn($cols);
                }
            });
        }

        if (Schema::hasTable('teachers')) {
            Schema::table('teachers', function (Blueprint $table) {
                $cols = array_filter(['email', 'ComCourse', 'nStd', 'rating', 'review', 'isTeacher', 'IsFeatured', 'bio'], fn($c) => Schema::hasColumn('teachers', $c));
                if (!empty($cols)) {
                    $table->dropColumn($cols);
                }
            });
        }
    }
};
