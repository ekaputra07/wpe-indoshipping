jQuery(document).ready(function () {
    /*
    jQuery('.block-head h3').click(function () {
        jQuery(this).parent().next('.slide-block').slideToggle();
    });
    */

    jQuery('.btn-add-province').click(function () {
        jQuery('.wpei_province_new_form').slideToggle();
    });

    jQuery('.btn-add-city').click(function () {
        jQuery('.wpei_city_new_form').slideToggle();
    });

    jQuery('.city_toggle').click(function () {
        jQuery(this).parent().find('table').toggle();
    });

    jQuery('.block-head h3').hover(

    function () {
        jQuery(this).parent().addClass('active');
    },

    function () {
        jQuery(this).parent().removeClass('active');
    });

    jQuery('.input-block, .module-block').hover(

    function () {
        jQuery(this).addClass('yellow');
    },

    function () {
        jQuery(this).removeClass('yellow');
    });

    jQuery('.wpei-table td').hover(

    function () {
        jQuery(this).find('.act').show();
    },

    function () {
        jQuery(this).find('.act').hide();
    });
});

function confirm_reset() {
    if (confirm('Warning! all settings will be lost. Continue?') == true) {
        return true;
    } else {
        return false;
    }
}

/*
 * CRUD function form Province
 */
function wpei_add_province() {
    var new_province = jQuery('#province_name').val();
    if (new_province == '') {
        alert('Isi nama provinsi terlebih dahulu.');
    } else {
        jQuery('.wpei_add_province_loading').show();
        jQuery.ajax({
            type: 'post',
            url: indoshipping_vars.ajaxurl,
            data: ({
                action: 'ADDPROVINCE',
                'province_name': new_province
            }),
            success: function (respond) {
                if (respond == 1) {
                    jQuery('.wpei_add_province_loading').hide();
                    location.href = 'admin.php?page=wpei_manage';
                } else {
                    jQuery('.wpei_add_province_loading').hide();
                    alert('Gagal menyimpan Provinsi: ' + new_province + ', silahkan dicoba kembali.');
                }
            },
            error: function () {
                jQuery('.wpei_add_province_loading').hide();
                alert('Gagal menyimpan Provinsi: ' + new_province + ', silahkan dicoba kembali.');
            }
        });
    }
}

function wpei_delete_province(prov_id) {
    if (confirm('Anda yakin akan menghapus provinsi ini?') == true) {

        jQuery('.wpei_delete_province_loading').show();

        jQuery.ajax({
            type: 'post',
            url: indoshipping_vars.ajaxurl,
            data: ({
                action: 'DELPROVINCE',
                'id': prov_id
            }),
            success: function (respond) {
                if (respond == 1) {
                    jQuery('.wpei_delete_province_loading').hide();
                    jQuery('.tr_' + prov_id + ' td').css('background', '#ffebe8').animate({
                        opacity: 0
                    }, 1000, function () {
                        jQuery('.tr_' + prov_id).remove();
                    });
                } else {
                    jQuery('.wpei_delete_province_loading').hide();
                    alert('Gagal menghapus provinsi, silahkan dicoba kembali.');
                }
            },
            error: function () {
                jQuery('.wpei_delete_province_loading').hide();
                alert('Gagal menghapus provinsi, silahkan dicoba kembali.');
            }
        });
    } else {
        return false;
    }
}

window.current_editvalue = '';

function wpei_current_provedit(cur_edit) {
    window.current_editvalue = cur_edit;
}

function wpei_update_province(id, new_name) {
    if (new_name != window.current_editvalue) {
        jQuery('.id_' + id).show();

        jQuery.ajax({
            type: 'post',
            url: indoshipping_vars.ajaxurl,
            data: ({
                action: 'UPDTPROVINCE',
                'id': id,
                'new_name': new_name
            }),
            success: function (respond) {
                if (respond == 1) {
                    jQuery('.id_' + id).hide();
                    //alert('Provinsi berhasil di update.');
                } else {
                    jQuery('.id_' + id).hide();
                    //alert('Gagal update provinsi!');
                }
            },
            error: function () {
                jQuery('.id_' + id).hide();
                alert('Gagal update provinsi!');
            }
        });
    }
}

