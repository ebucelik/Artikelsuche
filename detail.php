<?php
require_once("db.php");

$unEqualString = "";
$type = $itemId = $custAcc = $salesId = $version = $inventDimId = $prodGroupId = $invoiceId = $invoiceDate = $lPMRZBoardId = $lPMRZProdToolIdDieCut = $unEqualString;

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

$itemIdArray = $colorArray = $custArray = $notesArray = array();

//AxDev SQL queries 
require("getDataFromDB.php");
?>

<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marzek-Suche</title>

    <link rel="stylesheet" href="searching.css">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> 

    <script src="script.js"></script>
</head>
<body>
    <header>
        <a href="searching.php"><img src="Bilder/Version3.png" id="headerImg" title="Marzek Artikelsuche" alt="Marzek Artikelsuche Bild" width="400"></a>
    </header>

    <nav>
<?php if($itemIdArray){ foreach($itemIdArray as $v1){?>

        <div class="row" id="printBtn">
            <div class="col firstCols">
                <a target="_blank" href="createPDF.php?type=<?php echo $type; ?>&ItemId=<?php echo $v1['ItemId']; ?>&CustAcc=<?php echo $v1['CustVendRelation']; ?>&SalesId=<?php echo $v1['SalesId']; ?>&Version=<?php echo $v1['Version']; ?>&InventDimId=<?php echo $v1['InventDimId']; ?>&ProdGroupId=<?php echo $v1['ProdGroupId']; ?>&LPMRZBoardId=<?php echo $v1['LPMRZBoardId']; ?>&LPMRZProdToolIdDieCut=<?php echo $v1['LPMRZProdToolIdDieCut']; ?>&SimpleOrFullPDF=Full" style="color: #d80030;">
                    <button type="button" class="btn btn-lg printBtnStyle" style="width: 100%;">DRUCKANSICHT ANZEIGEN</button>
                </a>
            </div>
            <div class="col firstCols">
                <a <?php if($invoiceId == $unEqualString){?> href="#" <?php }else{ ?> target="_blank" href="http://intern.marzek.eu:88/Startseite/Dokumentenverwaltung/Ausgangsrechnungen/<?php echo $invoiceDate->format('Y'); ?>/<?php echo $invoiceDate->format('m'); ?>/<?php echo $invoiceId; ?>_<?php echo $v1['SalesId']; ?>_<?php echo $v1['CustVendRelation']; ?>.pdf" <?php } ?> style="color: #d80030;">
                    <button type="button" class="btn btn-lg printBtnStyle" <?php if($invoiceId == $unEqualString){?> style="opacity: 0.5; width: 100%; cursor: not-allowed" <?php } ?> style="width: 100%;">RECHNUNG ANZEIGEN</button>
                </a>
            </div>
            <div class="col firstCols">
            <a target="_blank" href="createPDF.php?type=<?php echo $type; ?>&ItemId=<?php echo $v1['ItemId']; ?>&CustAcc=<?php echo $v1['CustVendRelation']; ?>&SalesId=<?php echo $v1['SalesId']; ?>&Version=<?php echo $v1['Version']; ?>&InventDimId=<?php echo $v1['InventDimId']; ?>&ProdGroupId=<?php echo $v1['ProdGroupId']; ?>&LPMRZBoardId=<?php echo $v1['LPMRZBoardId']; ?>&LPMRZProdToolIdDieCut=<?php echo $v1['LPMRZProdToolIdDieCut']; ?>&SimpleOrFullPDF=Simple" style="color: #d80030;">
                    <button type="button" class="btn btn-lg printBtnStyle" style="width: 100%;">EINFACHE DRUCKANSICHT</button>
                </a>
            </div>
            <div class="col firstCols">
                <a <?php if(isset($v1['DesignJpgPreviewUrl'])){?> target="_blank" href="createImagePDF.php?DesignJpgPreviewUrl=<?php echo $v1['DesignJpgPreviewUrl'];?>" <?php }else{?> href=""<?php } ?>>
                    <button type="button" class="btn btn-lg printBtnStyle" <?php if(!isset($v1['DesignJpgPreviewUrl'])){?> style="opacity: 0.5; width: 100%; cursor: not-allowed" <?php } ?> style="width: 100%;">BILD ALS PDF ANZEIGEN</button>
                </a>
            </div>
            <div class="col firstCols">
                <a <?php if(isset($v1['DesignJpgPreviewUrl'])){?> target="_blank" href="showImagePNG.php?DesignJpgPreviewUrl=<?php echo $v1['DesignJpgPreviewUrl'];?>" <?php }else{?> href=""<?php } ?>>
                    <button type="button" class="btn btn-lg printBtnStyle" <?php if(!isset($v1['DesignJpgPreviewUrl'])){?> style="opacity: 0.5; width: 100%; cursor: not-allowed" <?php } ?> style="width: 100%;">BILD ALS JPG ANZEIGEN</button>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col firstCols">
                <div class="containerRow leftContainer">
                    <div class="row">
                        <div class="col titlerow">R-Nummer</div>
                        <div class="col"><?php echo $v1['ItemId'];?></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col titlerow">Version</div>
                        <div class="col"><?php echo $v1['Version'];?></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col titlerow">Produktvariante</div>
                        <div class="col"><?php echo $v1['ProdGroupId'];?></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col titlerow">Kundennummer</div>
                        <div class="col"><?php echo $v1['CustVendRelation'];?></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col titlerow">Kundenname</div>
                        <div class="col"><?php echo $v1['Name'];?></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col titlerow">Sorten Eindruck</div>
                        <div class="col"><?php echo $v1['Sort'];?></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col titlerow">Stichwort</div>
                        <div class="col"><?php echo $v1['ExternalItemTxt'];?></div>
                    </div>
                </div>
            </div>
            <div class="col align-self-center firstCols" style="text-align: center;">
            <?php if($v1['DesignJpgPreviewUrl']){?>
            <figure>
                <img src="data:image/jpg;base64, <?php echo base64_encode(file_get_contents($v1['DesignJpgPreviewUrl'])); ?>" title="<?php echo $v1['ItemId'];?>" style="max-width: 30%;"/><?php }else{ ?> <img src="Bilder/noimage.png" alt="Image not found" title="Image not found" style="max-width: 40%;"> <?php }  ?>
                <figcaption style="color: black;"><span>Letzte Änderung am </span><?php if(isset($v1['createdDateTime'])){echo $v1['createdDateTime']->format('d.m.Y');}?></figcaption>
            </figure>
            </div>
        </div>
        <div class="row" style="margin-top: 2%;">
            <div class="col firstCols">
                <div class="containerRow leftContainer">
                    <div class="row">
                        <div class="col titlerow">Papiernummer</div>
                        <div class="col"><?php if(isset($v1['LPMRZBoardId'])){echo $v1['LPMRZBoardId'];}?></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col titlerow">Papierbezeichnung</div>
                        <div class="col"><?php if(isset($v1['LPMRZBoardId'])){echo $v1['PaperName'];}?></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col titlerow">PapierzusatzBezeichnung</div>
                        <div class="col"><?php if(isset($v1['MARAdditionalDescription'])){echo $v1['MARAdditionalDescription'];}?></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col titlerow">PapierGrammaturBasisMaterial</div>
                        <div class="col"><?php if(isset($v1['MARAreaWeightBas'])){echo $v1['MARAreaWeightBas'];}?></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col titlerow">Papierart</div>
                        <div class="col"><?php if(isset($v1['MARPaperColor'])){echo $v1['MARPaperColor'];}?></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col titlerow">PapierKleberHinweis</div>
                        <div class="col"><?php if(isset($v1['MARGlue'])){echo $v1['MARGlue'];}?></div>
                    </div>
                </div>
            </div>
            <div class="col firstCols">
                <div class="containerRow rightToLeftRow rightContainer">
                    <div class="row">
                        <div class="col titlerow">Seite</div>

                        <div class="col titlerow">Aggregatstyp</div>

                        <div class="col titlerow">Rohmaterial</div>

                        <div class="col titlerow">Farbe</div>

                        <div class="col titlerow">Werkzeug</div>

                        <div class="col titlerow">Bemerkung</div>
                    </div>
                    <?php if($colorArray){ foreach($colorArray as $v2){?>
                    <hr>
                    <div class="row">
                        <div class="col"><?php echo $v2['FrontBack'] == 0 ? 'Vorderseite' : ($v2['FrontBack'] == 1 ? 'Rückseite' : 'Rückseite auf Kleber') ?></div>

                        <div class="col"><?php echo $v2['DeviceTypeId']?></div>

                        <div class="col"><?php echo $v2['ColorBaseMatId']?></div>

                        <div class="col"><?php echo $v2['ColorName']?></div>

                        <div class="col"><?php echo $v2['LPMRZProdToolId']?></div>

                        <div class="col"><?php echo $v2['MARDescription']?></div>
                    </div>
                    <?php } }?>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 2%;">
            <div class="col firstCols">
                <div class="containerRow leftContainer">
                    <div class="row">
                        <div class="col titlerow">Stanznummer</div>
                        <div class="col"><?php if(isset($v1['LPMRZProdToolIdDieCut'])){echo $v1['LPMRZProdToolIdDieCut'];}?></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col titlerow">Stanzform</div>
                        <div class="col"><?php if(isset($v1['CalcDesignStyleId'])){echo $v1['CalcDesignStyleId'];}?></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col titlerow">FormatQuer</div>
                        <div class="col"><?php echo $v1['LEPSizeW'];?></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col titlerow">FormatLaufrichtung</div>
                        <div class="col"><?php echo $v1['LEPSizeL'];?></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col titlerow">Stellung</div>
                        <div class="col"><?php if(isset($v1['TradeUnitSpecId'])){echo $v1['TradeUnitSpecId'];}?></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col titlerow">StückLM</div>
                        <div class="col"><?php if(isset($v1['LPMRZMaxAllowedQty'])){echo $v1['LPMRZMaxAllowedQty'];}?></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col titlerow">RolleBogen</div>
                        <div class="col"><?php if(isset($v1['TradeUnitGroupId'])){echo $v1['TradeUnitGroupId'];}?></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col titlerow">InnenDM</div>
                        <div class="col"><?php if(isset($v1['TradeUnitId'])){echo substr($v1['TradeUnitId'], 3, 2);}?></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col titlerow">AußenDM</div>
                        <div class="col"><?php if(isset($v1['LPMRZMaxDiameterOuter'])){echo $v1['LPMRZMaxDiameterOuter'];}?></div>
                    </div>
                </div>
            </div>
            <div class="col firstCols">
                <div class="containerRow rightToLeftRow rightContainer">
                    <div class="row">
                        <div class="col titlerow">Letzte Auftragsnummer</div>
                        <div class="col"><?php echo $v1['SalesId'];?></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col titlerow">Maschine(n)</div>
                        <div class="col"><?php echo $v1['WorkCenters'];?></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col titlerow">Lagerstand</div>
                        <div class="col"><?php echo $v1['StockLevel'];?></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col titlerow">GTIN</div>
                        <div class="col"><?php if(isset($v1['ExternalItemId'])){echo $v1['ExternalItemId'];}?></div>
                    </div>
                </div>
            </div>
        </div> 

        <div class="custInfo">
            <h2 id="custInfoTitle">Kundeninformationen</h2>
        </div>

        <?php if($custArray){ foreach($custArray as $v3){ ?>
        <div class="row">
            <div class="col">
                <div class="containerRow leftContainer">
                <?php if($v1['CustVendRelation']){?>
                    <div class="row">
                        <div class="col titlerow">Kundennummer</div>
                        <div class="col"><?php echo $v1['CustVendRelation'];?></div>
                    </div>
                    <hr/>
                <?php } ?>
                <?php if($v1['Name']){?>
                    <div class="row">
                        <div class="col titlerow">Firmenname</div>
                        <div class="col"><?php echo $v1['Name'];?></div>
                    </div>
                    <hr/>
                <?php } ?>
                <?php if(isset($v1['Branche'])){?>
                    <div class="row">
                        <div class="col titlerow">Branche</div>
                        <div class="col"><?php echo $v1['Branche'];?></div>
                    </div>
                    <hr/>
                <?php } ?>
                <?php if($v3['Street']){?>
                    <div class="row">
                        <div class="col titlerow">Straße</div>
                        <div class="col"><?php echo $v3['Street'];?></div>
                    </div>
                    <hr/>
                <?php } ?>
                <?php if($v3['CountryRegionId']){?>
                    <div class="row">
                        <div class="col titlerow">Land</div>
                        <div class="col"><?php echo $v3['CountryRegionId'];?></div>
                    </div>
                    <hr/>
                <?php } ?>
                <?php if($v1['ZipCode']){?>
                    <div class="row">
                        <div class="col titlerow">PLZ</div>
                        <div class="col"><?php echo $v1['ZipCode'];?></div>
                    </div>
                    <hr/>
                <?php } ?>
                <?php if(isset($v1['Steuernummer'])){?>
                    <div class="row">
                        <div class="col titlerow">Steuernummer</div>
                        <div class="col"><?php echo $v1['Steuernummer'];?></div>
                    </div>
                    <hr>
                <?php } ?>
                <?php if($v1['City']){?>
                    <div class="row">
                        <div class="col titlerow">Ort</div>
                        <div class="col"><?php echo $v1['City'];?></div>
                    </div>
                <?php } ?>
                </div>
            </div>
            <div class="col firstCols">
                <div class="containerRow rightToLeftRow rightContainer">
                <?php if($v3['ContactPerson']){?>
                    <div class="row">
                        <div class="col titlerow">VAD</div>
                        <div class="col"><?php echo $v3['ContactPerson'];?></div>
                    </div>
                <?php } ?>
                    <?php if($v3['Phone'] && $v3['Mobile'] != 'Mobil'){?>
                    <hr/>
                    <div class="row">
                        <div class="col titlerow">Telefon</div>
                        <div class="col"><?php echo $v3['Phone'];?></div>
                    </div>
                    <?php } ?>
                    <?php if($v3['Fax']){?>
                    <hr/>
                    <div class="row">
                        <div class="col titlerow">Fax</div>
                        <div class="col"><?php echo $v3['Fax'];?></div>
                    </div>
                    <?php } ?>
                <?php if($v3['Phone'] && $v3['Mobile'] == 'Mobil'){?>
                    <hr/>
                    <div class="row">
                        <div class="col titlerow">Mobil</div>
                        <div class="col"><?php echo $v3['Phone'];?></div>
                    </div>
                <?php } ?>
                    <?php if($v3['EMail']){?>
                    <hr/>
                    <div class="row">
                        <div class="col titlerow">E-Mail</div>
                        <div class="col"><?php echo $v3['EMail'];?></div>
                    </div>
                    <?php } ?>
                    <?php if($v3['WebSite']){?>
                    <hr/>
                     <div class="row">
                        <div class="col titlerow">Website</div>
                        <div class="col"><?php echo $v3['WebSite'];?></div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <?php if($notesArray){?>
        <div class="custInfo">
            <h2 id="custInfoTitle">Sonstiges</h2>
        </div>

        <div class="row">
            <div class="col">
                <div class="containerRow leftContainer">
                    <?php foreach($notesArray as $v4){?>
                        <div class="row">
                            <div class="col titlerow"><?php echo $v4['TypeId'];?></div>
                            <div class="col"><?php echo $v4['Notes'];?></div>
                        </div>
                        <hr/>
                    <?php } ?>
                </div>
            </div>
            <div class="col">
            </div>
        </div>
        <?php } ?>

        <?php } } ?>
<?php } } ?>  
    </nav>
</body>
</html>