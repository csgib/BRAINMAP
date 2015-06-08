	<?php

		require "Class/class_cameras.php";
		require "Class/class_liens.php";

		$hdl_lien = new Lien();		
		$hdl_camera = new Camera();

		$hdl_camera->_id 			= $_GET['ID'];

		$result = $hdl_camera->delete_camera();
		
		$hdl_lien->_site 			= $_GET['SITE'];
		$hdl_lien->_id 				= "K" . $_GET['ID'];	
		$hdl_lien->delete_liens();		

		echo $result;

	?>
