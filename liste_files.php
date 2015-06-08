<?php
    include "Class/class_sites.php";

    $hdl_site = new Site();   
    $hdl_site->_id = $_GET["ID"];
    $result_site = json_decode($hdl_site->get_site_from_id()); 

    $i = 0;
    $wl_array_doc = unserialize($result_site[0]->SITES_DOCUMENTS);
    
    echo "<table>";
    
    while ( $i < count($wl_array_doc) && !empty($wl_array_doc[$i]['name']) )
    {
        echo "<tr><td style='width: 24px;'><input id='FL_" . $i . "' type='checkbox' class='DEL_FILES'></td><td style='width: 32px;'><img src='Images/mime/" . $wl_array_doc[$i]['type'] . ".png' width=32px></td><td style='font-size: 12px;'><a href='Files/" . $hdl_site->_id . "/" . $wl_array_doc[$i]['name'] . "' target=\"_blank\">" . $wl_array_doc[$i]['name'] . "</a></td><td style='text-align: right; color: #FFFFFF; font-size: 10px; width: 50px;'>" . round($wl_array_doc[$i]['size'],2) . " Ko</td></tr>";
        $i++;
    }
    
    echo "</table>";

?>