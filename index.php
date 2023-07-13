<?php
//include BnriToImage class
require_once 'BnriToImage.php';
require_once "phpqrcode/qrlib.php"; 

//create img object
$img = new BnriToImage;

//create image from text
$tanggal = '26 Mei 2023';
$nomor = '40';
$tahun = '2023';
$penandatangan = 'ASEP N. MULYANA';
$link_document = 'https://peraturan.go.id/files/bn78-2023.pdf';

$img->createImage($tanggal, $nomor, $tahun, $penandatangan, $link_document);

$img->saveToPng('BNRI-Tahun'.$tahun.'-Nomor'.$nomor);

?>