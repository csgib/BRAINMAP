	<?php

		require "Class/class_switchs.php";
		require "Class/class_liens.php";

		$hdl_switche = new Switche();
		$hdl_lien = new Lien();

		$hdl_switche->_baie_id 		= "";
		$hdl_switche->_site 		= $_POST['SITE'];
		$hdl_lien->_site		= $_POST['SITE'];

		$hdl_switche->_marque		= $_POST['FRM_SWITCH_MARQUE'];
		$hdl_switche->_description 	= $_POST['FRM_SWITCH_COMMENTAIRES'];

		if ( $_POST['ISNEW'] == "1" )
		{
			$i = 0;

			$hdl_switche->_pos_y		= "0";
			$hdl_switche->_ports_vlan = "";
			$hdl_switche->_ports_connect = "";

			while ( $i < $_POST['FRM_SWITCH_NOMBRE_PORTS'] )
			{
				$hdl_switche->_ports_vlan .= "0;";
				$hdl_switche->_ports_connect .= "0;";
				$i++;
			}

			$hdl_switche->_fiber_connect = "";
			$hdl_switche->_web_interface = "0";
			$hdl_switche->_web_port 	= "";

			$hdl_switche->_https = "0";
		
			$hdl_switche->_ip		= $_POST['X'] . ";" . $_POST['Y'];
			$result = $hdl_switche->insert_switche();
		}
		else
		{
			$hdl_switche->_id 		= $_POST['FRM_SWITCH_ID'];
			$result = $hdl_switche->update_mini_switche();
			
			// *** ON SUPPRIME LES ANCIENS LIENS AVANT DE LE RECREER ***
			$hdl_lien->_id 			= "M" . $_POST['FRM_SWITCH_ID'];
			$hdl_lien->delete_liens();
			
			if ( !empty($_GET['LINKS']) )
			{
				$hdl_lien->_type 		= "0";
				$hdl_lien->_inner 		= "0";

				$wl_tmp_links = explode("~",$_GET['LINKS']);
				
				$wl_i = 0;
				
				while ( $wl_i < count($wl_tmp_links)-1 )
				{
					$wl_tmp_links_2 = explode("^",$wl_tmp_links[$wl_i]);

					if ( strpos($wl_tmp_links_2[0],";") > 0 )
					{
						$wl_tmp_obj_exp = explode(";",$wl_tmp_links_2[0]);
						$wl_tmp_obj = $wl_tmp_obj_exp[1];
					}
					else
					{
						$wl_tmp_obj = $wl_tmp_links_2[0];
					}
					
					$wl_tmp_links_3 = explode(";",$wl_tmp_links_2[1]);
				
					$hdl_lien->_src_id 		= "M" . $_POST['FRM_SWITCH_ID'];
					$hdl_lien->_src_port 		= $wl_tmp_links_3[0];
					$hdl_lien->_dst_id 		= $wl_tmp_obj;
					if ( $wl_tmp_links_3[1] == "null" )
					{
						$hdl_lien->_dst_port 		= "";
					}
					else
					{
						$hdl_lien->_dst_port 		= substr($wl_tmp_links_3[1],1);
					}
					
					$hdl_lien->insert_lien();
					$wl_i++;
				}
			}
		}
		echo $result;

	?>
