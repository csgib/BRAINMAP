	<?php

		require "Class/class_switchs.php";

		$hdl_switche = new Switche();

		$hdl_switche->_id 		= $_POST['FRM_SWITCH_ID'];
		$hdl_switche->_site 		= $_POST['FRM_SITE'];	

		$i = 0;

		$hdl_switche->_ports_connect = "";

		while ( $i < $_POST['FRM_SWITCH_NB_ETH_PORT'] )
		{
			if ( isset($_POST["SW" . $i]))
			{
				$hdl_switche->_ports_connect .= "1;";
			}
			else
			{
				$hdl_switche->_ports_connect .= "0;";
			}

			$i++;
		}

		$i = 0;

		$hdl_switche->_fiber_connect = "";

		while ( $i < $_POST['FRM_SWITCH_NB_FIB_PORT'] )
		{
			if ( isset($_POST["FB" . $i]))
			{
				$hdl_switche->_fiber_connect .= "1;";
			}
			else
			{
				$hdl_switche->_fiber_connect .= "0;";
			}
			$i++;
		}

		$i = 0;

		$hdl_switche->_ports_vlan = "";

		while ( $i < $_POST['FRM_SWITCH_NB_ETH_PORT'] )
		{
			if ( isset($_POST["VLA" . $i]) )
			{
				if ( trim($_POST["VLA" . $i] != "NOTV") )
				{
					$hdl_switche->_ports_vlan .= $_POST["VLA" . $i] . ";";
				}
				else
				{
					$hdl_switche->_ports_vlan .= "0;";
				}
			}
			else
			{
				$hdl_switche->_ports_vlan .= "0;";
			}

			$i++;
		}

		$i = 0;

		while ( $i < $_POST['FRM_SWITCH_NB_FIB_PORT'] )
		{
			if ( isset($_POST["VLAF" . $i]) )
			{
				if ( trim($_POST["VLAF" . $i] != "NOTV") )
				{
					$hdl_switche->_ports_vlan .= $_POST["VLAF" . $i] . ";";
				}
				else
				{
					$hdl_switche->_ports_vlan .= "0;";
				}				
			}
			else
			{
				$hdl_switche->_ports_vlan .= "0;";
			}

			$i++;
		}

		$result = $hdl_switche->update_switche_connect();
		echo $result;

	?>
