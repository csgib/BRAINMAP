	<?php

		require "Class/class_baies.php";

		$hdl_baie = new Baie();
		$hdl_baie->_site 		= $_POST['SITE'];	
		$hdl_baie->_pos_x		= $_POST['X'];
		$hdl_baie->_pos_y		= $_POST['Y'];
		$hdl_baie->_width		= 100;
		$hdl_baie->_height 		= 150;									
		$hdl_baie->_commentaires 	= trim($_POST['COMMENTAIRES']);

		if ( isset($_POST["FRM_BAIE_ONDULEE"]))
		{
			$hdl_baie->_ondulee = 1;
		}
		else
		{
			$hdl_baie->_ondulee = 0;
		}

		$hdl_baie->_datas 		= trim($_POST['FRM_BAIE_DATAS']);

		if ( $_POST['IS_NEW'] == "1" )
		{
			$result = $hdl_baie->insert_baie();
			echo $result;
		}
		else
		{
			$hdl_baie->_id		= $_POST['ID_NEW'];
			$result = $hdl_baie->update_baie_name();
			echo "UPDATE";
		}
	?>
