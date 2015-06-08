	<?php

		require "Class/class_switchs.php";

		$hdl_switche = new Switche();

		$hdl_switche->_id 		= $_GET['ID'];
		$hdl_switche->_site 		= $_GET['SITE'];	

		$result = $hdl_switche->delete_switche();
		echo $result;

	?>
