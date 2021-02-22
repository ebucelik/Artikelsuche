<?php
require_once('db/db.php');
ini_set('session.cache_limiter', 'private');
session_start();

$unEqualString = "";
$type = $withSalesId = $rNumber = $custnumber = $custName = $plz = $city = $sort = $keyword = $allVersions = $withImage = $custNumEmail = $format = $material = $stockLevel = $unEqualString; //We need to set it to something because otherwise the SQL Statement doesn't work
$newSearch = "false";
$itemQty = 0;
$itemsStart = 0;
$checkSort = false;
$itemIdArray = array();

if(isset($_SESSION["itemIdArray"])){
    $itemIdArray = $_SESSION["itemIdArray"];
}

if(isset($_SESSION["selectType"]) && $_SESSION["selectType"] != ''){
    $type = $_SESSION["selectType"];
}

if(isset($_SESSION["rNumber"]) && $_SESSION["rNumber"] != ''){
    $rNumber = $_SESSION["rNumber"];
}

if(isset($_SESSION["kNumber"]) && $_SESSION["kNumber"] != ''){
    $custnumber = $_SESSION["kNumber"];
}

if(isset($_SESSION["kName"]) && $_SESSION["kName"] != ''){
    $custName = $_SESSION["kName"];
}

if(isset($_SESSION["kPLZ"]) && $_SESSION["kPLZ"] != ''){
    $plz = $_SESSION["kPLZ"];
}

if(isset($_SESSION["place"]) && $_SESSION["place"] != ''){
    $city = $_SESSION["place"];
}

if(isset($_SESSION["sortNum"]) && $_SESSION["sortNum"] != ''){
    $sort = $_SESSION["sortNum"];
}

if(isset($_SESSION["keyWord"]) && $_SESSION["keyWord"] != ''){
    $keyword = $_SESSION["keyWord"];
}

if(isset($_SESSION["allVersions"]) && $_SESSION["allVersions"] != ''){
    $allVersions = $_SESSION["allVersions"];
}

if(isset($_SESSION["withImage"]) && $_SESSION["withImage"] != ''){
    $withImage = $_SESSION["withImage"];
}else{
    $withImage = $unEqualString;
}

if(isset($_SESSION["stockLevel"]) && $_SESSION["stockLevel"] != ''){
    $stockLevel = $_SESSION["stockLevel"];
}

if(isset($_SESSION["itemsStart"]) && $_SESSION["itemsStart"] != ''){
    $itemsStart = $_SESSION["itemsStart"];
}

