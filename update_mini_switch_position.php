	<?php

		require "Class/class_switchs.php";

		$hdl_switche = new Switche();
		$hdl_switche->_site 		= $_GET['SITE'];	
		$hdl_switche->_id		= $_GET['ID'];
		$hdl_switche->_pos_x		= $_GET['X'];
		$hdl_switche->_pos_y		= $_GET['Y'];

		$result = $hdl_switche->update_mini_switche_position();
		echo $result;

	?>
