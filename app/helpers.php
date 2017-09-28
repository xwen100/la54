<?php

function readImage($filename)
{
	$fh = fopen($filename, 'r');
    $content = fread($fh, filesize($filename));
    $info = getimagesize($filename);
    $mime = $info['mime'];
    header('content-type:'.$mime);
    echo $content;
}

function uploadImage($file)
{
	$root = public_path();
	$path = '/upload/image/' . date('Ymd');
	 if(!is_dir($root . $path))
	 {
	 	mkdir($root . $path, 0777, true);
	 }
	 $name = md5(uniqid()) . '.jpg';
	 $filename =  $path . '/' . $name;
	 move_uploaded_file($file, $root . $filename);
	 return $filename;
}