<?php

echo "<div class='CONTENT_SUB' id='CONTENT_SUB_BAIE'>";

	echo "<div id='SCROLLER_EDIT_BAIE'>";
	
		$var_right_menu = "";

		/* 	
			LIGNE 1 -> TITRE
			LIGNE 2 -> LIGNE 1 DES PRISES ETHERNET + FO
			LIGNE 3 -> LIGNE NUMERO PRISES
			LIGNE 4 -> LIGNE 2 DES PRISES ETHERNET + FO
			LIGNE 5 -> LIGNE NUMERO PRISES
		*/
		require "Class/class_switchs.php";

		$hdl_switche = new Switche();

		// *** RECUPERATION DES SWITCH DE LA BAIE ***

		$hdl_switche->_baie_id = $_GET['ID'];
		$hdl_switche->_site = $_GET['SITE'];
		$result_switch = json_decode($hdl_switche->get_all_switches_in_baie());

		$j = 0;
		$fiber_display = 0;

		while ( $j < count($result_switch) )
		{
			$fiber_display = 0;
			$table_connect = explode(";", $result_switch[$j]->SWITCHS_PORTS_CONNECT);
			$table_fconnect = explode(";", $result_switch[$j]->SWITCHS_FIBER_CONNECT);

			echo "<table class='DISPLAY_SWITCH' id='SW_" . $result_switch[$j]->SWITCHS_ID . "'>";
			$k = 0;
			$true_port = 0;

			while ( $k < 5 ) // *** IL FAUT 5 LIGNES POUR FAIRE UN SWITCH ***
			{
				echo "<tr>";

				if ( $k == 0 ) // *** LIGNE DES TITRES ***
				{
					if ( substr($result_switch[$j]->SWITCHS_IP , 0 ,5) != "NOIP_" )
					{
						echo "<th COLSPAN=27>" . $result_switch[$j]->SWITCHS_MARQUE . " " . $result_switch[$j]->SWITCHS_DESCRIPTION . " " . $result_switch[$j]->SWITCHS_IP . "</th>";
					}
					else 
					{
						echo "<th COLSPAN=27>" . $result_switch[$j]->SWITCHS_MARQUE . " " . $result_switch[$j]->SWITCHS_DESCRIPTION . "</th>";
					}
					
				}
				else
				{
					if ( $k%2 == 0 ) // *** LIGNE VIDE ENTRE LIGNE DE PRISES (AFFICHE NUMERO DE PRISE) ***
					{
						$i = 0;
						$eth_port = 0;	

						if ( $k == 2 ) // *** WORKAROUND POUR ALIGNEMENT PRISES 1 EN HAUT 2 EN BAS ... ***
						{
							$true_port = 1;
						}
						else
						{
							if ( $k == 4 )
							{
								$true_port = 2;
							}
						}

						while( $i < 48 ) // *** BOUCLE PRISES ETHERNET + FO ***
						{
							if ( $i != 0 && $eth_port < (count($table_connect)-1)/2 )
							{
								echo "<td style='text-align: center;'>" . $true_port . "</td>";
								$true_port = $true_port + 2;
								$eth_port++;
							}
							$i++;
						}
					}
					else
					{
						$i = 0;
						$eth_port = 0;

						if ( $k == 1 ) // *** WORKAROUND POUR ALIGNEMENT PRISES 1 EN HAUT 2 EN BAS ... ***
						{
							$true_port = 1;
						}
						else
						{
							if ( $k == 3 )
							{
								$true_port = 2;
							}
						}

						while( $i < 27 ) // *** BOUCLE PRISES ETHERNET + FO ***
						{
							if ($i != 0 )
							{
								if ( $eth_port < (count($table_connect)-1)/2 )
								{
									if ( $table_connect[$true_port-1] == "1" )
									{
										echo "<td class='PORT_ON' att_npo='" . $eth_port . "' id='" . $result_switch[$j]->SWITCHS_IP . ":" . $true_port . "'>&nbsp</td>";
									}
									else
									{
										echo "<td class='PORT_OFF' att_npo='" . $eth_port . "' id='" . $result_switch[$j]->SWITCHS_IP . ":" . $true_port . "'>&nbsp</td>";
									}
									$true_port = $true_port + 2;
									$eth_port++;
								}
								else
								{
									// *** PORTS FIBRE *** 
									if ( $i > 24 && $result_switch[$j]->SWITCHS_FIBER_PORTS > 0 )
									{
										if ( $fiber_display < $result_switch[$j]->SWITCHS_FIBER_PORTS )
										{
											if ( $table_fconnect[$fiber_display] == "1" )
											{
												echo "<td class='PORT_ON' id='" . $result_switch[$j]->SWITCHS_IP . ":F" . ($fiber_display+1) . "'>&nbsp</td>";
											}
											else
											{
												echo "<td class='PORT_OFF' id='" . $result_switch[$j]->SWITCHS_IP . ":F" . ($fiber_display+1) . "'>&nbsp</td>";
											}
											$fiber_display++;
										}
										else
										{
											echo "<td style='border: 0px;'>&nbsp</td>";
										}
									}
									else
									{
										echo "<td style='border: 0px;'>&nbsp</td>";
									}
								}
							}

							$i++;
						}
					}
				}
				echo "</tr>";
				$k++;
			}

			echo "</table>";
			
			$var_right_menu .= "<div class='editor_menu' id='ME_" . $result_switch[$j]->SWITCHS_ID . "' style='top: " . (($j*112)+(10*($j+2))) . "px'>";
			$var_right_menu .= "<button class='small_bt' onclick='javascript:edit_link_switch(" . $result_switch[$j]->SWITCHS_ID . ",\"" . $hdl_switche->_site . "\",\"" . $result_switch[$j]->SWITCHS_IP . "\")'><img src='Images/small_edit.png'></button>";
			$var_right_menu .= "<button class='small_bt_inv' onclick='javascript:delete_switch(" . $result_switch[$j]->SWITCHS_ID . ",\"" . $result_switch[$j]->SWITCHS_IP . "\"," . $result_switch[$j]->SWITCHS_POS_Y . "," . $result_switch[$j]->SWITCHS_BAIE_ID . ")'><img src='Images/small_delete.png'></button>";
			$var_right_menu .= "<button class='small_bt' onclick='javascript:move_switch_up(\"SW_" . $result_switch[$j]->SWITCHS_ID . "\")'><img src='Images/small_up.png'></button>";
			$var_right_menu .= "<button class='small_bt' onclick='javascript:move_switch_bottom(\"SW_" . $result_switch[$j]->SWITCHS_ID . "\")'><img src='Images/small_down.png'></button>";			
			$var_right_menu .= "</div>";

			$var_right_menu .= "<script language='text/javascript'>";
			$var_right_menu .= "table_edit_switch[" . $j . "] = \"SW_" . $result_switch[$j]->SWITCHS_ID . "\";";
			$var_right_menu .= "table_edit_max_switch++;";
			$var_right_menu .= "</script>";

			$j++;
		}

	echo "<canvas id='CANVAS_LINK_INNER'></canvas>";

	echo "</div>";

	echo $var_right_menu;
	
echo "</div>";

?>

<div id="SUB_WINDOW"></div>

<div class="BOTTOM_BUTTONS">
	<button class="main_bt_inv" onClick='javascript:close_sub_window()'>Retour</button>
</div>

<script type="text/javascript">

var canvas2=document.getElementById('CANVAS_LINK_INNER');

$(".DISPLAY_SWITCH").bind("contextmenu",function(e){
	return false;
});

</script>



