<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWhatsappCallTypeToAssetRegistrationsTable extends Migration
{
    public function up()
    {
        Schema::table('asset_registrations', function (Blueprint $table) {
            $table->string('whatsapp')->nullable()->after('mobile');
            $table->string('call_type')->nullable()->after('whatsapp');
        });
    }

    public function down()
    {
        Schema::table('asset_registrations', function (Blueprint $table) {
            $table->dropColumn(['whatsapp', 'call_type']);
        });
    }
}
