<?php
/*
 * Admin functions Wrapper
 * Wrapping all functions used by Indoshipping Admin panel
 */

function wpei_get_all_province(){
    global $wpdb, $app_db_province;
    $results = array();
    $query = "SELECT * FROM {$app_db_province} ORDER BY province_name";
    $results = $wpdb->get_results($query);
    return $results;
}

function wpei_kota_by_name($kota){
    global $wpdb, $app_db_city;
    $query = "SELECT * FROM {$app_db_city} WHERE city_name='{$kota}'";
    $kota = $wpdb->get_row($query);
    if($kota){
        return $kota;
    }else{
        return null;
    }
}

function wpei_ajax_add_province(){
    global $wpdb, $app_db_province;
    $province_name = $_POST['province_name'];
    $record = array('province_name'=>$province_name);

    if($wpdb->insert($app_db_province,$record)){
        echo '1';
        exit;
        }else{
        echo '0';
        exit;
        }
}

function wpei_ajax_del_province(){
    global $wpdb, $app_db_province, $app_db_city;
    $province_id = $_POST['id'];
    $query = "DELETE $app_db_province,$app_db_city FROM $app_db_province LEFT JOIN $app_db_city ON $app_db_city.province_id=$app_db_province.id WHERE $app_db_province.id=$province_id";

   if($wpdb->query($query)){
        echo '1';
        exit;
        }else{
        echo '0';
        exit;
        }
}

function wpei_ajax_updt_province(){
    global $wpdb, $app_db_province;
    $province_id = $_POST['id'];
    $province_newname = $_POST['new_name'];
    $record = array('province_name'=>$province_newname);
    $where = array('id'=>$province_id);

       if($wpdb->update($app_db_province,$record,$where)){
        echo '1';
        exit;
        }else{
        echo '0';
        exit;
        }

}

function wpei_ajax_add_city(){
    global $wpdb, $app_db_city;
    $city_name = $_POST['city_name'];
    $shipping_rate = trim($_POST['shipping_rate']);
    $shipping_rate = str_replace('.','',$shipping_rate ); //remove dot
    $shipping_rate = str_replace(',','',$shipping_rate ); //remove comma
    $province_id = $_POST['province_id'];
    $record = array(
        'city_name'=>$city_name,
        'shipping_rate'=>$shipping_rate,
        'province_id'=>$province_id
        );

    if($wpdb->insert($app_db_city,$record)){
        echo '1';
        exit;
        }else{
        echo '0';
        exit;
        }
}

function wpei_get_kota_by_provid($id){
    global $wpdb, $app_db_city;
    $query = "SELECT * FROM {$app_db_city} WHERE province_id={$id}";
    $results = $wpdb->get_results($query);
    return $results;
}

function wpei_get_numkota_by_provid($id){
    global $wpdb, $app_db_city;
    $query = "SELECT COUNT(*) FROM {$app_db_city} WHERE province_id={$id}";
    $result = $wpdb->get_var($query);
    return $result;
}

function wpei_delete_all(){
    global $wpdb, $app_db_province, $app_db_city;
    $query = "DELETE $app_db_province,$app_db_city FROM $app_db_province LEFT JOIN $app_db_city ON $app_db_city.province_id=$app_db_province.id";

   if($wpdb->query($query)){
        echo '1';
        exit;
        }else{
        echo '0';
        exit;
        }
}

function wpei_ajax_del_city(){
    global $wpdb, $app_db_city;
    $city_id = $_POST['id'];
    $query = "DELETE FROM $app_db_city WHERE id=$city_id";

   if($wpdb->query($query)){
        echo '1';
        exit;
        }else{
        echo '0';
        exit;
        }
}

function wpei_ajax_updt_city(){
    global $wpdb, $app_db_city;
    $id = $_POST['id'];
    $province_id = $_POST['province_id'];
    $city_name = $_POST['city_name'];
    $shipping_rate = trim($_POST['shipping_rate']);
    $shipping_rate = str_replace('.','',$shipping_rate ); //remove dot
    $shipping_rate = str_replace(',','',$shipping_rate ); //remove comma

    $record = array(
    'city_name'=>$city_name,
    'province_id'=>$province_id,
    'shipping_rate'=>$shipping_rate
    );

    $where = array('id'=>$id);

       if($wpdb->update($app_db_city,$record,$where)){
        echo '1';
        exit;
        }else{
        echo '0';
        exit;
        }
}

