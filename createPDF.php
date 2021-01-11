<?php
require_once("db/db.php");
require('FPDF/fpdf.php');

$unEqualString = "";
$type = $itemId = $custAcc = $salesId = $version = $inventDimId = $prodGroupId = $lPMRZBoardId = $lPMRZProdToolIdDieCut = $simpleOrFullPDF = $unEqualString;

if(isset($_GET['type'])){
    $type = $_GET['type'];
}
if(isset($_GET['ItemId'])){
    $itemId = $_GET['ItemId'];
}
if(isset($_GET['CustAcc'])){
    $custAcc = $_GET['CustAcc'];
}
if(isset($_GET['SalesId'])){
    $salesId = $_GET['SalesId'];
}
if(isset($_GET['Version'])){
    $version = $_GET['Version'];
}
if(isset($_GET['InventDimId'])){
    $inventDimId = $_GET['InventDimId'];
}
if(isset($_GET['ProdGroupId'])){
    $prodGroupId = $_GET['ProdGroupId'];
}
if(isset($_GET['LPMRZBoardId'])){
    $lPMRZBoardId = $_GET['LPMRZBoardId'];
}
if(isset($_GET['LPMRZProdToolIdDieCut'])){
    $lPMRZProdToolIdDieCut = $_GET['LPMRZProdToolIdDieCut'];
}
if(isset($_GET['SimpleOrFullPDF'])){
    $simpleOrFullPDF = $_GET['SimpleOrFullPDF'];
}

$itemIdArray = $colorArray = $custArray = array();

//AxDev SQL queries 
require("db/getDataFromDB.php");

//Page is from 210 mm broad
$pdf=new FPDF();
$pdf->AddPage();
$pdf->path = "C:\xampp\htdocs\Artikelsuche\PDFs";

//ItemId & Date
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(150, 10, $itemId);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(50, 10, "Druckdatum: " . date("d.m.Y"));
$pdf->SetLineWidth(0.5);
$pdf->Line(5, 20, 205, 20);

$pdf->ln();

//iconv('UTF-8', 'windows-1252', 'Bonität')

