<?php
/*
 *  Plugin Name: Custom Social
 *  Plugin URI: http://wordpress.org/extend/plugins/custom-social/
 *  Version: 0.1
 *  Author: <a href="http://alexobenauer.com/">Alexander O</a>
 *  Description: Set custom messages for tweeting links
 *  Text Domain: custom-social
 *  License: GPLv3
 */

$CustomSocial_minimalRequiredPhpVersion = '5.0';

/**
 * Check the PHP version and give a useful error message if the user's version is less than the required version
 * @return boolean true if version check passed. If false, triggers an error which WP will handle, by displaying
 * an error message on the Admin page
 */
function CustomSocial_noticePhpVersionWrong() {
    global $CustomSocial_minimalRequiredPhpVersion;
    echo '<div class="updated fade">' .
      __('Error: plugin "Custom Social" requires a newer version of PHP to be running.',  'custom-social').
            '<br/>' . __('Minimal version of PHP required: ', 'custom-social') . '<strong>' . $CustomSocial_minimalRequiredPhpVersion . '</strong>' .
            '<br/>' . __('Your server\'s PHP version: ', 'custom-social') . '<strong>' . phpversion() . '</strong>' .
         '</div>';
}


function CustomSocial_PhpVersionCheck() {
    global $CustomSocial_minimalRequiredPhpVersion;
    if (version_compare(phpversion(), $CustomSocial_minimalRequiredPhpVersion) < 0) {
        add_action('admin_notices', 'CustomSocial_noticePhpVersionWrong');
        return false;
    }
    return true;
}


/**
 * Initialize internationalization (i18n) for this plugin.
 * References:
 *      http://codex.wordpress.org/I18n_for_WordPress_Developers
 *      http://www.wdmac.com/how-to-create-a-po-language-translation#more-631
 * @return void
 */
function CustomSocial_i18n_init() {
    $pluginDir = dirname(plugin_basename(__FILE__));
    load_plugin_textdomain('custom-social', false, $pluginDir . '/languages/');
}


//////////////////////////////////
// Run initialization
/////////////////////////////////

// First initialize i18n
CustomSocial_i18n_init();


// Next, run the version check.
// If it is successful, continue with initialization for this plugin
if (CustomSocial_PhpVersionCheck()) {
    // Only load and run the init function if we know PHP version can parse it
    include_once('custom-social_init.php');
    CustomSocial_init(__FILE__);
}
