<?php
require_once('db.php');

$unEqualString = "";
$type = $rNumber = $custnumber = $custName = $plz = $city = $sort = $keyword = $allVersions = $withImage = $custNumEmail = $unEqualString; //We need to set it to something because otherwise the SQL Statement doesn't work
$checkSort = false;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['selectType']) && $_POST['selectType'] != ''){
        $type = $_POST['selectType'];
    }
    if(isset($_POST['rNumber']) && $_POST['rNumber'] != ''){
        $rNumber = $_POST['rNumber'];
    }  

    if(isset($_POST['kNumber']) && $_POST['kNumber'] != ''){
        $custnumber = $_POST['kNumber'];
    }

    if(isset($_POST['kName']) && $_POST['kName'] != ''){
        $custName = $_POST['kName'];
    }

    if(isset($_POST['kPLZ']) && $_POST['kPLZ'] != ''){
        $plz = $_POST['kPLZ'];
    }

    if(isset($_POST['place']) && $_POST['place'] != ''){
        $city = $_POST['place'];
    }

    if(isset($_POST['sortNum']) && $_POST['sortNum'] != ''){
        $sort = $_POST['sortNum'];
    }

    if(isset($_POST['keyWord']) && $_POST['keyWord'] != ''){
        $keyword = $_POST['keyWord'];
    }

    if(isset($_POST['allVersions'])){
        $allVersions = $_POST['allVersions'];
    }

    if(isset($_POST['withImage'])){
        $withImage = $_POST['withImage'];
    }
} 
?>

<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marzek-Suche</title>

    <link rel="stylesheet" href="search.css">

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
        <a href="searching.php" ><img src="Bilder/Version3.png" id="headerImg" title="Marzek Artikelsuche" alt="Marzek Artikelsuche Bild" width="400"></a>
    </header>

    <nav>
        <div class="container" id="inputFields">
            <form action="" method="POST">
                <div class="form-group fading">
                    <label for="selectType">Rolle/Bogen:</label>
                    <select class="form-control" id="selectType" name="selectType" onchange="changeTitle()">
                        <option>Rollenetiketten</option>
                        <option>Bogenetiketten</option>
                    </select>
                </div>
                <div class="form-group fading">
                    <label for="rNumber" id="Rnumber">R-Nummer:</label>
                    <input type="text" class="form-control" id="rNumber" placeholder="R-Nummer eingeben" name="rNumber" value="<?php if($rNumber != $unEqualString){echo $rNumber;} ?>">
                </div>
                <div class="form-group fading">
                    <label for="kNumber">Kundennummer:</label>
                    <input type="number" class="form-control" id="kNumber" placeholder="Kundennummer eingeben" name="kNumber" value="<?php if($custnumber != $unEqualString){echo $custnumber;} ?>">
                </div>
                <div class="form-group fading">
                    <label for="kName">Kundenname:</label>
                    <input type="text" class="form-control" id="kName" placeholder="Kundenname eingeben" name="kName" value="<?php if($custName != $unEqualString){echo $custName;} ?>">
                </div>
                <div class="form-group fading">
                    <label for="kPLZ">PLZ:</label>
                    <input type="number" class="form-control" id="kPLZ" placeholder="PLZ eingeben" name="kPLZ" value="<?php if($plz != $unEqualString){echo $plz;} ?>">
                </div>
                <div class="form-group fading">
                    <label for="place">Ort:</label>
                    <input type="text" class="form-control" id="place" placeholder="Ort eingeben" name="place" value="<?php if($city != $unEqualString){echo $city;} ?>">
                </div>
                <div class="form-group fading">
                    <label for="sortNum">Sorte:</label>
                    <input type="text" class="form-control" id="sortNum" placeholder="Sorte eingeben" name="sortNum" value="<?php if($sort != $unEqualString){echo $sort;} ?>">
                </div>
                <div class="form-group fading">
                    <label for="keyWord">Stichwort:</label>
                    <input type="text" class="form-control" id="keyWord" placeholder="Stichwort eingeben" name="keyWord" value="<?php if($keyword != $unEqualString){echo $keyword;} ?>">
                </div>
                <div class="form-group fading">
                    <label for="allVersions">Alle Versionen:</label>
                    <input type="checkbox" class="form-control" id="allVersions" name="allVersions" style="width: 20px; height: 20px; display: unset;" <?php if($allVersions != $unEqualString){echo 'checked';} ?>>
                    <label for="withImage" style="margin-left: 3%; ">Bild vorhanden:</label>
                    <input type="checkbox" class="form-control" id="withImage" name="withImage" style="width: 20px; height: 20px; display: unset;" <?php if($withImage != $unEqualString){echo 'checked';} ?>>
                </div>
                <button type="submit" class="btn btn-outline-light fading" id="articlesearch">SUCHEN</button>
                <button type="button" class="btn btn-primary" id="sendmailbtn" onclick="sendMail()">SENDE MAIL AN KUNDE</button>
            </form>

            <div id="toStartBtn">
               <img src="Bilder/arrowUp.png" onclick='toStart()' title="Nach Oben" alt="Nach Oben" style="max-width: 100%; cursor: pointer; color: white;">
            </div>
        </div>

