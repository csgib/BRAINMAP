<?php

echo "<div class='CONTENT_SUB'>";
		require "Class/class_switchs.php";
		require "Class/class_serveurs.php";
		require "Class/class_routeurs.php";
		require "Class/class_baies.php";
		require "Class/class_liens.php";
		require "Class/class_nas.php";
		require "Class/class_cameras.php";
		require "Class/class_antennes.php";
		require "Class/class_transcievers.php";

		$hdl_switche 			= new Switche();
		$hdl_serveur 			= new Serveur();
		$hdl_routeur 			= new Routeur();
		$hdl_baie 			= new Baie();
		$hdl_lien 			= new Lien();
		$hdl_nas 			= new Nas();
		$hdl_camera 			= new Camera();
		$hdl_antenne 			= new Antenne();
		$hdl_transciever		= new Transceiver();

		$hdl_baie->_site 		= $_GET['SITE'];
		$hdl_switche->_site 		= $_GET['SITE'];
		$hdl_lien->_site 		= $_GET['SITE'];
		$hdl_nas->_site 		= $_GET['SITE'];
		$hdl_serveur->_site 		= $_GET['SITE'];
		$hdl_routeur->_site 		= $_GET['SITE'];
		$hdl_camera->_site 		= $_GET['SITE'];
		$hdl_antenne->_site 		= $_GET['SITE'];
		$hdl_transciever->_site		= $_GET['SITE'];

		// *** RECUPERATION DES SWITCH DE LA BAIE ***

		$hdl_switche->_id = $_GET['ID'];
		$result_switch = json_decode($hdl_switche->get_switch_in_baie_from_id());

		$j = 1;
		$table_ligne = "";
		$col = 0;

		$table_vlan = "<option value='' disabled selected>VLAN</option><option value='NOTV'></option>";
		while ( $j < 40 )
		{
			$table_vlan .= "<option value='" . $j . "'>" . $j . "</option>";
			$j++;
		}
		$j = 0;

		if ( count($result_switch) > 0 )
		{
			$table_vlan_value = explode(";",$result_switch[0]->SWITCHS_PORTS_VLAN);

			/* ************************************************* */
			/* *** DIV DE GESTION DES UTILISATIONS DES PORTS *** */
			/* ************************************************* */

			echo "<h3 class='TITLE_BLUE TITLE_BORDER_IT'>&nbsp;&nbsp;Ports Ethernet</h3>";

			echo "<form method='post' action='insert_connect_switch.php' id='FORMULAIRE_CONNECT'>";
			echo "<input name='FRM_SITE' type='hidden' value='" . $_GET['SITE'] . "'>";
			echo "<input id='FRM_SWITCH_ID' name='FRM_SWITCH_ID' type='hidden' value='" . $_GET['ID'] . "'>";
			echo "<input id='FRM_SWITCH_IP' name='FRM_SWITCH_IP' type='hidden' value='" . $_GET['IP'] . "'>";
			echo "<table width='100%' style='border-spacing: 0px 0px;'>";
			$table_connect = explode(";", $result_switch[0]->SWITCHS_PORTS_CONNECT);

			while ( $j < count($table_connect)-1 )
			{
				$hdl_lien->_src_id = $_GET['IP'];
				$hdl_lien->_src_port = ($j+1);
				$hdl_lien->_type = 0;

				$result_table_lien = json_decode($hdl_lien->get_liens_from_object());
				if ( count($result_table_lien) > 0 )
				{
					$result_lien = "1";				
				}
				else
				{
					$result_lien = "0";
				}

				if ( $col < 4 )
				{
					$add_style = "border-right: 1px dotted rgba(40,40,40,0.4);";
				}
				else
				{
					$add_style = "";
				}

				$combo_vlan = "<select class='CL_CHOSEN_F' name='VLA" . $j . "' id='VLA" . $j . "' style='width:60px;' data-placeholder='VLAN'>" . $table_vlan . "</select>";
			
				if ( $table_connect[$j] == "1")
				{
					$table_ligne .= "<td style='font-size: 8px; text-align: right;'>" . ($j+1) . "</td><td><input id='SW" . $j . "' name='SW" . $j . "' type='checkbox' checked class='chk_style'></td><td>" . $combo_vlan . "</td><td style='" . $add_style . "'><img src='Images/link_" . $result_lien . "_defined.png' onclick='javascript:open_edit_link(\"E" . ($j+1) . "\")' style='vertical-align: middle;' id='RLE" . ($j+1) . "'>&nbsp</td>";	
				}
				else
				{
					$table_ligne .= "<td style='font-size: 8px; text-align: right;'>" . ($j+1) . "</td><td><input id='SW" . $j . "' name='SW" . $j . "' type='checkbox' class='chk_style'></td><td>" . $combo_vlan . "</td><td style='" . $add_style . "'><img src='Images/link_" . $result_lien . "_defined.png' onclick='javascript:open_edit_link(\"E" . ($j+1) . "\")' style='vertical-align: middle;' id='RLE" . ($j+1) . "'>&nbsp</td>";	
				}

				$col++;
				if ( $col == 5 )
				{
					echo "<tr>" . $table_ligne . "</tr>";
					$table_ligne = "";					
					$col = 0;
				}

				$j++;
			}
			if ( $col > 0 )
			{
				echo "<tr>" . $table_ligne . "</tr>";
				$table_ligne = "";					
				$col = 0;
			}

			echo "</table>";

			echo "<input id='FRM_SWITCH_NB_ETH_PORT' name='FRM_SWITCH_NB_ETH_PORT' type='hidden' value='" . (count($table_connect)-1) . "'>";

			/* *** AFFICHAGE S'ILS EXISTENT DES PORTS FIBRES *** */

			if ( $result_switch[0]->SWITCHS_FIBER_PORTS > 0 )
			{
				$table_connect = explode(";", $result_switch[0]->SWITCHS_FIBER_CONNECT);
				echo "<h3 class='TITLE_BLUE TITLE_BORDER_IT'>&nbsp;&nbsp;Ports Fibres</h3>";

				$k = 0;
				echo "<table width='100%'>";

				while ( $k < $result_switch[0]->SWITCHS_FIBER_PORTS )
				{
					$hdl_lien->_src_id = $_GET['IP'];
					$hdl_lien->_src_port = ($k+1);
					$hdl_lien->_type = 1;
					$result_lien = json_decode($hdl_lien->get_is_lien());

					$combo_vlan = "<select class='CL_CHOSEN_F' name='VLAF" . $k . "' id='VLAF" . $k . "' style='width:60px;' data-placeholder='VLAN'>" . $table_vlan . "</select>";

					if ( $table_connect[$k] == "1")
					{
						$table_ligne .= "<td style='font-size: 8px; text-align: right;'>" . ($k+1) . "</td><td><input id='FB" . $k . "' name='FB" . $k . "' type='checkbox' checked class='chk_style'></td><td>" . $combo_vlan . "</td><td style='border-right: 1px dotted rgba(40,40,40,0.4);'><img src='Images/link_" . $result_lien . "_defined.png' onclick='javascript:open_edit_link(\"F" . ($k+1) . "\")' id='RLF" . ($k+1) . "' style='vertical-align: middle;'></td>";	
					}
					else
					{
						$table_ligne .= "<td style='font-size: 8px; text-align: right;'>" . ($k+1) . "</td><td><input id='FB" . $k . "' name='FB" . $k . "' type='checkbox' class='chk_style'></td><td>" . $combo_vlan . "</td><td style='border-right: 1px dotted rgba(40,40,40,0.4);'><img src='Images/link_" . $result_lien . "_defined.png' onclick='javascript:open_edit_link(\"F" . ($k+1) . "\")' id='RLF" . ($k+1) . "' style='vertical-align: middle;'></td>";	
					}	

					$k++;
				}

				while ( $k < 5 )
				{ 
					$table_ligne .= "<td width=20%></td>";
					$k++;
				}

				echo "<tr>" . $table_ligne . "</tr>";
				echo "</table>";
			}
			echo "<input id='FRM_SWITCH_NB_FIB_PORT' name='FRM_SWITCH_NB_FIB_PORT' type='hidden' value='" . $result_switch[0]->SWITCHS_FIBER_PORTS . "'>";
			echo "</form>";

			// *** CHARGEMENT DES VLANS ***
			$j = 0;

			echo "<script language='text/javascript'>";

			$table_connect = explode(";", $result_switch[0]->SWITCHS_PORTS_CONNECT);
			while ( $j < count($table_connect)-1 )
			{

				if ( $table_vlan_value[$j] != "0" )
				{
					echo "$('#VLA" . $j . "').val(" . $table_vlan_value[$j] . ");";
					echo "$('#VLA" . $j . "').trigger('change');";
				}
				$j++;
			}

			$k = 0;
			while ( $k < $result_switch[0]->SWITCHS_FIBER_PORTS )
			{
				if ( $table_vlan_value[($j+$k)] != "0" )
				{
					echo "$('#VLAF" . $k . "').val(" . $table_vlan_value[($j+$k)] . ");";
					echo "$('#VLAF" . $k . "').trigger('change');";
				}
				$k++;
			}

			echo "</script>";

			/* ********************************************************* */
			/* *** DIV DE GESTION / CREATION DES LINKS ENTRE SWITCHS *** */
			/* ********************************************************* */

			echo "<div class='CLASS_LINK_EDIT' id='LINK_EDIT'>";

			//echo "<br><table><tr><td><img src='Images/link_1_defined.png'></td><td>Gérer les liens entre éléments de votre réseau.</td></tr></table>";
			echo "<input id='WA_EDIT' type='hidden' value=''>";
			$result_baie = json_decode($hdl_baie->get_all_baies());

			echo "<form method='post' action='insert_link_switch.php' id='FORMULAIRE_LINK'>";
			echo "<br><input type='hidden' name='FRM_TYPE_PORT' id='FRM_TYPE_PORT' style='border: 0px; box-shadow: 0 0 0px rgba(0,0,0,0.0); background-color: transparent; font-family: Droid; font-size:	14px; font-weight: bold;' disabled><input type='hidden' name='FRM_SRC_PORT' id='FRM_SRC_PORT'><input type='hidden' name='FRM_TP_PORT' id='FRM_TP_PORT'><br><br>";
			echo "<input id='FRM_SRC_IP' name='FRM_SRC_IP' type='hidden' value='" . $_GET['IP'] . "'>";
			echo "<input name='FRM_SITE' type='hidden' value='" . $_GET['SITE'] . "'>";
			echo "<input name='FRM_BAIE' type='hidden' value='" . $result_switch[0]->SWITCHS_BAIE_ID . "'>";

			echo "<br><b>DESTINATION</b>";
			echo "<br><select id='FRM_LINK_OBJECT' name='FRM_LINK_OBJECT' class='CL_CHOSEN' style='width:450px;' data-placeholder='Liaison...'>";
			echo "<option value=''></option>";

			$j = 0;
			while ( $j < count($result_baie) )
			{
				echo "<optgroup label='" . str_replace( "'", " ",$result_baie[$j]->BAIES_COMMENTAIRES ) . "'>";

				$hdl_switche->_baie_id = $result_baie[$j]->BAIES_ID;
				
				$result_switch_baie = json_decode($hdl_switche->get_all_switches_in_baie());
				$k = 0;
				while ( $k < count($result_switch_baie) )
				{
					if ( $result_switch_baie[$k]->SWITCHS_ID != $_GET['ID'] )
					{
						if ( substr($result_switch_baie[$k]->SWITCHS_IP,0,5) != "NOIP_" )
						{
							echo "<option value='" . $result_switch_baie[$k]->SWITCHS_ID . ";" . $result_switch_baie[$k]->SWITCHS_IP . "'>" . $result_switch_baie[$k]->SWITCHS_MARQUE . " " . $result_switch_baie[$k]->SWITCHS_DESCRIPTION . " - " . $result_switch_baie[$k]->SWITCHS_IP . "</option>";
						}
						else 
						{
							echo "<option value='" . $result_switch_baie[$k]->SWITCHS_ID . ";" . $result_switch_baie[$k]->SWITCHS_IP . "'>" . $result_switch_baie[$k]->SWITCHS_MARQUE . " " . $result_switch_baie[$k]->SWITCHS_DESCRIPTION . "</option>";
						}
						
					}
					$k++;
				}

				echo "</optgroup>";
				$j++;
			}
			
			echo "<optgroup label='MINIS SWITCHS'>";
			$result_minis_switchs = json_decode($hdl_switche->get_all_mini_switches());
			$k = 0;
			while ( $k < count($result_minis_switchs) )
			{
				if ( $result_minis_switchs[$k]->SWITCHS_ID != $_GET['ID'] )
				{
					echo "<option class='OPTMSWITCH' ' value='M" . $result_minis_switchs[$k]->SWITCHS_ID . "'>" . $result_minis_switchs[$k]->SWITCHS_MARQUE . " " . $result_minis_switchs[$k]->SWITCHS_DESCRIPTION . "</option>";
				}
				$k++;
			}

			echo "</optgroup>";
			
			
			echo "<optgroup label='SERVEURS'>";
			$result_serveur = json_decode($hdl_serveur->get_all_serveurs());
			$j = 0;
			while ( $j < count($result_serveur) )
			{
				$boucle_lan = 1;
				while ( $boucle_lan < 7 )
				{
					$n_ip = "SERVEURS_LAN_" . ($boucle_lan) . "_IP";
					if ( $result_serveur[$j]->$n_ip != "" )
					{
						$boucle_lan = 999;
					}
					else
					{
						$boucle_lan++;
					}
				}
				if ( $boucle_lan == 999 )
				{
					echo "<option value='S" . $result_serveur[$j]->SERVEURS_ID . "'>" . $result_serveur[$j]->SERVEURS_NAME . "</option>";
				}
				$j++;
			}
			echo "</optgroup>";

			echo "<optgroup label='ROUTEURS'>";
			$result_routeur = json_decode($hdl_routeur->get_all_routeurs());
			$j = 0;
			while ( $j < count($result_routeur) )
			{
				echo "<option value='R" . $result_routeur[$j]->ROUTEURS_ID . "'>" . $result_routeur[$j]->ROUTEURS_NAME . "</option>";
				$j++;
			}
			echo "</optgroup>";

			echo "<optgroup label='NAS'>";
			$result_nas = json_decode($hdl_nas->get_all_nas());
			$j = 0;
			while ( $j < count($result_nas) )
			{
				echo "<option value='N" . $result_nas[$j]->NAS_ID . "'>" . $result_nas[$j]->NAS_NAME . "</option>";
				$j++;
			}
			echo "</optgroup>";
			
			echo "<optgroup label='TRANSCIEVERS'>";
			$result_transcievers = json_decode( $hdl_transciever->get_all_transceivers() );
			$j = 0;
			while ( $j < count($result_transcievers) )
			{
				echo "<option value='T" . $result_transcievers[$j]->TRANSCEIVERS_ID . "'>" . $result_transcievers[$j]->TRANSCEIVERS_LIBELLE . "</option>";
				$j++;
			}
			echo "</optgroup>";			
			
			echo "<optgroup label='CAMERAS IP'>";
			$result_cameras = json_decode($hdl_camera->get_all_cameras());
			$j = 0;
			while ( $j < count($result_cameras ) )
			{
				echo "<option value='K" . $result_cameras[$j]->CAMERAS_ID . "'>" . $result_cameras[$j]->CAMERAS_NOM . "</option>";
				$j++;
			}
			echo "</optgroup>";			

			echo "<optgroup label='ANTENNES WIFI'>";
			$result_antennes = json_decode($hdl_antenne->get_all_antennes());
			$j = 0;
			while ( $j < count($result_antennes ) )
			{
				echo "<option value='A" . $result_antennes[$j]->ANTENNES_ID . "'>" . $result_antennes[$j]->ANTENNES_NOM . "</option>";
				$j++;
			}
			echo "</optgroup>";		
			
			echo "</select>";

			echo "<br><br>Port <select id='FRM_LINK_PORT' name='FRM_LINK_PORT' class='CL_CHOSEN' style='width:150px;' data-placeholder='Port...'></select>";

			echo "<input type='hidden' id='FRM_SAV_IP' name='FRM_SAV_IP'>";

			echo "</form>";

			echo"<div class='BOTTOM_BUTTONS'><button class='main_bt' type='button' onClick='javascript:valide_formulaire_link()'>Valider</button><button class='main_bt_inv' onClick='javascript:close_edit_link()'>Retour</button></div>";

			echo "</div>";
		}
		
