	<?php

		require "Class/class_baies.php";

		$hdl_baie = new Baie();
		$hdl_baie->_site 		= $_GET['SITE'];	
		$hdl_baie->_id 			= $_GET['ID'];
		$hdl_baie->_pos_x		= $_GET['X'];
		$hdl_baie->_pos_y		= $_GET['Y'];

		$result = $hdl_baie->update_baie_position();
		echo $result;

	?>
