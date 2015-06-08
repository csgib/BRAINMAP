	<?php

		require "Class/class_antennes.php";

		$hdl_antenne = new Antenne();

		$hdl_antenne->_site 			= $_POST['SITE'];
		$hdl_antenne->_ip 			= $_POST['FRM_ANTENNE_IP'];
		$hdl_antenne->_nom			= $_POST['FRM_ANTENNE_NOM'];

		if ( $_POST['ISNEW'] == "0" )
		{
			$hdl_antenne->_pos_x		= $_POST['X'];
			$hdl_antenne->_pos_y		= $_POST['Y'];
			$result = $hdl_antenne->insert_antenne();
		}
		else
		{
			$hdl_antenne->_id			= $_POST['FRM_ID'];
			$result = $hdl_antenne->update_antenne();
		}

		echo $result;

	?>