echo "</div>";
?>

<div class="BOTTOM_BUTTONS">
	<button class="main_bt" type='button' onClick='javascript:valide_formulaire_connect()'>Valider</button>
	<button class="main_bt_inv" onClick='javascript:close_edit_switch_link_window()'>Retour</button>
</div>

<script type="text/javascript">

$('.chk_style').checkbox();


//$("#CLASS_LINK_EDIT").css("height", $("#MODAL_ADD").height() + "px");


$("#FRM_LINK_OBJECT").change(function(){

	if ($("#FRM_LINK_OBJECT").val().substring(0,1) == "S" )
	{
		f_load_serveur_port($("#FRM_LINK_OBJECT").val().substring(1), $("#FRM_TP_PORT").val());
	}
	else
	{
		if ($("#FRM_LINK_OBJECT").val().substring(0,1) == "R" || $("#FRM_LINK_OBJECT").val().substring(0,1) == "T" || $("#FRM_LINK_OBJECT").val().substring(0,1) == "N" || $("#FRM_LINK_OBJECT").val().substring(0,1) == "K" || $("#FRM_LINK_OBJECT").val().substring(0,1) == "A" )
		{
			$("#FRM_LINK_PORT").html("<option></option>");
			//$("#FRM_LINK_PORT").val('').trigger("liszt:updated");
		}
		else
		{
			if ($("#FRM_LINK_OBJECT").val().substring(0,1) == "M" )
			{
				f_load_mini_switch_port($("#FRM_LINK_OBJECT").val().substring(1), $("#FRM_TP_PORT").val());
			}
			else
			{
				if ( $("#FRM_LINK_OBJECT").val().length > 0 )
				{
					f_load_switch_port($("#FRM_LINK_OBJECT").val(), $("#FRM_TP_PORT").val());
				}
				else
				{
					$("#FRM_LINK_PORT").html("<option></option>");
					//$("#FRM_LINK_PORT").val('').trigger("liszt:updated");
				}
			}
		}
	}
});

