	<?php

		require "Class/class_switchs.php";
		require "Class/class_liens.php";

		$hdl_switche = new Switche();
		$hdl_lien = new Lien();

		$hdl_switche->_site 		= $_GET['SITE'];
		$hdl_switche->_id 		= $_GET['ID'];

		$hdl_lien->_site 		= $_GET['SITE'];
		$type 				= $_GET['TYPE'];

		$result = json_decode($hdl_switche->get_switch_in_baie_from_id());
		$i = 0;

		if ( count($result) > 0 )
		{
			//echo "<option value=''></option>";

			if ( $type == "E" )
			{
				$table_connect = explode(";", $result[0]->SWITCHS_PORTS_CONNECT);
				while ( $i < count($table_connect)-1 )
				{
					$hdl_lien->_src_id = $result[0]->SWITCHS_IP;
					$hdl_lien->_src_port = ($i+1);
					$hdl_lien->_type = 0;

					$res_link = $hdl_lien->get_is_lien();
					if ( $res_link == "1" )
					{
						echo "<option value='E" . ($i+1) . "' style='color: #ff0000;'>Ethernet " . ($i+1) . "</option>";
					}
					else
					{
						echo "<option value='E" . ($i+1) . "'>Ethernet " . ($i+1) . "</option>";
					}
					$i++;
				}
			}
			else
			{
				$i = 0;
				$table_connect = explode(";", $result[0]->SWITCHS_FIBER_CONNECT);
				while ( $i < count($table_connect)-1 )
				{
					$hdl_lien->_src_id = $result[0]->SWITCHS_IP;
					$hdl_lien->_src_port = ($i+1);
					$hdl_lien->_type = 1;

					$res_link = $hdl_lien->get_is_lien();
					if ( $res_link == "1" )
					{
						echo "<option value='F" . ($i+1) . "' style='color: #ff0000;'>Fibre " . ($i+1) . "</option>";
					}
					else
					{
						echo "<option value='F" . ($i+1) . "'>Fibre " . ($i+1) . "</option>";
					}
					$i++;
				}
			}
		}
	?>
