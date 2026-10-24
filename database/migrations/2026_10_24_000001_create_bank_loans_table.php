<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Forward Reconciliation Migration: bank_loans
 *
 * Captures live MySQL schema for bank_loans (previously unmigrated).
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
        if (!Schema::hasTable('bank_loans')) {
            Schema::create('bank_loans', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('shareholder_id')->nullable()->index('bank_loans_shareholder_id_foreign');
                $table->string('bank_name', 191)->nullable();
                $table->decimal('loan_amount', 15, 2)->default(0.00);
                $table->decimal('interest_rate', 5, 2)->default(0.00);
                $table->integer('loan_term_months')->default(0);
                $table->date('loan_date')->nullable();
                $table->date('maturity_date')->nullable();
                $table->integer('installment_count')->default(0);
                $table->decimal('savings_amount', 15, 2)->default(0.00);
                $table->string('status', 191)->default('active');
                $table->text('remarks')->nullable();
                $table->unsignedBigInteger('created_by')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        } else {
            Schema::table('bank_loans', function (Blueprint $table) {
                if (!Schema::hasColumn('bank_loans', 'shareholder_id')) {
                    $table->unsignedBigInteger('shareholder_id')->nullable()->index('bank_loans_shareholder_id_foreign');
                }
                if (!Schema::hasColumn('bank_loans', 'bank_name')) {
                    $table->string('bank_name', 191)->nullable();
                }
                if (!Schema::hasColumn('bank_loans', 'loan_amount')) {
                    $table->decimal('loan_amount', 15, 2)->default(0.00);
                }
                if (!Schema::hasColumn('bank_loans', 'interest_rate')) {
                    $table->decimal('interest_rate', 5, 2)->default(0.00);
                }
                if (!Schema::hasColumn('bank_loans', 'loan_term_months')) {
                    $table->integer('loan_term_months')->default(0);
                }
                if (!Schema::hasColumn('bank_loans', 'loan_date')) {
                    $table->date('loan_date')->nullable();
                }
                if (!Schema::hasColumn('bank_loans', 'maturity_date')) {
                    $table->date('maturity_date')->nullable();
                }
                if (!Schema::hasColumn('bank_loans', 'installment_count')) {
                    $table->integer('installment_count')->default(0);
                }
                if (!Schema::hasColumn('bank_loans', 'savings_amount')) {
                    $table->decimal('savings_amount', 15, 2)->default(0.00);
                }
                if (!Schema::hasColumn('bank_loans', 'status')) {
                    $table->string('status', 191)->default('active');
                }
                if (!Schema::hasColumn('bank_loans', 'remarks')) {
                    $table->text('remarks')->nullable();
                }
                if (!Schema::hasColumn('bank_loans', 'created_by')) {
                    $table->unsignedBigInteger('created_by')->nullable();
                }
                if (!Schema::hasColumn('bank_loans', 'created_at')) {
                    $table->timestamps();
                }
                if (!Schema::hasColumn('bank_loans', 'deleted_at')) {
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
        Schema::dropIfExists('bank_loans');
    }
};
