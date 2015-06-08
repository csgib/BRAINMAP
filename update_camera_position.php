	<?php

		require "Class/class_cameras.php";

		$hdl_camera = new Camera();
		$hdl_camera->_site 		= $_GET['SITE'];	
		$hdl_camera->_id		= $_GET['ID'];
		$hdl_camera->_pos_x		= $_GET['X'];
		$hdl_camera->_pos_y		= $_GET['Y'];

		$result = $hdl_camera->update_camera_position();
		echo $result;

	?>
