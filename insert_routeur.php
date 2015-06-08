	<?php

		require "Class/class_routeurs.php";

		$hdl_routeur = new Routeur();

		$hdl_routeur->_site 			= $_POST['SITE'];
		$hdl_routeur->_name 			= $_POST['FRM_ROUTEUR_NAME'];		
		$hdl_routeur->_ip			= $_POST['FRM_ROUTEUR_IP'];
		$hdl_routeur->_ip_publique		= $_POST['FRM_ROUTEUR_IP_PUBLIQUE'];

		if ( isset($_POST["FRM_ROUTEUR_WIFI"]))
		{
			$hdl_routeur->_wifi 		= 1;
		}
		else
		{
			$hdl_routeur->_wifi 		= 0;
		}

		if ( $_POST['ISNEW'] == "0" )
		{
			$hdl_routeur->_pos_x		= $_POST['X'];
			$hdl_routeur->_pos_y		= $_POST['Y'];
			$result = $hdl_routeur->insert_routeur();
		}
		else
		{
			$hdl_routeur->_id		= $_POST['FRM_ID'];
			$result = $hdl_routeur->update_routeur();
		}

		echo $result;

	?>
