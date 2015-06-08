	<?php

		require "Class/class_transcievers.php";

		$hdl_transceiver = new Transceiver();
		$hdl_transceiver->_site 		= $_GET['SITE'];	
		$hdl_transceiver->_id			= $_GET['ID'];
		$hdl_transceiver->_pos_x		= $_GET['X'];
		$hdl_transceiver->_pos_y		= $_GET['Y'];

		$result = $hdl_transceiver->update_transceiver_position();
		echo $result;

	?>
