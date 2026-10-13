<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddUiThemeSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $settings = [
            ['admin_theme_color', 'gradient-purple'],
            ['admin_accent_color', '#667eea'],
            ['admin_font_family', 'default'],
            ['admin_border_radius', '8'],
            ['admin_glass_effect', '0'],
            ['admin_shadow_effect', '1'],
            ['admin_animation', '1'],
            ['admin_card_style', 'default'],
            ['admin_custom_css', ''],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting[0]],
                ['value' => $setting[1], 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $keys = [
            'admin_theme_color',
            'admin_accent_color',
            'admin_font_family',
            'admin_border_radius',
            'admin_glass_effect',
            'admin_shadow_effect',
            'admin_animation',
            'admin_card_style',
            'admin_custom_css',
        ];

        DB::table('settings')->whereIn('key', $keys)->delete();
    }
}