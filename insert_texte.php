	<?php

		require "Class/class_textes.php";

		$hdl_texte = new Texte();

		$hdl_texte->_site 			= $_POST['SITE'];
		$hdl_texte->_nom 			= $_POST['FRM_ZONE_NAME'];

		if ( $_POST['ISNEW'] == "0" )
		{
			$hdl_texte->_width		= 250;
			$hdl_texte->_height		= 150;
			$hdl_texte->_pos_x		= $_POST['X'];
			$hdl_texte->_pos_y		= $_POST['Y'];
			$result = $hdl_texte->insert_texte();
		}
		else
		{
			$hdl_texte->_id			= $_POST['FRM_ID'];
			$result = $hdl_texte->update_texte();
		}

		echo $result;

	?>
