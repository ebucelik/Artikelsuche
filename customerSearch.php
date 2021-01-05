<?php
require_once('db/db.php');

$unequalString = '';
$custNum = $custName = $custPLZ = $custStreet = $custPlace = $custTel = $custMail = $query = $unequalString;
$custDataArray = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['kNumber']) && $_POST['kNumber'] != ''){
        $custNum = $_POST['kNumber'];
        $query = "T1.AccountNum LIKE '$custNum%' ";
    }

    if(isset($_POST['kName']) && $_POST['kName'] != ''){
        $custName = $_POST['kName'];

        if($query){
            $query .= "AND T2.Name LIKE '%$custName%' ";
        }else{
            $query .= "T2.Name LIKE '%$custName%' ";
        }
    }

    if(isset($_POST['kPLZ']) && $_POST['kPLZ'] != ''){
        $custPLZ = $_POST['kPLZ'];

        if($query){
            $query .= "AND T3.ZipCode LIKE '$custPLZ%' ";
        }else{
            $query .= "T3.ZipCode LIKE '$custPLZ%' ";
        }
    }

    if(isset($_POST['street']) && $_POST['street'] != ''){
        $custStreet = $_POST['street'];

        if($query){
            $query .= "AND T3.Street LIKE '%$custStreet%' ";
        }else{
            $query .= "T3.Street LIKE '%$custStreet%' ";
        }
    }

    if(isset($_POST['place']) && $_POST['place'] != ''){
        $custPlace = $_POST['place'];

        if($query){
            $query .= "AND T3.City LIKE '%$custPlace%' ";
        }else{
            $query .= "T3.City LIKE '%$custPlace%' ";
        }
    }

    if(isset($_POST['tNumber']) && $_POST['tNumber'] != ''){
        $custTel = $_POST['tNumber'];

        if($query){
            $query .= "AND T5.Locator LIKE '%$custTel%' ";
        }else{
            $query .= "T5.Locator LIKE '%$custTel%' ";
        }
    }

    if(isset($_POST['email']) && $_POST['email'] != ''){
        $custMail = $_POST['email'];

        if($query){
            $query .= "AND T4.Locator LIKE '%$custMail%' ";
        }else{
            $query .= "T4.Locator LIKE '%$custMail%' ";
        }
    }
}
?>

<html lang="de">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Marzek Kundensuche</title>

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
    <script src="scripts/scriptmed.js"></script>
