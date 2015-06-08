<div class='CONTENT_SUB'>
	
<h2 class="TITLE_N0 TITLE_BLUE TITLE_CENTER_IT TITLE_BORDER_IT">Camera IP</h2>

<form method="post" action="insert_camera.php" id="FORMULAIRE" onsubmit="return false">
	<table>
		<tr><td class="rubrique">Description</td><td class="fields"><input class='wid_1' type="text" name="FRM_CAMERA_NOM" id="FRM_CAMERA_NOM" placeholder="Nom de la caméra" maxlength="45" size="25"></td></tr>
		<tr><td class="rubrique">Adresse IP</td><td class="fields"><input class='wid_1 ip' type="text" name="FRM_CAMERA_IP" id="FRM_CAMERA_IP" placeholder="Adresse IP" maxlength="45" size="25"></td></tr>
		<tr><td class="rubrique">Descriptif</td><td class="fields"><textarea name="FRM_CAMERA_DSC" id="FRM_CAMERA_DSC" rows="10" cols="80" placeholder="Informations complémentaires"></textarea></td></tr>

		
	</table>

	<input type='hidden' name='SITE' id='SITE'>
	<?php

		echo "<input type='hidden' name='ISNEW' id='ISNEW' value='0'>";

		if ( isset($_GET['ID']) )
		{
			echo "<input type='hidden' name='FRM_SITE' id='FRM_SITE' value='" . $_GET['SITE'] . "'>";
			echo "<input type='hidden' name='FRM_ID' id='FRM_ID' value='" . substr($_GET['ID'],1) . "'>";

			// *** RECUPERATION DES VALEURS SI EDITION ***
			require "Class/class_cameras.php";

			$hdl_camera = new Camera();
			$hdl_camera->_id = substr($_GET['ID'],1);
			$hdl_camera->_site = $_GET['SITE'];

			$result = json_decode($hdl_camera->get_camera_from_id());

			if ( count($result) > 0 )
			{
				echo "<script type='text/javascript'>";

				echo "$('#FRM_CAMERA_NOM').val('" . addslashes($result[0]->CAMERAS_NOM) . "');";
				echo "$('#FRM_CAMERA_IP').val('" . $result[0]->CAMERAS_IP . "');";
				echo "$('#FRM_CAMERA_DSC').val('" . addslashes($result[0]->CAMERAS_DESCRIPTIF) . "');";
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
			text: 'Certains champs obligatoires ne sont pas renseignés ou mal renseignés',
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
				create_camera_on_map(response.replace(/^\s+/g,'').replace(/\s+$/g,''), $("#X").val(), $("#Y").val(),$("#FRM_CAMERA_NOM").val());

				$("#LOCK_SCREEN").fadeOut(400);
				$("#MODAL_ADD").fadeOut(400);
			}
			else
			{
				if ( $('#ISNEW').val() == "1" )
				{				
					$("#K" + $("#FRM_ID").val() + " > .CAMERA_TITLE").html($('#FRM_CAMERA_NOM').val());

					$("#LOCK_SCREEN").fadeOut(400);
					$("#MODAL_ADD").fadeOut(400);
				}
				else
				{
					$.gritter.add({
						title: 'Création camera',
						text: 'Erreur lors de la création de la camera dans la base de données.',
						time: 1500
					});
				}
			}
		},
	        error: function(){
			$.gritter.add({
				title: 'Création camera',
				text: 'Erreur lors de la création de la camera dans la base de données.',
				time: 1500
			});
    		}
	});
}

</script>
