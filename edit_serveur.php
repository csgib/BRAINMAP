<div class='CONTENT_SUB'>
	
<h2 class="TITLE_N0 TITLE_BLUE TITLE_CENTER_IT TITLE_BORDER_IT">Serveur</h2>

<form method="post" action="insert_serveur.php" id="FORMULAIRE" onsubmit="return false">
	<table>	
		<tr><td class="rubrique">Nom du serveur</td><td class="fields"><input type="text" name="FRM_SERVEUR_NAME" id="FRM_SERVEUR_NAME" placeholder="Nom du serveur" class="requis wid_1"></td></tr>
		<tr><td class="rubrique">Marque du serveur</td><td class="fields"><select name='FRM_SERVEUR_MARQUE' id='FRM_SERVEUR_MARQUE' class="wid_1">
		
		<?php
		
			require "Class/class_constructeurs.php";
			$hdl_constructeur = new CONSTRUCTEUR();
			$hdl_constructeur->_type_object = "S";
			
			$result_cosntructeur = json_decode($hdl_constructeur->get_constructeurs());
			$wl_idx_con = 0;
			
			while ($wl_idx_con < count($result_cosntructeur))
			{
				echo "<option value='" . $result_cosntructeur[$wl_idx_con]->CONSTRUCTEURS_NAME . "'>" . $result_cosntructeur[$wl_idx_con]->CONSTRUCTEURS_NAME . "</option>";
				$wl_idx_con++;
			}
		
		?>
		</select></td></tr>
		<tr><td class="rubrique">Modèle du serveur</td><td class="fields"><input type="text" id="FRM_SERVEUR_MODELE" name="FRM_SERVEUR_MODELE" placeholder="Modèle du serveur" class="wid_1"></td></tr>
		<tr><td class="rubrique">Serveur ondulée</td><td class="fields"><input type="checkbox" id="FRM_SERVEUR_ONDULEE" name="FRM_SERVEUR_ONDULEE" class="chk_style"></td></tr>
		<tr><td class="rubrique">Firewall</td><td class="fields"><input type="checkbox" id="FRM_SERVEUR_FIREWALL" name="FRM_SERVEUR_FIREWALL" class="chk_style"></td></tr>				
		<tr><td class="rubrique">Système d'exploitation</td><td class="fields"><select name='FRM_SERVEUR_OS' id='FRM_SERVEUR_OS' class="wid_1">
		<?php
		
			require "Class/class_os.php";
			$hdl_os = new OS();
			
			$result_os = json_decode($hdl_os->get_os());
			$wl_idx_os = 0;
			
			while ($wl_idx_os < count($result_os))
			{
				echo "<option value='" . $result_os[$wl_idx_os]->OS_NAME . "'>" . $result_os[$wl_idx_os]->OS_NAME . "</option>";
				$wl_idx_os++;
			}
		
		?>		
		</select></td></tr>
		<tr><td class="rubrique">Version du système d'exploitation</td><td class="fields"><input type="text" id="FRM_SERVEUR_RELEASE" name="FRM_SERVEUR_RELEASE" placeholder="Version système d'exploitation" class="wid_1"></td></tr>
		
		<tr><td class="rubrique">Administration WEB<br><input id="FRM_SERVEUR_WEB_ADMIN" name="FRM_SERVEUR_WEB_ADMIN" type="checkbox" class="chk_style"></td><td class="fields">
		HTTP web port <input type="text" id="FRM_SERVEUR_WEB_PORT" name="FRM_SERVEUR_WEB_PORT" maxlength="6" size="4" value="80" class="requis">
		&nbsp; SSL<input id="FRM_SERVEUR_HTTPS" name="FRM_SERVEUR_HTTPS" type="checkbox" class='chk_style'>
		Carte réseau accès interface <select name='FRM_SERVEUR_WEB_CARD' id="FRM_SERVEUR_WEB_CARD" style="width:50px;">";
				<option value='1'>1</option>
				<option value='2'>2</option>
				<option value='3'>3</option>
				<option value='4'>4</option>
				<option value='5'>5</option>
				<option value='6'>6</option>
		</select></td></tr>

		<tr><td class="rubrique">Cartes réseau</td><td class="fields">
		<?php

		if ( isset($_GET['ID']) )
		{
			$wl_edit_yes = "";
		}
		else
		{
			$wl_edit_yes = "style='display: none;'";
		}

		$i = 0;
		while ( $i < 6 )
		{
			$type = "<div class='LAN_CARD'><table style='width: 100%;'><tr>
					<td style='width: 40px;'><input id='FRM_SERVEUR_NET" . $i . "_OK' name='FRM_SERVEUR_NET" . $i . "_OK' type='checkbox' class='chk_style'></td>
					<td style='width: 100px;'><select name='FRM_SERVEUR_LAN_TYPE_" . $i . "' id='FRM_SERVEUR_LAN_TYPE_" . $i . "'>
						<option value='0'>Ethernet</option>
						<option value='1'>Fibre optique</option>
					</select></td>
					<td style='width: 60px;'><input type='text' name='FRM_SERVEUR_IP_" . $i . "' id='FRM_SERVEUR_IP_" . $i . "' placeholder='Adresse IP' maxlength='15' size='19' class='ip TITLE_CENTER_IT'>
					<button class='main_bt' style='margin-top: 4px;' onclick='javascript:open_edit_link_card(" . ($i+1) . ")' " . $wl_edit_yes . " id='LK_" . $i . "'>Lier la carte</button></td></tr></table>
				</div>";
			echo $type;
			$i++;
		}


		?>
		</td></tr>
	</table>
	<?php

		echo "<input type='hidden' name='SITE' id='SITE' value='" . $_GET['SITE'] . "'>";

		// *** RECUPERATION DES VALEURS SI EDITION ***
		require "Class/class_serveurs.php";
		require "Class/class_liens.php";

		$hdl_serveur = new Serveur();
		$hdl_lien = new Lien();

		if ( isset($_GET['ID']) )
		{
			$hdl_serveur->_site = $_GET['SITE'];
			$hdl_serveur->_id = substr($_GET['ID'],1);

			$hdl_lien->_site = $_GET['SITE'];

			$result = json_decode($hdl_serveur->get_serveur_from_id());

			if ( count($result) > 0 )
			{
				echo "<script type='text/javascript'>

					$('#FRM_SERVEUR_NAME').val('" . addslashes($result[0]->SERVEURS_NAME) . "');
					$('#FRM_SERVEUR_MARQUE').val('" . addslashes($result[0]->SERVEURS_MARQUE) . "');
					$('#FRM_SERVEUR_MODELE').val('" . addslashes($result[0]->SERVEURS_MODELE) . "');
					$('#FRM_SERVEUR_OS').val('" . addslashes($result[0]->SERVEURS_OS) . "');
					$('#FRM_SERVEUR_RELEASE').val('" . addslashes($result[0]->SERVEURS_RELEASE) . "');
					$('#FRM_SERVEUR_WEB_CARD').val('" . $result[0]->SERVEURS_WEB_CARD . "');
					$('#FRM_SERVEUR_WEB_PORT').val('" . $result[0]->SERVEURS_WEB_PORT . "');";

					if ( $result[0]->SERVEURS_ONDULEE == "1" )
					{
						echo "$('#FRM_SERVEUR_ONDULEE').attr('checked', true);";
					}					

					if ( $result[0]->SERVEURS_FIREWALL == "1" )
					{
						echo "$('#FRM_SERVEUR_FIREWALL').attr('checked', true);";
					}
					
					if ( $result[0]->SERVEURS_WEB_INTERFACE == "1" )
					{
						echo "$('#FRM_SERVEUR_WEB_ADMIN').attr('checked', true);";
					}

					if ( $result[0]->SERVEURS_HTTPS == "1" )
					{
						echo "$('#FRM_SERVEUR_HTTPS').attr('checked', true);";
					}

				$i = 0;

				while( $i < 6 )
				{
					$wl_var_on = "SERVEURS_LAN_" . ($i+1) . "_ON";
					$wl_var_ip = "SERVEURS_LAN_" . ($i+1) . "_IP";
					$wl_var_tp = "SERVEURS_LAN_" . ($i+1) . "_TYPE";

					if ( $result[0]->$wl_var_ip == "" )
					{
						echo "$('#LK_" . $i ."').remove();";
						echo "$('#EI_" . $i ."').remove();";
					}
					else
					{
						$hdl_lien->_src_id = $_GET['ID'];
						$hdl_lien->_src_port = ($i+1);
						$hdl_lien->_type = $result[0]->$wl_var_tp;

						if ( $hdl_lien->get_is_lien() == "1" )
						{
							echo "$('#LK_" . $i . "').addClass('main_bt_war');";
							echo "$('#LK_" . $i . "').html('Modifier lien');";
						}
					}

					echo "$('#FRM_SERVEUR_LAN_TYPE_" . $i . "').val('" . $result[0]->$wl_var_tp . "');";
					echo "$('#FRM_SERVEUR_IP_" . $i . "').val('" . $result[0]->$wl_var_ip . "');";

					if ( $result[0]->$wl_var_on == "1" )
					{
						echo "$('#FRM_SERVEUR_NET" . $i . "_OK').attr('checked', true);";
					}

					$i++;
				}

				echo "</script>";
				echo "<input type='hidden' name='ISNEW' id='ISNEW' value='0'>";
				echo "<input type='hidden' name='ID' id='ID' value='" . substr($_GET['ID'],1) . "'>";
			}
			else
			{
				echo "<input type='hidden' name='ISNEW' id='ISNEW' value='1'>";
				
				echo "<script type='text/javascript'>";
				$wl_i_d = 0;
				while($wl_i_d < 6 )
				{
					echo "$('#LK_" . $wl_i_d ."').remove();";
					echo "$('#EI_" . $wl_i_d ."').remove();";
					$wl_i_d++;
				}
				echo "</script>";
			}
		}
		else
		{
			echo "<input type='hidden' name='X' id='X' value='" . $_GET['X'] . "'>";
			echo "<input type='hidden' name='Y' id='Y' value='" . $_GET['Y'] . "'>";
			echo "<input type='hidden' name='ISNEW' id='ISNEW' value='1'>";
			
			echo "<script type='text/javascript'>";
			$wl_i_d = 0;
			while($wl_i_d < 6 )
			{
				echo "$('#LK_" . $wl_i_d ."').remove();";
				echo "$('#EI_" . $wl_i_d ."').remove();";
				$wl_i_d++;
			}
			echo "</script>";			
		}



	?>

