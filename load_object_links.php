	<?php

		require "Class/class_liens.php";
		require "Class/class_switchs.php";

		$hdl_lien = new Lien();
		$hdl_switche = new Switche();

		$hdl_lien->_site 		= $_GET['SITE'];
		$hdl_lien->_src_id 		= $_GET['IP'];
		$hdl_lien->_src_port 		= $_GET['PORT'];
		$hdl_lien->_type 		= $_GET['TPORT'];

		$hdl_switche->_site 		= $_GET['SITE'];

		$result = json_decode($hdl_lien->get_liens_from_object());

		if ( count($result) > 0 )
		{
			if ( $result[0]->LIENS_SRC_ID == $hdl_lien->_src_id ) // *** LE LIEN EST SOURCE ***
			{
				if ( (substr($result[0]->LIENS_DST_ID,0,1) == "R" OR substr($result[0]->LIENS_DST_ID,0,1) == "T" OR substr($result[0]->LIENS_DST_ID,0,1) == "S" OR substr($result[0]->LIENS_DST_ID,0,1) == "N" OR substr($result[0]->LIENS_DST_ID,0,1) == "M" OR substr($result[0]->LIENS_DST_ID,0,1) == "K" OR substr($result[0]->LIENS_DST_ID,0,1) == "A") AND substr($result[0]->LIENS_DST_ID,0,5) != "NOIP_" )
				{
					echo $result[0]->LIENS_DST_ID . ";" . $result[0]->LIENS_DST_PORT . ";" . $result[0]->LIENS_TYPE;
				}
				else
				{
					$hdl_switche->_ip 		= $result[0]->LIENS_DST_ID;

					$result_switche = json_decode($hdl_switche->get_switch_in_baie_from_ip());

					if ( count($result_switche) > 0 )
					{
						echo $result_switche[0]->SWITCHS_ID . ";" . $result[0]->LIENS_DST_PORT . ";" . $result[0]->LIENS_DST_ID . ";" . $result[0]->LIENS_TYPE;
					}
				}
			}
			else
			{
				if ( (substr($result[0]->LIENS_SRC_ID,0,1) == "R" OR substr($result[0]->LIENS_SRC_ID,0,1) == "T" OR substr($result[0]->LIENS_SRC_ID,0,1) == "S" OR substr($result[0]->LIENS_SRC_ID,0,1) == "N" OR substr($result[0]->LIENS_SRC_ID,0,1) == "M" OR substr($result[0]->LIENS_SRC_ID,0,1) == "K") AND substr($result[0]->LIENS_SRC_ID,0,5) != "NOIP_" )
				{
					echo $result[0]->LIENS_SRC_ID . ";" . $result[0]->LIENS_SRC_PORT . ";" . $result[0]->LIENS_TYPE;
				}
				else
				{
					$hdl_switche->_ip 		= $result[0]->LIENS_SRC_ID;

					$result_switche = json_decode($hdl_switche->get_switch_in_baie_from_ip());

					if ( count($result_switche) > 0 )
					{
						echo $result_switche[0]->SWITCHS_ID . ";" . $result[0]->LIENS_SRC_PORT . ";" . $result[0]->LIENS_SRC_ID . ";" . $result[0]->LIENS_TYPE;
					}
				}
			}	
		}
	?>
