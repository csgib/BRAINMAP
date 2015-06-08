	<?php

		require "Class/class_switchs.php";

		$hdl_switche = new Switche();

		$hdl_switche->_baie_id 		= $_POST['BAIE_ID'];
		$hdl_switche->_site 		= $_POST['SITE'];	

		$hdl_switche->_marque		= $_POST['FRM_SWITCH_MARQUE'];
		$hdl_switche->_description 	= $_POST['FRM_SWITCH_COMMENTAIRES'];

		$i = 0;
		$hdl_switche->_pos_y		= $_POST['FRM_NOMBRE_SWITCH'];
		
		if ( isset($_POST["FRM_SWITCH_IP"]) && $_POST['ISNEW'] == "1" )
		{
			$hdl_switche->_ip		= $_POST['FRM_SWITCH_IP'];
			
			$hdl_switche->_ports_vlan = "";
			$hdl_switche->_ports_connect = "";

			while ( $i < $_POST['FRM_SWITCH_NOMBRE_PORTS'] )
			{
				$hdl_switche->_ports_vlan .= "0;";
				$hdl_switche->_ports_connect .= "0;";
				$i++;
			}

			$i = 0;
	
			$hdl_switche->_fiber_connect = "";
	
			while ( $i < $_POST['FRM_SWITCH_FIBER_PORTS'] )
			{
				$hdl_switche->_fiber_connect .= "0;";
				$hdl_switche->_ports_vlan .= "0;";
				$i++;
			}
		}
		else
		{
			if ( isset($_POST["FRM_SWITCH_IP"]) )
			{
				$hdl_switche->_ip		= $_POST['FRM_SWITCH_IP'];
			}
		}
		
		if ( isset($_POST["FRM_SWITCH_WEB_ADMIN"]))
		{
			$hdl_switche->_web_interface = "1";
		}
		else
		{
			$hdl_switche->_web_interface = "0";
		}
					
		$hdl_switche->_web_port 	= $_POST['FRM_SWITCH_WEB_PORT'];

		if ( isset($_POST["FRM_SWITCH_FIBER_PORTS"]))
		{
			$hdl_switche->_fiber_ports 	= $_POST['FRM_SWITCH_FIBER_PORTS'];
		}

		if ( isset($_POST["FRM_SWITCH_HTTPS"]))
		{
			$hdl_switche->_https = "1";
		}
		else
		{
			$hdl_switche->_https = "0";
		}

		if ( $_POST['ISNEW'] == "1" )
		{
			$result = $hdl_switche->insert_switche();
		}
		else
		{		
			$hdl_switche->_id 		= $_POST['FRM_SWITCH_ID'];
			$result = $hdl_switche->update_switche();
			
			
			if ( $_POST['FRM_SWITCH_IP'] != $_POST['FRM_SWITCH_OLD_IP'] )
			{
				require "Class/class_liens.php";
				$hdl_lien = new Lien();
				$hdl_lien->_site = $_POST['SITE'];
				$hdl_lien->_dst_id = $_POST['FRM_SWITCH_IP'];
				$hdl_lien->_src_id = $_POST['FRM_SWITCH_OLD_IP'];
				$hdl_lien->update_switch_ip_src();
				$hdl_lien->update_switch_ip_dst();
				
				echo $result;
			}
		}
		echo $result;

	?>
