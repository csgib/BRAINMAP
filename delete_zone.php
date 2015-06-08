	<?php

		require "Class/class_zones.php";

		$hdl_zone = new Zone();

		$hdl_zone->_id 			= $_GET['ID'];

		$result = $hdl_zone->delete_zone();

		echo $result;

	?>
