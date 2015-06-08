	<?php

		require "Class/class_baies.php";
		require "Class/class_nas.php";
		require "Class/class_routeurs.php";
		require "Class/class_serveurs.php";
		require "Class/class_sites.php";

		$hdl_baie = new Baie();
		$hdl_nas = new Nas();
		$hdl_routeur = new Routeur();
		$hdl_serveur = new Serveur();
		$hdl_site = new Site();

		$hdl_baie->_site = $_GET['SITEO'];
		$hdl_nas->_site = $_GET['SITEO'];
		$hdl_routeur->_site = $_GET['SITEO'];
		$hdl_serveur->_site = $_GET['SITEO'];
		$hdl_site->_id = $_GET['SITEO'];
		
		$wl_opt_dup = $_GET['OPT'];
		$elem = explode(";",$wl_opt_dup);
		
		$wl_sited = $_GET['SITED'];
		
		if ( $elem[0] == "1" )
		{
			$result = json_decode($hdl_serveur->get_all_serveurs());
			$i = 0;

			while ( $i < count($result) )
			{
				$hdl_serveur->_site 		= $wl_sited;
				$hdl_serveur->_name 		= $result[$i]->SERVEURS_NAME;
				$hdl_serveur->_pos_x		= $result[$i]->SERVEURS_POS_X;
				$hdl_serveur->_pos_y		= $result[$i]->SERVEURS_POS_Y;
				$hdl_serveur->_marque		= $result[$i]->SERVEURS_MARQUE;
				$hdl_serveur->_modele		= $result[$i]->SERVEURS_MODELE;
				$hdl_serveur->_web_card		= "1";
				
				$hdl_serveur->insert_serveur();
				$i++;
			}
		}
		
		if ( $elem[1] == "1" )
		{
			$result = json_decode($hdl_routeur->get_all_routeurs());
			$i = 0;

			while ( $i < count($result) )
			{
				$hdl_routeur->_site 			= $wl_sited;
				$hdl_routeur->_name 			= $result[$i]->ROUTEURS_NAME;		
				$hdl_routeur->_ip			= "";
				$hdl_routeur->_ip_publique		= "";
				$hdl_routeur->_wifi 			= $result[$i]->ROUTEURS_WIFI;
				$hdl_routeur->_pos_x			= $result[$i]->ROUTEURS_POS_X;
				$hdl_routeur->_pos_y			= $result[$i]->ROUTEURS_POS_Y;
				
				$hdl_routeur->insert_routeur();
				$i++;
			}
		}
		
		if ( $elem[2] == "1" )
		{
			$result = json_decode($hdl_nas->get_all_nas());
			$i = 0;

			while ( $i < count($result) )
			{
				$hdl_nas->_site 			= $wl_sited;
				$hdl_nas->_name 			= $result[$i]->NAS_NAME;		
				$hdl_nas->_ip 				= "";
				$hdl_nas->_pos_x			= $result[$i]->NAS_POS_X;
				$hdl_nas->_pos_y			= $result[$i]->NAS_POS_Y;
				
				$hdl_nas->insert_nas();
				$i++;
			}
		}

		if ( $elem[3] == "1" )
		{
			$result = json_decode($hdl_baie->get_all_baies());
			$i = 0;

			while ( $i < count($result) )
			{
				$hdl_baie->_site 			= $wl_sited;	
				$hdl_baie->_pos_x			= $result[$i]->BAIES_POS_X;
				$hdl_baie->_pos_y			= $result[$i]->BAIES_POS_Y;
				$hdl_baie->_width			= $result[$i]->BAIES_WIDTH;
				$hdl_baie->_height 			= $result[$i]->BAIES_HEIGHT;									
				$hdl_baie->_commentaires 		= $result[$i]->BAIES_COMMENTAIRES;
				$hdl_baie->_ondulee 			= $result[$i]->BAIES_ONDULEE;
				$hdl_baie->_datas 			= $result[$i]->BAIES_DATAS;

				$hdl_baie->insert_baie();
				$i++;
			}
		}
	?>
