	<?php

		require "Class/class_zones.php";

		$hdl_zone = new Zone();
		$hdl_zone->_site 		= $_GET['SITE'];	
		$hdl_zone->_id			= $_GET['ID'];
		$hdl_zone->_pos_x		= $_GET['X'];
		$hdl_zone->_pos_y		= $_GET['Y'];
		$hdl_zone->_width		= $_GET['W'];
		$hdl_zone->_height		= $_GET['H'];

		$result = $hdl_zone->update_zone_position();
		echo $result;

	?>
