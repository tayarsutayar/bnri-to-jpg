<?php

class BnriToImage {
    private $img;
    
    function createImage($tanggal, $nomor, $tahun, $penandatangan){

        $fontSize = 12;
        $imgWidth = 600;
        $imgHeight = 350;
        $spacing = 20;
        $angle = 0;
        //text font path
        $font = dirname(__FILE__) .'/bos.ttf';

        $text = '
        Diundangkan di Jakarta\n
        pada tanggal '.$tanggal.'\n
        \n
        DIREKTUR JENDERAL\n
        PERATURAN PERUNDANG-UNDANGAN\n
        KEMENTERIAN HUKUM DAN HAK ASASI MANUSIA\n
        REPUBLIK INDONESIA,\n
        \n
        \n
        \n
        '.$penandatangan.'\n
        \n
        \n
        BERITA NEGARA REPUBLIK INDONESIA TAHUN '.$tahun.' NOMOR '.$nomor;
        
        //create the image
        $this->img = imagecreatetruecolor($imgWidth, $imgHeight);
        
        //create some colors
        $white = imagecolorallocate($this->img, 255, 255, 255);
        $black = imagecolorallocate($this->img, 0, 0, 0);
        imagefilledrectangle($this->img, 0, 0, $imgWidth - 1, $imgHeight - 1, $white);
        
        //break lines
        $splitText = explode ( "\\n" , $text );
        $lines = 0;
        
        foreach($splitText as $txt){
            $textBox = imagettfbbox($fontSize,$angle,$font,$txt);
            $x = 0;
            $y = 0+$lines*$spacing;
            $lines = $lines+1;
            
            //add the text
            imagettftext($this->img, $fontSize, $angle, $x, $y, $black, $font, $txt);
        }
	return true;
    }
    
    function showImage(){
        header('Content-Type: image/png');
        return imagepng($this->img);
    }
    
    function saveImage($fileName, $location = ''){
        $fileName = $fileName.".jpg";
        $fileName = !empty($location)?$location.$fileName:$fileName;
        return imagejpeg($this->img, $fileName);
    }
}