<?php

$itemIdArray = array();

function fillItemArray($_stmt){
    $_itemIdArray = array();

    foreach($_stmt as $val){
        array_push($_itemIdArray, array('ItemId' => $val['ItemId'], 'Version' => $val['InventStyleId'], 'InventDimId' => $val['InventDimId'], 'ProdGroupId' => $val['ProdGroupId'], 
        'CustVendRelation' => $val['CustVendRelation'], 'Name' => $val['CustName'], 'ExternalItemTxt' => $val['ExternalItemTxt'], 
        'LEPSizeW' => intval($val['LEPSizeW']), 'LEPSizeL' => intval($val['LEPSizeL']),
        'TradeUnitSpecId' => $val['TradeUnitSpecId'], 'DesignJpgPreviewUrl' => $val['DesignJpgPreviewUrl'], 'SalesId' => $val['SalesIdLast'], 
        'WorkCenters' => $val['WorkCenters'], 'StockLevel' => $val['StockLevel'], 'Sort' => $val['MARInprintingSortName'], 'LPMRZBoardId' => $val['LPMRZBoardId'], 'LPMRZProdToolIdDieCut' => $val['LPMRZProdToolIdDieCut']));
        
        if($val['MARInprintingSortName']){
            $GLOBALS["checkSort"] = true;
        }
    }

    return $_itemIdArray;
}

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

    if($sort != $unEqualString){
        if($queryParams == ""){
            $queryParams = "T1.MARInprintingSortName LIKE '%$sort%'";
        }else{
            $queryParams .=" AND T1.MARInprintingSortName LIKE '%$sort%'";
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
            $queryParams = "T10.DesignJpgPreviewUrl != ''";
        }else{
            $queryParams .=" AND T10.DesignJpgPreviewUrl != ''";
        }
    }

    if($type == "Rollenetiketten" && $queryParams != ""){
        $queryParams .=" AND T11.MARItemType = 4 AND T1.InventStyleId != '' AND T1.InventDimId != '' ";
    }else if($queryParams != ""){
        $queryParams .=" AND T11.MARItemType = 12";
    }

    if($allVersions == 'on'){ //ALL VERSIONS PART
        $stmt = $conn->prepare("SELECT T1.ItemId, T1.InventStyleId, T1.ProdGroupId, T1.CustVendRelation, T1.CustName, T1.ExternalItemTxt, 
                                    T1.LEPSizeL, T1.LEPSizeW, T1.InventDimId, T1.SalesIdLast, T1.WorkCenters, T1.StockLevel, T1.MARInprintingSortName, T1.LPMRZBoardId, T1.LPMRZProdToolIdDieCut,
                                    T9.TradeUnitSpecId, T10.DesignJpgPreviewUrl
                                    FROM MARItemSearchDataTable T1
                                    LEFT JOIN LEPItemUnitLoad T8 ON T8.ItemId = T1.ItemId 
                                    LEFT JOIN LEPUnitLoadTradeUnit T9 ON T9.TradeUnitLevel = 0 AND T9.UnitLoadId = T8.UnitLoadId
                                    LEFT JOIN MARDesignIDRelationTable T10 ON T10.ItemId = T1.ItemId
                                    LEFT JOIN InventTable T11 ON T11.ItemId = T1.ItemId
                                    WHERE $queryParams ORDER BY T1.InventStyleId");

        $stmt->execute();

        $itemIdArray = fillItemArray($stmt);
    }
    else{ //HIGHEST VERSION PART
        $queryParams .= " AND T1.SalesIdLast IN (SELECT MAX(T11.SalesIdLast) AS style FROM MARItemSearchDataTable T11 WHERE T11.ItemId = T1.ItemId)";

        $stmt = $conn->prepare("SELECT T1.ItemId, T1.InventStyleId, T1.ProdGroupId, T1.CustVendRelation, T1.CustName, T1.ExternalItemTxt, 
                                    T1.LEPSizeL, T1.LEPSizeW, T1.InventDimId, T1.SalesIdLast, T1.WorkCenters, T1.StockLevel, T1.MARInprintingSortName, T1.LPMRZBoardId, T1.LPMRZProdToolIdDieCut,
                                    T9.TradeUnitSpecId, T10.DesignJpgPreviewUrl
                                    FROM MARItemSearchDataTable T1
                                    LEFT JOIN LEPItemUnitLoad T8 ON T8.ItemId = T1.ItemId 
                                    LEFT JOIN LEPUnitLoadTradeUnit T9 ON T9.TradeUnitLevel = 0 AND T9.UnitLoadId = T8.UnitLoadId
                                    LEFT JOIN MARDesignIDRelationTable T10 ON T10.ItemId = T1.ItemId
                                    LEFT JOIN InventTable T11 ON T11.ItemId = T1.ItemId
                                    WHERE $queryParams ORDER BY T1.InventStyleId");

        $stmt->execute();

        $itemIdArray = fillItemArray($stmt);
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;

?>

<div id="dataView">

<?php

if($itemIdArray){
?>
        <div class="containerRow">
            <div class="row titlerow">
                <div class="col checkbox"></div>
                <div class="col">Artikelnr.</div>
                <div class="col">Version</div>
                <?php if($allVersions == 'on'){?><div class="col">Produktvariante</div><?php } ?>
                <div class="col">Kundennr.</div>
                <div class="col">Kunde</div>
                <?php if($checkSort){?><div class="col">Sorte</div><?php }?>
                <div class="col">Stichwort</div>
                <div class="col">FormatQuer</div>
                <div class="col">FormatLauf</div>
                <div class="col">Stellung</div>
                <div class="col">Auftragsnr.</div>
                <div class="col">Maschine</div>
                <div class="col">Lagerstand</div>
                <div class="col">Thumbnail</div>
                <div class="col">Drucken</div>
            </div>

            <!-- Show data here with a foreach over the div (PHP) -->
            <?php foreach($itemIdArray as $v1){?>
            <div class="row">
                <div class="col align-self-center checkbox"><input type="checkbox" class="form-control sendMailCheck" style="width: 20px; height: 20px;" unchecked></div>
                <div class="col align-self-center itemid"><a href="detail.php?type=<?php echo $_POST['selectType']; ?>&ItemId=<?php echo $v1['ItemId']; ?>&CustAcc=<?php echo $v1['CustVendRelation']; ?>&SalesId=<?php echo $v1['SalesId']; ?>&Version=<?php echo $v1['Version']; ?>&InventDimId=<?php echo $v1['InventDimId']; ?>&ProdGroupId=<?php echo $v1['ProdGroupId']; ?>&LPMRZBoardId=<?php echo $v1['LPMRZBoardId'] ?>&LPMRZProdToolIdDieCut=<?php echo $v1['LPMRZProdToolIdDieCut'] ?>" style="color: black;"><?php echo $v1['ItemId']; ?></a></div>
                <div class="col align-self-center version"><?php echo $v1['Version']; ?></div>
                <?php if($GLOBALS["allVersions"] == 'on'){?><div class="col align-self-center prodgroupid"><?php echo $v1['ProdGroupId']; ?></div><?php } ?>
                <div class="col align-self-center custvendrelation"><?php echo $v1['CustVendRelation']; ?></div>
                <div class="col align-self-center name"><?php echo $v1['Name']; ?></div>
                <?php if($v1['Sort']){?><div class="col align-self-center sort"><?php echo $v1['Sort']; ?></div><?php }?>
                <div class="col align-self-center externalitemtxt"><?php echo $v1['ExternalItemTxt']; ?></div>
                <div class="col align-self-center lepsizew"><?php echo $v1['LEPSizeW']; ?></div>
                <div class="col align-self-center lepsizel"><?php echo $v1['LEPSizeL']; ?></div>
                <div class="col align-self-center tradeunitspecid"><?php echo $v1['TradeUnitSpecId']; ?></div>
                <div class="col align-self-center salesid"><?php echo $v1['SalesId']; ?></div>
                <div class="col align-self-center workcenters"><?php echo $v1['WorkCenters']; ?></div>
                <div class="col align-self-center stocklevel"><?php echo $v1['StockLevel']; ?></div>
                <div class="col align-self-center"><?php if($v1['DesignJpgPreviewUrl']){?><img title="Bild öffnen" class="designjpgpreviewurl" onclick="openImage('<?php echo base64_encode(file_get_contents($v1['DesignJpgPreviewUrl'])); ?>', '<?php echo $v1['ItemId']; ?>')" src="data:image/jpg;base64, <?php echo base64_encode(file_get_contents($v1['DesignJpgPreviewUrl'])); ?>" style="height: 50px; width: 50px; cursor: pointer;"/><?php } ?></div>
                <div class="col align-self-center printImg"><a target="_blank" href="createPDF.php?type=<?php echo $_POST['selectType']; ?>&ItemId=<?php echo $v1['ItemId']; ?>&CustAcc=<?php echo $v1['CustVendRelation']; ?>&SalesId=<?php echo $v1['SalesId']; ?>&Version=<?php echo $v1['Version']; ?>&InventDimId=<?php echo $v1['InventDimId']; ?>&ProdGroupId=<?php echo $v1['ProdGroupId']; ?>&LPMRZBoardId=<?php echo $v1['LPMRZBoardId'] ?>&LPMRZProdToolIdDieCut=<?php echo $v1['LPMRZProdToolIdDieCut'] ?>&SimpleOrFullPDF=Full" style="color: #d80030;"><img src="Bilder/drucker.png" class="print" title="Drucken" alt="Drucken" width="35"></a></div>
            </div>
            <hr/>
            <?php 
            }
            ?>
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
    </nav>
</body>
</html>