if(isset($_SESSION["withSalesId"]) && $_SESSION["withSalesId"] != ''){
    $withSalesId = $_SESSION["withSalesId"];
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['selectType']) && $_POST['selectType'] != ''){
        $type = $_POST['selectType'];
        $_SESSION["selectType"] = $type;
    }

    if(isset($_POST['rNumber']) && $_POST['rNumber'] != ''){
        $rNumber = $_POST['rNumber'];
        $_SESSION["rNumber"] = $rNumber;
    }else{
        $rNumber = $unEqualString;
        $_SESSION["rNumber"] = $rNumber;
    }

    if(isset($_POST['kNumber']) && $_POST['kNumber'] != ''){
        $custnumber = $_POST['kNumber'];
        $_SESSION["kNumber"] = $custnumber;
    }else{
        $custnumber = $unEqualString;
        $_SESSION["kNumber"] = $custnumber;
    }

    if(isset($_POST['kName']) && $_POST['kName'] != ''){
        $custName = $_POST['kName'];
        $_SESSION["kName"] = $custName;
    }else{
        $custName = $unEqualString;
        $_SESSION["kName"] = $custName;
    }

    if(isset($_POST['kPLZ']) && $_POST['kPLZ'] != ''){
        $plz = $_POST['kPLZ'];
        $_SESSION["kPLZ"] = $plz;
    }else{
        $plz = $unEqualString;
        $_SESSION["kPLZ"] = $plz;
    }

    if(isset($_POST['place']) && $_POST['place'] != ''){
        $city = $_POST['place'];
        $_SESSION["place"] = $city;
    }else{
        $city = $unEqualString;
        $_SESSION["place"] = $city;
    }

    if(isset($_POST['sortNum']) && $_POST['sortNum'] != ''){
        $sort = $_POST['sortNum'];
        $_SESSION["sortNum"] = $sort;
    }else{
        $sort = $unEqualString;
        $_SESSION["sortNum"] = $sort;
    }

    if(isset($_POST['keyWord']) && $_POST['keyWord'] != ''){
        $keyword = $_POST['keyWord'];
        $_SESSION["keyWord"] = $keyword;
    }else{
        $keyword = $unEqualString;
        $_SESSION["keyWord"] = $keyword;
    }

    if(isset($_POST['allVersions'])){
        $allVersions = $_POST['allVersions'];
        $_SESSION["allVersions"] = $allVersions;
    }else{
        $allVersions = $unEqualString;
        $_SESSION["allVersions"] = $allVersions;
    }

    if(isset($_POST['withImage'])){
        $withImage = $_POST['withImage'];
        $_SESSION["withImage"] = $withImage;
    }else{
        $withImage = $unEqualString;
        $_SESSION["withImage"] = $withImage;
    }

    if(isset($_POST['Format']) && $_POST['Format'] != ''){
        $format = $_POST['Format'];
    }

    if(isset($_POST['Material']) && $_POST['Material'] != ''){
        $material = $_POST['Material'];
    }

    if(isset($_POST['stockLevel'])){
        $stockLevel = $_POST['stockLevel'];
        $_SESSION["stockLevel"] = $stockLevel;
    }else{
        $stockLevel = $unEqualString;
        $_SESSION["stockLevel"] = $stockLevel;
    }

    if(isset($_POST['itemsStart'])){
        $itemsStart = $_POST['itemsStart'];
        $_SESSION["itemsStart"] = $itemsStart;
    }

    if(isset($_POST['newSearch'])){
        $newSearch = $_POST['newSearch'];
    }

    if(isset($_POST['withSalesId'])){
        $withSalesId = $_POST['withSalesId'];
        $_SESSION["withSalesId"] = $withSalesId;
    }else{
        $withSalesId = $unEqualString;
        $_SESSION["withSalesId"] = $withSalesId;
    }
} 
?>

<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marzek-Suche</title>

    <link rel="stylesheet" href="css/searching.css">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> 

    <script src="scripts/script.js"></script>
