<?php

$custNum = $custName = $custPLZ = $custStreet = $custPlace = $custTel = $custMail = $custFax = $custWebsite = "";

    if(isset($_GET['custNum'])) {
        $custNum = $_GET['custNum']; 
    }
    if(isset($_GET['custName'])) {
        $custName = $_GET['custName']; 
    }
    if(isset($_GET['custPLZ'])) {
        $custPLZ = $_GET['custPLZ']; 
    }
    if(isset($_GET['custStreet'])) {
        $custStreet = $_GET['custStreet']; 
    }
    if(isset($_GET['custPlace'])) {
        $custPlace = $_GET['custPlace']; 
    }
    if(isset($_GET['custTel'])) {
        $custTel = $_GET['custTel']; 
    }
    if(isset($_GET['custMail'])) {
        $custMail = $_GET['custMail']; 
    }
    if(isset($_GET['custFax'])) {
        $custFax = $_GET['custFax']; 
    }
    if(isset($_GET['custWebsite'])) {
        $custWebsite = $_GET['custWebsite']; 
    }


?>

<html lang="de">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Marzek Kundensuche</title>

    <link rel="stylesheet" href="css/detail.css">

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
        <a href="index.php" ><img src="Bilder/kundensuche.png" id="headerImg" title="Marzek Kundensuche" alt="Marzek Kundensuche Bild" width="400"></a>
    </header>

    
    <nav class="navDetailCustomer">
             <div class="custInfo custInfoDetailCustomer">
                    <h2 id="custInfoTitle">Kundeninformationen</h2>
                </div>
        

                <div class="row">
                    <div class="col">
                        <div class="containerRow leftContainer">
                        
                            <div class="row">
                                <div class="col titlerow">Kundennummer</div>
                                <div class="col"><?php echo $custNum;?></div>
                            </div>
                            <hr/>
                        
                            <div class="row">
                                <div class="col titlerow">Firmenname</div>
                                <div class="col"><?php echo $custName;?></div>
                            </div>
                            <hr/>
                        
                            <div class="row">
                                <div class="col titlerow">Branche</div>
                                <div class="col">Etiketten</div>
                            </div>
                            <hr/>
                        
                            <div class="row">
                                <div class="col titlerow">Straße</div>
                                <div class="col"><?php echo $custStreet;?></div>
                            </div>
                            <hr/>
                            
                            <div class="row">
                                <div class="col titlerow">Land</div>
                                <div class="col">AUT</div>
                            </div>
                            <hr/>
                       
                            <div class="row">
                                <div class="col titlerow">PLZ</div>
                                <div class="col"><?php echo $custPLZ;?></div>
                            </div>
                            <hr/>
                        
                            <div class="row">
                                <div class="col titlerow">Steuernummer</div>
                                <div class="col">ATU17558202</div>
                            </div>
                            <hr>
                        
                            <div class="row">
                                <div class="col titlerow">Ort</div>
                                <div class="col"><?php echo $custPlace;?></div>
                            </div>
                        
                        </div>
                    </div>
                    <div class="col firstCols">
                        <div class="containerRow rightToLeftRow rightContainer">
                        
                            <div class="row">
                                <div class="col titlerow">VAD</div>
                                <div class="col">Marzek</div>
                            </div>
                        
                            <hr/>
                            <div class="row">
                                <div class="col titlerow">Telefon</div>
                                <div class="col"><?php echo $custTel;?></div>
                            </div>
                            
                            <hr/>
                            <div class="row">
                                <div class="col titlerow">Fax</div>
                                <div class="col"><?php echo $custFax;?></div>
                            </div>
                            
                            <hr/>
                            <div class="row">
                                <div class="col titlerow">Mobil</div>
                                <div class="col">0267688500500</div>
                            </div>
                        
                            <hr/>
                            <div class="row">
                                <div class="col titlerow">E-Mail</div>
                                <div class="col"><?php echo $custMail;?></div>
                            </div>
                            
                            <hr/>
                             <div class="row">
                                <div class="col titlerow">Website</div>
                                <div class="col"><?php echo $custWebsite;?></div>
                            </div>
                            
                        </div>
                    </div>
                </div>
        
                
                <div class="custInfo">
                    <h2 id="custInfoTitle">Sonstiges</h2>
                </div>
        
                <div class="row">
                    <div class="col">
                        <div class="containerRow leftContainer">
                            
                                <div class="row">
                                    <div class="col titlerow">Test</div>
                                    <div class="col">Test</div>
                                </div>
                                <hr/>
                            
                        </div>
                    </div>
                    <div class="col">
                    </div>
                </div>
                
            </nav>
</body>
</html>