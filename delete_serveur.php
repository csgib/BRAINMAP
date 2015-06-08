	<?php

		require "Class/class_serveurs.php";
		require "Class/class_liens.php";

		$hdl_serveur = new Serveur();
		$hdl_lien = new Lien();

		$hdl_serveur->_id 		= $_GET['ID'];

		$result = $hdl_serveur->delete_serveur();

		$hdl_lien->_site 			= $_GET['SITE'];
		$hdl_lien->_id 			= "S" . $_GET['ID'];	
		$hdl_lien->delete_liens();

		echo $result;

	?>