</form>

<?php

	/* ******************************************* */
	/* *** DIV DE GESTION / CREATION DES LINKS *** */
	/* ******************************************* */

	if ( isset($_GET['ID']) )
	{
		require "Class/class_switchs.php";
		require "Class/class_routeurs.php";
		require "Class/class_nas.php";
		require "Class/class_baies.php";
		require "Class/class_cameras.php";
		require "Class/class_antennes.php";
		require "Class/class_transcievers.php";

		$hdl_switche 			= new Switche();
		$hdl_routeur 			= new Routeur();
		$hdl_baie 			= new Baie();
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

		echo "<div class='CLASS_LINK_EDIT' id='LINK_EDIT'>";

		$result_baie = json_decode($hdl_baie->get_all_baies());

		echo "<form method='post' action='insert_link_serveur.php' id='FORMULAIRE_LINK'>";
		echo "<input id='WA_EDIT' type='hidden' value=''>";
		echo "<input type='hidden' name='FRM_SRC_PORT' id='FRM_SRC_PORT' style='border: 0px; box-shadow: 0 0 0px rgba(0,0,0,0.0); background-color: transparent; font-family: Droid; font-size: 14px; font-weight: bold;' readonly><br><br>";
		echo "<input id='FRM_SRC_IP' name='FRM_SRC_IP' type='hidden' value='" . $_GET['ID'] . "'>";
		echo "<input name='FRM_SITE' type='hidden' value='" . $_GET['SITE'] . "'><input type='hidden' name='FRM_TP_PORT' id='FRM_TP_PORT'>";

		echo "<br><b>DESTINATION</b>";
		echo "<br><select id='FRM_LINK_OBJECT' name='FRM_LINK_OBJECT' style='width:450px;' data-placeholder=''>";
		echo "<option value=''></option>";

		$j = 0;
		while ( $j < count($result_baie) )
		{
			echo "<optgroup label=" . $result_baie[$j]->BAIES_COMMENTAIRES . ">";

			$hdl_switche->_baie_id = $result_baie[$j]->BAIES_ID;
		
			$result_switch_baie = json_decode($hdl_switche->get_all_switches_in_baie());
			$k = 0;
			while ( $k < count($result_switch_baie) )
			{
				if ( $result_switch_baie[$k]->SWITCHS_ID != $_GET['ID'] )
				{
					if ( substr($result_switch_baie[$k]->SWITCHS_IP,0, 5) != "NOIP_" )
					{
						echo "<option value='" . $result_switch_baie[$k]->SWITCHS_ID . ";" . $result_switch_baie[$k]->SWITCHS_IP . "'>" . addslashes($result_switch_baie[$k]->SWITCHS_MARQUE) . " " . addslashes($result_switch_baie[$k]->SWITCHS_DESCRIPTION) . " - " . $result_switch_baie[$k]->SWITCHS_IP . "</option>";
					}
					else 
					{
						echo "<option value='" . $result_switch_baie[$k]->SWITCHS_ID . ";" . $result_switch_baie[$k]->SWITCHS_IP . "'>" . addslashes($result_switch_baie[$k]->SWITCHS_MARQUE) . " " . addslashes($result_switch_baie[$k]->SWITCHS_DESCRIPTION) . "</option>";
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
			if ( $boucle_lan == 999 && $result_serveur[$j]->SERVEURS_ID != substr($_GET['ID'],1) )
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

		echo "<br><br>Port <select id='FRM_LINK_PORT' name='FRM_LINK_PORT' style='width:150px;'></select>";
		echo "<input type='hidden' id='FRM_SAV_IP' name='FRM_SAV_IP'>";

		echo "</form>";

		echo"<div class='BOTTOM_BUTTONS'><button class='main_bt' type='button' onClick='javascript:valide_formulaire_link_card()'>Valider</button><button class='main_bt_inv' onClick='javascript:close_edit_link_card()'>Retour</button></div>";

		echo "</div>";
	}
?>

</div>

<div class="BOTTOM_BUTTONS">
	<button class="main_bt" onClick='javascript:valide_formulaire()'>Valider</button>
	<button class="main_bt_inv" onClick='javascript:close_sub_window()'>Annuler</button>
</div>

<script type="text/javascript">

$('.chk_style').checkbox();

$("#FRM_LINK_OBJECT").change(function(){
	if ($("#FRM_LINK_OBJECT").val().substring(0,1) == "S" )
	{
		f_load_serveur_port($("#FRM_LINK_OBJECT").val().substring(1), $("#FRM_TP_PORT").val());
	}
	else
	{
		if ($("#FRM_LINK_OBJECT").val().substring(0,1) == "R" || $("#FRM_LINK_OBJECT").val().substring(0,1) == "N" || $("#FRM_LINK_OBJECT").val().substring(0,1) == "K" || $("#FRM_LINK_OBJECT").val().substring(0,1) == "A" )
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
				}
			}
		}
	}
});

function valide_formulaire()
{
	var regtxt = new RegExp("^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?).(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?).(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?).(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$");

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
	
	// *** VERIFICATION QUE LES CHAMPS IP SOIENT CORRECTE ***

	$(".ip").each(function(i){

		$(this).removeClass("invalid");

		var field = this.value;

		if ( field.length > 0 )
		{
			var resultat = regtxt.test(field);
			if ( resultat == false )
			{
				$(this).addClass("invalid");
				errors += 1;
			}
		}
	});

	// *** Y A T IL EU DES ERREURS ***
	if ( errors > 0 )
	{
		$.gritter.add({
			title: 'ATTENTION',
			text: 'Certains champs obligatoires ne sont pas renseignés.',
			time: 2500
		});
		return false;
	}

	$(".ip").removeAttr("disabled", "disabled");
	$("input").removeAttr("disabled", "disabled");
	//$(".CL_CHOSEN").removeAttr("disabled", "disabled").trigger("liszt:updated");

	$.ajax({
		data: $("#FORMULAIRE").serialize(),
		type: $("#FORMULAIRE").attr("method"),
		url: $("#FORMULAIRE").attr("action"),
		success: function(response) {

			if ( $("#ISNEW").val() == "1" )
			{
				if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 )
				{
					var wl_interface;
					var wl_ip;
					var wl_ssl;

					if ( $('#FRM_SERVEUR_WEB_ADMIN').is(':checked') )
					{
						wl_interface = 1;
					}
					else
					{
						wl_interface = 0;
					}

					if ( $('#FRM_SERVEUR_HTTPS').is(':checked') )
					{
						wl_ssl = 1;
					}
					else
					{
						wl_ssl = 0;
					}

					wl_ip = $("#FRM_SERVEUR_IP_" + ($('#FRM_SERVEUR_WEB_CARD').val()-1)).val();

					if ( $("#FRM_SERVEUR_ONDULEE").is(':checked') )
					{
						wl_ondulee = '1';
					}
					else
					{
						wl_ondulee = '0';
					}

					if ( $("#FRM_SERVEUR_FIREWALL").is(':checked') )
					{
						wl_firewall = '1';
					}
					else
					{
						wl_firewall = '0';
					}
					
					create_serveur_on_map(response.replace(/^\s+/g,'').replace(/\s+$/g,''), $("#FRM_SERVEUR_NAME").val(), $("#X").val(), $("#Y").val(), wl_interface , $("#FRM_SERVEUR_WEB_PORT").val() , wl_ssl , wl_ip, wl_ondulee, wl_firewall);

					$("#LOCK_SCREEN").fadeOut(400);
					$("#MODAL_ADD").fadeOut(400);
				}
				else
				{
					$.gritter.add({
						title: 'Création serveur',
						text: 'Erreur lors de la création du serveur dans la base de données.',
						time: 1500
					});
					$("#LOCK_SCREEN").fadeOut(400);
					$("#MODAL_ADD").fadeOut(400);
				}
			}
			else
			{			
				reload_site();
				
				$("#LOCK_SCREEN").fadeOut(400);
				$("#MODAL_ADD").fadeOut(400);
			}
		},
	        error: function(){
			$.gritter.add({
				title: 'Création serveur',
				text: 'Erreur lors de la création du serveur dans la base de données.',
				time: 1500
			});
			$("#LOCK_SCREEN").fadeOut(400);
			$("#MODAL_ADD").fadeOut(400);
    		}
	});
}

