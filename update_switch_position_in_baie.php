	<?php

		require "Class/class_switchs.php";

		$hdl_switche = new Switche();

		$id_1 = $_GET['ID1'];
		$id_2 = $_GET['ID2'];

		$hdl_switche->_id = $id_1; 
		$hdl_switche->update_switche_position();

		$hdl_switche->_id = $id_2; 
		$hdl_switche->update_switche_position_add();

	?>
