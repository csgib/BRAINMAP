	<?php

		require "Class/class_switchs.php";
		require "Class/class_liens.php";

		$hdl_switche = new Switche();
		$hdl_lien = new Lien();

		$hdl_switche->_baie_id 	= $_GET['BAIE_ID'];
		$hdl_switche->_pos_y 		= $_GET['POS_Y'];	

		$result_switch = json_decode($hdl_switche->get_switch_in_baie_from_pos());

		$i = 0;

		while ( $i < count($result_switch) )
		{
			$hdl_switche->_id = $result_switch[$i]->SWITCHS_ID; 
			$hdl_switche->update_switche_position();

			$i++;
		}

		$hdl_lien->_site 		= $_GET['SITE'];	
		$hdl_lien->_id 		= $_GET['IP'];	
		$hdl_lien->delete_liens();

	?>
