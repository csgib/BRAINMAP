	<?php

		require "Class/class_routeurs.php";

		$hdl_routeur = new Routeur();
		$hdl_routeur->_site 		= $_GET['SITE'];	
		$hdl_routeur->_id		= $_GET['ID'];
		$hdl_routeur->_pos_x		= $_GET['X'];
		$hdl_routeur->_pos_y		= $_GET['Y'];

		$result = $hdl_routeur->update_routeur_position();
		echo $result;

	?>
