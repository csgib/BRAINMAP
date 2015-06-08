	<?php

		require "Class/class_sites.php";

		$hdl_site = new Site();
		$hdl_site->_id 		= addslashes($_POST['FRM_NEW_S_CODE']);	
		$hdl_site->_description	= addslashes($_POST['FRM_NEW_S_LIBELLE']);
		$hdl_site->_color_1		= "#F376DE";
		$hdl_site->_color_2		= "#23F512";
		$hdl_site->_color_3		= "#CEC2C2";
		$hdl_site->_color_4		= "#FCA012";
		$hdl_site->_adresse		= "";
		$hdl_site->_postal		= "";
		$hdl_site->_ville		= "";

		// *** CONTROLE UNICITE ID ***
		$result = $hdl_site->get_site_exist();
		if ( $result == "1" )
		{
			echo "ALREADY_EXIST";
		}
		else
		{
			$result = $hdl_site->insert_site();
			echo $result;
		}

	?>
