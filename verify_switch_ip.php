	<?php

		require "Class/class_switchs.php";

		$hdl_switche = new Switche();

		$hdl_switche->_site 		= $_POST['SITE'];	

		if ( isset($_POST["FRM_SWITCH_IP"]))
		{
			$hdl_switche->_ip		= $_POST['FRM_SWITCH_IP'];

			$result = $hdl_switche->verify_ip_in_schema();
			echo $result;
		}
		else
		{
			echo "0";
		}

	?>
