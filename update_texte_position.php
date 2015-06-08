	<?php

		require "Class/class_textes.php";

		$hdl_texte = new Texte();
		$hdl_texte->_site 		= $_GET['SITE'];	
		$hdl_texte->_id			= $_GET['ID'];
		$hdl_texte->_pos_x		= $_GET['X'];
		$hdl_texte->_pos_y		= $_GET['Y'];
		$hdl_texte->_width		= $_GET['W'];
		$hdl_texte->_height		= $_GET['H'];

		$result = $hdl_texte->update_texte_position();
		echo $result;

	?>
