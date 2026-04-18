<?php
$file_name = $_FILES['fileUpload']['name'];
$file_type = $_FILES['fileUpload']['type'];
$file_size = $_FILES['fileUpload']['size'];
$file_tmp_name = $_FILES['fileUpload']['tmp_name'];
$file_error = $_FILES['fileUpload']['error'];

move_uploaded_file($file_tmp_name, __DIR__.'/images/'.$file_name);

echo $file_name . "<br>";
echo $file_type . "<br>";
echo $file_size . "<br>";
echo $file_tmp_name . "<br>";
echo $file_error . "<br>";
?>