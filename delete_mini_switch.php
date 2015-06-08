	<?php

		require "Class/class_switchs.php";
		require "Class/class_liens.php";

		$hdl_switche = new Switche();
		$hdl_lien = new Lien();

		$hdl_switche->_site 			= $_GET['SITE'];
		$hdl_switche->_id 			= $_GET['ID'];

		$result = $hdl_switche->delete_mini_switche();

		$hdl_lien->_site 			= $_GET['SITE'];
		$hdl_lien->_id 				= "M" . $_GET['ID'];	
		$hdl_lien->delete_liens();

		echo $result;

	?>
