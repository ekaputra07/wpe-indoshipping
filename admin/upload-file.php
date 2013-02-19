<?php
$upload_path = $_POST['upload_path'];
$filename = $_FILES["uploadfile"]["name"];
if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $upload_path.$filename)) {
    echo $filename;
} else {
	echo 'error';
}
?>
