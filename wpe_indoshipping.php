<?php
/*
 Plugin Name: WPE Indoshipping
 Plugin URI: http://balitechy.com/wp-plugins/wp-ecommerce-indoshipping/
 Description: Indonesian typical Shipping Module For WP E-Commerce
 Version: 2.5.0
 Author: Putu Eka Putra
 Author URI: http://balitechy.com/

 This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, version 2.
 This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
*/

/* Include Plugin config */
include 'settings.php';

/* Plugin DB install */
function wpei_install_db(){
	global $wpdb, $app_db_province,$app_db_city;

	if($wpdb->get_var("show tables like '$app_db_province'") != $app_db_province ) {

        $sql = "CREATE TABLE $app_db_province (
         id int(11) NOT NULL AUTO_INCREMENT,
         province_name varchar(255) NOT NULL,
         status tinyint(4) NOT NULL DEFAULT '1',
         PRIMARY KEY (id),
         UNIQUE KEY province_name (province_name)
        );";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

	if($wpdb->get_var("show tables like '$app_db_city'") != $app_db_city ) {
        $sql2 = "CREATE TABLE $app_db_city (
        id int(11) NOT NULL AUTO_INCREMENT,
        city_name varchar(255) NOT NULL,
        shipping_rate float NOT NULL,
        province_id int(11) NOT NULL,
        PRIMARY KEY (id)
        );";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql2);
    }
}

register_activation_hook(__FILE__,'wpei_install_db');

/* Include Admin UI */
include $app_base_path.'admin/admin.php';

/* Register plugin's Style and Scripts */
function indosEnqueue() {
    global $app_base_url;

	if(! is_admin()){
	    wp_register_style('indoshipping_css',$app_base_url.'assets/indoshipping.css');
	    wp_register_script('indoshipping_js',$app_base_url.'assets/indoshipping.js',array('jquery'));
	    wp_localize_script('indoshipping_js','indoshipping',array('pluginurl'=>$app_base_url,'ajaxurl'=>admin_url('admin-ajax.php')));
	    wp_enqueue_style('indoshipping_css');
	    wp_enqueue_script('indoshipping_js');
	}
}
add_action('wp_enqueue_scripts', 'indosEnqueue');

/* Load Province */
function wpei_load_province_html(){
    global $wpsc_cart;
    $kota = null;
    if($wpsc_cart->selected_shipping_method == 'wpe_indoshipping'):
        $k = $wpsc_cart->selected_shipping_option;
        $kota = wpei_kota_by_name($k);
    endif;
    $results = wpei_get_all_province();

	$html = '<td colspan="3">';
	$html.='<select name="sel_propinsi" id="sel_propinsi" onchange="wpei_get_kota(this.value, \'onchange\');">'."\n";
    if($kota == null){
	    $html.='<option value="0" selected="selected">Provinsi</option>'."\n";
    }
   	foreach($results as $prop){
        if($kota != null && $kota->province_id == $prop->id){
    	    $html.='<option value="'.$prop->id.'" selected="selected">'.$prop->province_name.'</option>'."\n";
        }else{
            $html.='<option value="'.$prop->id.'">'.$prop->province_name.'</option>'."\n";
        }
	}
	$html .='</select>&nbsp;<select name="sel_kota" id="sel_kota" onchange="switchmethod(this.value, \'wpe_indoshipping\');"><option value="0">Kota</option></select></td>';
    $html .='<td></td><td></td>';
    die ($html);
}

/* Load City */
function wpei_load_all_kota(){
    $province_id = $_GET['prov_id'];
    global $wpdb, $app_db_province, $app_db_city, $wpsc_cart;

    $listkota= array('current_kota'=>'', 'list_kota'=> array());
    $kotas = wpei_get_kota_by_provid($province_id);
    
    if($wpsc_cart->selected_shipping_method == 'wpe_indoshipping'):
        $k = $wpsc_cart->selected_shipping_option;
    endif;
    
    $listkota['current_kota'] = $k;
    
    if(count($kotas) > 0){
        foreach($kotas as $keys=>$vals){
            $listkota['list_kota'][] = array('kota_id'=>$vals->id,'kota_name'=>$vals->city_name, 'ongkir'=>number_format($vals->shipping_rate));
        }
    }else{
        $listkota['list_kota'][] = array('kota_id'=>0, 'kota_name'=>'Kota', 'ongkir'=>'0');
    }
    die(json_encode($listkota));
}