</head>
<body>
    <div id="loaderBackground"></div> 

    <div class="loader"></div>
    
    <div id="loaderTextDiv"><h5 id="loaderText"></h5></div>

    <header>
        <a href="index.php" ><img src="Bilder/Version3.png" id="headerImg" title="Marzek Artikelsuche" alt="Marzek Artikelsuche Bild" width="400"></a>
    </header>

    <nav>
        <div class="container" id="inputFields">
            <form action="" method="POST">
                <div class="form-group fading searchForm">
                    <label for="selectType" class="align-self-center labelTxt">Rolle/Bogen:</label>
                    <select class="form-control searchInput" id="selectType" name="selectType" onchange="changeTitle()">
                        <option <?php if($type == "Rollenetiketten"){ echo "selected";} ?> >Rollenetiketten</option>
                        <option <?php if($type == "Bogenetiketten"){ echo "selected";} ?> >Bogenetiketten</option>
                    </select>
                </div>
                <div class="form-group fading searchForm">
                    <label for="rNumber" class="align-self-center labelTxt" id="Rnumber">R-Nummer:</label>
                    <input type="text" class="form-control searchInput" id="rNumber" placeholder="R-Nummer eingeben" name="rNumber" value="<?php if($rNumber != $unEqualString){echo $rNumber;} ?>">
                </div>
                <div class="form-group fading searchForm">
                    <label for="kNumber" class="align-self-center labelTxt">Kundennummer:</label>
                    <input type="number" class="form-control searchInput" id="kNumber" placeholder="Kundennummer eingeben" name="kNumber" value="<?php if($custnumber != $unEqualString){echo $custnumber;} ?>">
                </div>
                <div class="form-group fading searchForm">
                    <label for="kName" class="align-self-center labelTxt">Kundenname:</label>
                    <input type="text" class="form-control searchInput" id="kName" placeholder="Kundenname eingeben" name="kName" value="<?php if($custName != $unEqualString){echo $custName;} ?>">
                </div>
                <div class="form-group fading searchForm">
                    <label for="kPLZ" class="align-self-center labelTxt">PLZ:</label>
                    <input type="number" class="form-control searchInput" id="kPLZ" placeholder="PLZ eingeben" name="kPLZ" value="<?php if($plz != $unEqualString){echo $plz;} ?>">
                </div>
                <div class="form-group fading searchForm">
                    <label for="place" class="align-self-center labelTxt">Ort:</label>
                    <input type="text" class="form-control searchInput" id="place" placeholder="Ort eingeben" name="place" value="<?php if($city != $unEqualString){echo $city;} ?>">
                </div>
               <!-- <div class="form-group fading searchForm">
                    <label for="sortNum" class="align-self-center labelTxt">Sorten Eindruck:</label>
                    <input type="text" class="form-control searchInput" id="sortNum" placeholder="Sorten Eindruck eingeben" name="sortNum" value="<?php if($sort != $unEqualString){echo $sort;} ?>">
                </div> -->
                <div class="form-group fading searchForm">
                    <label for="keyWord" class="align-self-center labelTxt">Stichwort:</label>
                    <input type="text" class="form-control searchInput" id="keyWord" placeholder="Stichwort eingeben" name="keyWord" value="<?php if($keyword != $unEqualString){echo $keyword;} ?>">
                </div>
                <div class="form-group fading searchForm" id="parameterContainer">
                    <label for="selectParameter" class="align-self-center labelTxt">Weitere Parameter:</label>
                    <select class="form-control searchInput" id="selectParameter" name="selectParameter" onchange="addInputfield()">
                        <option>Parameter auswählen</option>
                        <option>Format</option>
                        <option>Material</option>
                    </select>
                </div>
                <div class="form-group fading">
                    <label for="allVersions">Alle Versionen:</label>
                    <input type="checkbox" class="form-control" id="allVersions" name="allVersions" style="width: 20px; height: 20px; display: unset;" <?php if($allVersions == 'on'){echo 'checked';} ?>>
                    <label for="withImage" style="margin-left: 3%; ">Bild vorhanden:</label>
                    <input type="checkbox" class="form-control" id="withImage" name="withImage" style="width: 20px; height: 20px; display: unset;" <?php if($withImage == 'on'){echo 'checked';} ?>>
                    <label for="stockLevel" style="margin-left: 3%; ">Lagerstand:</label>
                    <input type="checkbox" class="form-control" id="stockLevel" name="stockLevel" style="width: 20px; height: 20px; display: unset;" <?php if($stockLevel == 'on'){echo 'checked';} ?>>
                    <label for="withSalesId" id="withSalesIdLabel" style="margin-left: 3%; ">Auftrag vorhanden:</label>
                    <input type="checkbox" class="form-control" id="withSalesId" name="withSalesId" style="width: 20px; height: 20px; display: unset;" <?php if($withSalesId == 'on'){echo 'checked';} ?>>
                </div>
                <input type="hidden" name="itemsStart" value="0" />
                <input type="hidden" name="newSearch" value="true" />
                <button type="submit" class="btn btn-outline-light fading" id="articlesearch">SUCHEN</button>
                <div class="row">
                    <div class="col">
                        <button type="button" class=" btn-primary mailbtns" id="sendmailJpg" onclick="sendMailJpg();">EINZELNE JPG'S SENDEN</button>
                    </div>
                    <div class="col">
                        <button type="button" class=" btn-primary mailbtns" id="sendmailSinglePdf" onclick="sendMailSinglePdfs();">EINZELNE PDF'S SENDEN</button>
                    </div>
                    <div class="col">
                        <button type="button" class=" btn-primary mailbtns" id="sendmailPdf" onclick="sendMailPdf();">LAGERSTAND SENDEN</button>
                    </div>
                </div>
            </form>

            <div id="toStartBtn">
               <img src="Bilder/arrowUp.png" onclick='toStart()' title="Nach Oben" alt="Nach Oben" style="max-width: 100%; cursor: pointer; color: white;">
            </div>
        </div>

