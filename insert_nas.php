	<?php

		require "Class/class_nas.php";

		$hdl_nas = new Nas();

		$hdl_nas->_site 		= $_POST['SITE'];
		$hdl_nas->_name 		= $_POST['FRM_NAS_NAME'];		
		$hdl_nas->_ip 			= $_POST['FRM_NAS_IP'];

		if ( $_POST['ISNEW'] == "0" )
		{
			$hdl_nas->_pos_x		= $_POST['X'];
			$hdl_nas->_pos_y		= $_POST['Y'];
			$result = $hdl_nas->insert_nas();
		}
		else
		{
			$hdl_nas->_id		= $_POST['FRM_ID'];
			$result = $hdl_nas->update_nas();
		}

		echo $result;

	?>
