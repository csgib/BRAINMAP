<?php

	require "Class/class_liens.php";
	require "Class/class_switchs.php";

	$hdl_lien = new Lien();
	$hdl_switche = new Switche();

	$hdl_lien->_site 		= $_POST['FRM_SITE'];
	$hdl_lien->_src_id 		= $_POST['FRM_SRC_IP'];
	$hdl_lien->_src_port 		= $_POST['FRM_SRC_PORT'];

	$wl_explode = explode(";",$_POST['FRM_LINK_OBJECT']);
	if ( count($wl_explode) > 1 )
	{
		if ( (substr($_POST['FRM_LINK_OBJECT'],0,1) == "R" || substr($_POST['FRM_LINK_OBJECT'],0,1) == "S" || substr($_POST['FRM_LINK_OBJECT'],0,1) == "N") && substr($_POST['FRM_LINK_OBJECT'],0,5) != "NOIP_" )
		{
			$hdl_lien->_dst_id 		= $_POST['FRM_LINK_OBJECT'];
			$hdl_lien->_inner 		= 999;
		}
		else
		{
			$hdl_lien->_dst_id 		= $wl_explode[1];
			$hdl_switche->_site		= $_POST['FRM_SITE'];
			$hdl_switche->_id		= $wl_explode[0]; //$_POST['FRM_LINK_OBJECT'];

			$result = json_decode($hdl_switche->get_switch_in_baie_from_id());
			if ( count($result) > 0 )
			{
				if ( $result[0]->SWITCHS_BAIE_ID == $_POST['FRM_BAIE'] )
				{
					$hdl_lien->_inner = 1;
				}
				else
				{
					$hdl_lien->_inner = 0;
				}
			}
			else
			{
				$hdl_lien->_inner = 2; // *** CAS D'ERREUR ***
			}		
		}
	}
	else
	{
		$hdl_lien->_dst_id 		= $_POST['FRM_LINK_OBJECT'];
		$hdl_lien->_inner 		= 0;
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
