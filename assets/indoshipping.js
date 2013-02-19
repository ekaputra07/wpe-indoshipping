/*
 * Main JS file for WPE Indoshipping
 * jQuery required
 * author : Putu Eka Putra - Balitechy.com
 */
jQuery(document).ready(function($){
    $(".wpe_indoshipping_0").parent().append('<tr class="prov prov-label wpsc_shipping_quote_name"></tr>');
    $(".prov").append('Loading provinces...').load(indoshipping.ajaxurl,{action:'LOADPROVINCE'}, function(){
        var selected_province = $('#sel_propinsi').val();
        if(selected_province != 0){
            wpei_get_kota(selected_province, 'onload');
        }    
    });
});


function wpei_get_kota(prov_id, event){
	jQuery('select#sel_kota > option').remove();
	jQuery('select#sel_kota').append('<option value="0">Loading City...</option>');
    jQuery.get(indoshipping.ajaxurl, {'action':'GETKOTA','prov_id':prov_id},function(json){
        jQuery('select#sel_kota > option').remove();
        var data = jQuery.parseJSON(json);
        for(i=0; i < data.list_kota.length; i++){
            if(data.list_kota[i].kota_name == data.current_kota){
           jQuery('select#sel_kota')
           .append('<option selected="selected" value="'+data.list_kota[i].kota_name+'">'+data.list_kota[i].kota_name+' - '+data.list_kota[i].ongkir+'/Kg</option>');
            }else{
           jQuery('select#sel_kota')
           .append('<option value="'+data.list_kota[i].kota_name+'">'+data.list_kota[i].kota_name+' - '+data.list_kota[i].ongkir+'/Kg</option>');
            }
        }
        
        if(event == 'onchange'){
            var first_kota = jQuery('select#sel_kota > option').val();
            switchmethod(first_kota, 'wpe_indoshipping');
        }else if(event == 'onload' && data.current_kota != ''){
            switchmethod(data.current_kota, 'wpe_indoshipping');
        }
    });
}

