<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Forward Reconciliation Migration: investment_withdraws
 *
 * Captures live MySQL schema for investment_withdraws (previously unmigrated).
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
        if (!Schema::hasTable('investment_withdraws')) {
            Schema::create('investment_withdraws', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('shareholder_id')->nullable()->index();
                $table->decimal('amount', 15, 2)->default(0.00);
                $table->date('withdraw_date')->nullable();
                $table->string('method', 191)->nullable();
                $table->string('branch_name', 191)->nullable();
                $table->string('receiver_name', 191)->nullable();
                $table->string('pay_by', 191)->nullable();
                $table->string('account_number', 191)->nullable();
                $table->string('status', 191)->default('pending');
                $table->unsignedBigInteger('requested_by')->nullable();
                $table->timestamp('requested_at')->nullable();
                $table->unsignedBigInteger('processed_by')->nullable();
                $table->timestamp('processed_at')->nullable();
                $table->text('processed_remarks')->nullable();
                $table->text('remarks')->nullable();
                $table->string('attachment', 191)->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        } else {
            Schema::table('investment_withdraws', function (Blueprint $table) {
                if (!Schema::hasColumn('investment_withdraws', 'shareholder_id')) {
                    $table->unsignedBigInteger('shareholder_id')->nullable()->index();
                }
                if (!Schema::hasColumn('investment_withdraws', 'amount')) {
                    $table->decimal('amount', 15, 2)->default(0.00);
                }
                if (!Schema::hasColumn('investment_withdraws', 'withdraw_date')) {
                    $table->date('withdraw_date')->nullable();
                }
                if (!Schema::hasColumn('investment_withdraws', 'method')) {
                    $table->string('method', 191)->nullable();
                }
                if (!Schema::hasColumn('investment_withdraws', 'branch_name')) {
                    $table->string('branch_name', 191)->nullable();
                }
                if (!Schema::hasColumn('investment_withdraws', 'receiver_name')) {
                    $table->string('receiver_name', 191)->nullable();
                }
                if (!Schema::hasColumn('investment_withdraws', 'pay_by')) {
                    $table->string('pay_by', 191)->nullable();
                }
                if (!Schema::hasColumn('investment_withdraws', 'account_number')) {
                    $table->string('account_number', 191)->nullable();
                }
                if (!Schema::hasColumn('investment_withdraws', 'status')) {
                    $table->string('status', 191)->default('pending');
                }
                if (!Schema::hasColumn('investment_withdraws', 'requested_by')) {
                    $table->unsignedBigInteger('requested_by')->nullable();
                }
                if (!Schema::hasColumn('investment_withdraws', 'requested_at')) {
                    $table->timestamp('requested_at')->nullable();
                }
                if (!Schema::hasColumn('investment_withdraws', 'processed_by')) {
                    $table->unsignedBigInteger('processed_by')->nullable();
                }
                if (!Schema::hasColumn('investment_withdraws', 'processed_at')) {
                    $table->timestamp('processed_at')->nullable();
                }
                if (!Schema::hasColumn('investment_withdraws', 'processed_remarks')) {
                    $table->text('processed_remarks')->nullable();
                }
                if (!Schema::hasColumn('investment_withdraws', 'remarks')) {
                    $table->text('remarks')->nullable();
                }
                if (!Schema::hasColumn('investment_withdraws', 'attachment')) {
                    $table->string('attachment', 191)->nullable();
                }
                if (!Schema::hasColumn('investment_withdraws', 'created_at')) {
                    $table->timestamps();
                }
                if (!Schema::hasColumn('investment_withdraws', 'deleted_at')) {
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
        Schema::dropIfExists('investment_withdraws');
    }
};