/*
 * CRUD function form city
 */
function wpei_add_city() {
    var new_city = jQuery('#city_name').val();
    var prov_id = jQuery('#wpei_city_province').val();
    var price = jQuery('#ongkir').val();
    if (new_city == '' || price == '') {
        alert('Isi nama Kota dan Ongkos Kirim terlebih dahulu.');
    } else {
        jQuery('.wpei_add_city_loading').show();
        jQuery.ajax({
            type: 'post',
            url: indoshipping_vars.ajaxurl,
            data: ({
                action: 'ADDCITY',
                'city_name': new_city,
                'province_id': prov_id,
                'shipping_rate': price
            }),
            success: function (respond) {
                if (respond == 1) {
                    jQuery('.wpei_add_city_loading').hide();
                    location.href = 'admin.php?page=wpei_manage';
                } else {
                    jQuery('.wpei_add_city_loading').hide();
                    alert('Gagal menyimpan Kota: ' + new_city + ', silahkan dicoba kembali.');
                }
            },
            error: function () {
                jQuery('.wpei_add_city_loading').hide();
                alert('Gagal menyimpan Kota: ' + new_city + ', silahkan dicoba kembali.');
            }
        });
    }
}

function wpei_delete_city(city_id) {
    jQuery('.del_' + city_id).show();

    jQuery.ajax({
        type: 'post',
        url: indoshipping_vars.ajaxurl,
        data: ({
            action: 'DELCITY',
            'id': city_id
        }),
        success: function (respond) {
            if (respond == 1) {
                jQuery('.del_' + city_id).hide();
                jQuery('.trkota_' + city_id + ' td').css('background', '#ffebe8').animate({
                    opacity: 0
                }, 1000, function () {
                    jQuery('.trkota_' + city_id).remove();
                });
            } else {
                jQuery('.del_' + city_id).hide();
                alert('Gagal menghapus Kota, silahkan dicoba kembali.');
            }
        },
        error: function () {
            jQuery('.del_' + city_id).hide();
            alert('Gagal menghapus Kota, silahkan dicoba kembali.');
        }
    });
}

function wpei_update_city(city_id) {
    var city = city_id;
    var city_name = jQuery('#update_city_name_' + city).val();
    var shipping_rate = jQuery('#update_ongkir_' + city).val();
    var province_id = jQuery('#update_city_province_' + city).val();

    jQuery('.wpei_update_city_loading').show();

    jQuery.ajax({
        type: 'post',
        url: indoshipping_vars.ajaxurl,
        data: ({
            action: 'UPDTCITY',
            'id': city,
            'city_name': city_name,
            'shipping_rate': shipping_rate,
            'province_id': province_id
        }),
        success: function (respond) {
            if (respond == 1) {
                jQuery('.wpei_update_city_loading').hide();
                alert('Kota berhasil di update.');
                location.href = 'admin.php?page=wpei_manage';
            } else {
                jQuery('.wpei_update_city_loading').hide();
                alert('Gagal update Kota!');
            }
        },
        error: function () {
            jQuery('.wpei_update_city_loading').hide();
            alert('Gagal update Kota!');
        }
    });
}
/*
 * Deleta all Shipping Data
 */
function wpei_delete_all_shipping() {
    if (confirm('Semua data shipping akan dihapus. Lanjutkan?') == true) {
        jQuery('.wpei_reset_loading').show();

        jQuery.ajax({
            type: 'post',
            url: indoshipping_vars.ajaxurl,
            data: ({
                action: 'DELALL'
            }),
            success: function (respond) {
                if (respond == 1) {
                    jQuery('.wpei_reset_loading').hide();
                    location.href = 'admin.php?page=wpei_manage';
                } else {
                    jQuery('.wpei_reset_loading').hide();
                    alert('Gagal menghapus semua data, silahkan dicoba kembali.');
                }
            },
            error: function () {
                jQuery('.wpei_reset_loading').hide();
                alert('Gagal menghapus semua data, silahkan dicoba kembali.');
            }
        });
    } else {
        return false;
    }
}
