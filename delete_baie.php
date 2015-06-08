	<?php

		require "Class/class_baies.php";

		$hdl_baie = new Baie();

		$hdl_baie->_id 		= $_GET['ID'];
		$hdl_baie->_site 		= $_GET['SITE'];	

		$result = $hdl_baie->delete_baie();
		echo $result;

	?>
