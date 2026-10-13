<div class="tile">
    <form action="{{ route('admin.settings.update') }}" method="POST" role="form">
        @csrf
        <h3 class="tile-title">UI/Theme Settings</h3>
        <hr>
        <div class="tile-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="admin_theme_color">Sidebar Theme Color</label>
                        <select class="form-control" id="admin_theme_color" name="admin_theme_color">
                            <option value="gradient-purple" {{ config('settings.admin_theme_color') == 'gradient-purple' ? 'selected' : '' }}>Purple Gradient (Default)</option>
                            <option value="gradient-blue" {{ config('settings.admin_theme_color') == 'gradient-blue' ? 'selected' : '' }}>Blue Gradient</option>
                            <option value="gradient-green" {{ config('settings.admin_theme_color') == 'gradient-green' ? 'selected' : '' }}>Green Gradient</option>
                            <option value="gradient-dark" {{ config('settings.admin_theme_color') == 'gradient-dark' ? 'selected' : '' }}>Dark Gradient</option>
                            <option value="glass" {{ config('settings.admin_theme_color') == 'glass' ? 'selected' : '' }}>Glass Effect</option>
                            <option value="light" {{ config('settings.admin_theme_color') == 'light' ? 'selected' : '' }}>Light Theme</option>
                        </select>
                        <small class="text-muted">Select the sidebar color theme</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="admin_accent_color">Accent Color</label>
                        <input type="color" class="form-control" id="admin_accent_color" name="admin_accent_color" value="{{ config('settings.admin_accent_color') ?? '#667eea' }}">
                        <small class="text-muted">Primary accent color for buttons & highlights</small>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="admin_font_family">Font Family</label>
                        <select class="form-control" id="admin_font_family" name="admin_font_family">
                            <option value="default" {{ config('settings.admin_font_family') == 'default' ? 'selected' : '' }}>System Default</option>
                            <option value="poppins" {{ config('settings.admin_font_family') == 'poppins' ? 'selected' : '' }}>Poppins</option>
                            <option value="roboto" {{ config('settings.admin_font_family') == 'roboto' ? 'selected' : '' }}>Roboto</option>
                            <option value="open-sans" {{ config('settings.admin_font_family') == 'open-sans' ? 'selected' : '' }}>Open Sans</option>
                            <option value="noto-sans" {{ config('settings.admin_font_family') == 'noto-sans' ? 'selected' : '' }}>Noto Sans (Bengali)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="admin_border_radius">Border Radius</label>
                        <select class="form-control" id="admin_border_radius" name="admin_border_radius">
                            <option value="0" {{ config('settings.admin_border_radius') == '0' ? 'selected' : '' }}>Square (0px)</option>
                            <option value="4" {{ config('settings.admin_border_radius') == '4' ? 'selected' : '' }}>Small (4px)</option>
                            <option value="8" {{ config('settings.admin_border_radius') == '8' ? 'selected' : '' }}>Medium (8px)</option>
                            <option value="12" {{ config('settings.admin_border_radius') == '12' ? 'selected' : '' }}>Large (12px)</option>
                            <option value="20" {{ config('settings.admin_border_radius') == '20' ? 'selected' : '' }}>Rounded (20px)</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">UI Effects</label>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="admin_glass_effect" name="admin_glass_effect" value="1" {{ config('settings.admin_glass_effect') == '1' ? 'checked' : '' }}>
                            <label class="custom-control-label" for="admin_glass_effect">Enable Glass Effect</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="admin_shadow_effect" name="admin_shadow_effect" value="1" {{ config('settings.admin_shadow_effect') == '1' ? 'checked' : '' }}>
                            <label class="custom-control-label" for="admin_shadow_effect">Enable Shadow Effects</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="admin_animation" name="admin_animation" value="1" {{ config('settings.admin_animation') == '1' ? 'checked' : '' }}>
                            <label class="custom-control-label" for="admin_animation">Enable Animations</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="admin_card_style">Card Style</label>
                        <select class="form-control" id="admin_card_style" name="admin_card_style">
                            <option value="default" {{ config('settings.admin_card_style') == 'default' ? 'selected' : '' }}>Default</option>
                            <option value="flat" {{ config('settings.admin_card_style') == 'flat' ? 'selected' : '' }}>Flat</option>
                            <option value="modern" {{ config('settings.admin_card_style') == 'modern' ? 'selected' : '' }}>Modern</option>
                            <option value="glass" {{ config('settings.admin_card_style') == 'glass' ? 'selected' : '' }}>Glass</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label" for="admin_custom_css">Custom CSS</label>
                        <textarea class="form-control" id="admin_custom_css" name="admin_custom_css" rows="4" placeholder="Enter custom CSS for admin panel">{{ config('settings.admin_custom_css') ?? '' }}</textarea>
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
</div>