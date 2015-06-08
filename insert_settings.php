	<?php

		require "Class/class_sites.php";

		$hdl_site = new Site();

		$hdl_site->_id 			= $_POST['SITE'];
		$hdl_site->_description		= $_POST['FRM_SITE_NOM'];
		$hdl_site->_adresse			= $_POST['FRM_SITE_ADRESSE'];
		$hdl_site->_postal			= $_POST['FRM_SITE_POSTAL'];
		$hdl_site->_ville			= $_POST['FRM_SITE_VILLE'];
		$hdl_site->_color_1 			= $_POST['color_1'];
		$hdl_site->_color_2 			= $_POST['color_2'];
		$hdl_site->_color_3 			= $_POST['color_3'];
		$hdl_site->_color_4 			= $_POST['color_4'];
		$hdl_site->_lat				= $_GET['LAT'];
		$hdl_site->_lng				= $_GET['LNG'];

		$result = $hdl_site->update_site_settings();
		echo $result;

	?>
