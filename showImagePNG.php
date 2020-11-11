<?php 
$unEqualString = "null";
$image = $unEqualString;

if(isset($_GET['DesignJpgPreviewUrl'])){
    $image = $_GET['DesignJpgPreviewUrl'];
}

echo '<div style="text-align:center;"><img src="data:image/jpg;base64,' . base64_encode(file_get_contents($image)) . '"></div>';
?>