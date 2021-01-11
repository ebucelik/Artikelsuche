<?php 
require_once('submit.php');

$email = "";
$pdf = "";
$data = array();
$imageArray = array();

if(isset($_GET["email"])){
    $email = $_GET["email"];
}

if(isset($_GET["data"])){
    $data = json_decode($_GET["data"]);
}

if(isset($_GET["PDF"])){
    $pdf = $_GET["PDF"];
}
?>

<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Mail senden</title>
    <link href="css/mailForm.css" rel="stylesheet" type="text/css"/>
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> 
</head>
<body>
    <header>
        <a href="searching.php" ><img src="Bilder/Version3.png" id="headerImg" title="Marzek Artikelsuche" alt="Marzek Artikelsuche Bild" width="400"></a>
    </header>
    
    <nav>
        <div class="container">
            <!-- Display contact form -->
            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="senderEmail">Sender:</label>
                    <input type="email" name="senderEmail" id="senderEmail" class="form-control" value="" placeholder="Sender E-Mail Adresse" required="">
                </div>
                <div class="form-group">
                    <label for="receiverEmail">Empfänger:</label>
                    <input type="email" name="receiverEmail" id="receiverEmail" class="form-control" value="<?php echo !empty($email)?$email:''; ?>" placeholder="Empfänger E-Mail Adresse" required="">
                </div>
                <div class="form-group">
                    <label for="subject">Betreff:</label>
                    <input type="text" name="subject" id="subject" class="form-control" value="<?php echo !empty($postData['subject'])?$postData['subject']:''; ?>" placeholder="Betreff" required="">
                </div>
                <div class="form-group">
                    <label for="message">Nachricht:</label>
                    <textarea name="message" id="message" class="form-control" placeholder="Ihre Nachricht." rows="15" required=""><?php 
                    echo "Sehr geehrter Kunde, <br><br>\n\nanbei senden wir Ihnen die Informationen zu Ihren Etikett(en) inkl. Bild(er).<br><br>\n\n";
                    
                    if(isset($data)){
                        for($i = 0; $i < count($data); $i++){
                            for($j = 0; $j < count($data[$i]) - 1; $j++){
                                if($data[$i][$j] && $j < count($data[$i]) - 2){
                                    echo $data[$i][$j] . " <br>\n";
                                }else{
                                    echo $data[$i][$j] . " <br><br>\n";
                                }
                            }
                            echo "\n";
    
                            $url = $data[$i][12];
                            $itemid = str_replace('R-Nummer: ', '', $data[$i][0]);
                            $itemid = str_replace('/', '-', $itemid);
                            $img = 'Uploads/' . $itemid . '.jpg';
                            file_put_contents($img, @file_get_contents($url));
                            array_push($imageArray, $img);
                        } 
                    }
                    echo "Mit freundlichen Grüßen,<br>\nIhr Marzek Etiketten+Packaging Team";
                    ?></textarea>
                </div>
                <?php 
                if(isset($imageArray)){
                    foreach($imageArray as $urls)
                    {
                        echo '<input type="hidden" name="attachment[]" value="'. $urls. '">';
                    }
                }
                
                if(isset($pdf)){
                    $test = array();
                    array_push($test, $pdf);
                    echo '<input type="hidden" name="attachment[]" value="'. $pdf. '">'; 
                }
                ?>
                <div class="submit">
                    <input type="submit" name="submit" class="btn btn-outline-light fading" id="articlesearch" value="SENDEN">
                </div>
            </form>
            
        </div>
    </nav>
</body>
</html>