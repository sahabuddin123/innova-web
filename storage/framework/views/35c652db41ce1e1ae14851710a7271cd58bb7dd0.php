<div class="tile">
    <form action="<?php echo e(route('admin.settings.update')); ?>" method="POST" role="form">
        <?php echo csrf_field(); ?>
        <h3 class="tile-title">UI/Theme Settings</h3>
        <hr>
        <div class="tile-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="admin_theme_color">Sidebar Theme Color</label>
                        <select class="form-control" id="admin_theme_color" name="admin_theme_color">
                            <option value="gradient-purple" <?php echo e(config('settings.admin_theme_color') == 'gradient-purple' ? 'selected' : ''); ?>>Purple Gradient (Default)</option>
                            <option value="gradient-blue" <?php echo e(config('settings.admin_theme_color') == 'gradient-blue' ? 'selected' : ''); ?>>Blue Gradient</option>
                            <option value="gradient-green" <?php echo e(config('settings.admin_theme_color') == 'gradient-green' ? 'selected' : ''); ?>>Green Gradient</option>
                            <option value="gradient-dark" <?php echo e(config('settings.admin_theme_color') == 'gradient-dark' ? 'selected' : ''); ?>>Dark Gradient</option>
                            <option value="glass" <?php echo e(config('settings.admin_theme_color') == 'glass' ? 'selected' : ''); ?>>Glass Effect</option>
                            <option value="light" <?php echo e(config('settings.admin_theme_color') == 'light' ? 'selected' : ''); ?>>Light Theme</option>
                        </select>
                        <small class="text-muted">Select the sidebar color theme</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="admin_accent_color">Accent Color</label>
                        <input type="color" class="form-control" id="admin_accent_color" name="admin_accent_color" value="<?php echo e(config('settings.admin_accent_color') ?? '#667eea'); ?>">
                        <small class="text-muted">Primary accent color for buttons & highlights</small>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="admin_font_family">Font Family</label>
                        <select class="form-control" id="admin_font_family" name="admin_font_family">
                            <option value="default" <?php echo e(config('settings.admin_font_family') == 'default' ? 'selected' : ''); ?>>System Default</option>
                            <option value="poppins" <?php echo e(config('settings.admin_font_family') == 'poppins' ? 'selected' : ''); ?>>Poppins</option>
                            <option value="roboto" <?php echo e(config('settings.admin_font_family') == 'roboto' ? 'selected' : ''); ?>>Roboto</option>
                            <option value="open-sans" <?php echo e(config('settings.admin_font_family') == 'open-sans' ? 'selected' : ''); ?>>Open Sans</option>
                            <option value="noto-sans" <?php echo e(config('settings.admin_font_family') == 'noto-sans' ? 'selected' : ''); ?>>Noto Sans (Bengali)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="admin_border_radius">Border Radius</label>
                        <select class="form-control" id="admin_border_radius" name="admin_border_radius">
                            <option value="0" <?php echo e(config('settings.admin_border_radius') == '0' ? 'selected' : ''); ?>>Square (0px)</option>
                            <option value="4" <?php echo e(config('settings.admin_border_radius') == '4' ? 'selected' : ''); ?>>Small (4px)</option>
                            <option value="8" <?php echo e(config('settings.admin_border_radius') == '8' ? 'selected' : ''); ?>>Medium (8px)</option>
                            <option value="12" <?php echo e(config('settings.admin_border_radius') == '12' ? 'selected' : ''); ?>>Large (12px)</option>
                            <option value="20" <?php echo e(config('settings.admin_border_radius') == '20' ? 'selected' : ''); ?>>Rounded (20px)</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">UI Effects</label>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="admin_glass_effect" name="admin_glass_effect" value="1" <?php echo e(config('settings.admin_glass_effect') == '1' ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="admin_glass_effect">Enable Glass Effect</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="admin_shadow_effect" name="admin_shadow_effect" value="1" <?php echo e(config('settings.admin_shadow_effect') == '1' ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="admin_shadow_effect">Enable Shadow Effects</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="admin_animation" name="admin_animation" value="1" <?php echo e(config('settings.admin_animation') == '1' ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="admin_animation">Enable Animations</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="admin_card_style">Card Style</label>
                        <select class="form-control" id="admin_card_style" name="admin_card_style">
                            <option value="default" <?php echo e(config('settings.admin_card_style') == 'default' ? 'selected' : ''); ?>>Default</option>
                            <option value="flat" <?php echo e(config('settings.admin_card_style') == 'flat' ? 'selected' : ''); ?>>Flat</option>
                            <option value="modern" <?php echo e(config('settings.admin_card_style') == 'modern' ? 'selected' : ''); ?>>Modern</option>
                            <option value="glass" <?php echo e(config('settings.admin_card_style') == 'glass' ? 'selected' : ''); ?>>Glass</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label" for="admin_custom_css">Custom CSS</label>
                        <textarea class="form-control" id="admin_custom_css" name="admin_custom_css" rows="4" placeholder="Enter custom CSS for admin panel"><?php echo e(config('settings.admin_custom_css') ?? ''); ?></textarea>
                        <small class="text-muted">Add custom CSS to override default styles</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="tile-footer">
            <div class="row d-print-none mt-2">
                <div class="col-12 text-right">
                    <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update UI Settings</button>
                </div>
            </div>
        </div>
    </form>
</div><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/settings/includes/ui_theme.blade.php ENDPATH**/ ?>