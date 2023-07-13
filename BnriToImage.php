<?php

class BnriToImage {
    private $img;
    
    function createImage($tanggal, $nomor, $tahun, $penandatangan, $link_document){

        $fontSize = 100;
        $imgWidth = 4550;
        $imgHeight = 2200;
        $spacing = 150;
        $angle = 0;
        //text font path
        $font = dirname(__FILE__) .'/bos.ttf';

        $text = 'Diundangkan di Jakarta\npada tanggal '.$tanggal.'\n\nDIREKTUR JENDERAL\nPERATURAN PERUNDANG-UNDANGAN\nKEMENTERIAN HUKUM DAN HAK ASASI MANUSIA\nREPUBLIK INDONESIA,\n###REPLACELOGO###\n\n\n'.$penandatangan.'\n\n\nBERITA NEGARA REPUBLIK INDONESIA TAHUN '.$tahun.' NOMOR '.$nomor;
        
        //create the image
        $this->img = imagecreatetruecolor($imgWidth, $imgHeight);
        
        //create some colors
        $white = imagecolorallocate($this->img, 255, 255, 255);
        $black = imagecolorallocate($this->img, 0, 0, 0);
        imagefilledrectangle($this->img, 0, 0, $imgWidth - 1, $imgHeight - 1, $white);
        
        //break lines
        $splitText = explode ( "\\n" , $text );
        $lines = 1;
        
        foreach($splitText as $txt){
            $x = 0;
            $y = $lines*$spacing;
            $lines = $lines+1;
            
            if(strpos($txt, "###REPLACELOGO###") !== false){
                $this->createQrCode($link_document, $x, $y-$spacing, $spacing*7.5);
            }
            else{
                imagettftext($this->img, $fontSize, $angle, $x, $y, $black, $font, $txt);
            }
        }
	    return true;
    }

    private function createQrCode($text, $x, $y, $res_width){
        $path_logo = dirname(__FILE__).'/logo-kumham.png';
        $file_name= "temp_qr.png";
        $file_path = dirname(__FILE__).'/'.$file_name;

        QRcode::png($text, $file_path, "H", 20, 4, 0, "#fff", "#fff");

        $QR = imagecreatefrompng($file_path);

        // memulai menggambar logo dalam file qrcode
        $logo = imagecreatefromstring(file_get_contents($path_logo));

        imagecolortransparent($logo , imagecolorallocatealpha($logo , 0, 0, 0, 127));
        imagealphablending($logo , false);
        imagesavealpha($logo , true);

        $QR_width = imagesx($QR);
        $QR_height = imagesy($QR);

        $logo_width = imagesx($logo);
        $logo_height = imagesy($logo);

        // Scale logo to fit in the QR Code
        $logo_qr_width = $QR_width/8;
        $scale = $logo_width/$logo_qr_width;
        $logo_qr_height = $logo_height/$scale;

        imagecopyresampled($QR, $logo, $QR_width/2.3, $QR_height/2.3, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

        imagepng($QR,$file_path);

        imagecopyresampled($this->img, $QR, $x, $y, 0, 0, $res_width, $res_width, $logo_width, $logo_height);
    }
    
    function showImage(){
        header('Content-Type: image/png');
        return imagepng($this->img);
    }
    
    function saveToJpg($fileName, $location = ''){
        $fileName = $fileName.".jpg";
        $fileName = !empty($location)?$location.$fileName:$fileName;
        return imagejpeg($this->img, $fileName);
    }

    function saveToPng($fileName, $location = ''){
        $fileName = $fileName.".png";
        $fileName = !empty($location)?$location.$fileName:$fileName;
        return imagepng($this->img, $fileName);
    }
}