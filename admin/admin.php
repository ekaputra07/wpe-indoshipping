<?php
/*
 * Includes Admin Functions
 */
include $app_base_path.'admin/admin-functions.php';

/*
 * Create Menu for admin
 */
function wpei_render_province_city(){
    global $app_prefix, $app_base_path, $app_base_url;
    global $app_db_province, $app_db_city;
    global $app_menu_slug_setting, $app_menu_slug_manage;
    global $wpdb;

    include $app_base_path.'admin/shipping-manager.php';
}

function wpei_render_plugin_options(){
    global $app_prefix, $app_base_path, $app_base_url;
    global $app_db_province, $app_db_city;
    global $app_menu_slug_setting, $app_menu_slug_manage;
    global $wpdb;
    include $app_base_path.'admin/form-builder.php';
}

function wpei_render_tools(){
    global $app_prefix, $app_base_path, $app_base_url;
    global $app_db_province, $app_db_city;
    global $app_menu_slug_setting, $app_menu_slug_manage;
    global $wpdb;

    include $app_base_path.'admin/tools.php';
}

function wpei_render_about(){
    global $app_base_path;
    include $app_base_path.'assets/readme.html';
}

function wpei_render_menu(){
    global $app_menu_slug_setting, $app_menu_slug_manage;

    add_menu_page('IndoShipping', 'IndoShipping', 'manage_options',$app_menu_slug_manage, 'wpei_render_province_city');
    add_submenu_page($app_menu_slug_manage, 'Manage', 'Manage','manage_options',$app_menu_slug_manage, 'wpei_render_province_city');
    add_submenu_page($app_menu_slug_manage, 'Tools', 'Tools','manage_options','wpei_tools', 'wpei_render_tools');
}

/*
 * Load Styles and Scripts
 */
function load_admin_style_script(){
global $app_prefix, $app_base_path, $app_base_url, $app_admin_base_url;
wp_enqueue_style("wpei_admin_style", $app_admin_base_url."css/admin.css");
wp_enqueue_script("wpei_admin_script", $app_admin_base_url."js/admin.js", array('jquery'));
wp_localize_script('wpei_admin_script','indoshipping_vars',array('pluginurl'=>$app_base_url,'ajaxurl'=>admin_url('admin-ajax.php')));
wp_enqueue_style('thickbox');
wp_enqueue_script('thickbox');
}

/*
 * Built our Admin page
 */
add_action('admin_init','load_admin_style_script');
add_action('admin_menu','wpei_render_menu');
?>
