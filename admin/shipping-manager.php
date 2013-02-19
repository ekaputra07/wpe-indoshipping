<div class="wrap">
<div class="options-header">
<div class="header-wrapper">
<h3>Manage Provinsi dan Kota &nbsp;&nbsp;<a href="javascript:void(0)" title="Tambah Provinsi" class="button-primary btn-add-province">Tambah Provinsi</a>&nbsp;<a href="javascript:void(0)" title="Tambah Kota" class="button-primary btn-add-city">Tambah Kota</a>&nbsp;<a href="javascript:void(0)" title="Reset Settings" class="button-secondary btn-reset" onclick="return wpei_delete_all_shipping();">Hapus semua data</a> <img src="<?=$app_base_url?>admin/images/loading.gif" class="wpei_reset_loading"/></h3>
</div>
</div>

<div class="admin-wrapper">
<?php
$provinces = wpei_get_all_province();
?>

<div class="wpei_province_new_form"><label for="province_name">Nama Provinsi</label><br /><input type="text" name="province_name" id="province_name" value="" /> <input type="button" id="wpei_province_new_btn" class="button-secondary" value="Simpan" onclick="wpei_add_province();"/> <img src="<?=$app_base_url?>admin/images/loading.gif" class="wpei_add_province_loading"/></div>

<div class="wpei_city_new_form"><table><tr><td><label for="city_name">Nama Kota</label><br /><input name="city_name" id="city_name" value="" type="text"/></td>
<td><label for="wpei_city_province">Provinsi</label><br />
<select id="wpei_city_province">
<?php
foreach($provinces as $key=>$data){
    echo '<option value="'.$data->id.'">'.$data->province_name.'</option>';
    }
?>
</select>
</td><td><label for="ongkir">Ongkos Kirim</label><br />
<input type="text" name="ongkir" id="ongkir" value=""/>
<input type="button" id="wpei_city_new_btn" class="button-secondary" value="Simpan" onclick="wpei_add_city();"/> <img src="<?=$app_base_url?>admin/images/loading.gif" class="wpei_add_city_loading"/>
</td>
</tr></table></div>
<table class="wpei-table" cellspacing="0">
<tr><th width="5%">No.</th><th width="50%">Nama Provinsi</th><th width="40%">Jumlah Kota</th></tr>
<?php
$counter = 0;
foreach($provinces as $key=>$data){
    $counter++;
    $numkota = wpei_get_numkota_by_provid($data->id);
    ?>
    <tr class="tr_<?=$data->id?>"><td><?=$counter?></td><td><img src="<?=$app_base_url?>admin/images/loading.gif" class="wpei_update_province_loading id_<?=$data->id?>"/> <input id="province_<?=$data->id?>" value="<?=$data->province_name?>" title="Click to edit" onclick="wpei_current_provedit(this.value);" onblur="wpei_update_province(<?=$data->id?>,this.value);"/> <span class="act"><a class="button-secondary" onclick="wpei_delete_province(<?=$data->id?>);">Hapus</a> <img src="<?=$app_base_url?>admin/images/loading.gif" class="wpei_delete_province_loading"/></span></td><td><a href="javascript:void(0)" class="city_toggle"><?=$numkota?> Kota</a>
    <table cellspacing="0">
    <?php
    $kotas = wpei_get_kota_by_provid($data->id);
    foreach($kotas as $key=>$kota){
        echo '<tr class="trkota_'.$kota->id.'"><td width="50%"><img src="'.$app_base_url.'admin/images/loading.gif" class="wpei_delete_kota_loading del_'.$kota->id.'"/> '.$kota->city_name.'</td><td width="30%">'.$kota->shipping_rate.'</td><td width="20%"><a href="TB_inline?height=220&width=200&inlineId=tb_'.$kota->id.'" title="Edit Kota" class="thickbox"><img src="'.$app_base_url.'admin/images/edit.png"/></a> <a href="javascript:void(0)" title="Hapus" onclick="wpei_delete_city('.$kota->id.');"><img src="'.$app_base_url.'admin/images/del.png"/></a>
<div id="tb_'.$kota->id.'" class="tb-container">

<!-- START Thickbox content-->
<div class="tb-wrapper">
<label for="city_name_'.$kota->id.'">Nama Kota</label>
<input type="text" name="city_name_'.$kota->id.'" id="update_city_name_'.$kota->id.'" value="'.$kota->city_name.'" class="styled"/>
<label for="wpei_city_province">Provinsi</label>
<select id="update_city_province_'.$kota->id.'" class="styled">';

foreach($provinces as $key=>$data){
        if($data->id == $kota->province_id){
        echo '<option value="'.$data->id.'" selected="selected">'.$data->province_name.'</option>';
        }else{
        echo '<option value="'.$data->id.'">'.$data->province_name.'</option>';
        }
    }

echo '</select>
<label for="ongkir_'.$kota->id.'">Ongkos Kirim</label>
<input type="text" name="ongkir" id="update_ongkir_'.$kota->id.'" value="'.$kota->shipping_rate.'" class="styled"/>
<input type="button" id="wpei_city_new_btn" class="button-secondary" value="Simpan" onclick="wpei_update_city('.$kota->id.');"/> <img src="'.$app_base_url.'admin/images/loading.gif" class="wpei_update_city_loading"/>
</div>
<!-- END Thickbox content-->
</div>
        </td></tr>';
        }
    ?>
    </table>
    </td></tr>
    <?php
    }
?>
</table>
</div>

<div class="footer-wrapper" ><a href="http://balitechy.com/" title="Bali WordPress Developer">Developed by Balitechy.com</a></div>
</div>
