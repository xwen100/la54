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