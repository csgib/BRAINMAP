	<?php

		require "Class/class_nas.php";
		require "Class/class_liens.php";

		$hdl_nas = new Nas();
		$hdl_lien = new Lien();

		$hdl_nas->_id 				= $_GET['ID'];

		$result = $hdl_nas->delete_nas();

		$hdl_lien->_site 			= $_GET['SITE'];
		$hdl_lien->_id 			= "N" . $_GET['ID'];	
		$hdl_lien->delete_liens();

		echo $result;

	?>
