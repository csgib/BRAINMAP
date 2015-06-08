<div class='CONTENT_SUB'>
	
<h2 class="TITLE_N0 TITLE_BLUE TITLE_CENTER_IT TITLE_BORDER_IT">MINIS-SWITCHS</h2>

<script type="text/javascript">
	
function load_ports(id, ports)
{
	var var_obj = $("#" + id).val().substring(0,1);
	var var_id = parseInt($("#" + id).attr("id").substring(16));
	
	if (var_obj == "S" )
	{
		$.ajax({
			url: "load_server_port.php?SITE=" + sessionStorage.getItem("SITKEY") + "&ID=" + $("#" + id).val().substring(1) + "&TP=E",
			success: function(response) {
				$("#FRM_LINK_PORT_" + var_id).html(response);
				if ( typeof ports != 'undefined' )
				{
					$("#FRM_LINK_PORT_" + var_id + " option[value='E" + ports + "']").attr('selected', 'selected');
				}				
			}
		});
	}
	else
	{
		if ( (var_obj == "R" || var_obj == "N" || var_obj == "K" || var_obj == "A" || var_obj == "T") && $("#" + id).val().substring(0,5) != "NOIP_" )
		{
			$("#FRM_LINK_PORT").html("<option></option>");
		}
		else
		{
			if (var_obj == "M" )
			{
				$.ajax({
					url: "load_mini_switch_port.php?SITE=" + sessionStorage.getItem("SITKEY") + "&ID=" + $("#" + id).val().substring(1) + "&TP=E",
					success: function(response) {
						$("#FRM_LINK_PORT_" + var_id).html(response);
						if ( typeof ports != 'undefined' )
						{
							$("#FRM_LINK_PORT_" + var_id + " option[value='E" + ports + "']").attr('selected', 'selected');
						}						
					}
				});
			}
			else
			{
				if ( var_obj.length > 0 )
				{
					$.ajax({
						url: "load_switch_port.php?SITE=" + sessionStorage.getItem("SITKEY") + "&ID=" + $("#" + id + " option:selected").attr("attrid") + ";" + $("#" + id).val() + "&TYPE=E",
						success: function(response) {
							$("#FRM_LINK_PORT_" + var_id).html(response);
							
							if ( typeof ports != 'undefined' )
							{
								$("#FRM_LINK_PORT_" + var_id + " option[value='E" + ports + "']").attr('selected', 'selected');
							}
							
						}
					});
				}
				else
				{
					$("#FRM_LINK_PORT").html("<option></option>");
				}
			}
		}
	}
}	
	
</script>