</head>
<body>
    <header>
        <a href="index.html" ><img src="Bilder/Version3.png" id="headerImg" title="Marzek Kundensuche" alt="Marzek Kundensuche Bild" width="400"></a>
    </header>

    <nav>
        <div class="container" id="inputFields">
            <form action="" method="POST">
                <div class="form-group fading searchForm">
                    <label for="kNumber" class="align-self-center labelTxt">Kundennummer:</label>
                    <input type="number" class="form-control searchInput" id="kNumber" placeholder="Kundennummer eingeben" name="kNumber" min="4" value="<?php echo $custNum; ?>">
                    <span class="kNumberalert"></span>
                </div>
                <div class="form-group fading searchForm">
                    <label for="kName" class="align-self-center labelTxt">Kundenname:</label>
                    <input type="text" class="form-control searchInput" id="kName" placeholder="Kundenname eingeben" name="kName" value="<?php echo $custName; ?>">
                </div>
                <div class="form-group fading searchForm">
                    <label for="kPLZ" class="align-self-center labelTxt">PLZ:</label>
                    <input type="number" class="form-control searchInput" id="kPLZ" placeholder="PLZ eingeben" name="kPLZ" value="<?php echo $custPLZ; ?>">
                    <span class="kPLZalert"></span>
                </div>
                <div class="form-group fading searchForm">
                    <label for="street" class="align-self-center labelTxt">Straße:</label>
                    <input type="text" class="form-control searchInput" id="street" placeholder="Straße eingeben" name="street" value="<?php echo $custStreet; ?>">
                </div>
                <div class="form-group fading searchForm">
                    <label for="place" class="align-self-center labelTxt">Ort:</label>
                    <input type="text" class="form-control searchInput" id="place" placeholder="Ort eingeben" name="place" value="<?php echo $custPlace; ?>">
                </div>
                <div class="form-group fading searchForm">
                    <label for="tNumber" class="align-self-center labelTxt">Telefonnummer:</label>
                    <input type="text" class="form-control searchInput" id="tNumber" placeholder="Telefonnummer eingeben" name="tNumber" value="<?php echo $custTel; ?>">
                    <span class="tNumberalert"></span>
                </div>             
                <div class="form-group fading searchForm">
                    <label for="email" class="align-self-center labelTxt">E-Mail:</label>
                    <input type="text" class="form-control searchInput" id="email" placeholder="E-Mail eingeben" name="email" value="<?php echo $custMail; ?>">
                </div>
                <button type="submit" class="btn btn-outline-light fading" id="articlesearch">SUCHEN</button>   
            </form>
        </div>

        <?php 
        function fillCustDataToArray($_stmt){
            $_custDataArray = array();
        
            foreach($_stmt as $val){
                array_push($_custDataArray, array('AccountNum' => $val['AccountNum'], 'Party' => $val['Party'], 'Name' => $val['Name'], 'City' => $val['City'],
                            'Street' => $val['Street'], 'CountryRegionId' => $val['CountryRegionId'], 'ZipCode' => $val['ZipCode'], 'Mail' => $val['Mail'],
                            'Tel' => $val['Tel'], 'Fax' => $val['Fax'], 'Website' => $val['Website']));
            }
        
            return $_custDataArray;
        }
        
        try{
            $stmt = $conn->prepare("SELECT T1.AccountNum, T1.Party, T2.Name, T3.City, T3.Street, T3.CountryRegionId, T3.ZipCode, T4.Locator as Mail,
                                    T5.Locator as Tel, T6.Locator as Fax, T7.Locator as Website
                                    FROM CustTable T1
                                    LEFT JOIN DirPartyTable T2 ON T2.RecId = T1.Party
                                    LEFT JOIN LogisticsPostalAddress T3 ON T3.Location = T2.PrimaryAddressLocation AND 
                                    T3.ValidFrom IN (SELECT MAX(T8.ValidFrom) AS valid FROM LogisticsPostalAddress T8 WHERE T8.Location = T2.PrimaryAddressLocation)
                                    LEFT JOIN LogisticsElectronicAddress T4 ON T4.RecId = T2.PrimaryContactEmail
                                    LEFT JOIN LogisticsElectronicAddress T5 ON T5.RecId = T2.PrimaryContactPhone
                                    LEFT JOIN LogisticsElectronicAddress T6 ON T6.RecId = T2.PrimaryContactFax
                                    LEFT JOIN LogisticsElectronicAddress T7 ON T7.RecId = T2.PrimaryContactURL
                                    WHERE $query");
            $stmt->execute();

            $custDataArray = fillCustDataToArray($stmt);
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
        
        if($custDataArray){ ?>
            <div id="dataView">
                <div class="containerRow">
                    <div class="row titlerow">
                        <div class="col">Kundennummer</div>
                        <div class="col">Kundenname</div>
                        <div class="col">PLZ</div>
                        <div class="col">Straße</div>
                        <div class="col">Ort</div>
                        <div class="col">Tel. Nummer</div>
                        <div class="col" style="flex-grow:2;">E-Mail</div>
                        <div class="col">Fax</div>
                        <div class="col">Website</div>
                    </div>

                    <?php foreach($custDataArray as $v1){?>
                        <div class="row">
                            <div class="col align-self-center"><?php echo $v1['AccountNum']; ?></div>
                            <div class="col align-self-center"><?php echo $v1['Name']; ?></div>
                            <div class="col align-self-center"><?php echo $v1['ZipCode']; ?></div>
                            <div class="col align-self-center"><?php echo $v1['Street']; ?></div>
                            <div class="col align-self-center"><?php echo $v1['City']; ?></div>
                            <div class="col align-self-center"><?php echo $v1['Tel']; ?></div>
                            <div class="col align-self-center" style="flex-grow:2;"><?php echo $v1['Mail']; ?></div>
                            <div class="col align-self-center"><?php echo $v1['Fax']; ?></div>
                            <div class="col align-self-center"><?php echo $v1['Website']; ?></div>
                        </div>
                        <hr/>
                    <?php 
                    }
                    ?>
                </div>
            </div>
        <?php } ?>

    </nav>
</html> 