<div class='CONTENT_SUB'>
	
<h2 class="TITLE_N0 TITLE_BLUE TITLE_CENTER_IT TITLE_BORDER_IT">Zone de texte</h2>

<form method="post" action="insert_texte.php" id="FORMULAIRE" onsubmit="return false">
	<table>
		<tr><td class="rubrique">Texte</td><td class="fields"><textarea class='wid_1' type="text" name="FRM_ZONE_NAME" id="FRM_ZONE_NAME" placeholder="Texte de la zone de texte" class="requis"></textarea></td></tr>
	
	</table>

	<input type='hidden' name='SITE' id='SITE'>
	<?php

		echo "<input type='hidden' name='ISNEW' id='ISNEW' value='0'>";

		if ( isset($_GET['ID']) )
		{
			echo "<input type='hidden' name='FRM_SITE' id='FRM_SITE' value='" . $_GET['SITE'] . "'>";
			echo "<input type='hidden' name='FRM_ID' id='FRM_ID' value='" . substr($_GET['ID'],1) . "'>";

			// *** RECUPERATION DES VALEURS SI EDITION ***
			require "Class/class_textes.php";

			$hdl_texte = new Texte();
			$hdl_texte->_id = substr($_GET['ID'],1);
			$hdl_texte->_site = $_GET['SITE'];

			$result = json_decode($hdl_texte->get_texte_from_id());

			if ( count($result) > 0 )
			{
				echo "<script type='text/javascript'>";

				echo "$('#FRM_ZONE_NAME').val(" . json_encode($result[0]->TEXTES_TEXT) . ");";
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
				create_texte_on_map(response.replace(/^\s+/g,'').replace(/\s+$/g,''), $("#FRM_ZONE_NAME").val().replace(/\n/g,"<br>"), $("#X").val(), $("#Y").val(),250,150, $("#color_1").val());

				$("#LOCK_SCREEN").fadeOut(400);
				$("#MODAL_ADD").fadeOut(400);
			}
			else
			{
				if ( $('#ISNEW').val() == "1" )
				{
					$("#T" + $("#FRM_ID").val() + " > .TEXTE_TITLE").html($('#FRM_ZONE_NAME').val().replace(/\n/g,"<br>"));

					$("#LOCK_SCREEN").fadeOut(400);
					$("#MODAL_ADD").fadeOut(400);
				}
				else
				{
					$.gritter.add({
						title: 'Création texte',
						text: 'Erreur lors de la création de la zone de texte dans la base de données.',
						time: 1500
					});
				}
			}
		},
	        error: function(){
			$.gritter.add({
				title: 'Création texte',
				text: 'Erreur lors de la création de la zone de texte dans la base de données.',
				time: 1500
			});
    		}
	});
}

</script>
