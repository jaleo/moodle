<?php

/**
 * EN:Settings for the cafe_con_leche theme
 * SP:Configuracion para el tema cafe_con_leche theme. Las zonas escritas en español son novedades con respecto al tema Decaf.
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

	// Selección de logotipo
    $name = 'theme_cafe_con_leche/logotipo';
    $title = get_string('logo','theme_cafe_con_leche');
    $description = get_string('logodesc', 'theme_cafe_con_leche');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logotipo');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);
	
	// Imagen de fondo de cabecera
    $name = 'theme_cafe_con_leche/fondo_cabecera';
    $title = get_string('fondo_cabecera', 'theme_cafe_con_leche');
    $description = get_string('fondo_cabecera_desc', 'theme_cafe_con_leche');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'fondo_cabecera');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);
	
	// Favicon
    $name = 'theme_cafe_con_leche/favicon';
    $title = get_string('favicon', 'theme_cafe_con_leche');
    $description = get_string('favicon_desc', 'theme_cafe_con_leche');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'favicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);
	
    // Background colour setting
	$name = 'theme_cafe_con_leche/backgroundcolor';
    $title = get_string('backgroundcolor','theme_cafe_con_leche');
    $description = get_string('backgroundcolordesc', 'theme_cafe_con_leche');
    $default = '#FFF';
    $previewconfig = array('selector'=>'html', 'style'=>'backgroundColor');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $settings->add($setting);
    
	// Color de fondo de cabecera
    $name = 'theme_cafe_con_leche/cabecerabackgroundcolor';
    $title = get_string('cabecerabackgroundcolor','theme_cafe_con_leche');
    $description = get_string('cabecerabackgroundcolordesc', 'theme_cafe_con_leche');
    $default = '#BEBA82';
	$previewconfig = array('selector'=>'#page-header', 'style'=>'backgroundColor');
	//$previewconfig = array('selector'=>'header', 'style'=>'backgroundColor');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $settings->add($setting);

    // Foot note setting
    $name = 'theme_cafe_con_leche/footnote';
    $title = get_string('footnote','theme_cafe_con_leche');
    $description = get_string('footnotedesc', 'theme_cafe_con_leche');
    $setting = new admin_setting_confightmleditor($name, $title, $description, '');
    $settings->add($setting);

    // Custom CSS file
    $name = 'theme_cafe_con_leche/customcss';
    $title = get_string('customcss','theme_cafe_con_leche');
    $description = get_string('customcssdesc', 'theme_cafe_con_leche');
    $setting = new admin_setting_configtextarea($name, $title, $description, '');
    $settings->add($setting);
    
    // Show user profile picture
    $name = 'theme_cafe_con_leche/showuserpicture';
    $title = get_string('showuserpicture','theme_cafe_con_leche');
    $description = get_string('showuserpicturedesc', 'theme_cafe_con_leche');
    $default = 0;
    $choices = array(1=>'Yes', 0=>'No');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

    // Editing Mode heading
    $settings->add(new admin_setting_heading('themecafe_con_lecheeditingsettings', get_string('editingsettings', 'theme_cafe_con_leche'), get_string('editingsettingsdesc', 'theme_cafe_con_leche')));

    // Enable mod chooser "tiles"
    $name = 'theme_cafe_con_leche/usemodchoosertiles';
    $title = get_string('usemodchoosertiles','theme_cafe_con_leche');
    $description = get_string('usemodchoosertilesdesc', 'theme_cafe_con_leche');
    $default = 0;
    $choices = array(0=>'No', 1=>'Yes');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

    // Enable edit buttons (replace rows of icons)
    $name = 'theme_cafe_con_leche/useeditbuttons';
    $title = get_string('useeditbuttons','theme_cafe_con_leche');
    $description = get_string('useeditbuttonsdesc', 'theme_cafe_con_leche');
    $default = 1;
    $choices = array(1=>'Yes', 0=>'No');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

    // Enable "persistent editing mode" (no need to turn on/off edit mode)
    $name = 'theme_cafe_con_leche/persistentedit';
    $title = get_string('persistentedit','theme_cafe_con_leche');
    $description = get_string('persistenteditdesc', 'theme_cafe_con_leche');
    $default = 0;
    $choices = array(0=>'No', 1=>'Yes');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

    // Awesomebar / Navigation heading
    $settings->add(new admin_setting_heading('themecafe_con_lecheawesombarsettings', get_string('awesomebarsettings', 'theme_cafe_con_leche'), get_string('awesomebarsettingsdesc', 'theme_cafe_con_leche')));

    // Hide Settings block
    $name = 'theme_cafe_con_leche/hidesettingsblock';
    $title = get_string('hidesettingsblock','theme_cafe_con_leche');
    $description = get_string('hidesettingsblockdesc', 'theme_cafe_con_leche');
    $default = 1;
    $choices = array(1=>'Yes', 0=>'No');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

    // Hide Navigation block
    $name = 'theme_cafe_con_leche/hidenavigationblock';
    $title = get_string('hidenavigationblock','theme_cafe_con_leche');
    $description = get_string('hidenavigationblockdesc', 'theme_cafe_con_leche');
    $default = 0;
    $choices = array(1=>'Yes', 0=>'No');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

    // Add custom menu to Awesomebar
    $name = 'theme_cafe_con_leche/custommenuinawesomebar';
    $title = get_string('custommenuinawesomebar','theme_cafe_con_leche');
    $description = get_string('custommenuinawesomebardesc', 'theme_cafe_con_leche');
    $default = 0;
    $choices = array(1=>'Yes', 0=>'No');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

    // Place custom menu after Awesomebar
    $name = 'theme_cafe_con_leche/custommenuafterawesomebar';
    $title = get_string('custommenuafterawesomebar','theme_cafe_con_leche');
    $description = get_string('custommenuafterawesomebardesc', 'theme_cafe_con_leche');
    $default = 0;
    $choices = array(0=>'No', 1=>'Yes');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

    // Hide courses menu from non-logged-in users
    $name = 'theme_cafe_con_leche/coursesloggedinonly';
    $title = get_string('coursesloggedinonly','theme_cafe_con_leche');
    $description = get_string('coursesloggedinonlydesc', 'theme_cafe_con_leche');
    $default = 0;
    $choices = array(0=>'No', 1=>'Yes');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

    // Don't actually show courses under "Courses" menu item
    $name = 'theme_cafe_con_leche/coursesleafonly';
    $title = get_string('coursesleafonly','theme_cafe_con_leche');
    $description = get_string('coursesleafonlydesc', 'theme_cafe_con_leche');
    $default = 0;
    $choices = array(0=>'Yes', 1=>'No'); // This seems backwards, but makes it easier for users to understand as it eliminates the double-negative.
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

    // Expand to activities at cost of performance
    $name = 'theme_cafe_con_leche/expandtoactivities';
    $title = get_string('expandtoactivities','theme_cafe_con_leche');
    $description = get_string('expandtoactivitiesdesc', 'theme_cafe_con_leche');
    $default = 0;
    $choices = array(0=>'No', 1=>'Yes');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);
   

}