<form method="post" action="insert_mini_switch.php" id="FORMULAIRE">
	<table>
		<tr><td class="rubrique">Nom du constructeur</td><td class="fields"><select name='FRM_SWITCH_MARQUE' id='FRM_SWITCH_MARQUE' class="requis" style="width:250px;">";
			<option value='APC'>APC</option>			
			<option value='CISCO'>CISCO</option>
			<option value='DELL'>DELL</option>
			<option value='DLINK'>DLINK</option>
			<option value='EXTREME'>EXTREME</option>
			<option value='GEUTEBRUCK'>GEUTEBRUCK</option>
			<option value='HP'>HP</option>
			<option value='IBM'>IBM</option>
			<option value='JUNIPER'>JUNIPER</option>
			<option value='LANTRONIX'>LANTRONIX</option>
			<option value='NETGEAR'>NETGEAR</option>
			<option value='NORTEL'>NORTEL</option>
			<option value='ORACLE'>ORACLE</option>
			<option value='SIEMENS'>SIEMENS</option>
			<option value='TRENDNET'>TRENDNET</option>
			<option value='TPLINK'>TPLINK</option>
			<option value='WLINX'>WLINX</option>
		</select></td></tr>
		<tr><td class="rubrique">Commentaires</td><td class="fields"><input type="text" id="FRM_SWITCH_COMMENTAIRES" name="FRM_SWITCH_COMMENTAIRES" placeholder="Modèle du switch" maxlength="65" size="40" class="requis"></td></tr>
		<tr><td class="rubrique">Ports ethernet</td><td class="fields"><select name='FRM_SWITCH_NOMBRE_PORTS' id="FRM_SWITCH_NOMBRE_PORTS" class="CL_CHOSEN" style="width:50px;">
				<option value='8'>8</option>
				<option value='12'>12</option>
				<option value='16'>16</option>
				<option value='24'>24</option>
			</select></td></tr>
	</table>
	
	<div id="PORTS_DEFINE_MINI_SWITCHS">
		<div id="PORTS_DEFINE_MINI_SWITCHS_LISTE"></div>
	</div>

	<input type='hidden' name='SITE' id='SITE'>

	<?php
	
	
		echo "<input type='hidden' name='ISNEW' id='ISNEW' value='1'>";
		echo "<input type='hidden' name='FRM_SWITCH_ID' id='FRM_SWITCH_ID'>";

		if ( isset($_GET['IDS']) )
		{
			require "Class/class_switchs.php";
			require "Class/class_routeurs.php";
			require "Class/class_nas.php";
			require "Class/class_baies.php";
			require "Class/class_serveurs.php";
			require "Class/class_liens.php";
			require "Class/class_cameras.php";
			require "Class/class_antennes.php";
			require "Class/class_transcievers.php";
	
			$hdl_serveur 			= new Serveur();
			$hdl_lien 			= new Lien();			
			$hdl_switche 			= new Switche();
			$hdl_routeur 			= new Routeur();
			$hdl_baie 			= new Baie();
			$hdl_nas 			= new Nas();
			$hdl_camera 			= new Camera();
			$hdl_antenne 			= new Antenne();
			$hdl_transciever		= new Transceiver();
	
			$hdl_baie->_site 		= $_GET['SITE'];
			$hdl_switche->_site 		= $_GET['SITE'];
			$hdl_switche->_id 		= substr($_GET['IDS'],1);
			$hdl_lien->_site 		= $_GET['SITE'];
			$hdl_nas->_site 		= $_GET['SITE'];
			$hdl_serveur->_site 		= $_GET['SITE'];
			$hdl_routeur->_site 		= $_GET['SITE'];			
			$hdl_camera->_site 		= $_GET['SITE'];
			$hdl_antenne->_site 		= $_GET['SITE'];
			$hdl_transciever->_site		= $_GET['SITE'];
			
			$result = json_decode($hdl_switche->get_mini_switch_from_id());

			if ( count($result) > 0 )
			{
				echo "<script type='text/javascript'>
					$('#FRM_SWITCH_ID').val('" . $result[0]->SWITCHS_ID . "');
					$('#FRM_SWITCH_MARQUE').val('" . addslashes($result[0]->SWITCHS_MARQUE) . "');
					$('#FRM_SWITCH_COMMENTAIRES').val('" . addslashes($result[0]->SWITCHS_DESCRIPTION) . "');
					
					$('#FRM_SWITCH_NOMBRE_PORTS').val('" . (count(explode(";",$result[0]->SWITCHS_PORTS_CONNECT))-1) . "');
					$('#ISNEW').val('0');";
					
				if ( count(explode(";",$result[0]->SWITCHS_PORTS_CONNECT))-1 > 0 )
				{
					echo "$('#FRM_SWITCH_NOMBRE_PORTS').attr('disabled', 'disabled');";
				}
				echo "</script>";
			}
			
			$var_co_obj = "<option value=''></option>";
			$result_baie = json_decode($hdl_baie->get_all_baies());
	
			$j = 0;
			while ( $j < count($result_baie) )
			{
				$var_co_obj .=  "<optgroup label=" . $result_baie[$j]->BAIES_COMMENTAIRES . ">";
	
				$hdl_switche->_baie_id = $result_baie[$j]->BAIES_ID;
			
				$result_switch_baie = json_decode($hdl_switche->get_all_switches_in_baie());
				$k = 0;
				while ( $k < count($result_switch_baie) )
				{				
					if ( $result_switch_baie[$k]->SWITCHS_ID != substr($_GET['IDS'],1) )
					{
						if ( substr($result_switch_baie[$k]->SWITCHS_IP,0, 5) != "NOIP_" )
						{
							$var_co_obj .=  "<option attrid='" . $result_switch_baie[$k]->SWITCHS_ID . "' value='" . $result_switch_baie[$k]->SWITCHS_IP . "'>" . $result_switch_baie[$k]->SWITCHS_MARQUE . " " . $result_switch_baie[$k]->SWITCHS_DESCRIPTION . " - " . $result_switch_baie[$k]->SWITCHS_IP . "</option>";
						}
						else 
						{
							$var_co_obj .=  "<option attrid='" . $result_switch_baie[$k]->SWITCHS_ID . "' value='" . $result_switch_baie[$k]->SWITCHS_IP . "'>" . $result_switch_baie[$k]->SWITCHS_MARQUE . " " . $result_switch_baie[$k]->SWITCHS_DESCRIPTION . "</option>";
						}			
					}
					$k++;
				}
	
				$var_co_obj .=  "</optgroup>";
				$j++;
			}
			
			$var_co_obj .=  "<optgroup label='MINIS SWITCHS'>";
			$result_minis_switchs = json_decode($hdl_switche->get_all_mini_switches());
			$k = 0;
			while ( $k < count($result_minis_switchs) )
			{
				if ( $result_minis_switchs[$k]->SWITCHS_ID != substr($_GET['IDS'],1) )
				{
					$var_co_obj .=  "<option class='OPTMSWITCH' ' value='M" . $result_minis_switchs[$k]->SWITCHS_ID . "'>" . $result_minis_switchs[$k]->SWITCHS_MARQUE . " " . $result_minis_switchs[$k]->SWITCHS_DESCRIPTION . "</option>";
				}
				$k++;
			}
	
			$var_co_obj .= "</optgroup>";
			
			$var_co_obj .=  "<optgroup label='SERVEURS'>";
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
					$var_co_obj .=  "<option value='S" . $result_serveur[$j]->SERVEURS_ID . "'>" . $result_serveur[$j]->SERVEURS_NAME . "</option>";
				}
				$j++;
			}
			$var_co_obj .=  "</optgroup>";
	
			$var_co_obj .=  "<optgroup label='ROUTEURS'>";
			$result_routeur = json_decode($hdl_routeur->get_all_routeurs());
			$j = 0;
			while ( $j < count($result_routeur) )
			{
				$var_co_obj .=  "<option value='R" . $result_routeur[$j]->ROUTEURS_ID . "'>" . $result_routeur[$j]->ROUTEURS_NAME . "</option>";
				$j++;
			}
			$var_co_obj .=  "</optgroup>";
	
			$var_co_obj .=  "<optgroup label='NAS'>";
			$result_nas = json_decode($hdl_nas->get_all_nas());
			$j = 0;
			while ( $j < count($result_nas) )
			{
				$var_co_obj .=  "<option value='N" . $result_nas[$j]->NAS_ID . "'>" . $result_nas[$j]->NAS_NAME . "</option>";
				$j++;
			}
			$var_co_obj .=  "</optgroup>";
			
			$var_co_obj .= "<optgroup label='TRANSCIEVERS'>";
			$result_transcievers = json_decode( $hdl_transciever->get_all_transceivers() );
			$j = 0;
			while ( $j < count($result_transcievers) )
			{
				$var_co_obj .= "<option value='T" . $result_transcievers[$j]->TRANSCEIVERS_ID . "'>" . $result_transcievers[$j]->TRANSCEIVERS_LIBELLE . "</option>";
				$j++;
			}
			$var_co_obj .= "</optgroup>";			
			
			$var_co_obj .=  "<optgroup label='CAMERAS IP'>";
			$result_cameras = json_decode($hdl_camera->get_all_cameras());
			$j = 0;
			while ( $j < count($result_cameras ) )
			{
				$var_co_obj .=  "<option value='K" . $result_cameras[$j]->CAMERAS_ID . "'>" . $result_cameras[$j]->CAMERAS_NOM . "</option>";
				$j++;
			}
			$var_co_obj .=  "</optgroup>";
			
			$var_co_obj .=  "<optgroup label='ANTENNES WIFI'>";
			$result_antennes = json_decode($hdl_antenne->get_all_antennes());
			$j = 0;
			while ( $j < count($result_antennes ) )
			{
				$var_co_obj .=  "<option value='A" . $result_antennes[$j]->ANTENNES_ID . "'>" . $result_antennes[$j]->ANTENNES_NOM . "</option>";
				$j++;
			}
			$var_co_obj .=  "</optgroup>";			
			
			$var_connect = "<table>";
			$var_script = "";
			
			$wl_i = 0;
			
			while ( $wl_i < (count(explode(";",$result[0]->SWITCHS_PORTS_CONNECT))-1) )
			{
				$hdl_lien->_src_id = "M" . $result[0]->SWITCHS_ID;
				$hdl_lien->_src_port = ($wl_i+1);
				$hdl_lien->_type = "0";
				$result_lien = json_decode($hdl_lien->get_liens_from_object());

				$var_connect .= "<tr><td>Port " . ($wl_i+1) . "</td>";
				$var_connect .= "<td><select id=\"FRM_LINK_OBJECT_" . ($wl_i+1) . "\" class=\"FRM_LINK_OBJECT\" style=\"width: 90%;\">";
				$var_connect .= addslashes($var_co_obj);
				$var_connect .= "</select></td>";
				$var_connect .= "<td><select id=\"FRM_LINK_PORT_" . ($wl_i+1) . "\">";
				$var_connect .= "<option></option>";
				$var_connect .= "</select></td>";				
				$var_connect .= "</tr>";

				if ( !empty($result_lien[0]->LIENS_SRC_ID) )
				{
					if ( $result_lien[0]->LIENS_SRC_ID == $hdl_lien->_src_id )
					{	
						$var_script .= "$(\"#FRM_LINK_OBJECT_" . ($wl_i+1) . " option[value='" . $result_lien[0]->LIENS_DST_ID . "']\").attr('selected', 'selected');";
						$var_script .= "load_ports('" . "FRM_LINK_OBJECT_" . ($wl_i+1) . "','" . $result_lien[0]->LIENS_DST_PORT . "');";
						//$var_script .= "$(\"#FRM_LINK_PORT_" . ($wl_i+1) . " option[value='E" . $result_lien[0]->LIENS_DST_PORT . "']\").attr('selected', 'selected');";					
					}
					else
					{
						$var_script .= "$(\"#FRM_LINK_OBJECT_" . ($wl_i+1) . " option[value='" . $result_lien[0]->LIENS_SRC_ID . "']\").attr('selected', 'selected');";
						$var_script .= "load_ports('" . "FRM_LINK_OBJECT_" . ($wl_i+1) . "','" . $result_lien[0]->LIENS_SRC_PORT . "');";
					}
				}
				$wl_i++;
			}
			
			$var_connect .= "</table>";
			echo "<script type='text/javascript'>";
			echo "$('#PORTS_DEFINE_MINI_SWITCHS_LISTE').html('" . $var_connect . "');";
			echo $var_script;
			echo "</script>";
			
		}
		else
		{
			echo "<input type='hidden' name='X' id='X' value='" . $_GET['X'] . "'>";
			echo "<input type='hidden' name='Y' id='Y' value='" . $_GET['Y'] . "'>";
		}
	?>

