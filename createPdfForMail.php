<?php
require('FPDF/fpdf.php');

$name = "";
$data = array();

if(isset($_POST["Name"])){
    $name = $_POST["Name"];
}else{
    $name = date('d-m-y');
}

if(isset($_POST["Data"])){
    $data = json_decode($_POST["Data"]);
}

//Page is from 210 mm broad
$pdf=new FPDF();
$pdf->AddPage();
//$pdf->SetAutoPageBreak(true, 0);

$cntYpos = 10;
$imgYpos = 10;

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(35, $cntYpos, "Sehr geehrter Kunde!");
$pdf->ln(10);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(35, $cntYpos, iconv('UTF-8', 'windows-1252',"Nach Abzug der aktuellen Bestellung(en), lagern wir mit Stand per 18.11.2020 folgende Etiketten für Sie:"));
$pdf->ln(10);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(35, $cntYpos, iconv('UTF-8', 'windows-1252', "Die Etiketten sind nicht maßstabsgetreu abgebildet!"));
$pdf->ln(15);

foreach($data as $d){
    $pdf->SetFont('Arial', 'I', 11);
    $pdf->Cell(35, $cntYpos, "R-Nummer:");
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(35, $cntYpos, $d[1]);
    $pdf->ln(5);

    $pdf->SetFont('Arial', 'I', 11);
    $pdf->Cell(35, $cntYpos, "");
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(35, $cntYpos, iconv('UTF-8', 'windows-1252', $d[2]));
    $pdf->ln(5);

    $pdf->SetFont('Arial', 'I', 11);
    $pdf->Cell(35, $cntYpos, "Menge:");
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(35, $cntYpos, $d[3]);
    $pdf->ln(5);

    $pdf->SetFont('Arial', 'I', 11);
    $pdf->Cell(35, $cntYpos, "Format Quer:");
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(35, $cntYpos, $d[4]);
    $pdf->ln(5);

    $pdf->SetFont('Arial', 'I', 11);
    $pdf->Cell(35, $cntYpos, "Format Lauf:");
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(35, $cntYpos, $d[5]);

    if(isset($d[0])){
        $pdf->Cell(30, 30, $pdf->Image($d[0], 150, $pdf->GetY()-20, -350));
    }

    $pdf->ln(35);
}

$pdf->Output("F", "Uploads/" . $name . ".pdf", true); 
?>