// *** VALIDATION FORMULAIRE DES CONNECTIONS ***

function valide_formulaire_connect()
{
	// *** AJOUT / MODIFICATION DANS LA BASE DE DONNEES ***

	$.ajax({
		data: $("#FORMULAIRE_CONNECT").serialize(),
		type: $("#FORMULAIRE_CONNECT").attr("method"),
		url: $("#FORMULAIRE_CONNECT").attr("action"),
		success: function(response) {
			var i = 0;
			var wl_id = "";

			while ( i <= $('#FRM_SWITCH_NB_ETH_PORT').val()-1 )
			{
				wl_id = $('#FRM_SWITCH_IP').val() + ":" + (i+1);;
				wl_id = wl_id.replace(/(:|\.)/g,'\\$1');

				$("#" + wl_id).removeClass('PORT_ON');
				$("#" + wl_id).removeClass('PORT_OFF');
				
				if ( $('#SW' + i).prop('checked') == true )
				{
				        $("#" + wl_id).addClass("PORT_ON");
				}
				else
				{
				        $("#" + wl_id).addClass("PORT_OFF");
				}

				i++;
			}

			i = 0;

			while ( i <= $('#FRM_SWITCH_NB_FIB_PORT').val()-1 )
			{
				wl_id = $('#FRM_SWITCH_IP').val() + ":F" + (i+1);;
				wl_id = wl_id.replace(/(:|\.)/g,'\\$1');

				$("#" + wl_id).removeClass('PORT_ON');
				$("#" + wl_id).removeClass('PORT_OFF');				
				
				if ( $('#FB' + i).prop('checked') == true )
				{
				        $("#" + wl_id).addClass("PORT_ON");
				}
				else
				{
				        $("#" + wl_id).addClass("PORT_OFF");
				}

				i++;
			}
			
			$('#CONTENT_SUB_BAIE').animate({
				scrollTop: 0
				}, 200, function(){
					$("#SUB_WINDOW").fadeOut(400);
					join_inner();
				        return false;
		        });	

			
		},
		error: function(){
			$.gritter.add({
				title: 'Création liens',
				text: 'Erreur lors de la création du lien dans la base de données.',
				time: 1500
			});
    		}
	});
}

