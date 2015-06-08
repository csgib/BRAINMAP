<?php
    @session_start();
    $filteredData=substr($_POST['img_val'], strpos($_POST['img_val'], ",")+1);
    
    $unencodedData=base64_decode($filteredData);

    file_put_contents("Snaps/" . $_SESSION['SITKEY'] . ".png", $unencodedData, LOCK_EX);
    
?>