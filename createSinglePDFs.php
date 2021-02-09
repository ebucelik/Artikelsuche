<?php
require('FPDF/fpdf.php');

$name = "";
$img = "";

if(isset($_POST["Name"])){
    $name = $_POST["Name"];
}else{
    $name = date('d-m-y');
}

if(isset($_POST["Image"])){
    $image = $_POST["Image"];
}

$width = getimagesize($image)[0];
$height = getimagesize($image)[1];

if($width > $height){
    $pdf = new FPDF('L', 'mm', array($height, $width));
}else{
    $pdf = new FPDF('P', 'mm', array($width, $height));
}

$pdf->AddPage();
$pdf->Image($image, 0, 0, $width, $height);
$pdf->Output("F", "Uploads/" . $name . ".pdf", true); 

echo "Uploads/" . $name . ".pdf";
?>