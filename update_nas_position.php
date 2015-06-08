	<?php

		require "Class/class_nas.php";

		$hdl_nas = new Nas();
		$hdl_nas->_site 		= $_GET['SITE'];	
		$hdl_nas->_id		= $_GET['ID'];
		$hdl_nas->_pos_x		= $_GET['X'];
		$hdl_nas->_pos_y		= $_GET['Y'];

		$result = $hdl_nas->update_nas_position();
		echo $result;

	?>
