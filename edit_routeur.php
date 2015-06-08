<div class='CONTENT_SUB'>
	
<h2 class="TITLE_N0 TITLE_BLUE TITLE_CENTER_IT TITLE_BORDER_IT">Routeur</h2>

<form method="post" action="insert_routeur.php" id="FORMULAIRE" onsubmit="return false">
	<table>
		<tr><td class="rubrique">Modèle</td><td class="fields"><input class='wid_1' type="text" name="FRM_ROUTEUR_NAME" id="FRM_ROUTEUR_NAME" placeholder="Modèle du routeur" maxlength="45" size="25" class="requis"></td></tr>
		<tr><td class="rubrique">Adresse IP interne</td><td class="fields"><input class='wid_1 ip' type="text" name="FRM_ROUTEUR_IP" id="FRM_ROUTEUR_IP" placeholder="Adresse IP" maxlength="15" size="25" class="ip requis"></td></tr>
		<tr><td class="rubrique">Adresse IP publique</td><td class="fields"><input class='wid_1 ip' type="text" name="FRM_ROUTEUR_IP_PUBLIQUE" id="FRM_ROUTEUR_IP_PUBLIQUE" placeholder="Adresse IP publique" maxlength="15" size="25" class="ip"></td></tr>
		<tr><td class="rubrique">Le routeur dispose d'un module WIFI</td><td class="fields"><input name='FRM_ROUTEUR_WIFI' id='FRM_ROUTEUR_WIFI' type='checkbox' class='chk_style'></td></tr>

	</table>

	<input type='hidden' name='SITE' id='SITE'>
	<?php

		echo "<input type='hidden' name='ISNEW' id='ISNEW' value='0'>";

		if ( isset($_GET['ID']) )
		{
			echo "<input type='hidden' name='FRM_SITE' id='FRM_SITE' value='" . $_GET['SITE'] . "'>";
			echo "<input type='hidden' name='FRM_ID' id='FRM_ID' value='" . substr($_GET['ID'],1) . "'>";

			// *** RECUPERATION DES VALEURS SI EDITION ***
			require "Class/class_routeurs.php";

			$hdl_routeur = new Routeur();
			$hdl_routeur->_id = substr($_GET['ID'],1);
			$hdl_routeur->_site = $_GET['SITE'];

			$result = json_decode($hdl_routeur->get_routeur_from_id());

			if ( count($result) > 0 )
			{
				echo "<script type='text/javascript'>";

				echo "$('#FRM_ROUTEUR_NAME').val('" . addslashes($result[0]->ROUTEURS_NAME) . "');";
				echo "$('#FRM_ROUTEUR_IP').val('" . $result[0]->ROUTEURS_IP . "');";

				if ( $result[0]->ROUTEURS_WIFI == "1" )
				{
					echo "$('#FRM_ROUTEUR_WIFI').attr('checked', true);";
				}

				echo "$('#FRM_ROUTEUR_IP_PUBLIQUE').val('" . $result[0]->ROUTEURS_IP_PUBLIQUE . "');";
				echo "$('#ISNEW').val('1');";

				echo "</script>";
			}

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

	var regtxt = new RegExp("^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?).(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?).(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?).(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$");

	$(".ip").each(function(i){

		if ( $(this).hasClass("requis") ) 
		{
			$(this).removeClass("invalid");
	
			var field = this.value;
	
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
			text: 'Certains champs obligatoires ne sont pas renseignés',
			time: 2500
		});
		return false;
	}

	$.ajax({
		data: $("#FORMULAIRE").serialize(),
		type: $("#FORMULAIRE").attr("method"),
		url: $("#FORMULAIRE").attr("action"),
		success: function(response) {
	
			if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 && $('#ISNEW').val() == "0" )
			{
				var wl_wifi = "0";
				if ( $('#FRM_ROUTEUR_WIFI').is(':checked') )
				{
					wl_wifi = "1";
				}

				create_routeur_on_map(response.replace(/^\s+/g,'').replace(/\s+$/g,''), $("#FRM_ROUTEUR_NAME").val(), $("#X").val(), $("#Y").val(), wl_wifi);

				$("#LOCK_SCREEN").fadeOut(400);
				$("#MODAL_ADD").fadeOut(400);
			}
			else
			{
				if ( $('#ISNEW').val() == "1" )
				{
					$("#R" + $("#FRM_ID").val() + " > .ROUTEUR_TITLE").html($('#FRM_ROUTEUR_NAME').val());

					if ( $('#FRM_ROUTEUR_WIFI').is(':checked') )
					{
						$("#R" + $("#FRM_ID").val() + " > .ROUTEUR_WIFI").fadeIn(100);
					}
					else
					{
						$("#R" + $("#FRM_ID").val() + " > .ROUTEUR_WIFI").fadeOut(100);
					}

					$("#LOCK_SCREEN").fadeOut(400);
					$("#MODAL_ADD").fadeOut(400);
				}
				else
				{
					$.gritter.add({
						title: 'Création routeur',
						text: 'Erreur lors de la création du routeur dans la base de données.',
						time: 1500
					});
				}
			}
		},
	        error: function(){
			$.gritter.add({
				title: 'Création switch',
				text: 'Erreur lors de la création du routeur dans la base de données.',
				time: 1500
			});
    		}
	});
}

</script>
