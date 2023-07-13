<!DOCTYPE html>
<head>
    <title>BNRI to Image</title>
    <style>
        .form-input{
            margin-bottom: 10px;
        }
    </style>
</head>
    <form method="GET" action="index.php">
        <div class="form-input">
            <label>Tanggal Pengundangan : </label>
            <input name="tanggal" type="date"  required value="<?php echo isset($_GET['tanggal']) ? $_GET['tanggal'] : '2023-07-12' ?>">
        </div>
        <div class="form-input">
            <label>Nomor : </label>
            <input name="nomor" type="number" placeholder="ex: 99" required value="<?php echo isset($_GET['nomor']) ? $_GET['nomor'] : '40' ?>">
        </div>
        <div class="form-input">
            <label>Tahun : </label>
            <input name="tahun" type="number" placeholder="ex: 2023" required value="<?php echo isset($_GET['tahun']) ? $_GET['tahun'] : '2023' ?>">
        </div>
        <div class="form-input">
            <label>Penandatangan : </label>
            <input name="ttd" type="text" placeholder="ex: ASEP N. MULYANA" required value="<?php echo isset($_GET['ttd']) ? $_GET['ttd'] : 'ASEP N. MULYANA' ?>">
        </div>
        <div class="form-input">
            <label>Link QR CODE : </label>
            <input name="qr" type="text" placeholder="ex: https://peraturan.go.id/files/bn78-2023.pdf" required value="<?php echo isset($_GET['qr']) ? $_GET['qr'] : 'https://peraturan.go.id/files/bn78-2023.pdf'?>">
        </div>
        <div class="form-input">
            <button type="submit">Generate</button>
        </div>
    </form>

    <?php
    function date_indo($tanggal){
        $month = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $split = explode('-', $tanggal);
     
        return $split[2] . ' ' . $month[ (int)$split[1] ] . ' ' . $split[0];
    }
    if(isset($_GET['nomor'])){
        require_once 'BnriToImage.php';
        require_once "phpqrcode/qrlib.php"; 

        $img = new BnriToImage;

        $tanggal = date_indo($_GET['tanggal']);
        $nomor = $_GET['nomor'];
        $tahun = $_GET['tahun'];
        $penandatangan = $_GET['ttd'];
        $link_qr = $_GET['qr'];
        $path = 'result/BNRI-Tahun'.$tahun.'-Nomor'.$nomor;

        $img->createImage($tanggal, $nomor, $tahun, $penandatangan, $link_qr);
        
        if(isset($_GET['return_image']) && $_GET['return_image'] == true){
            $img->showImage();
            exit();
        }
        else{
            $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $img->saveToPng(dirname(__FILE__).'/'.$path);
            echo '
                <a href="'.$actual_link.'&return_image=true" target="_blank">
                    Open In New Tab 
                </a>        
                &nbsp&nbsp&nbsp&nbsp
                <a download="'.$path.'.png" href="'.$path.'.png">
                    Click to Download    <br><br>
                </a>
                
                <img src="'.$path.'.png" width="50%" height="50%" border="1"></img>
            ';
        }
    }

    ?>
</html>