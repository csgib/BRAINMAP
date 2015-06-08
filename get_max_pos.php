	<?php

		$max_x = 0;
		$max_y = 0;
	
		require "Class/class_baies.php";
		require "Class/class_liens.php";
		require "Class/class_nas.php";
		require "Class/class_routeurs.php";
		require "Class/class_serveurs.php";
		require "Class/class_sites.php";
		require "Class/class_switchs.php";
		require "Class/class_cameras.php";
		require "Class/class_antennes.php";
		require "Class/class_zones.php";
		require "Class/class_transcievers.php";
		require "Class/class_textes.php";

		$hdl_baie = new Baie();
		$hdl_lien = new Lien();
		$hdl_nas = new Nas();
		$hdl_routeur = new Routeur();
		$hdl_serveur = new Serveur();
		$hdl_site = new Site();
		$hdl_switche = new Switche();
		$hdl_camera = new Camera();
		$hdl_antenne = new Antenne();
		$hdl_transciever = new Transceiver();
		$hdl_zone = new Zone();
		$hdl_texte = new Texte();

		$hdl_baie->_site = $_GET['ID'];
		$hdl_lien->_site = $_GET['ID'];
		$hdl_nas->_site = $_GET['ID'];
		$hdl_routeur->_site = $_GET['ID'];
		$hdl_serveur->_site = $_GET['ID'];
		$hdl_site->_id = $_GET['ID'];
		$hdl_switche->_site = $_GET['ID'];
		$hdl_camera->_site = $_GET['ID'];
		$hdl_antenne->_site = $_GET['ID'];
		$hdl_transciever->_site = $_GET['ID'];
		$hdl_zone->_site = $_GET["ID"];
		$hdl_texte->_site = $_GET["ID"];

		$result = json_decode($hdl_serveur->get_maxpos_serveur());
		if ( $result[0]->X > $max_x )
		{
			$max_x = $result[0]->X;
		}
		if ( $result[0]->Y > $max_y )
		{
			$max_y = $result[0]->Y;
		}
		
		$result = json_decode($hdl_baie->get_maxpos_baie());
		if ( $result[0]->X > $max_x )
		{
			$max_x = $result[0]->X;
		}
		if ( $result[0]->Y > $max_y )
		{
			$max_y = $result[0]->Y;
		}
		
		$result = json_decode($hdl_nas->get_maxpos_nas());
		if ( $result[0]->X > $max_x )
		{
			$max_x = $result[0]->X;
		}
		if ( $result[0]->Y > $max_y )
		{
			$max_y = $result[0]->Y;
		}
		
		$result = json_decode($hdl_routeur->get_maxpos_routeur());
		if ( $result[0]->X > $max_x )
		{
			$max_x = $result[0]->X;
		}
		if ( $result[0]->Y > $max_y )
		{
			$max_y = $result[0]->Y;
		}
		
		$result = json_decode($hdl_serveur->get_maxpos_serveur());
		if ( $result[0]->X > $max_x )
		{
			$max_x = $result[0]->X;
		}
		if ( $result[0]->Y > $max_y )
		{
			$max_y = $result[0]->Y;
		}
		
		$result = json_decode($hdl_camera->get_maxpos_camera());
		if ( $result[0]->X > $max_x )
		{
			$max_x = $result[0]->X;
		}
		if ( $result[0]->Y > $max_y )
		{
			$max_y = $result[0]->Y;
		}
		
		$result = json_decode($hdl_antenne->get_maxpos_antenne());
		if ( $result[0]->X > $max_x )
		{
			$max_x = $result[0]->X;
		}
		if ( $result[0]->Y > $max_y )
		{
			$max_y = $result[0]->Y;
		}
		
		$result = json_decode($hdl_transciever->get_maxpos_transceiver());
		if ( $result[0]->X > $max_x )
		{
			$max_x = $result[0]->X;
		}
		if ( $result[0]->Y > $max_y )
		{
			$max_y = $result[0]->Y;
		}
		
		$result = json_decode($hdl_zone->get_maxpos_zone());
		if ( $result[0]->X > $max_x )
		{
			$max_x = $result[0]->X;
		}
		if ( $result[0]->Y > $max_y )
		{
			$max_y = $result[0]->Y;
		}
		
		$result = json_decode($hdl_texte->get_maxpos_texte());
		if ( $result[0]->X > $max_x )
		{
			$max_x = $result[0]->X;
		}
		if ( $result[0]->Y > $max_y )
		{
			$max_y = $result[0]->Y;
		}
		
		echo $max_x . ";" . $max_y;
	?>
