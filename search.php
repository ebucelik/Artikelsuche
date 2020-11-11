<?php
error_reporting(E_ALL);

require_once('db.php');

$rNumber = $custnumber = $custName = $plz = $city = $sort = $keyword = $allVersions = 'null'; //We need to set it to something because otherwise the SQL Statement doesn't work

if($_SERVER['REQUEST_METHOD'] == 'POST'){
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
} 

try{
    //RNummer
    if($rNumber != "null"){
        $stmt = $conn->prepare("SELECT * FROM DirPartyTable T1 INNER JOIN LepItemUnitLoad T6 ON T6.ItemId = '$rNumber' 
                                INNER JOIN LepUnitLoadTradeUnit T7 ON T7.TradeUnitGroupId = 'ROLLE' AND T7.UnitLoadId = T6.UnitLoadId 
                                INNER JOIN InventTable T5 ON T5.ItemId = '$rNumber' INNER JOIN CustVendExternalItem T2 ON T2.ItemId = '$rNumber' 
                                INNER JOIN SalesLine T8 ON T8.ItemId = '$rNumber' AND 
                                T8.SalesId = (SELECT TOP 1 SalesId FROM SalesLine WHERE SalesLine.ItemId = '$rNumber' ORDER BY SalesLine.SalesId DESC) 
                                INNER JOIN InventDim T4 ON T4.inventDimId = T2.InventDimId 
                                INNER JOIN CustTable T3 ON T3.AccountNum = T2.CustVendRelation 
                                WHERE T3.Party = T1.RecId ORDER BY T4.InventStyleId");

        $stmt_3 = $conn->prepare("SELECT DESIGNJPGPREVIEWURL FROM MARDesignIDRelationTable T9 WHERE T9.ItemId = '$rNumber'");

        $stmt_4 = $conn->prepare("SELECT * FROM SalesLine T1 WHERE T1.ItemId = '$rNumber' ORDER BY T1.SalesId DESC");

        $stmt->execute();

        $inventStyleIdArray = $itemid = $inventstyleid = $custvendRelation = $name = $externalItemtxt = $lepSizeW = $lepSizeL = $tradeUnitSpecId = array();

        foreach($stmt as $v) { 
            array_push($itemid, $v['ITEMID']);
            array_push($inventstyleid, $v['INVENTSTYLEID']);
            array_push($custvendRelation, $v['CUSTVENDRELATION']);
            array_push($name, $v['NAME']);
            array_push($externalItemtxt, $v['EXTERNALITEMTXT']);
            array_push($lepSizeW, intval($v['LEPSIZEW']));
            array_push($lepSizeL, intval($v['LEPSIZEL']));
            array_push($tradeUnitSpecId, $v['TRADEUNITSPECID']);
            array_push($inventStyleIdArray, $v['INVENTSTYLEID']);
        }

        $stmt_3->execute();

        foreach($stmt_3 as $v){
            echo '<img src="data:image/jpg;base64,'.base64_encode(file_get_contents($v['DESIGNJPGPREVIEWURL'])).'" style="height: 150px; width: 150px; "/>';
        }

        //Get right INVENTDIMID for oldest SALESID
        $stmt_5 = $conn->prepare("SELECT * FROM InventDim T1 WHERE T1.inventDimId = ?");

        $salesIdArray = array();
        $inventDimArray = array();

        foreach($inventStyleIdArray as $j){
            $stmt_4->execute();

            foreach($stmt_4 as $v){
                $stmt_5->execute(array($v['INVENTDIMID']));

                foreach($stmt_5 as $z){
                    if($z['INVENTSTYLEID'] == $j){
                        $stmt_6 = $conn->prepare("SELECT SalesId FROM SalesLine T1 WHERE T1.InventDimId = '" . $z['INVENTDIMID'] . "'");
                        $stmt_6->execute();

                        echo "</br>" . $salesId = $stmt_6->fetchColumn();

                        array_push($salesIdArray, $salesId);
                        array_push($inventDimArray, $z['INVENTDIMID']);

                        $j = next($inventStyleIdArray); //Go to next StyleId 
                    }
                }
            }
        }

        //Get Machine
        $stmt_7 = $conn->prepare("SELECT ProdId FROM LEPProdRef T1 WHERE T1.ItemId = '$rNumber' AND T1.InventRefId = ?");

        foreach($salesIdArray as $z){
            $stmt_7->execute(array($z));
            
            $prodId = $stmt_7->fetchColumn();

            $stmt_8 = $conn->prepare("SELECT ProdJobId FROM LEPProdJob T1 WHERE T1.ProdId = ? ORDER BY T1.LineNum DESC");
            $stmt_8->execute(array($prodId));

            $prodJobId = $stmt_8->fetchColumn();

            $stmt_8 = $conn->prepare("SELECT WrkCtrId FROM LEPProdJournalJob T1 WHERE T1.ProdId = ? AND T1.ProdJobId = ?");
            $stmt_8->execute(array($prodId, $prodJobId));

            echo "</br>" . $stmt_8->fetchColumn() . " "; //Machine
        }

        //Get Stock Level
        $stmt_8 = $conn->prepare("SELECT * FROM InventSum T1 WHERE T1.ItemId = '$rNumber' AND T1.InventDimId = ?");
        
        foreach($inventDimArray as $i){
            $stmt_8->execute(array($i));

            $result = $stmt_8->fetch(PDO::FETCH_ASSOC);

            $stock = ($result['POSTEDQTY'] + $result['RECEIVED'] - $result['DEDUCTED'] + $result['REGISTERED'] - $result['PICKED']) - $result['RESERVPHYSICAL'];

            echo $stock . "</br>";
        }
    }

    //Kundenname
    /*if($custName != "null"){
        if($allVersions == 'on'){
            $stmt = $conn->prepare("SELECT * FROM CustVendExternalItem T3 
                                INNER JOIN CustTable T1 ON T1.AccountNum = T3.CustVendRelation 
                                INNER JOIN DirPartyTable T2 ON T1.Party = T2.RecId AND T2.Name LIKE '%$custName%' 
                                INNER JOIN InventDim T4 ON T4.inventDimId = T3.InventDimId ORDER BY T4.InventStyleId");
        }else{
            $stmt = $conn->prepare("SELECT * FROM CustVendExternalItem T3 
                                INNER JOIN CustTable T1 ON T1.AccountNum = T3.CustVendRelation 
                                INNER JOIN DirPartyTable T2 ON T1.Party = T2.RecId AND T2.Name LIKE '%$custName%' 
                                INNER JOIN InventDim T4 ON T4.inventDimId = T3.InventDimId AND T4.InventStyleId > '' ORDER BY T4.InventStyleId");
        }

        $stmt->execute();

        foreach($stmt as $v) {
            echo $v['ACCOUNTNUM'] . " " . $v['INVENTDIMID'] . " " . $v['INVENTSTYLEID'] . "</br>";
        }
    }*/
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>