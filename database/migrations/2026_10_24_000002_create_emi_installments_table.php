<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Forward Reconciliation Migration: emi_installments
 *
 * Captures live MySQL schema for emi_installments (previously unmigrated).
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
        if (!Schema::hasTable('emi_installments')) {
            Schema::create('emi_installments', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('bank_loan_id')->nullable()->index('emi_installments_bank_loan_id_foreign');
                $table->unsignedBigInteger('shareholder_id')->nullable()->index('emi_installments_shareholder_id_foreign');
                $table->decimal('emi_amount', 15, 2)->default(0.00);
                $table->decimal('savings_amount', 15, 2)->default(0.00);
                $table->date('payment_date')->nullable();
                $table->string('payment_method', 191)->nullable();
                $table->unsignedBigInteger('paid_by')->nullable();
                $table->unsignedBigInteger('received_by')->nullable();
                $table->timestamp('paid_at')->nullable();
                $table->string('status', 191)->default('pending');
                $table->text('remarks')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        } else {
            Schema::table('emi_installments', function (Blueprint $table) {
                if (!Schema::hasColumn('emi_installments', 'bank_loan_id')) {
                    $table->unsignedBigInteger('bank_loan_id')->nullable()->index('emi_installments_bank_loan_id_foreign');
                }
                if (!Schema::hasColumn('emi_installments', 'shareholder_id')) {
                    $table->unsignedBigInteger('shareholder_id')->nullable()->index('emi_installments_shareholder_id_foreign');
                }
                if (!Schema::hasColumn('emi_installments', 'emi_amount')) {
                    $table->decimal('emi_amount', 15, 2)->default(0.00);
                }
                if (!Schema::hasColumn('emi_installments', 'savings_amount')) {
                    $table->decimal('savings_amount', 15, 2)->default(0.00);
                }
                if (!Schema::hasColumn('emi_installments', 'payment_date')) {
                    $table->date('payment_date')->nullable();
                }
                if (!Schema::hasColumn('emi_installments', 'payment_method')) {
                    $table->string('payment_method', 191)->nullable();
                }
                if (!Schema::hasColumn('emi_installments', 'paid_by')) {
                    $table->unsignedBigInteger('paid_by')->nullable();
                }
                if (!Schema::hasColumn('emi_installments', 'received_by')) {
                    $table->unsignedBigInteger('received_by')->nullable();
                }
                if (!Schema::hasColumn('emi_installments', 'paid_at')) {
                    $table->timestamp('paid_at')->nullable();
                }
                if (!Schema::hasColumn('emi_installments', 'status')) {
                    $table->string('status', 191)->default('pending');
                }
                if (!Schema::hasColumn('emi_installments', 'remarks')) {
                    $table->text('remarks')->nullable();
                }
                if (!Schema::hasColumn('emi_installments', 'created_at')) {
                    $table->timestamps();
                }
                if (!Schema::hasColumn('emi_installments', 'deleted_at')) {
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
        Schema::dropIfExists('emi_installments');
    }
};
