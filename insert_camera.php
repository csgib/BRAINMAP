	<?php

		require "Class/class_cameras.php";

		$hdl_camera = new Camera();

		$hdl_camera->_site 			= $_POST['SITE'];
		$hdl_camera->_ip 			= $_POST['FRM_CAMERA_IP'];
		$hdl_camera->_descriptif		= $_POST['FRM_CAMERA_DSC'];
		$hdl_camera->_nom			= $_POST['FRM_CAMERA_NOM'];

		if ( $_POST['ISNEW'] == "0" )
		{
			$hdl_camera->_pos_x		= $_POST['X'];
			$hdl_camera->_pos_y		= $_POST['Y'];
			$result = $hdl_camera->insert_camera();
		}
		else
		{
			$hdl_camera->_id			= $_POST['FRM_ID'];
			$result = $hdl_camera->update_camera();
		}

		echo $result;

	?>