// *** VALIDATION FORMULAIRE DES LIAISONS ***

function valide_formulaire_link()
{
	// *** ON ECRASE LE LIEN ACTUEL ***
	//if ( $("#FRM_SAV_IP").val().length > 0 )
	//{
		$.ajax({
			type: 'GET',
			url: "delete_lien.php?SITE=" + sessionStorage.getItem("SITKEY") + "&SRCI=" + $("#FRM_SRC_IP").val() + "&SRCP=" + $("#FRM_SRC_PORT").val() + "&SRCO=" + $("#FRM_SAV_IP").val() + "&TPPORT=" + $("#FRM_TP_PORT").val(),
			success: function(){
				// *** ON NE RECREE PAS DE LIEN DONC ONT SORT ***

				if ( $("#FRM_LINK_OBJECT").val().length == 0 )
				{
					if ( $("#FRM_TP_PORT").val() == "F" )
					{
						$("#RLF" + $("#FRM_SRC_PORT").val()).attr("src", "Images/link_0_defined.png");
						$("#RLF" + $("#FRM_SRC_PORT").val()).attr("title" ,"Aucun lien définis");
					}
					else
					{
						$("#RLE" + $("#FRM_SRC_PORT").val()).attr("src", "Images/link_0_defined.png");
						$("#RLE" + $("#FRM_SRC_PORT").val()).attr("title" ,"Aucun lien définis");
					}

					$("#LINK_EDIT").animate({
						top: '-=100%',		
					},400);

					$.ajax({
						type: 'GET',
						url: "reload_links.php?SITE=" + sessionStorage.getItem("SITKEY"),
						success: function(response) {
							eval(response);
							join();

							$("#SCROLLER_EDIT_BAIE").css("top", "10px");
							$("#SCROLLER_V_EDITOR").css("top", "0px");

							join_inner();
						}
					});

					return false;
				}
	
				// *** AJOUT / MODIFICATION DANS LA BASE DE DONNEES ***

				$.ajax({
					data: $("#FORMULAIRE_LINK").serialize(),
					type: $("#FORMULAIRE_LINK").attr("method"),
					url: $("#FORMULAIRE_LINK").attr("action"),
					success: function(response) {
						if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 )
						{
								if ( $("#FRM_TP_PORT").val() == "F" )
								{
									$("#RLF" + $("#FRM_SRC_PORT").val()).attr("src", "Images/link_1_defined.png");
								}
								else
								{
									$("#RLE" + $("#FRM_SRC_PORT").val()).attr("src", "Images/link_1_defined.png");
								}
									$("#LINK_EDIT").animate({
										top: '-=100%',		
									},400, function(){
										$.ajax({
										type: 'GET',
										url: "reload_links.php?SITE=" + sessionStorage.getItem("SITKEY"),
										success: function(response) {
											eval(response);
											join();

											$("#SCROLLER_EDIT_BAIE").css("top", "10px");
											$("#SCROLLER_V_EDITOR").css("top", "0px");

											join_inner();
										}
									});
								});
						}
						else
						{
							$.gritter.add({
								title: 'Création liens',
								text: 'Erreur lors de la création du lien dans la base de données.',
								time: 1500
							});
						}
					},
					error: function(){
						$.gritter.add({
							title: 'Création liens',
							text: 'Erreur lors de la création du lien dans la base de données.',
							time: 1500
						});
			    		}
				});
			},
			error: function(){
				$.gritter.add({
					title: 'Création liens',
					text: 'Erreur lors de la création du lien dans la base de données.',
					time: 1500
				});
				return false;
	    		}
		});
	//}
}

</script>
