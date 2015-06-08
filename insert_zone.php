	<?php

		require "Class/class_zones.php";

		$hdl_zone = new Zone();

		$hdl_zone->_site 			= $_POST['SITE'];
		$hdl_zone->_nom 			= $_POST['FRM_ZONE_NAME'];
		$hdl_zone->_color 			= $_POST['color_1'];

		if ( $_POST['ISNEW'] == "0" )
		{
			$hdl_zone->_width		= 250;
			$hdl_zone->_height		= 150;
			$hdl_zone->_pos_x		= $_POST['X'];
			$hdl_zone->_pos_y		= $_POST['Y'];
			$result = $hdl_zone->insert_zone();
		}
		else
		{
			$hdl_zone->_id			= $_POST['FRM_ID'];
			$result = $hdl_zone->update_zone();
		}

		echo $result;

	?>
