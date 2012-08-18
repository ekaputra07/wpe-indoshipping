/*
 * Main JS file for WPE Indoshipping
 * jQuery required
 * author : Putu Eka Putra - Balitechy.com
 */
jQuery(document).ready(function($){
    $(".wpe_indoshipping_0").parent().append('<tr class="prov prov-label"></tr>');
    $(".prov").append('Loading provinsi...').load(indoshipping.ajaxurl,{action:'LOADPROVINCE'});
});


function wpei_get_kota(prov_id){
	jQuery('select#sel_kota > option').remove();
	jQuery('select#sel_kota').append('<option value="0">Loading City...</option>');
	    jQuery.get(indoshipping.ajaxurl, {'action':'GETKOTA','prov_id':prov_id},function(json){
	        jQuery('select#sel_kota > option').remove();
            var kotas = jQuery.parseJSON(json);
            for(i=0; i < kotas.length; i++){
               jQuery('select#sel_kota').append('<option value="'+prov_id+' - '+kotas[i].kota_name+'">'+kotas[i].kota_name+'</option>');
                }

            var first_kota = jQuery('select#sel_kota > option').val();
            switchmethod(first_kota, 'wpe_indoshipping');
	    });
	}

