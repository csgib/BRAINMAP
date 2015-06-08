<?php
        session_start();
 
	require "Class/class_sites.php";

        $hdl_site = new Site();
        $hdl_site->_id = $_SESSION['SITKEY'];
        $result_site = json_decode($hdl_site->get_site_from_id());
        
        $wl_file_delete = explode(";",$_GET['FILES']);
        $wl_i = 0;
        
        $wl_doc = unserialize($result_site[0]->SITES_DOCUMENTS);
        $repository = "Files/" . $_SESSION['SITKEY'];
        
        while ( $wl_i < count($wl_file_delete)-1 )
        {
            unlink($repository . "/" . $wl_doc[substr($wl_file_delete[$wl_i],3)]["name"]);
            unset($wl_doc[substr($wl_file_delete[$wl_i],3)]);
            $wl_i++;
        }
        
        $foo2 = array_values($wl_doc); 

        $hdl_site->_documents = serialize($foo2);
        $hdl_site->update_site_documents();

?>