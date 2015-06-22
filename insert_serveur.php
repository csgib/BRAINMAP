	<?php

		require "Class/class_serveurs.php";

		$hdl_serveur = new Serveur();

		$hdl_serveur->_site 		= $_POST['SITE'];
		$hdl_serveur->_name 		= $_POST['FRM_SERVEUR_NAME'];

		if ( isset($_POST["X"]) )
		{
			$hdl_serveur->_pos_x		= $_POST['X'];
			$hdl_serveur->_pos_y		= $_POST['Y'];
		}
		$hdl_serveur->_marque		= $_POST['FRM_SERVEUR_MARQUE'];
		$hdl_serveur->_modele		= $_POST['FRM_SERVEUR_MODELE'];
		$hdl_serveur->_os		= $_POST['FRM_SERVEUR_OS'];
		$hdl_serveur->_release		= $_POST['FRM_SERVEUR_RELEASE'];
		$hdl_serveur->_web_port 	= $_POST['FRM_SERVEUR_WEB_PORT'];
		
		if ( isset($_POST["FRM_SERVEUR_ONDULEE"]))
		{
			$hdl_serveur->_ondulee		= "1";
		}
		else
		{
			$hdl_serveur->_ondulee		= "0";
		}

		if ( isset($_POST["FRM_SERVEUR_FIREWALL"]))
		{
			$hdl_serveur->_firewall		= "1";
		}
		else
		{
			$hdl_serveur->_firewall		= "0";
		}
		
		if ( isset($_POST["FRM_SERVEUR_WEB_ADMIN"]))
		{
			$hdl_serveur->_web_interface = "1";
		}
		else
		{
			$hdl_serveur->_web_interface = "0";
		}

		if ( isset($_POST["FRM_SERVEUR_HTTPS"]))
		{
			$hdl_serveur->_https = "1";
		}
		else
		{
			$hdl_serveur->_https = "0";
		}

		if ( isset($_POST["FRM_SERVEUR_NET0_OK"]))
		{
			$hdl_serveur->_lan_1_on = "1";
		}
		else
		{
			$hdl_serveur->_lan_1_on = "0";
		}
		$hdl_serveur->_lan_1_type = $_POST['FRM_SERVEUR_LAN_TYPE_0'];
		$hdl_serveur->_lan_1_ip = $_POST['FRM_SERVEUR_IP_0'];

		if ( isset($_POST["FRM_SERVEUR_NET1_OK"]))
		{
			$hdl_serveur->_lan_2_on = "1";
		}
		else
		{
			$hdl_serveur->_lan_2_on = "0";
		}
		$hdl_serveur->_lan_2_type = $_POST['FRM_SERVEUR_LAN_TYPE_1'];
		$hdl_serveur->_lan_2_ip = $_POST['FRM_SERVEUR_IP_1'];

		if ( isset($_POST["FRM_SERVEUR_NET2_OK"]))
		{
			$hdl_serveur->_lan_3_on = "1";
		}
		else
		{
			$hdl_serveur->_lan_3_on = "0";
		}
		$hdl_serveur->_lan_3_type = $_POST['FRM_SERVEUR_LAN_TYPE_2'];
		$hdl_serveur->_lan_3_ip = $_POST['FRM_SERVEUR_IP_2'];

		if ( isset($_POST["FRM_SERVEUR_NET3_OK"]))
		{
			$hdl_serveur->_lan_4_on = "1";
		}
		else
		{
			$hdl_serveur->_lan_4_on = "0";
		}
		$hdl_serveur->_lan_4_type = $_POST['FRM_SERVEUR_LAN_TYPE_3'];
		$hdl_serveur->_lan_4_ip = $_POST['FRM_SERVEUR_IP_3'];

		if ( isset($_POST["FRM_SERVEUR_NET4_OK"]))
		{
			$hdl_serveur->_lan_5_on = "1";
		}
		else
		{
			$hdl_serveur->_lan_5_on = "0";
		}
		$hdl_serveur->_lan_5_type = $_POST['FRM_SERVEUR_LAN_TYPE_4'];
		$hdl_serveur->_lan_5_ip = $_POST['FRM_SERVEUR_IP_4'];

		if ( isset($_POST["FRM_SERVEUR_NET5_OK"]))
		{
			$hdl_serveur->_lan_6_on = "1";
		}
		else
		{
			$hdl_serveur->_lan_6_on = "0";
		}
		$hdl_serveur->_lan_6_type = $_POST['FRM_SERVEUR_LAN_TYPE_5'];
		$hdl_serveur->_lan_6_ip = $_POST['FRM_SERVEUR_IP_5'];

		$hdl_serveur->_web_card = $_POST['FRM_SERVEUR_WEB_CARD'];
		
		$hdl_serveur->_glpi_id = $_POST['FRM_SERVEUR_GLPI_ID'];

		if ( $_POST['ISNEW'] == "1" )
		{
			$result = $hdl_serveur->insert_serveur();
		}
		else
		{
			$hdl_serveur->_id = $_POST['ID'];
			$result = $hdl_serveur->update_serveur();
		}
		echo $result;

	?>
