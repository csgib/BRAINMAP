	<?php

		require "Class/class_computers.php";


		$hdl_computer = new Computer();
		$hdl_computer->_site	 		= $_POST['FRM_SITE'];
		$hdl_computer->_hostname		= $_POST['FRM_HOSTNAME'];
		$hdl_computer->_ip 			= $_POST['FRM_IP'];
		$hdl_computer->_os	 		= $_POST['FRM_OS'];
		$hdl_computer->_release	 		= $_POST['FRM_RELEASE'];
		$hdl_computer->_vnc_port 		= $_POST['FRM_VNC_PORT'];

		
		if ( $_POST['FRM_NEW'] == "0" )
		{
			$result = $hdl_computer->insert_computers();
		}
		else
		{
			$hdl_computer->_id		= $_POST['FRM_NEW'];
			$result = $hdl_computer->update_computers();
		}
		echo $result;

	?>
