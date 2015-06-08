	<?php

		require "Class/class_serveurs.php";
		require "Class/class_liens.php";

		$hdl_serveur = new Serveur();
		$hdl_lien = new Lien();

		$hdl_serveur->_site 		= $_GET['SITE'];
		$hdl_serveur->_id 		= $_GET['ID'];
		$hdl_lien->_site 		= $_GET['SITE'];
		$type_lien 			= $_GET['TP'];

		if ( $type_lien == "E" )
		{
			$type_lien = 0;
		}
		else
		{
			$type_lien = 1;
		}

		$result = json_decode($hdl_serveur->get_serveur_from_id());
		$i = 1;

		if ( count($result) > 0 )
		{
			//echo "<option value=''></option>";
			while ( $i < 7 )
			{
				$wl_var_on = "SERVEURS_LAN_" . $i . "_ON";
				$wl_var_ip = "SERVEURS_LAN_" . $i . "_IP";
				$wl_var_tp = "SERVEURS_LAN_" . $i . "_TYPE";
				if ( $result[0]->$wl_var_on == "1" )
				{
					if ( $result[0]->$wl_var_tp == $type_lien )
					{
						if ( $result[0]->$wl_var_tp == "0" )
						{

							$hdl_lien->_src_id = "S" . $_GET['ID'];
							$hdl_lien->_src_port = $i;
							$hdl_lien->_type = 0;

							$res_link = $hdl_lien->get_is_lien();
							if ( $res_link == "1" )
							{
								echo "<option value='E" . $i . "' style='color: #ff0000;'>Ethernet " . $i . " - " . $result[0]->$wl_var_ip . "</option>";
							}
							else
							{
								echo "<option value='E" . $i . "'>Ethernet " . $i . " - " . $result[0]->$wl_var_ip . "</option>";
							}
						}
						else
						{
							$hdl_lien->_src_id = "S" . $_GET['ID'];
							$hdl_lien->_src_port = $i;
							$hdl_lien->_type = 1;

							$res_link = $hdl_lien->get_is_lien();
							if ( $res_link == "1" )
							{
								echo "<option value='F" . $i . "' style='color: #ff0000;'>Fibre " . $i . " - " . $result[0]->$wl_var_ip . "</option>";
							}
							else
							{
								echo "<option value='F" . $i . "'>Fibre " . $i . " - " . $result[0]->$wl_var_ip . "</option>";
							}
						}
					}
				}
				$i++;
			}
		}
	?>
