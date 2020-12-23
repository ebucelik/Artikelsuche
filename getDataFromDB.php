<?php

if($itemId != $unEqualString){

    if($type == "Rollenetiketten"){
        //TODO: Implement T1.MARPngPath, 
        $stmt = $conn->prepare("SELECT TOP 1 T1.ItemId, T1.InventStyleId, T1.ProdGroupId, T1.CustVendRelation, T1.CustName, T1.ExternalItemTxt, 
                            T1.LEPSizeL, T1.LEPSizeW, T1.InventStyleId, T1.SalesIdLast, T1.WorkCenters, T1.StockLevel, T1.InventDimId, T1.ZipCode, T1.City, T1.MARInprintingSortName,
                            T1.LPMRZBoardId, T1.LPMRZProdToolIdDieCut, T1.DesignJpgPreviewUrl,
                            T1.TradeUnitSpecId, T9.TradeUnitGroupId, T9.TradeUnitId, 
                            T12.MARAdditionalDescription, T12.MARAreaWeightBas, T12.MARPaperColor, T12.MARGlue, T12.Name,
                            T14.LPMRZMaxAllowedQty, T14.LPMRZMaxDiameterOuter, T16.ExternalItemId, T17.VATNum, T18.BusinessSectorId, T20.createdDateTime, T21.CalcDesignStyleId
                            FROM MARItemSearchDataTable T1
                            LEFT JOIN LEPItemUnitLoad T8 ON T8.ItemId = T1.ItemId 
                            LEFT JOIN LEPUnitLoadTradeUnit T9 ON T9.TradeUnitLevel = 0 AND T9.UnitLoadId = T8.UnitLoadId
                            LEFT JOIN LEPCalcBoardTable T12 ON T12.BoardId = T1.LPMRZBoardId
                            LEFT JOIN LEPUnitLoad T13 ON T13.UnitLoadId = T8.UnitLoadId
                            LEFT JOIN LEPUnitLoadOptSpec T14 ON T14.RefRecId = T13.RecId
                            LEFT JOIN CustVendExternalItem T15 ON T15.ItemId = T1.ItemId AND T15.InventDimId = T1.InventDimId AND T15.CustVendRelation = T1.CustVendRelation
                            LEFT JOIN LEPCustVendExternalItem T16 ON T16.Reference = T15.RecId
                            LEFT JOIN CustTable T17 ON T17.AccountNum = T1.CustVendRelation
                            LEFT JOIN smmBusRelSectorTable T18 ON T18.Party = T17.Party
                            LEFT JOIN InventTable T19 ON T19.ItemId = T1.ItemId
                            LEFT JOIN DocuRef T20 ON T20.RefRecId = T19.RecId AND T20.RefTableId = 175
                            LEFT JOIN LEPProdToolTable T21 ON T21.ProdToolId = T1.LPMRZProdToolIdDieCut
                            WHERE T1.ItemId = '$itemId' AND T1.SalesIdLast = '$salesId' AND T1.InventStyleId = '$version'");
    }else{
        $stmt = $conn->prepare("SELECT TOP 1 T1.ItemId, T1.InventStyleId, T1.ProdGroupId, T1.CustVendRelation, T1.CustName, T1.ExternalItemTxt, 
                            T1.LEPSizeL, T1.LEPSizeW, T1.InventStyleId, T1.SalesIdLast, T1.WorkCenters, T1.StockLevel, T1.InventDimId, T1.ZipCode, T1.City, T1.MARInprintingSortName
                            FROM MARItemSearchDataTable T1
                            WHERE T1.ItemId = '$itemId' AND T1.SalesIdLast = '$salesId'");
    }

    $stmt->execute();

    $itemIdArray = fillItemArray($stmt, $type); 

    $stmt = $conn->prepare("SELECT T1.FrontBack, T1.DeviceTypeId, T1.ColorBaseMatId, T1.ColorName, T1.LPMRZProdToolId, T1.MARDescription
                            FROM LEPItemColorSequence T1 
                            LEFT JOIN LEPItemProdConfig T2 ON T2.ItemId = '$itemId' AND T2.InventDimId = '$inventDimId' 
                            
                            AND T2.ProdGroupId = '$prodGroupId' AND T2.LPMRZBoardId = '$lPMRZBoardId' AND T2.LPMRZProdToolIdDieCut = '$lPMRZProdToolIdDieCut'
                            WHERE T1.LEPItemProdConfig = T2.RecId ORDER BY T1.DeviceTypeId");

    $stmt->execute();
    $colorArray = fillColorArray($stmt);

    $stmt = $conn->prepare("SELECT TOP 1 T1.Street, T1.CountryRegionId, T4.Locator as Mail, T5.Locator as Phone, T5.Description as Mobile, T6.Locator as Fax,
                            T7.Locator as WebSite, T10.Name as NameAlias
                            FROM LogisticsPostalAddress T1
                            LEFT JOIN CustTable T2 ON T2.AccountNum = '$custAcc'
                            LEFT JOIN DirPartyTable T3 ON T3.RecId = T2.Party
                            LEFT JOIN LogisticsElectronicAddress T4 ON T4.RecId = T3.PrimaryContactEmail
                            LEFT JOIN LogisticsElectronicAddress T5 ON T5.RecId = T3.PrimaryContactPhone
                            LEFT JOIN LogisticsElectronicAddress T6 ON T6.RecId = T3.PrimaryContactFax
                            LEFT JOIN LogisticsElectronicAddress T7 ON T7.RecId = T3.PrimaryContactURL
                            LEFT JOIN smmResponsibilitiesEmplTable T8 ON T8.RefTableId = 77 AND T8.RefRecId = T2.RecId AND T8.ResponsibilityId = 'VAD'
                            LEFT JOIN HcmWorker T9 ON T9.RecId = T8.Worker
                            LEFT JOIN DirPartyTable T10 ON T10.RecId = T9.Person
                            WHERE T1.Location = T3.PrimaryAddressLocation ORDER BY T1.ValidFrom DESC");

    $stmt->execute();
    $custArray = fillCustArray($stmt);

    $stmt = $conn->prepare("SELECT T1.InvoiceDate, T1.InvoiceId
                            FROM CustInvoiceTrans T1
                            WHERE T1.ItemId = '$itemId' AND T1.SalesId = '$salesId'");
    $stmt->execute();

    //get Invoice
    if(isset($invoiceId) && isset($invoiceDate)){
        $row = $stmt->fetch();

        if($row){
            $invoiceDate = $row[0];
            $invoiceId = $row[1];
        }

        $invoiceDate = new DateTime($invoiceDate);
    }

    $stmt = $conn->prepare("SELECT T1.Notes, T1.TypeId
                            FROM DocuRef T1
                            LEFT JOIN CustTable T2 ON T2.AccountNum = '$custAcc'
                            WHERE T1.RefTableId = 77 AND T1.RefRecId = T2.RecId");
    $stmt->execute();

    $notesArray = fillNotesArray($stmt);
}

function fillNotesArray($_stmt){
    $_notesArray = array();

    foreach($_stmt as $val){
        array_push($_notesArray, array('Notes' => $val['Notes'], 'TypeId' => $val['TypeId']));
    }

    return $_notesArray;
}

function fillCustArray($_stmt){
    $_custArray = array();

    foreach($_stmt as $val){
        array_push($_custArray, array('Street' => $val['Street'], 'EMail' => $val['Mail'], 'Phone' => $val['Phone'], 'Fax' => $val['Fax'], 'WebSite' => $val['WebSite'],
        'ContactPerson' => $val['NameAlias'], 'Mobile' => $val['Mobile'], 'CountryRegionId' => $val['CountryRegionId']));
    }

    return $_custArray;
}

function fillColorArray($_stmt){
    $_colorArray = array();

    foreach($_stmt as $val){
        array_push($_colorArray, array('FrontBack' => $val['FrontBack'], 'DeviceTypeId' => $val['DeviceTypeId'], 'ColorBaseMatId' => $val['ColorBaseMatId'],
        'ColorName' => $val['ColorName'], 'LPMRZProdToolId' => $val['LPMRZProdToolId'], 'MARDescription' => $val['MARDescription']));
    }

    return $_colorArray;
}

function fillItemArray($_stmt, $_type){
    $_itemIdArray = array();

    if($_type == "Rollenetiketten"){
        //TODO: Implement 'MARPngPath' => $val['MARPngPath']
        foreach($_stmt as $val){
            array_push($_itemIdArray, array('ItemId' => $val['ItemId'], 'Version' => $val['InventStyleId'], 'ProdGroupId' => $val['ProdGroupId'], 
            'CustVendRelation' => $val['CustVendRelation'], 'Name' => $val['CustName'], 'ExternalItemTxt' => $val['ExternalItemTxt'], 
            'LEPSizeW' => intval($val['LEPSizeW']), 'LEPSizeL' => intval($val['LEPSizeL']),
            'TradeUnitSpecId' => $val['TradeUnitSpecId'], 'DesignJpgPreviewUrl' => $val['DesignJpgPreviewUrl'], 'SalesId' => $val['SalesIdLast'], 
            'WorkCenters' => $val['WorkCenters'], 'StockLevel' => $val['StockLevel'], 'InventDimId' => $val['InventDimId'], 'LPMRZBoardId' => $val['LPMRZBoardId'],
            'MARAdditionalDescription' => $val['MARAdditionalDescription'], 'MARAreaWeightBas' => $val['MARAreaWeightBas'], 'MARPaperColor' => $val['MARPaperColor'], 'PaperName' => $val['Name'],
            'MARGlue' => $val['MARGlue'], 'LPMRZProdToolIdDieCut' => $val['LPMRZProdToolIdDieCut'], 'LPMRZMaxAllowedQty' => intval($val['LPMRZMaxAllowedQty']),
            'LPMRZMaxDiameterOuter' => intval($val['LPMRZMaxDiameterOuter']), 'TradeUnitGroupId' => $val['TradeUnitGroupId'], 'TradeUnitId' => $val['TradeUnitId'],
            'ExternalItemId' => $val['ExternalItemId'], 'ZipCode' => $val['ZipCode'], 'City' => $val['City'], 'Branche' => $val['BusinessSectorId'], 'Steuernummer' => $val['VATNum'],
            'Sort' => $val['MARInprintingSortName'], 'createdDateTime' =>  new DateTime($val['createdDateTime']), 'CalcDesignStyleId' => $val['CalcDesignStyleId']));
        }
    }else{
        foreach($_stmt as $val){
            array_push($_itemIdArray, array('ItemId' => $val['ItemId'], 'Version' => $val['InventStyleId'], 'ProdGroupId' => $val['ProdGroupId'], 
            'CustVendRelation' => $val['CustVendRelation'], 'Name' => $val['CustName'], 'ExternalItemTxt' => $val['ExternalItemTxt'], 
            'LEPSizeW' => intval($val['LEPSizeW']), 'LEPSizeL' => intval($val['LEPSizeL']),
            'SalesId' => $val['SalesIdLast'], 
            'WorkCenters' => $val['WorkCenters'], 'StockLevel' => $val['StockLevel'], 'InventDimId' => $val['InventDimId'],
            'ZipCode' => $val['ZipCode'], 'City' => $val['City'],
            'Sort' => $val['MARInprintingSortName']));
        }
    }
    
    return $_itemIdArray;
}
?>