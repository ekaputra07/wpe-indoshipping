<!-- Module Admin Wrapper -->
<div class="admin-wrapper">
<div class="block">
<div class="block-head"><h3 title="Click to toggle">DB Importer</h3>
<div class="clearfix"></div>
</div>
<div class="slide-block">
<div class="module-block">
<!-- start module content Admin-->
<p>Dengan DB importer ini anda dapat mengimport seluruh data shipping (Provinsi & Kota) dari file <strong>CSV</strong> dan akan secara otomatis diimport ke dalam database.</p><p>
<strong>PERHATIAN :</strong><br />Setiap operasi Import tidak akan menghapus semua data shipping yang sudah ada di Database terlebih dahulu, namun hanya akan menambahkan data Provinsi yang belum ada di database.</p>
<p>Untuk itu untuk melakukkan Import secara Full semua data, maka data shipping yang sekarang perlu dikosongkan terlebih dahulu melalui menu <strong>Indoshipping -> Manage -> Hapus semua data</strong>.</p>
<p>Pastikan format daftar ongkos kirim di file CSV sesuai format yang telah ditentukan. <a href="<?=$app_base_url ?>sample.zip">Download contoh disini</a>.</p>
<p>Upload file <strong>CSV</strong> melalui uploader di bawah ini, dan click Import.</p>

<?php
global $upload_path,$upload_action;
$upload_path = $app_base_path.'upload/';
$upload_action = $app_base_url.'admin/upload-file.php';
if(!is_writable($upload_path)){
    echo '<p class="error"><strong>WARNING : '.$upload_path.' is NOT WRITABLE, upload operation will be fail.</strong> Please make it writable by change the permission to 777.</p>';
    }
?>

<!-- JS FOR AJAX UPLOADER-->
<script type="text/javascript" src="<?=$app_base_url?>admin/js/ajaxupload.3.5.js" ></script>
<script type="text/javascript" >
	jQuery(document).ready(function($){

		var btnUpload=$('#btn-upload');
		var status=$('.upload-status');
		new AjaxUpload(btnUpload, {
			action: '<?=$upload_action?>',
			name: 'uploadfile',
			data:({upload_path:'<?=$upload_path?>'}),
			onSubmit: function(file, ext){
				 if (! (ext && /^(csv)$/.test(ext))){
                    // extension is not allowed
					status.text('Error: Hanya file CSV yang diijinkan!');
					return false;
				}
				status.text('Mengupload, silahkan tunggu...');
			},
			onComplete: function(file, resp){
                $('#import_file').val(file);
                status.text('');
                /*
				//On completion clear the status
				status.text('');
				//Add uploaded file to list
				if(response.length < 25 && response != 'error'){
				    $('#import_file').val(file);
					status.text('Upload berhasil!');
				} else{
					status.text('Upload error!');
				}*/
			}
		});

    $('#btn-import').click(function(){
        var dbfile = $('#import_file').val();
        if(dbfile != ''){
        $('.import-status').text('mengimport...');
        $.ajax({
            type : 'post',
            url : indoshipping_vars.ajaxurl,
            data :({action:'DBIMPORT','dbfile':dbfile}),
            success : function(respond){
            $('.import-status').html(respond);
            },
            error : function(){
                $('.import-status').text('Import gagal!.');
            }
        });
        }else{
        alert('Upload file CSV terlebih dahulu!');
        }
    });

});
</script>
<!-- END JS FOR AJAX UPLOADER-->
<p><input type="text" name="import_file" id="import_file" value="" readonly="readonly"> <input type="button" value="Upload" id="btn-upload" class="button-secondary"/> <span class="upload-status"></span></p>
<p><input type="button" value="Import sekarang" id="btn-import" class="button-primary"/><br/><br/>
<span class="import-status"></span></p>
<!-- End module content Admin -->
</div>
</div></div></div>
<!-- End Module Admin Wrapper -->
