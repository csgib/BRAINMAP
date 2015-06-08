	<?php

		require "Class/class_antennes.php";

		$hdl_antenne = new Antenne();
		$hdl_antenne->_site 		= $_GET['SITE'];	
		$hdl_antenne->_id		= $_GET['ID'];
		$hdl_antenne->_pos_x		= $_GET['X'];
		$hdl_antenne->_pos_y		= $_GET['Y'];

		$result = $hdl_antenne->update_antenne_position();
		echo $result;

	?>
