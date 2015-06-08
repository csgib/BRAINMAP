	<?php

		require "Class/class_antennes.php";
		require "Class/class_liens.php";

		$hdl_lien = new Lien();		
		$hdl_antenne = new Antenne();

		$hdl_antenne->_id 			= $_GET['ID'];

		$result = $hdl_antenne->delete_antenne();
		
		$hdl_lien->_site 			= $_GET['SITE'];
		$hdl_lien->_id 				= "A" . $_GET['ID'];	
		$hdl_lien->delete_liens();		

		echo $result;

	?>
