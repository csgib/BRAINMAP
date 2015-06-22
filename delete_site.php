	<?php

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

		$result = $hdl_serveur->delete_serveur();

		$hdl_baie->delete_baies_for_site();
		$hdl_lien->delete_liens_for_site();
		$hdl_nas->delete_nas_for_site();
		$hdl_routeur->delete_routeurs_for_site();
		$hdl_serveur->delete_serveurs_for_site();
		$hdl_switche->delete_switches_for_site();
		$hdl_camera->delete_cameras_for_site();
		$hdl_antenne->delete_antennes_for_site();
		$hdl_transciever->delete_transceivers_for_site();
		$hdl_zone->delete_zones_for_site();
		$hdl_texte->delete_textes_for_site();
		
		$result = $hdl_site->delete_site();
		
		unlink('Snaps/' . $_GET['ID'] . '.png');

		$result_site = json_decode($hdl_site->get_all_sites());

		$i = 0;
		$tabsite = "<option></option>";
			
		while ( $i < count($result_site) )
		{
			$tabsite .= "<option value='" . $result_site[$i]->SITES_ID . "'>" . $result_site[$i]->SITES_ID . " " . $result_site[$i]->SITES_DESCRIPTION . "</option>";
			$i++;
		}
		
		echo $result . $tabsite;

	?>