// *** VALIDATION FORMULAIRE DES LIAISONS ***

function valide_formulaire_link_card()
{
	// *** ON ECRASE LE LIEN ACTUEL ***
	$.ajax({
		type: 'GET',
		url: "delete_lien.php?SITE=" + sessionStorage.getItem("SITKEY") + "&SRCI=" + $("#FRM_SRC_IP").val() + "&SRCP=" + $("#FRM_SRC_PORT").val() + "&SRCO=" + $("#FRM_SAV_IP").val() + "&TPPORT=" + $("#FRM_TP_PORT").val(),
		success: function(retour){
			// *** ON NE RECREE PAS DE LIEN DONC ONT SORT ***
			if ( $("#FRM_LINK_OBJECT").val().length == 0 )
			{
				var wl_sport = $("#FRM_SRC_PORT").val();
				
				$("#LK_" + (wl_sport-1)).removeClass('main_bt_war');
				$("#LK_" + (wl_sport-1)).html('Lier la carte');

				$("#LINK_EDIT").animate({
					top: '-=100%',		
				},400);

				$.ajax({
					type: 'GET',
					url: "reload_links.php?SITE=" + sessionStorage.getItem("SITKEY"),
					success: function(response) {
						eval(response);
						join();
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
							var wl_sport = $("#FRM_SRC_PORT").val();
							
							$("#LK_" + (wl_sport-1)).addClass('main_bt_war');
							$("#LK_" + (wl_sport-1)).html('Modifier lien');

							$("#LINK_EDIT").animate({
								top: '-=100%',		
							},400, function(){
								$.ajax({
									type: 'GET',
									url: "reload_links.php?SITE=" + sessionStorage.getItem("SITKEY"),
									success: function(response) {
										eval(response);
										join();
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
}

</script>
