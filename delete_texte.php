	<?php

		require "Class/class_textes.php";

		$hdl_texte = new Texte();

		$hdl_texte->_id			= $_GET['ID'];

		$result = $hdl_texte->delete_texte();

		echo $result;

	?>
