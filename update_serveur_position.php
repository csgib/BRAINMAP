	<?php

		require "Class/class_serveurs.php";

		$hdl_serveur = new Serveur();
		$hdl_serveur->_site 		= $_GET['SITE'];	
		$hdl_serveur->_id		= $_GET['ID'];
		$hdl_serveur->_pos_x		= $_GET['X'];
		$hdl_serveur->_pos_y		= $_GET['Y'];

		$result = $hdl_serveur->update_serveur_position();
		echo $result;

	?>
