<div class='CONTENT_SUB'>
	
<h2 class="TITLE_N0 TITLE_BLUE TITLE_CENTER_IT TITLE_BORDER_IT">Zone de groupe</h2>

<form method="post" action="insert_zone.php" id="FORMULAIRE" onsubmit="return false">
	<table>
		<tr><td class="rubrique">Nom</td><td class="fields"><input class='wid_1' type="text" name="FRM_ZONE_NAME" id="FRM_ZONE_NAME" placeholder="Descriptif de la zone de groupe" maxlength="45" size="25" class="requis"></td></tr>

		<tr><td class="rubrique">Couleur de la zone</td><td class="fields">
			<input type='hidden' id='color_1' name='color_1' value='#123456' />
			<div id='cp_1'></div>
		</td></tr>
		
	</table>

	<input type='hidden' name='SITE' id='SITE'>
	<?php

		echo "<input type='hidden' name='ISNEW' id='ISNEW' value='0'>";

		if ( isset($_GET['ID']) )
		{
			echo "<input type='hidden' name='FRM_SITE' id='FRM_SITE' value='" . $_GET['SITE'] . "'>";
			echo "<input type='hidden' name='FRM_ID' id='FRM_ID' value='" . substr($_GET['ID'],1) . "'>";

			// *** RECUPERATION DES VALEURS SI EDITION ***
			require "Class/class_zones.php";

			$hdl_zone = new Zone();
			$hdl_zone->_id = substr($_GET['ID'],1);
			$hdl_zone->_site = $_GET['SITE'];

			$result = json_decode($hdl_zone->get_zone_from_id());

			if ( count($result) > 0 )
			{
				echo "<script type='text/javascript'>";

				echo "$('#FRM_ZONE_NAME').val('" . addslashes($result[0]->ZONES_NOM) . "');";
				echo "$('#ISNEW').val('1');";
				echo "$('#cp_1').farbtastic('#color_1');";
				
				if ( empty($result[0]->ZONES_COLOR) )
				{
					echo "$.farbtastic('#cp_1').setColor(\"#DCDCDC\");";
				}
				else
				{
					echo "$.farbtastic('#cp_1').setColor(\"" . $result[0]->ZONES_COLOR . "\");";
				}

				echo "</script>";
			}

		}
		else
		{
			echo "<input type='hidden' name='X' id='X' value='" . $_GET['X'] . "'>";
			echo "<input type='hidden' name='Y' id='Y' value='" . $_GET['Y'] . "'>";
			echo "<script type='text/javascript'>";
			echo "$('#cp_1').farbtastic('#color_1');";
			echo "$.farbtastic('#cp_1').setColor(\"#DCDCDC\");";
			echo "</script>";
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
				create_zone_on_map(response.replace(/^\s+/g,'').replace(/\s+$/g,''), $("#FRM_ZONE_NAME").val(), $("#X").val(), $("#Y").val(),250,150, $("#color_1").val());

				$("#LOCK_SCREEN").fadeOut(400);
				$("#MODAL_ADD").fadeOut(400);
			}
			else
			{
				if ( $('#ISNEW').val() == "1" )
				{
					var wl_red = hexToRgb($("#color_1").val()).r;
					var wl_green = hexToRgb($("#color_1").val()).g;
					var wl_blue = hexToRgb($("#color_1").val()).b;
					
					$("#Z" + $("#FRM_ID").val()).css("background-color","rgba(" + wl_red + "," + wl_green + "," + wl_blue + ",0.2)");
					$("#Z" + $("#FRM_ID").val()).css("border-color","rgba(" + wl_red + "," + wl_green + "," + wl_blue + ",0.4)");

					$("#Z" + $("#FRM_ID").val() + " > .ZONE_TITLE").html($('#FRM_ZONE_NAME').val());

					$("#LOCK_SCREEN").fadeOut(400);
					$("#MODAL_ADD").fadeOut(400);
				}
				else
				{
					$.gritter.add({
						title: 'Création zone',
						text: 'Erreur lors de la création de la zone de groupe dans la base de données.',
						time: 1500
					});
				}
			}
		},
	        error: function(){
			$.gritter.add({
				title: 'Création zone',
				text: 'Erreur lors de la création de la zone de groupe dans la base de données.',
				time: 1500
			});
    		}
	});
}

</script>
