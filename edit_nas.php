<div class='CONTENT_SUB'>
	
<h2 class="TITLE_N0 TITLE_BLUE TITLE_CENTER_IT TITLE_BORDER_IT">NAS</h2>

<form method="post" action="insert_nas.php" id="FORMULAIRE" onsubmit="return false">
	
	<table>
	
	<tr><td class="rubrique">Nom du constructeur</td><td class="fields"><input class="wid_1" type="text" name="FRM_NAS_NAME" id="FRM_NAS_NAME" placeholder="Modèle du nas" maxlength="45" size="25" class="requis"></td></tr>
	<tr><td class="rubrique">Adresse IP</td><td class="fields"><input class="wid_1" type="text" name="FRM_NAS_IP" id="FRM_NAS_IP" placeholder="Adresse IP du nas" maxlength="45" size="25" class="requis ip"></td></tr>

	</table>
	
	<input type='hidden' name='SITE' id='SITE'>

	<?php

		echo "<input type='hidden' name='ISNEW' id='ISNEW' value='0'>";

		if ( isset($_GET['ID']) )
		{
			echo "<input type='hidden' name='FRM_SITE' id='FRM_SITE' value='" . $_GET['SITE'] . "'>";
			echo "<input type='hidden' name='FRM_ID' id='FRM_ID' value='" . substr($_GET['ID'],1) . "'>";

			// *** RECUPERATION DES VALEURS SI EDITION ***
			require "Class/class_nas.php";

			$hdl_nas = new Nas();
			$hdl_nas->_id = substr($_GET['ID'],1);
			$hdl_nas->_site = $_GET['SITE'];

			$result = json_decode($hdl_nas->get_nas_from_id());

			if ( count($result) > 0 )
			{
				echo "<script type='text/javascript'>";

				echo "$('#FRM_NAS_NAME').val('" . addslashes($result[0]->NAS_NAME) . "');";
				echo "$('#FRM_NAS_IP').val('" . $result[0]->NAS_IP . "');";
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

function valide_formulaire()
{
	var errors = 0;
	var regtxt = new RegExp("^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?).(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?).(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?).(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$");

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

	$(".ip").each(function(i){

		$(this).removeClass("invalid");

		var field = this.value;

		var resultat = regtxt.test(field);
		if ( resultat == false )
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

	$.ajax({
		data: $("#FORMULAIRE").serialize(),
		type: $("#FORMULAIRE").attr("method"),
		url: $("#FORMULAIRE").attr("action"),
		success: function(response) {
			if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 && $('#ISNEW').val() == "0" )
			{
				create_nas_on_map(response.replace(/^\s+/g,'').replace(/\s+$/g,''), $("#FRM_NAS_NAME").val(), $("#X").val(), $("#Y").val());

				$("#LOCK_SCREEN").fadeOut(400);
				$("#MODAL_ADD").fadeOut(400);
			}
			else
			{
				if ( $('#ISNEW').val() == "1" )
				{
					$("#N" + $("#FRM_ID").val() + " > .NAS_TITLE").html($('#FRM_NAS_NAME').val());
					$("#LOCK_SCREEN").fadeOut(400);
					$("#MODAL_ADD").fadeOut(400);
				}
				else
				{
					$.gritter.add({
						title: 'Création nas',
						text: 'Erreur lors de la création du nas dans la base de données.',
						time: 1500
					});
				}
			}
		},
	        error: function(){
			$.gritter.add({
				title: 'Création nas',
				text: 'Erreur lors de la création du nas dans la base de données.',
				time: 1500
			});
    		}
	});
}

</script>
