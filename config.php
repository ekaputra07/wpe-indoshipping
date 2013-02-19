<?php
/*
 * Base configuration for plugins
 */
global $app_prefix, $app_base_path, $app_base_url, $app_admin_base_url;
$app_prefix = 'wpei_';
$app_base_path = dirname(__FILE__).'/';
$app_base_url = plugin_dir_url(__FILE__);
$app_admin_base_url = plugin_dir_url(__FILE__).'admin/';

/*
 * Global Database parameter
 */

global $app_db_province, $app_db_city;
$app_db_province = $app_prefix.'province';
$app_db_city = $app_prefix.'city';


/*
 * Global Option page parameter and admin menu
 */

global $app_menu_slug_setting, $app_menu_slug_manage;
$app_menu_slug_setting = $app_prefix.'settings';
$app_menu_slug_manage = $app_prefix.'manage';
?>
