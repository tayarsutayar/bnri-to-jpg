<?php
//include BnriToImage class
require_once 'BnriToImage.php';

//create img object
$img = new BnriToImage;

//create image from text
$tanggal = '26 Mei 2023';
$nomor = '40';
$tahun = '2023';
$penandatangan = 'ASEP N. MULYANA';

$img->createImage($tanggal, $nomor, $tahun, $penandatangan);

$img->saveImage('BNRI-Tahun'.$tahun.'-Nomor'.$nomor);
?>