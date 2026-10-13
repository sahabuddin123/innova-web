<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegistrationStatusToAssetRegistrationsTable extends Migration
{
    public function up()
    {
        Schema::table('asset_registrations', function (Blueprint $table) {
            if (!Schema::hasColumn('asset_registrations', 'registration_status')) {
                $table->string('registration_status')->default('Pending')->after('photo');
            }
        });
    }

    public function down()
    {
        Schema::table('asset_registrations', function (Blueprint $table) {
            if (Schema::hasColumn('asset_registrations', 'registration_status')) {
                $table->dropColumn('registration_status');
            }
        });
    }
}