if($itemIdArray){ 
    foreach($itemIdArray as $v1){
        foreach($custArray as $v3){
            if($simpleOrFullPDF == 'Full')
            {
                //Cust Data
                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(25, 10, "KundenNummer");
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(70, 10, $v1['CustVendRelation']);

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(12, 10, 'VAD');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(35, 10, iconv('UTF-8', 'windows-1252', $v3['ContactPerson']));

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(12, 10, 'E-Mail');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(50, 10, $v3['EMail']);

                $pdf->ln(7);

                //Cust Data
                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(25, 10, "FirmenName");
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(70, 10, iconv('UTF-8', 'windows-1252', $v1['Name']));

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(12, 10, 'Telefon');
                $pdf->SetFont('Arial', '', 8);
                if($v3['Phone'] && $v3['Mobile'] != 'Mobil'){
                    $pdf->Cell(35, 10, $v3['Phone']);
                }else{
                    $pdf->Cell(35, 10, '');
                }

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(12, 10, 'Web');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(50, 10, $v3['WebSite']);
                $pdf->ln(7);

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(25, 10, 'Branche');
                $pdf->SetFont('Arial', '', 8);
                if(isset($v1['Branche'])){
                    $pdf->Cell(70, 10, iconv('UTF-8', 'windows-1252', $v1['Branche']));
                }else{
                    $pdf->Cell(70, 10, '');
                }
                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(12, 10, 'Fax');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(35, 10, $v3['Fax']);
                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(12, 10, 'Mobil');
                $pdf->SetFont('Arial', '', 8);
                if($v3['Phone'] && $v3['Mobile'] == 'Mobil'){
                    $pdf->Cell(50, 10, $v3['Phone']);
                }else{
                    $pdf->Cell(50, 10, '');
                }

                $pdf->ln(7);

                //Cust Data
                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(25, 10, "Adresse");
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(117, 10, iconv('UTF-8', 'windows-1252', $v3['Street'] . ", " . $v1['ZipCode'] . " " . $v1['City'] . ", " . $v3['CountryRegionId'] ));

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(25, 10, "Betriebsnummer");
                $pdf->SetFont('Arial', '', 8);
                if(isset($v1['Steuernummer'])){
                    $pdf->Cell(12, 10, $v1['Steuernummer']);
                }else{
                    $pdf->Cell(12, 10, '');
                }

                $pdf->ln(10);
                $pdf->SetLineWidth(0.5);
                $pdf->Line(5, 51, 205, 51);

                //Body data
                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(25, 10, 'R-Nummer');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(70, 10, $v1['ItemId']);

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(35, 10, 'Auftragsnummer');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(90, 10, $v1['SalesId']);

                $pdf->ln(7);

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(25, 10, "Stichwort");
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(70, 10, iconv('UTF-8', 'windows-1252', $v1['ExternalItemTxt']));

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(35, 10, 'Version');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(90, 10, $v1['Version']);

                $pdf->ln(7);

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(25, 10, 'Sorten Eindruck');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(70, 10, iconv('UTF-8', 'windows-1252', $v1['Sort']));

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(35, 10, "Produktvariante");
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(90, 10, $v1['ProdGroupId']);

                $pdf->ln(10);
                $pdf->SetLineWidth(0.5);
                $pdf->Line(5, 75, 205, 75);

                //Paper data
                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(25, 10, 'Papiernummer');
                $pdf->SetFont('Arial', '', 8);
                if(isset($v1['LPMRZBoardId'])){
                    $pdf->Cell(70, 10, $v1['LPMRZBoardId']);
                }else{
                    $pdf->Cell(70, 10, '');
                }

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(35, 10, 'Papierzusatzbezeichnung');
                $pdf->SetFont('Arial', '', 8);
                if(isset($v1['MARAdditionalDescription'])){
                    $pdf->Cell(90, 10, $v1['MARAdditionalDescription']);
                }else{
                    $pdf->Cell(90, 10, '');
                }

                $pdf->ln(7);

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(25, 10, 'PapGramBasMat');
                $pdf->SetFont('Arial', '', 8);
                if(isset($v1['MARAreaWeightBas'])){
                    $pdf->Cell(70, 10, $v1['MARAreaWeightBas']);
                }else{
                    $pdf->Cell(70, 10, '');
                }

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(35, 10, 'Papierart');
                $pdf->SetFont('Arial', '', 8);
                if(isset($v1['MARPaperColor'])){
                    $pdf->Cell(90, 10, $v1['MARPaperColor']);
                }else{
                    $pdf->Cell(90, 10, '');
                }

                $pdf->ln(7);

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(25, 10, 'PapKleberHinweis');
                $pdf->SetFont('Arial', '', 8);
                if(isset($v1['MARGlue'])){
                    $pdf->Cell(70, 10, $v1['MARGlue']);
                }else{
                    $pdf->Cell(70, 10, '');
                }

                $pdf->ln(10);
                $pdf->SetLineWidth(0.5);
                $pdf->Line(5, 99, 205, 99);

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(25, 10, 'Stanznummer');
                $pdf->SetFont('Arial', '', 8);
                if(isset($v1['LPMRZProdToolIdDieCut'])){
                    $pdf->Cell(70, 10, $v1['LPMRZProdToolIdDieCut']);
                }else{
                    $pdf->Cell(70, 10, '');
                }

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(35, 10, 'Stanzform');
                $pdf->SetFont('Arial', '', 8);
                if(isset($v1['CalcDesignStyleId'])){
                    $pdf->Cell(90, 10, $v1['CalcDesignStyleId']);
                }else{
                    $pdf->Cell(90, 10, '');
                }

                $pdf->ln(7);

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(25, 10, 'FormatQuer');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(70, 10, $v1['LEPSizeW']);

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(35, 10, 'FormatLaufrichtung');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(90, 10, $v1['LEPSizeL']);

                $pdf->ln(7);

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(25, 10, 'Stellung');
                $pdf->SetFont('Arial', '', 8);
                if(isset($v1['TradeUnitSpecId'])){
                    $pdf->Cell(70, 10, $v1['TradeUnitSpecId']);
                }else{
                    $pdf->Cell(70, 10, '');
                }

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(35, 10, iconv('UTF-8', 'windows-1252', 'StückLM'));
                $pdf->SetFont('Arial', '', 8);
                if(isset($v1['LPMRZMaxAllowedQty'])){
                    $pdf->Cell(90, 10, $v1['LPMRZMaxAllowedQty']);
                }else{
                    $pdf->Cell(90, 10, '');
                }

                $pdf->ln(7);

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(25, 10, 'RolleBogen');
                $pdf->SetFont('Arial', '', 8);
                if(isset($v1['TradeUnitGroupId'])){
                    $pdf->Cell(70, 10, $v1['TradeUnitGroupId']);
                }else{
                    $pdf->Cell(70, 10, '');
                }

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(35, 10, 'InnenDM');
                $pdf->SetFont('Arial', '', 8);
                if(isset($v1['TradeUnitId'])){
                    $pdf->Cell(90, 10, substr($v1['TradeUnitId'], 3, 2));
                }else{
                    $pdf->Cell(90, 10, '');
                }

                $pdf->ln(7);

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(25, 10, iconv('UTF-8', 'windows-1252', 'AußenDM'));
                $pdf->SetFont('Arial', '', 8);
                if(isset($v1['LPMRZMaxDiameterOuter'])){
                    $pdf->Cell(70, 10, $v1['LPMRZMaxDiameterOuter']);
                }else{
                    $pdf->Cell(70, 10, '');
                }

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(35, 10, 'Maschine(n)');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(90, 10, $v1['WorkCenters']);

                $pdf->ln(7);

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(25, 10, 'Lagerstand');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(70, 10, $v1['StockLevel']);

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(35, 10, 'GTIN');
                $pdf->SetFont('Arial', '', 8);
                if(isset($v1['ExternalItemId'])){
                    $pdf->Cell(90, 10, $v1['ExternalItemId']);
                }else{
                    $pdf->Cell(90, 10, '');
                }

                $pdf->ln(10);
                $pdf->SetLineWidth(0.5);
                $pdf->Line(5, 144, 205, 144);
                $pdf->ln(3);

                $cnt = 0;
                foreach($colorArray as $v2){
                    if($cnt == 0){
                        $pdf->SetFont('Arial', 'I', 8);
                        $pdf->Cell(25, 5, 'Seite');
                        $pdf->SetFont('Arial', '', 8);
                        $pdf->Cell(40, 5, $v2['FrontBack'] == 0 ? 'Vorderseite' : ($v2['FrontBack'] == 1 ? 'Rückseite' : 'Rückseite auf Kleber'));

                        $pdf->SetFont('Arial', 'I', 8);
                        $pdf->Cell(25, 5, 'Aggregatstyp');
                        $pdf->SetFont('Arial', '', 8);
                        $pdf->Cell(45, 5, iconv('UTF-8', 'windows-1252', $v2['DeviceTypeId']));

                        $pdf->SetFont('Arial', 'I', 8);
                        $pdf->Cell(25, 5, 'Rohmaterial');
                        $pdf->SetFont('Arial', '', 8);
                        $pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', $v2['ColorBaseMatId']));
                    }else{
                        $pdf->SetFont('Arial', 'I', 8);
                        $pdf->Cell(25, 5, '');
                        $pdf->SetFont('Arial', '', 8);
                        $pdf->Cell(40, 5, $v2['FrontBack'] == 0 ? 'Vorderseite' : ($v2['FrontBack'] == 1 ? 'Rückseite' : 'Rückseite auf Kleber'));

                        $pdf->SetFont('Arial', 'I', 8);
                        $pdf->Cell(25, 5, '');
                        $pdf->SetFont('Arial', '', 8);
                        $pdf->Cell(45, 5, iconv('UTF-8', 'windows-1252', $v2['DeviceTypeId']));

                        $pdf->SetFont('Arial', 'I', 8);
                        $pdf->Cell(25, 5, '');
                        $pdf->SetFont('Arial', '', 8);
                        $pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', $v2['ColorBaseMatId']));
                    }

                    $pdf->ln(3);

                    $cnt++;
                }

                $pdf->ln(3);

                $cnt = 0;
                foreach($colorArray as $v2){
                    if($cnt == 0){
                        $pdf->SetFont('Arial', 'I', 8);
                        $pdf->Cell(25, 5, 'Farbe');
                        $pdf->SetFont('Arial', '', 8);
                        $pdf->Cell(40, 5, iconv('UTF-8', 'windows-1252', $v2['ColorName']));

                        $pdf->SetFont('Arial', 'I', 8);
                        $pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', 'Werkzeug'));
                        $pdf->SetFont('Arial', '', 8);
                        $pdf->Cell(45, 5, iconv('UTF-8', 'windows-1252', $v2['LPMRZProdToolId']));

                        $pdf->SetFont('Arial', 'I', 8);
                        $pdf->Cell(25, 5, 'Bemerkung');
                        $pdf->SetFont('Arial', '', 8);
                        $pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', $v2['MARDescription']));
                    }else{
                        $pdf->SetFont('Arial', 'I', 8);
                        $pdf->Cell(25, 5, '');
                        $pdf->SetFont('Arial', '', 8);
                        $pdf->Cell(40, 5, iconv('UTF-8', 'windows-1252', $v2['ColorName']));

                        $pdf->SetFont('Arial', 'I', 8);
                        $pdf->Cell(25, 5, '');
                        $pdf->SetFont('Arial', '', 8);
                        $pdf->Cell(45, 5, iconv('UTF-8', 'windows-1252', $v2['LPMRZProdToolId']));

                        $pdf->SetFont('Arial', 'I', 8);
                        $pdf->Cell(25, 5, '');
                        $pdf->SetFont('Arial', '', 8);
                        $pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', $v2['MARDescription']));
                    }

                    $pdf->ln(3);

                    $cnt++;
                }

                $imgYpos = 0;
                if(count($colorArray) <= 3){
                    $pdf->ln(40);
                    $pdf->SetLineWidth(0.5);
                    $pdf->Line(5, 175, 205, 175); 
                    $imgYpos = 200;
                }
                else if(count($colorArray) == 4){
                    $pdf->ln(25);
                    $pdf->SetLineWidth(0.5);
                    $pdf->Line(5, 185, 205, 185); 
                    $imgYpos = 200;      
                }else{
                    $pdf->ln(25);
                    $pdf->SetLineWidth(0.5);
                    $pdf->Line(5, 195, 205, 195);
                    $imgYpos = 210;
                }

                if(isset($v1['DesignJpgPreviewUrl'])){
                    if(@file_get_contents($v1['DesignJpgPreviewUrl']) !== FALSE)
                    {
                        $pdf->Image($v1['DesignJpgPreviewUrl'], 125, $imgYpos, -220);
                    }
                }

            }
            else if($simpleOrFullPDF == 'Simple'){
                $pdf->ln(5);

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(25, 10, "KundenNummer");
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(40, 10, $v1['CustVendRelation']);

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(25, 10, "FirmenName");
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(40, 10, iconv('UTF-8', 'windows-1252', $v1['Name']));

                $pdf->ln(10);

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(25, 10, "Stichwort");
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(40, 10, iconv('UTF-8', 'windows-1252', $v1['ExternalItemTxt']));

                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(35, 10, 'Version');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(40, 10, $v1['Version']);

                if(isset($v1['DesignJpgPreviewUrl'])){
                    if(@file_get_contents($v1['DesignJpgPreviewUrl']) !== FALSE)
                    {
                        $pdf->Image($v1['DesignJpgPreviewUrl'], 125, 50, -220);
                    }
                }
                $pdf->ln(20);
            }
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(100, 3, iconv('UTF-8', 'windows-1252', 'Copyright by Marzek Etiketten+Packaging GmbH - Das Eigentum und die Urheberrechte an diesem Design/Entwurf, an den produktionstechnischenVerfahrensentwicklungen und an den Daten liegen bei Marzek Etiketten+Packaging GmbH, jede (auch nur auszugsweise) Vervielfältigung oder sonstige Verwendungbedarf der ausdrücklichen Genehmigung der Marzek Etiketten+Packaging GmbH - Austria.Diese Daten sind ausschließlich für die interne Verwendung beim Geschäftspartner bestimmt und dürfen ohne Zustimmung der Marzek Etiketten+Packaging GmbH nicht an Dritte weitergegeben werden. Bei Aufforderung der Marzek Etiketten+Packaging GmbH sind diese Daten zu retournieren bzw. zu vernichten.'));
            $pdf->ln(2);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(100, 3, iconv('UTF-8', 'windows-1252', 'Disclaimer - Haftungsausschluss - Die Marzek Etiketten+Packaging GmbH übernimmt keine Haftung für die Rechtskonformität von beigestellten Sujets sowie von Korrekturen und Entwürfen, auch wenn diese von der Marzek Etiketten+Packaging GmbH selbst oder deren Erfüllungsgehilfen erstellt wurden. Dies betrifft insbesonders zum Beispiel Copyright, Wettbewerbsrecht, produktbezogene regionale und nationale Vorschriften in Österreich und anderen Staaten etc.'));
        }
    }
}


$pdf->Output();
?>