// DB Importer
function wpei_is_valid_dbfile(){
    global $app_prefix, $app_base_path, $app_base_url;
    global $app_db_province, $app_db_city;
    global $app_menu_slug_setting, $app_menu_slug_manage;
    global $wpdb;

    $dbfile = $_POST['dbfile'];
    if(! file_exists($app_base_path.'upload/'.$dbfile)){
        echo 'File daerah.db.php tidak ada di directory upload!';
        exit;
        }else{
        //process file here.
        include_once $app_base_path.'upload/'.$dbfile;
        if(is_array($daerah)){
            $count_prov = 0;
            $count_city = 0;
            foreach($daerah as $provinsi=>$kotas){ //import loops. any way better than this?
                $record = array('province_name'=>$provinsi);
                if($wpdb->insert($app_db_province,$record)):
                    $count_prov++;
                    $prov_id =$wpdb->insert_id;
                    foreach($kotas as $kota=>$ongkir):
                        $kota_record = array(
                        'city_name'=>$kota,
                        'shipping_rate'=>$ongkir,
                        'province_id'=>$prov_id
                        );
                        if($wpdb->insert($app_db_city,$kota_record)){
                            $count_city++;
                            }
                        endforeach;
                    endif;
                }
            die ($count_prov.' Provinsi dan '.$count_city.' Kota berhasil di Import.');
            }else{
            die ('Import gagal!, '.$dbfile.' tidak valid.');
            }
        }
}


class CSVImprter{

    public $filename;
    public $logs = array();
    
    function __construct($filename){
        $this->filename = $filename;
    }
    
    public function import_now(){
        global $app_db_province, $app_db_city;
        global $wpdb;
        
        $row = 0;
        $province = 0;
        
        if (($handle = fopen($this->filename, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $row++;
                if(!$data[0] && !$data[1] && !$data[2]){
                    //Its empty line, do nothing
                    $this->logs[] = "[$row] Baris kosong...";
                }else{
                                    
                    if($data[0] && $data[1] && $data[2]){
                        //This is head section of profince
                        $province_name = $data[0];
                        $city = $data[1];
                        $price = $data[2];
                        
                        $prov = array('province_name'=>$province_name);
                        
                        if($wpdb->insert($app_db_province, $prov)){
                            $province = $wpdb->insert_id;
                            $this->logs[] = "[$row] : === Prov. '$province_name' ===";
                        }else{
                            $this->logs[] = "[$row] : === Prov. '$province_name' (not imported, Duplicate) ===";
                        }
                        

                            
                        $kota = array(
                        'city_name'=>$city,
                        'shipping_rate'=>$price,
                        'province_id'=>$province
                        );
                        
                        if($wpdb->insert($app_db_city, $kota)){
                            $this->logs[] = "[$row] : imported '$city'";
                        }else{
                            $this->logs[] = "[$row] : not imported...";
                        }
    
                        
                    }else if(!$data[0] && $data[1] && $data[2]){
                    
                        $city = $data[1];
                        $price = $data[2];
                        
                        $kota = array(
                        'city_name'=>$city,
                        'shipping_rate'=>$price,
                        'province_id'=>$province
                        );
                        
                        if($wpdb->insert($app_db_city, $kota)){
                            $this->logs[] = "[$row] : imported '$city'";
                        }else{
                            $this->logs[] = "[$row] : not imported...";
                        }
                        
                    }else{
                        $this->logs[] = "[$row] : not imported...";
                    }
                }
            }
            fclose($handle);
        } 
    }
}

function wpei_csv_import(){
    global $app_prefix, $app_base_path, $app_base_url;

    $dbfile = $_POST['dbfile'];
    $csv_path = $app_base_path.'upload/'.$dbfile;
    
    if(file_exists($csv_path)){
        $importer = new CSVImprter($csv_path);
        $importer->import_now();
        $stat = implode('<br/>', $importer->logs);
        die($stat);
    }else{
        die ('Import gagal!, '.$dbfile.' tidak valid CSV.');
    }
}

/*
 * Handle Ajax Reqest
 */
add_action('wp_ajax_ADDPROVINCE','wpei_ajax_add_province');
add_action('wp_ajax_DELPROVINCE','wpei_ajax_del_province');
add_action('wp_ajax_UPDTPROVINCE','wpei_ajax_updt_province');
add_action('wp_ajax_ADDCITY','wpei_ajax_add_city');
add_action('wp_ajax_DELALL','wpei_delete_all');
add_action('wp_ajax_DELCITY','wpei_ajax_del_city');
add_action('wp_ajax_UPDTCITY','wpei_ajax_updt_city');
add_action('wp_ajax_DBIMPORT','wpei_csv_import');
?>
