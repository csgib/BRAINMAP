<?php
	require "Class/class_liens.php";

	$hdl_lien = new Lien();

	$hdl_lien->_site 		= $_GET['SITE'];	
	
	$result = json_decode($hdl_lien->get_all_liens());
	$i = 0;

	echo "wg_table_links.splice(0,wg_table_links.length);";

	while ( $i < count($result) )
	{
		if ( substr($result[$i]->LIENS_SRC_ID,0,1) == "M" || substr($result[$i]->LIENS_SRC_ID,0,1) == "R" || substr($result[$i]->LIENS_SRC_ID,0,1) == "N" || substr($result[$i]->LIENS_SRC_ID,0,1) == "K" || substr($result[$i]->LIENS_SRC_ID,0,1) == "A"  )
		{
			echo "wg_table_links[" . $i . "] = \"" . $result[$i]->LIENS_DST_ID . ";" . $result[$i]->LIENS_SRC_ID.  ";" . $result[$i]->LIENS_TYPE . ";" . $result[$i]->LIENS_INNER . ";" . $result[$i]->LIENS_DST_PORT . ";" . $result[$i]->LIENS_SRC_PORT . "\";";
		}
		else
		{
			echo "wg_table_links[" . $i . "] = \"" . $result[$i]->LIENS_SRC_ID . ";" . $result[$i]->LIENS_DST_ID.  ";" . $result[$i]->LIENS_TYPE . ";" . $result[$i]->LIENS_INNER . ";" . $result[$i]->LIENS_SRC_PORT . ";" . $result[$i]->LIENS_DST_PORT . "\";";
		}
		$i++;
	}
?>
