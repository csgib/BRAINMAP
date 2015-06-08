	<?php

		require "Class/class_transcievers.php";
		require "Class/class_liens.php";

		$hdl_lien = new Lien();		
		$hdl_transciever = new Transceiver();

		$hdl_transciever->_id 			= $_GET['ID'];

		$result = $hdl_transciever->delete_transceiver();
		
		$hdl_lien->_site 			= $_GET['SITE'];
		$hdl_lien->_id 				= "T" . $_GET['ID'];	
		$hdl_lien->delete_liens();		

		echo $result;

	?>
