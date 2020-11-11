<?php
require('FPDF/fpdf.php');

$unEqualString = "null";
$image = $unEqualString;

if(isset($_GET['DesignJpgPreviewUrl'])){
    $image = $_GET['DesignJpgPreviewUrl'];
}

$width = (getimagesize($image)[0] / 5);
$height = (getimagesize($image)[1] / 5);

if($width > $height){
    $pdf = new FPDF('L', 'mm', array($height, $width));
}else{
    $pdf = new FPDF('P', 'mm', array($width, $height));
}

$pdf->AddPage();
$pdf->Image($image, 0, 0, $width, $height);
$pdf->Output();
?>