</form>

</div>

<div class="BOTTOM_BUTTONS">
	<button class="main_bt" type='button' onClick='javascript:valide_formulaire()'>Valider</button>
	<button class="main_bt_inv" onClick='javascript:close_sub_window()'>Retour</button>
</div>

<script type="text/javascript">

$('#SITE').val(sessionStorage.getItem("SITKEY"));

// *** RECUPERATION DU NOMBRE DE SWITCHS DANS LA BAIE ***
$("#FRM_NOMBRE_SWITCH").val($("#" + $('#BAIE_ID').val() + " > .SWITCH").length);

$(".FRM_LINK_OBJECT").change(function(){
	
	$("#FRM_LINK_PORT_" + $(this).attr("id").substring(16)).empty();	
	load_ports($(this).attr("id"));
	
});

function valide_formulaire()
{
	var errors = 0;

	// *** VERIFICATION QUE LES CHAMPS NE SONT PAS VIDE ***

	$(".requis").each(function(i){

		$(this).removeClass("invalid");

		var field = this.value;

		if ( field.length < 1 )
		{
			$(this).addClass("invalid");
			errors += 1;
		}
	});

	// *** Y A T IL EU DES ERREURS ***
	if ( errors > 0 )
	{
		$.gritter.add({
			title: 'ATTENTION',
			text: 'Certains champs obligatoires ne sont pas renseignés',
			time: 2500
		});
		return false;
	}
	
	/*var regtxt2 = new RegExp("\"|\'");

	$("input").each(function(i){

		$(this).removeClass("invalid");

		field = this.value;

		var resultat = regtxt2.test(field);
		if ( resultat == true )
		{
			$(this).addClass("invalid");
			errors += 1;
		}
	});*/
	// *** Y A T IL EU DES ERREURS ***
	if ( errors > 0 )
	{
		$.gritter.add({
			title: 'ATTENTION',
			text: 'Les caractères \' et " ne sont pas autorisés',
			time: 2500
		});
		return false;
	}
	
	var var_link = "";
	var tmp_obj;
	$(".FRM_LINK_OBJECT").each(function(){
		if ( $(this).val().length > 0 )
		{
			tmp_obj = parseInt($(this).attr("id").substring(16));
			var_link += $(this).val() + "^" + tmp_obj + ";" + $("#FRM_LINK_PORT_" + tmp_obj).val() + "~";
		}
	});
	
	// *** AJOUT / MODIFICATION DANS LA BASE DE DONNEES ***

	$.ajax({
		data: $("#FORMULAIRE").serialize(),
		type: $("#FORMULAIRE").attr("method"),
		url: "insert_mini_switch.php?LINKS=" + var_link,
		success: function(response) {
			response = response.replace(/^\s+/g,'').replace(/\s+$/g,'');
			if ( (parseInt(response) > 0 && $("#ISNEW").val() == "1") || $("#ISNEW").val() == "0" )
			{
				if ( $("#ISNEW").val() == "1" )
				{
					create_mini_switch_on_map($("#FRM_SWITCH_MARQUE").val() + " " + $("#FRM_SWITCH_COMMENTAIRES").val(), $("#X").val(),$("#Y").val(),response );
				}
				else
				{
					$("#M" + $("#FRM_SWITCH_ID").val() + " > .MINI_SWITCH_TITLE").html($('#FRM_SWITCH_MARQUE').val() + " " + $("#FRM_SWITCH_COMMENTAIRES").val());
					$.ajax({
						type: 'GET',
						url: "reload_links.php?SITE=" + sessionStorage.getItem("SITKEY"),
						success: function(response) {
							eval(response);
							join();
						}
					});
				}

				$("#LOCK_SCREEN").fadeOut(400);
				$("#MODAL_ADD").fadeOut(400);
			}
			else
			{
				$.gritter.add({
					title: 'Création switch',
					text: 'Erreur lors de la création du switch dans la base de données.',
					time: 1500
				});
			}
		},
		error: function(){
			$.gritter.add({
				title: 'Création switch',
				text: 'Erreur lors de la création du switch dans la base de données.',
				time: 1500
			});
		}
	});
}

</script>