<?php

function fillItemArray($_stmt){
    $_itemIdArray = array();

    //TODO: Implement 'MARPngPath' => $val['MARPngPath']
    foreach($_stmt as $val){
        if($val['ItemId'] != ''){
            array_push($_itemIdArray, array('ItemId' => $val['ItemId'], 'Version' => $val['InventStyleId'], 'InventDimId' => $val['InventDimId'], 'ProdGroupId' => $val['ProdGroupId'], 
            'CustVendRelation' => $val['CustVendRelation'], 'Name' => $val['CustName'], 'ExternalItemTxt' => $val['ExternalItemTxt'], 
            'LEPSizeW' => intval($val['LEPSizeW']), 'LEPSizeL' => intval($val['LEPSizeL']),
            'TradeUnitSpecId' => $val['TradeUnitSpecId'], 'DesignJpgPreviewUrl' => $val['DesignJpgPreviewUrl'], 'SalesId' => $val['SalesIdLast'], 
            'WorkCenters' => $val['WorkCenters'], 'StockLevel' => $val['StockLevel'], 'Sort' => $val['MARInprintingSortName'], 'LPMRZBoardId' => $val['LPMRZBoardId'], 'LPMRZProdToolIdDieCut' => $val['LPMRZProdToolIdDieCut'])
            );
        }
        
        /*if($val['MARInprintingSortName']){
            $GLOBALS["checkSort"] = true;
        }*/
    }

    return $_itemIdArray;
}

