<div class='CONTENT_SUB'>
	
<h2 class="TITLE_N0 TITLE_BLUE TITLE_CENTER_IT TITLE_BORDER_IT">Switchs</h2>

<form method="post" action="insert_switch.php" id="FORMULAIRE">
	<table>
		<tr><td class="rubrique">Constructeur</td><td class="fields"><select class="wid_1 requis" name='FRM_SWITCH_MARQUE' id='FRM_SWITCH_MARQUE'>";
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
		<tr><td class="rubrique">modèle du switch</td><td class="fields"><input class="wid_1" type="text" id="FRM_SWITCH_COMMENTAIRES" name="FRM_SWITCH_COMMENTAIRES" placeholder="Modèle du switch" maxlength="65" size="40" class="requis"></td></tr>
		<tr><td class="rubrique">Adresse IP du switch</td><td class="fields"><input class="wid_2 TITLE_CENTER_IT" type="text" name="FRM_SWITCH_IP" id="FRM_SWITCH_IP" placeholder="Adresse IP" maxlength="15" size="19" class="ip"><input type="hidden" name="FRM_SWITCH_OLD_IP" id="FRM_SWITCH_OLD_IP" maxlength="15" size="19"></td></tr>
		<tr><td class="rubrique">Ports ethernet</td><td class="fields"><select name='FRM_SWITCH_NOMBRE_PORTS' id="FRM_SWITCH_NOMBRE_PORTS" style='width: 100px;'>";
				<option value='8'>8</option>
				<option value='12'>12</option>
				<option value='16'>16</option>
				<option value='24'>24</option>
				<option value='48'>48</option>
			</select></td></tr>
		<tr><td class="rubrique">Ports fibre</td><td class="fields"><select name='FRM_SWITCH_FIBER_PORTS' id="FRM_SWITCH_FIBER_PORTS" style='width: 100px;'>";
				<option value='0'>0</option>
				<option value='1'>1</option>
				<option value='2'>2</option>
				<option value='3'>3</option>
				<option value='4'>4</option>
			</select></td></tr>
		<tr><td class="rubrique">Administration web<br><input name="FRM_SWITCH_WEB_ADMIN" id="FRM_SWITCH_WEB_ADMIN" type="checkbox" class="requis chk_style"></td><td class="fields">
		&nbsp; HTTP web port <input type="text" name="FRM_SWITCH_WEB_PORT" id="FRM_SWITCH_WEB_PORT" maxlength="6" size="4" value="80">
		&nbsp; SSL<input name="FRM_SWITCH_HTTPS" id="FRM_SWITCH_HTTPS" type="checkbox" class='chk_style'>
		</td></tr>
	</table>

	<input type="hidden" name="FRM_NOMBRE_SWITCH" id="FRM_NOMBRE_SWITCH">
	<input type='hidden' name='SITE' id='SITE'>

	<?php
		echo "<input type='hidden' name='BAIE_ID' id='BAIE_ID' value='" . $_GET['ID'] . "'>";
		echo "<input type='hidden' name='ISNEW' id='ISNEW' value='1'>";
		echo "<input type='hidden' name='FRM_SWITCH_ID' id='FRM_SWITCH_ID'>";

		if ( isset($_GET['IDS']) )
		{
			// *** RECUPERATION DES VALEURS SI EDITION ***
			require "Class/class_switchs.php";

			$hdl_switch = new Switche();

			$hdl_switch->_site = $_GET['SITE'];
			$hdl_switch->_ip = $_GET['IDS'];

			$result = json_decode($hdl_switch->get_switch_in_baie_from_ip());

			if ( count($result) > 0 )
			{
				echo "<script type='text/javascript'>

					$('#FRM_SWITCH_MARQUE').val('" . addslashes($result[0]->SWITCHS_MARQUE) . "');
					$('#FRM_SWITCH_COMMENTAIRES').val('" . addslashes($result[0]->SWITCHS_DESCRIPTION) . "');";
				if ( substr( $result[0]->SWITCHS_IP ,0,5) != 'NOIP_')
				{
					echo "$('#FRM_SWITCH_IP').val('" . $result[0]->SWITCHS_IP . "');";
					echo "$('#FRM_SWITCH_OLD_IP').val('" . $result[0]->SWITCHS_IP . "');";
				}
				else
				{
					echo "$('#FRM_SWITCH_IP').hide();";
					echo "$('#FRM_SWITCH_IP').val('" . $result[0]->SWITCHS_IP . "');";
					echo "$('#FRM_SWITCH_OLD_IP').val('" . $result[0]->SWITCHS_IP . "');";
				}
				echo "	$('#FRM_SWITCH_NOMBRE_PORTS').val('" . (count(explode(";",$result[0]->SWITCHS_PORTS_CONNECT))-1) . "');
					$('#FRM_SWITCH_FIBER_PORTS').val('" . $result[0]->SWITCHS_FIBER_PORTS . "');
					$('#FRM_SWITCH_WEB_PORT').val('" . $result[0]->SWITCHS_WEB_PORT . "');
					$('#FRM_SWITCH_ID').val('" . $result[0]->SWITCHS_ID . "');
					$('#FRM_SWITCH_FIBER_PORTS').attr('disabled', 'disabled');
					$('#FRM_SWITCH_NOMBRE_PORTS').attr('disabled', 'disabled');					
					$('#ISNEW').val('0');
				";

				if ( $result[0]->SWITCHS_WEB_INTERFACE == "1" )
				{
					echo "$('#FRM_SWITCH_WEB_ADMIN').attr('checked', true);";
				}

				if ( $result[0]->SWITCHS_HTTPS == "1" )
				{
					echo "$('#FRM_SWITCH_HTTPS').attr('checked', true);";
				}

				echo "</script>";
			}
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
$("#FRM_NOMBRE_SWITCH").val($("#" + $('#BAIE_ID').val() + " .BAIE_SUPPORT > .SWITCH").length);
$('.chk_style').checkbox();

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

	// *** CONTROLE VALIDITE ADRESSE IPV4 ***

	var regtxt = new RegExp("^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?).(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?).(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?).(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$");
	var resultat;
	
	$(".ip").each(function(i){

		$(this).removeClass("invalid");

		var field = this.value;

		if ( field.length > 0 )
		{
			resultat = regtxt.test(field);
			if ( resultat == false )
			{
				$(this).addClass("invalid");
				errors += 1;
			}
		}
	});

	if ( $("#FRM_SWITCH_IP").val().length == 0 )
	{
		$("#FRM_SWITCH_IP").fadeOut(1, function(){
			var d = new Date();
			var n = d.getTime(); 
			$("#FRM_SWITCH_IP").val("NOIP_" + n);
		});
	}
	
	
	
	$.ajax({
		data: $("#FORMULAIRE").serialize(),
		type: $("#FORMULAIRE").attr("method"),
		url: "verify_switch_ip.php",
		success: function(response) {
			if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 && $("#FRM_SWITCH_IP").val() != $("#FRM_SWITCH_OLD_IP").val() )
			{
				$.gritter.add({
					title: 'ATTENTION',
					text: 'L adresse IP de votre switch existe déja dans votre schéma.',
					time: 2500
				});
				return false;
			}
			else
			{
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
				});
				// *** Y A T IL EU DES ERREURS ***
				if ( errors > 0 )
				{
					$.gritter.add({
						title: 'ATTENTION',
						text: 'Les caractères \' et " ne sont pas autorisés',
						time: 2500
					});
					return false;
				}*/

				// *** AJOUT / MODIFICATION DANS LA BASE DE DONNEES ***

				var sav_place_switch = parseInt($("#FRM_NOMBRE_SWITCH").val());
				$.ajax({
					data: $("#FORMULAIRE").serialize(),
					type: $("#FORMULAIRE").attr("method"),
					url: $("#FORMULAIRE").attr("action"),
					success: function(response) {
						if ( (parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 && $("#ISNEW").val() == "1") || $("#ISNEW").val() == "0" )
						{
							if ( $("#FRM_SWITCH_WEB_ADMIN").is(':checked') )
							{
								var web_interface = "1";
							}
							else
							{
								var web_interface = "0";
							}

							if ( $("#FRM_SWITCH_HTTPS").is(':checked') )
							{
								var web_ssl = "1";
							}
							else
							{
								var web_ssl = "0";
							}

							if ( $("#ISNEW").val() == "1" )
							{
								create_switch_on_baie($("#BAIE_ID").val(), $("#FRM_SWITCH_IP").val(), sav_place_switch, $("#FRM_SWITCH_MARQUE").val() + " " + $("#FRM_SWITCH_COMMENTAIRES").val(), $("#FRM_SWITCH_FIBER_PORTS").val(), web_interface, $("#FRM_SWITCH_WEB_PORT").val(), web_ssl, $("#FRM_SWITCH_NOMBRE_PORTS").val());
							}
							else
							{
								update_switch_on_baie();
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
		}
	});	
}

</script>