add_action('wp_ajax_GETKOTA','wpei_load_all_kota');
add_action('wp_ajax_nopriv_GETKOTA','wpei_load_all_kota');


add_action('wp_ajax_nopriv_LOADPROVINCE','wpei_load_province_html');
add_action('wp_ajax_LOADPROVINCE','wpei_load_province_html');

//======================== Main Shipping Class ===============================//

class wpe_indoshipping {

	var $internal_name;
	var $name;
	var $is_external;

	function wpe_indoshipping () {

		$this->internal_name = "wpe_indoshipping";
		$wpei_shippingname = get_option('wpe_shippingname_neo');

		if(!$wpei_shippingname){
		    $this->name = 'WPE Indoshipping';
		    }else{
		    $this->name = $wpei_shippingname;
            }
		$this->is_external = true;
		return true;
	}

	function getName() {
		return $this->name;
	}

	function getInternalName() {
		return $this->internal_name;
	}

	function getForm() {

		$wpei_shippingname = get_option('wpe_shippingname_neo');

		$output = '<tr>';
		$output .= '<td>';
		$output .= '<p style="color:red;"><strong>WARNING</strong>: Selalu ingat men-set berat produk anda. Apabila satu saja berat produk anda di Cart = 0, maka hasil perhitungan ongkir menjadi 0. Secara default ongkir akan dihitung 1 Kg.</p>';
		$output .= '<p><strong>Apabila hal diatas terjadi, developer/plugin tidak bertanggung jawab atas kesalahan/kerugian yang terjadi karena ongkir yang tidak akurat.</strong></p>';
		$output .= '</td>';
		$output .= '</tr>';

		$output .= '<tr>';
		$output .= '<td>';
		$output .= 'Shipping Name:<br/>';
		$output .= '<input type="text" name="wpe_indoshipping_name" value="'.$wpei_shippingname.'"><input type="hidden" name="indoshipping" value="1"/><br/>';
		$output .= '</td>';
		$output .= '</tr>';

		return $output;
	}

	function submit_form() {

		if($_POST['indoshipping'] == 1) {
			$shipping_name = $_POST['wpe_indoshipping_name'];
			update_option('wpe_shippingname_neo',$shipping_name);
		}
		return true;
	}

	function get_item_shipping(&$cart_item) {
	}

	function getQuote() {
		
		$_SESSION['wpsc_delivery_country'] = 'ID';

		if (isset($_POST['country'])) {
			$country = $_POST['country'];
			$_SESSION['wpsc_delivery_country'] = $country;
		} else {
			$country = $_SESSION['wpsc_delivery_country'];
		}

		if($country == 'ID'):
		    $weight_in_pound = wpsc_cart_weight_total();
		    $weight_in_kgs_float = (float)$weight_in_pound / 2.205;
		    $weight_in_kgs_round = round((float)$weight_in_pound / 2.205);
		    if($weight_in_kgs_round < $weight_in_kgs_float){
		        $weight_in_kgs = $weight_in_kgs_round + 1;
		    }else if($weight_in_kgs_round == 0){
		        $weight_in_kgs = 1;
		    }else{
		        $weight_in_kgs = $weight_in_kgs_round;
		    }
            return $this->load_all_kota($weight_in_kgs);
        else:
            return array(null=>null);
        endif;
	}

    function load_all_kota($weight){
        global $wpdb, $app_db_province, $app_db_city;
        $listkota = array();
        $provinsi = wpei_get_all_province();
        foreach($provinsi as $key=>$val){
                $kotas = wpei_get_kota_by_provid($val->id);
                foreach($kotas as $keys=>$vals){
                    $listkota[$vals->city_name] = $vals->shipping_rate*$weight;
                    }
            }
        return $listkota;
    }
}

$wpe_indoshipping = new wpe_indoshipping();
$wpsc_shipping_modules[$wpe_indoshipping->getInternalName()] = $wpe_indoshipping;
?>
