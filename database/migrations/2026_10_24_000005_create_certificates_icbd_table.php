<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Forward Reconciliation Migration: certificates_icbd
 *
 * Captures live MySQL schema for certificates_icbd (previously unmigrated).
 * Two-tier safety:
 *  - Tier 1: Creates complete table if absent.
 *  - Tier 2: If table exists but is incomplete, ensures all canonical columns exist.
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
        if (!Schema::hasTable('certificates_icbd')) {
            Schema::create('certificates_icbd', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('student_id')->index('fk_certificates_student');
                $table->unsignedBigInteger('batch_id')->index('fk_certificates_batch');
                $table->unsignedBigInteger('course_id')->index('fk_certificates_course');
                $table->string('certificate_no', 100)->nullable()->unique('certificate_no');
                $table->integer('theory_hours')->nullable()->default(0);
                $table->integer('practical_hours')->nullable()->default(0);
                $table->integer('intern_hours')->nullable()->default(0);
                $table->string('result', 50)->nullable();
                $table->date('issue_date')->nullable();
                $table->string('certificate_receiver', 150)->nullable();
                $table->date('delivery_date')->nullable();
                $table->tinyInteger('is_active')->nullable()->default(1);
                $table->timestamps();
                $table->softDeletes();
            });
        } else {
            Schema::table('certificates_icbd', function (Blueprint $table) {
                if (!Schema::hasColumn('certificates_icbd', 'student_id')) {
                    $table->unsignedBigInteger('student_id')->index('fk_certificates_student');
                }
                if (!Schema::hasColumn('certificates_icbd', 'batch_id')) {
                    $table->unsignedBigInteger('batch_id')->index('fk_certificates_batch');
                }
                if (!Schema::hasColumn('certificates_icbd', 'course_id')) {
                    $table->unsignedBigInteger('course_id')->index('fk_certificates_course');
                }
                if (!Schema::hasColumn('certificates_icbd', 'certificate_no')) {
                    $table->string('certificate_no', 100)->nullable()->unique('certificate_no');
                }
                if (!Schema::hasColumn('certificates_icbd', 'theory_hours')) {
                    $table->integer('theory_hours')->nullable()->default(0);
                }
                if (!Schema::hasColumn('certificates_icbd', 'practical_hours')) {
                    $table->integer('practical_hours')->nullable()->default(0);
                }
                if (!Schema::hasColumn('certificates_icbd', 'intern_hours')) {
                    $table->integer('intern_hours')->nullable()->default(0);
                }
                if (!Schema::hasColumn('certificates_icbd', 'result')) {
                    $table->string('result', 50)->nullable();
                }
                if (!Schema::hasColumn('certificates_icbd', 'issue_date')) {
                    $table->date('issue_date')->nullable();
                }
                if (!Schema::hasColumn('certificates_icbd', 'certificate_receiver')) {
                    $table->string('certificate_receiver', 150)->nullable();
                }
                if (!Schema::hasColumn('certificates_icbd', 'delivery_date')) {
                    $table->date('delivery_date')->nullable();
                }
                if (!Schema::hasColumn('certificates_icbd', 'is_active')) {
                    $table->tinyInteger('is_active')->nullable()->default(1);
                }
                if (!Schema::hasColumn('certificates_icbd', 'created_at')) {
                    $table->timestamps();
                }
                if (!Schema::hasColumn('certificates_icbd', 'deleted_at')) {
                    $table->softDeletes();
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
        Schema::dropIfExists('certificates_icbd');
    }
};