if($newSearch == "true"){
    try{
        $queryParams = "";
    
        if($rNumber != $unEqualString){
            $queryParams = "T1.ItemId LIKE '%$rNumber%'";  
        }
    
        if($custnumber != $unEqualString){
            if($queryParams == ""){
                $queryParams = "T1.CustVendRelation = '$custnumber'";
            }else{
                $queryParams .=" AND T1.CustVendRelation = '$custnumber'";
            }
        }
    
        if($custName != $unEqualString){
            if($queryParams == ""){
                $queryParams = "T1.CustName LIKE '%$custName%'";
            }else{
                $queryParams .=" AND T1.CustName LIKE '%$custName%'";
            }
        }
    
        if($plz != $unEqualString){
            if($queryParams == ""){
                $queryParams = "T1.ZipCode LIKE '%$plz%'";
            }else{
                $queryParams .=" AND T1.ZipCode LIKE '%$plz%'";
            }
        }
    
        if($city != $unEqualString){
            if($queryParams == ""){
                $queryParams = "T1.City LIKE '%$city%'";
            }else{
                $queryParams .=" AND T1.City LIKE '%$city%'";
            }
        }

        if($keyword != $unEqualString){
            if($queryParams == ""){
                $queryParams = "T1.ExternalItemTxt LIKE '%$keyword%'";
            }else{
                $queryParams .=" AND T1.ExternalItemTxt LIKE '%$keyword%'";
            }
        }
    
        if($withImage == "on"){
            if($queryParams == ""){
                $queryParams = "T1.DesignJpgPreviewUrl != ''";
            }else{
                $queryParams .=" AND T1.DesignJpgPreviewUrl != ''";
            }
        }
    
        if($type == "Rollenetiketten" && $queryParams != ""){
            $queryParams .=" AND T1.MARItemType = 4 AND T1.InventStyleId != '' AND T1.InventDimId != '' ";
        }else if($queryParams != ""){
            $queryParams .=" AND T1.MARItemType = 12";
        }
    
        //Deactivated articles. 0 stands for No regarding NoYes Enum. % at the end, selects all strings that have ## at the start of the string.
        if($queryParams != $unEqualString){
            $queryParams .= " AND T1.ItemStopped = 0 AND T1.ExternalItemTxt NOT LIKE '##%'";
        }
    
        if($stockLevel == "on"){
            if($queryParams != $unEqualString){
                $queryParams .=" AND T1.StockLevel != 0";
            }
        }

        if($withSalesId == "on"){
            if($queryParams != $unEqualString){
                $queryParams .=" AND T1.SalesIdLast != ''";
            }
        }
    
        if($allVersions == 'on'){ //ALL VERSIONS PART
            $stmt = $conn->prepare("SELECT T1.ItemId, T1.InventStyleId, T1.ProdGroupId, T1.CustVendRelation, T1.CustName, T1.ExternalItemTxt, 
                                        T1.LEPSizeL, T1.LEPSizeW, T1.InventDimId, T1.SalesIdLast, T1.WorkCenters, T1.StockLevel, T1.MARInprintingSortName, T1.LPMRZBoardId, T1.LPMRZProdToolIdDieCut,
                                        T1.TradeUnitSpecId, T1.DesignJpgPreviewUrl
                                        FROM MARItemSearchDataTable T1
                                        WHERE $queryParams ORDER BY T1.InventStyleId");
    
            $stmt->execute();
    
            $itemIdArray = fillItemArray($stmt);
            $_SESSION["itemIdArray"] = $itemIdArray;
        }
        else{ //HIGHEST VERSION PART
            if($queryParams != $unEqualString){
                $queryParams .= " AND T1.SalesIdLast IN (SELECT MAX(T11.SalesIdLast) AS style FROM MARItemSearchDataTable T11 WHERE T11.ItemId = T1.ItemId)";
    
                $stmt = $conn->prepare("SELECT T1.ItemId, T1.InventStyleId, T1.ProdGroupId, T1.CustVendRelation, T1.CustName, T1.ExternalItemTxt, 
                                            T1.LEPSizeL, T1.LEPSizeW, T1.InventDimId, T1.SalesIdLast, T1.WorkCenters, T1.StockLevel, 
                                            T1.MARInprintingSortName, T1.LPMRZBoardId, T1.LPMRZProdToolIdDieCut,
                                            T1.TradeUnitSpecId, T1.DesignJpgPreviewUrl
                                            FROM MARItemSearchDataTable T1
                                            WHERE $queryParams ORDER BY T1.InventStyleId"); 

                $stmt->execute();
                
                $itemIdArray = fillItemArray($stmt);
                $_SESSION["itemIdArray"] = $itemIdArray;
            }else{
                $itemIdArray = null;
                $_SESSION["itemIdArray"] = $itemIdArray;
            }
        }
    }
    catch(PDOException $e) 
    {
        echo "Error: " . $e->getMessage();
    }
}

$conn = null;
?>

<?php
function filterArrayForValidImages($item){
    if(@file_get_contents($item['DesignJpgPreviewUrl']) !== FALSE){
        return TRUE;
    }
    else{
        return FALSE;
    }
}

if($itemIdArray){
    if($withImage == 'on'){
        //Filter array and return array only with valid Images. Means: No "noimage.png" images included.
        $itemIdArray = array_filter($itemIdArray, "filterArrayForValidImages");
    }

    $itemQty = count($itemIdArray);
?>

<div class="row">
    <div class="col" id="allItemsButtons">
        <button id="checkAllBtn" class="btn btn-outline-light" onclick="checkAll()">Alle Artikel auswählen</button>
        <button id="checkAllWithStockBtn" class="btn btn-outline-light" onclick="checkAllWithStock()">Alle Artikel mit Lagerstand auswählen</button>
        <h5 id="selectedItemQty" style="display: inline-block; color: black;"></h5>
    </div>
    <div class="col" style="text-align: center;">
        <h5 style="display: inline-block; color: black;"><?php echo $itemsStart . " bis "; echo (($itemsStart + 50) < $itemQty) ? ($itemsStart + 50) : $itemQty; echo " von " . $itemQty . " Artikel"?></h5>
    </div>
     <div class="col" style="text-align: right;">
        <button id="firstItems" class="btn btn-outline-light" <?php if($itemQty <= 50){echo "disabled='disabled'";} ?>><img id="endLeft" src="Bilder/endLeft.png" width="25"/></button>
        <button id="leastItems" class="btn btn-outline-light" <?php if(($itemsStart - 50) < 0){echo "disabled='disabled'";} ?>><img id="leftArrow" src="Bilder/leftArrow.png" width="25"/></button>
        <button id="nextItems" class="btn btn-outline-light" <?php if(($itemsStart + 50) > $itemQty){echo "disabled='disabled'";} ?>><img id="rightArrow" src="Bilder/rightArrow.png" width="25"/></button>
        <button id="lastItems" class="btn btn-outline-light" <?php if($itemQty <= 50){echo "disabled='disabled'";} ?>><img id="endRight" src="Bilder/endRight.png" width="25"/></button>
    </div>
</div>
        <div id="dataView">
            <div class="containerRow">
                <div class="row titlerow" id="itemHeader">
                    <div class="col checkbox"></div>
                    <div class="col">Artikelnr.</div>
                    <div class="col">Version</div>
                    <?php if($allVersions == 'on'){?><div class="col">Produktvariante</div><?php } ?>
                    <div class="col">Kundennr.</div>
                    <div class="col">Kunde</div>
                    <?php //if($checkSort){?><!--<div class="col">Sorten Eindruck</div>--><?php //}?>
                    <div class="col" style="flex-grow:2;">Stichwort</div>
                    <div class="col">Format Quer</div>
                    <div class="col">Format Lauf</div>
                    <div class="col">Stellung</div>
                    <div class="col">Auftragsnr.</div>
                    <div class="col">Maschine</div>
                    <div class="col">Lagerstand</div>
                    <div class="col">Bild</div>
                    <div class="col">Drucken</div>
                </div>

                <!-- Show data here with a foreach over the div (PHP) -->
                <?php 
                function addItemsToView($v1)
                {
                ?>
                    <div class="row">
                        <div class="col align-self-center checkbox"><input type="checkbox" class="form-control sendMailCheck" style="width: 20px; height: 20px;" unchecked></div>
                        <div class="col align-self-center itemid"><a style="color: black;" href="detail.php?type=<?php if(isset($_SESSION['selectType'])){echo $_SESSION['selectType'];} ?>&ItemId=<?php echo $v1['ItemId']; ?>&CustAcc=<?php echo $v1['CustVendRelation']; ?>&SalesId=<?php echo $v1['SalesId']; ?>&Version=<?php echo $v1['Version']; ?>&InventDimId=<?php echo $v1['InventDimId']; ?>&ProdGroupId=<?php echo $v1['ProdGroupId']; ?>&LPMRZBoardId=<?php echo $v1['LPMRZBoardId'] ?>&LPMRZProdToolIdDieCut=<?php echo $v1['LPMRZProdToolIdDieCut'] ?>"><?php echo $v1['ItemId']; ?></a></div>
                        <div class="col align-self-center version"><?php echo $v1['Version']; ?></div>
                        <?php if($GLOBALS["allVersions"] == 'on'){?><div class="col align-self-center prodgroupid"><?php echo $v1['ProdGroupId']; ?></div><?php } ?>
                        <div class="col align-self-center custvendrelation"><?php echo $v1['CustVendRelation']; ?></div>
                        <div class="col align-self-center name"><?php echo $v1['Name']; ?></div>
                        <?php //if($v1['Sort']){?><!-- <div class="col align-self-center sort"> <?php //echo $v1['Sort']; ?></div> --><?php //}?>
                        <div class="col align-self-center externalitemtxt" style="flex-grow:2;"><?php echo $v1['ExternalItemTxt']; ?></div>
                        <div class="col align-self-center lepsizew"><?php echo $v1['LEPSizeW']; ?></div>
                        <div class="col align-self-center lepsizel"><?php echo $v1['LEPSizeL']; ?></div>
                        <div class="col align-self-center tradeunitspecid"><?php echo $v1['TradeUnitSpecId']; ?></div>
                        <div class="col align-self-center salesid"><?php echo $v1['SalesId']; ?></div>
                        <div class="col align-self-center workcenters"><?php echo $v1['WorkCenters']; ?></div>
                        <div class="col align-self-center stocklevel"><?php echo $v1['StockLevel']; ?></div>
                        <div class="col align-self-center itemImage">
                            <?php if($v1['DesignJpgPreviewUrl']){ ?>
                                <img title="Bild öffnen" class="designjpgpreviewurl" <?php if(@file_get_contents($v1['DesignJpgPreviewUrl']) !== FALSE){ ?> onclick="openImage('<?php echo base64_encode(@file_get_contents($v1['DesignJpgPreviewUrl'])); ?>', '<?php echo $v1['ItemId']; ?>')" <?php } ?> src="<?php if(@file_get_contents($v1['DesignJpgPreviewUrl']) === FALSE){ echo 'Bilder/noimage.png'; }else{ echo 'data:image/jpg;base64,' . base64_encode(file_get_contents($v1['DesignJpgPreviewUrl'])); } ?>" style="height: 50px; width: 50px; cursor: pointer;"/>
                            <?php } ?>
                        </div>
                        <div class="col align-self-center printImg"><a target="_blank" href="createPDF.php?type=<?php if(isset($_SESSION['selectType'])){echo $_SESSION['selectType'];} ?>&ItemId=<?php echo $v1['ItemId']; ?>&CustAcc=<?php echo $v1['CustVendRelation']; ?>&SalesId=<?php echo $v1['SalesId']; ?>&Version=<?php echo $v1['Version']; ?>&InventDimId=<?php echo $v1['InventDimId']; ?>&ProdGroupId=<?php echo $v1['ProdGroupId']; ?>&LPMRZBoardId=<?php echo $v1['LPMRZBoardId'] ?>&LPMRZProdToolIdDieCut=<?php echo $v1['LPMRZProdToolIdDieCut'] ?>&SimpleOrFullPDF=Full" style="color: #d80030;"><img src="Bilder/drucker.png" class="print" title="Drucken" alt="Drucken" width="35"></a></div>
                    </div>
                    <hr/>
                <?php 
                }

                if($withImage == 'on'){
                    $tmpItemArray = array();

                    $tmpItemArray = array_slice($itemIdArray, $itemsStart, 50);

                    foreach($tmpItemArray as $key => $v1)
                    { 
                        if(@file_get_contents($v1['DesignJpgPreviewUrl']) !== FALSE){
                            addItemsToView($v1);
                        }
                    }
                }else{
                    $tmpItemArray = array();

                    $tmpItemArray = array_slice($itemIdArray, $itemsStart, 50);

                    foreach($tmpItemArray as $key => $v1)
                    { 
                        addItemsToView($v1);
                    }
                }
                ?>
            </div>
            <div class="row">
                <div class="col" style="text-align: right;">
                    <button id="firstItemsBottom" class="btn btn-outline-light" <?php if($itemQty <= 50){echo "disabled='disabled'";} ?>><img id="endLeftBottom" src="Bilder/endLeft.png" width="25"/></button>
                    <button id="leastItemsBottom" class="btn btn-outline-light" <?php if(($itemsStart - 50) < 0){echo "disabled='disabled'";} ?>><img id="leftArrowBottom" src="Bilder/leftArrow.png" width="25"/></button>
                    <button id="nextItemsBottom" class="btn btn-outline-light" <?php if(($itemsStart + 50) > $itemQty){echo "disabled='disabled'";} ?>><img id="rightArrowBottom" src="Bilder/rightArrow.png" width="25"/></button>
                    <button id="lastItemsBottom" class="btn btn-outline-light" <?php if($itemQty <= 50){echo "disabled='disabled'";} ?>><img id="endRightBottom" src="Bilder/endRight.png" width="25"/></button>
                </div>
            </div>

            <?php } ?>
        </div>

        <div id="myModal" class="modal">
            <!-- The Close Button -->
            <span class="close">×</span>

            <!-- Modal Content (The Image) -->
            <img class="modal-content" id="showImg">

            <!-- Modal Caption (Image Text) -->
            <div id="caption"></div>
        </div>

        <form id="sendMailForm" method="POST" action="sendMail.php">
            <input type="hidden" name="email" value="" />
            <input type="hidden" name="data" value="" />
            <input type="hidden" name="singlePdf" value="" />
            <input type="hidden" name="Pdf" value="" />
        </form>
        <form id="showNextItems" method="POST" action="searching.php">
            <input type="hidden" name="selectType" value="" />
            <input type="hidden" name="rNumber" value="" />
            <input type="hidden" name="kNumber" value="" />
            <input type="hidden" name="kName" value="" />
            <input type="hidden" name="kPLZ" value="" />
            <input type="hidden" name="place" value="" />
            <input type="hidden" name="sortNum" value="" />
            <input type="hidden" name="keyWord" value="" />
            <input type="hidden" name="allVersions" value="" />
            <input type="hidden" name="withImage" value="" />
            <input type="hidden" name="stockLevel" value="" />
            <input type="hidden" name="itemsStart" value="" />
            <input type="hidden" name="newSearch" value="false" />
            <input type="hidden" name="withSalesId" value="" />
        </form>
    </nav>
</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    function getNextItems(){
        let itemsStart = <?php echo $itemsStart; ?>;
        itemsStart = itemsStart + 50;

        let showNextItems = document.getElementById("showNextItems");
        setItemForm(showNextItems, itemsStart);

        showNextItems.submit();
    };

    function getLeastItems(){
        let itemsStart = <?php echo $itemsStart; ?>;
        itemsStart = itemsStart - 50;
        
        let showNextItems = document.getElementById("showNextItems");
        setItemForm(showNextItems, itemsStart);

        showNextItems.submit();
    };

    function getFirstItems(){
        let showNextItems = document.getElementById("showNextItems");
        setItemForm(showNextItems, 0);

        showNextItems.submit();
    };

    function getLastItems(){
        <?php 
        $numLen = strlen((string)$itemQty);
        
        $restNum = 0;

        if($numLen > 2){
            $restNum = substr((string) $itemQty, $numLen-2);
            if($restNum > 50){
                $secRestNum = $restNum - 50;
                $itemsStart = $itemQty - $secRestNum;
            }
            else{
                $itemsStart = $itemQty - $restNum;
            }
        }else if($numLen == 2 && $itemQty > 50){
            $restNum = $itemQty - 50;
            $itemsStart = $itemQty - $restNum;
        }
        ?>

        let itemsStart = <?php echo $itemsStart; ?>;

        let showNextItems = document.getElementById("showNextItems");
        setItemForm(showNextItems, itemsStart);

        showNextItems.submit();
    };

    function setItemForm(showNextItems, itemsStart){
        showNextItems.selectType.value = "<?php echo $type; ?>";
        showNextItems.rNumber.value = "<?php echo $rNumber; ?>";
        showNextItems.kNumber.value = "<?php echo $custnumber; ?>";
        showNextItems.kName.value = "<?php echo $custName; ?>";
        showNextItems.kPLZ.value = "<?php echo $plz; ?>";
        showNextItems.place.value = "<?php echo $city; ?>";
        showNextItems.sortNum.value = "<?php echo $sort; ?>";
        showNextItems.keyWord.value = "<?php echo $keyword; ?>";
        showNextItems.allVersions.value = "<?php echo $allVersions; ?>";
        showNextItems.withImage.value = "<?php echo $withImage; ?>";
        showNextItems.stockLevel.value = "<?php echo $stockLevel; ?>";
        showNextItems.withSalesId.value = "<?php echo $withSalesId; ?>";
        showNextItems.itemsStart.value = itemsStart;
    };

    $.noConflict();
    $(document).ready(function () {
        $('#firstItems').click(getFirstItems);
        $('#leastItems').click(getLeastItems);
        $('#nextItems').click(getNextItems);
        $('#lastItems').click(getLastItems);

        $('#firstItemsBottom').click(getFirstItems);
        $('#leastItemsBottom').click(getLeastItems);
        $('#nextItemsBottom').click(getNextItems);
        $('#lastItemsBottom').click(getLastItems);
    });
</script>