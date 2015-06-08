	<?php

		require "Class/class_transcievers.php";

		$hdl_transceiver = new Transceiver();

		$hdl_transceiver->_site 			= $_POST['SITE'];
		$hdl_transceiver->_libelle			= $_POST['FRM_TRANSCEIVER_LIBELLE'];
		$hdl_transceiver->_constructeur			= $_POST['FRM_TRANSCEIVER_CONSTRUCTEUR'];

		if ( $_POST['ISNEW'] == "0" )
		{
			$hdl_transceiver->_pos_x		= $_POST['X'];
			$hdl_transceiver->_pos_y		= $_POST['Y'];
			$result = $hdl_transceiver->insert_transceiver();
		}
		else
		{
			$hdl_transceiver->_id			= $_POST['FRM_ID'];
			$result = $hdl_transceiver->update_transceiver();
			
			require "Class/class_liens.php";
			$hdl_lien = new Lien();
			$hdl_lien->_site = $_POST['SITE'];
			$hdl_lien->_src_id = "T" . $_POST['FRM_ID'];

			$hdl_lien->delete_liens_from_trans();
			
			if ( $_POST['FRM_LINK_OBJECT'] != "" )
			{
				$hdl_lien->_src_port = "";
				$hdl_lien->_dst_port = "";
				$hdl_lien->_dst_id = $_POST['FRM_LINK_OBJECT'];
				$hdl_lien->_src_id = "T" . $_POST['FRM_ID'];
				$hdl_lien->_type = "1";
				
				$hdl_lien->insert_lien();
			}
	
		}

		echo $result;

	?>
