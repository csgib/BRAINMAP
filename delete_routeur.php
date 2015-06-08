	<?php

		require "Class/class_routeurs.php";
		require "Class/class_liens.php";

		$hdl_routeur = new Routeur();
		$hdl_lien = new Lien();

		$hdl_routeur->_id 			= $_GET['ID'];

		$result = $hdl_routeur->delete_routeur();

		$hdl_lien->_site 			= $_GET['SITE'];
		$hdl_lien->_id 			= "R" . $_GET['ID'];	
		$hdl_lien->delete_liens();

		echo $result;

	?>
