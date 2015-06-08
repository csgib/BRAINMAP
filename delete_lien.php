	<?php

		if ( strlen($_GET['SRCO']) == 0 )
		{
			return;
		}

		require "Class/class_liens.php";

		$hdl_lien = new Lien();

		$hdl_lien->_src_id 			= $_GET['SRCI'];	
		$hdl_lien->_src_port 			= $_GET['SRCP'];
		$hdl_lien->_site 			= $_GET['SITE'];

		if ( substr($_GET['SRCO'],0,1) == "R" || substr($_GET['SRCO'],0,1) == "T" || substr($_GET['SRCO'],0,1) == "N" || substr($_GET['SRCO'],0,1) == "K" || substr($_GET['SRCO'],0,1) == "A" )
		{
			$hdl_lien->_dst_id 			= $_GET['SRCO'];
			if ( $_GET['TPPORT'] == "E" )
			{
				$hdl_lien->_type 			= 0;
			}
			else
			{
				$hdl_lien->_type 			= 1;
			}
			$hdl_lien->_dst_port 			= "";	
		}
		else
		{
			if ( substr($_GET['SRCO'],0,1) == "S" )
			{
				$elem = explode(";", $_GET['SRCO']);
	
				$hdl_lien->_dst_id 			= $elem[0];

				if ( substr($elem[1],0,1) == "E" )
				{
					$hdl_lien->_type 			= 0;	
				}
				else
				{
					$hdl_lien->_type 			= 1;	
				}
	
				$hdl_lien->_dst_port 			= substr($elem[1],1);
			}
			else
			{
				if ( substr($_GET['SRCO'],0,1) == "M" )
				{
					$elem = explode(";", $_GET['SRCO']);
		
					$hdl_lien->_dst_id 			= $elem[0];

					if ( substr($elem[1],0,1) == "E" )
					{
						$hdl_lien->_type 			= 0;	
					}
					else
					{
						$hdl_lien->_type 			= 1;	
					}
		
					$hdl_lien->_dst_port 			= substr($elem[1],1);
				}
				else 
				{
					$elem = explode(";", $_GET['SRCO']);
		
					$hdl_lien->_dst_id 			= $elem[1];

					if ( substr($elem[2],0,1) == "E" )
					{
						$hdl_lien->_type 			= 0;	
					}
					else
					{
						$hdl_lien->_type 			= 1;	
					}
		
					$hdl_lien->_dst_port 			= substr($elem[2],1);	
				}
			}
		}

		$result = $hdl_lien->delete_liens_with_ports();

		echo $result;

	?>
