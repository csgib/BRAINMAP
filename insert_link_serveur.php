	<?php

		require "Class/class_liens.php";

		$hdl_lien = new Lien();

		$hdl_lien->_site 		= $_POST['FRM_SITE'];
		$hdl_lien->_src_id 		= $_POST['FRM_SRC_IP'];
		$hdl_lien->_src_port 		= $_POST['FRM_SRC_PORT'];
		$hdl_lien->_inner 		= 0;

		$wl_explode = explode(";",$_POST['FRM_LINK_OBJECT']);
		if ( count($wl_explode) > 1 )
		{
			$hdl_lien->_dst_id 		= $wl_explode[1];
		}
		else
		{
			$hdl_lien->_dst_id 		= $_POST['FRM_LINK_OBJECT'];
		}

		if ( isset($_POST["FRM_LINK_PORT"]) )
		{
			$hdl_lien->_dst_port 		= substr($_POST['FRM_LINK_PORT'],1);

			if ( substr($_POST['FRM_LINK_PORT'],0,1) == "E" )
			{
				$hdl_lien->_type 		= 0;
			}
			else
			{
				if ( substr($_POST['FRM_LINK_PORT'],0,1) == "F" )
				{
					$hdl_lien->_type 		= 1;
				}
				else
				{
					if ( $_POST['FRM_TP_PORT'] == "E" )
					{
						$hdl_lien->_type 		= 0;
					}
					else
					{
						$hdl_lien->_type 		= 1;
					}
				}
			}

		}
		else
		{
			$hdl_lien->_dst_port 		= "";

			if ( $_POST['FRM_TP_PORT'] == "E" )
			{
				$hdl_lien->_type 		= 0;
			}
			else
			{
				$hdl_lien->_type 		= 1;
			}
		}

		$result = $hdl_lien->insert_lien();
		echo $result . ";" . $hdl_lien->_inner . ";" . $hdl_lien->_type;

	?>
