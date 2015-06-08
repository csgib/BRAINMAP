<div class='CONTENT_SUB'>
	
	<h2 class="TITLE_N0 TITLE_BLUE TITLE_CENTER_IT TITLE_BORDER_IT">BAIE DE BRASSAGE</h2>
	<form method="post" action="insert_baie.php" id="FORMULAIRE" onsubmit="return false">
		
		<table>	
		<tr><td class="rubrique">Nom de la baie</td><td class="fields"><input type="text" name="COMMENTAIRES" id="COMMENTAIRES" placeholder="Nom de la baie" class="requis wid_1"></td></tr>
		<tr><td class="rubrique">Description de la baie</td><td class="fields"><textarea name="FRM_BAIE_DATAS" id="FRM_BAIE_DATAS" rows="10" cols="80" placeholder="Informations complémentaires"></textarea></td></tr>
		<tr><td class="rubrique">Cochez la case si la baie est ondulée</td><td class="fields"><input name='FRM_BAIE_ONDULEE' id='FRM_BAIE_ONDULEE' type='checkbox' class='chk_style'></td></tr>
		</table>
		<?php
			echo "<input type='hidden' name='X' id='X' value='" . $_GET['X'] . "'>";
			echo "<input type='hidden' name='Y' id='Y' value='" . $_GET['Y'] . "'>";
	
			if ( isset($_GET['ID']) )
			{
				// *** RECUPERATION DES VALEURS SI EDITION ***
				require "Class/class_baies.php";
	
				$hdl_baie = new Baie();
				$hdl_baie->_id = $_GET['ID'];
				$result = json_decode($hdl_baie->get_baie_from_id());
	
				echo "<script type='text/javascript'>$('#COMMENTAIRES').val('" . addslashes($result[0]->BAIES_COMMENTAIRES) . "');</script>";
				echo "<input type='hidden' name='IS_NEW' id='IS_NEW' value='0'>";
				echo "<input type='hidden' name='ID_NEW' id='ID_NEW' value='" . $_GET['ID'] . "'>";
	
				echo "<script type='text/javascript'>";
	
				if ( $result[0]->BAIES_ONDULEE == "1" )
				{
					echo "$('#FRM_BAIE_ONDULEE').attr('checked', true);";
				}
	
				echo "$('#FRM_BAIE_DATAS').val('" . addslashes($result[0]->BAIES_DATAS) . "');";
				echo "</script>";
			}
			else
			{
				echo "<input type='hidden' name='IS_NEW' id='IS_NEW' value='1'>";
				echo "<input type='hidden' name='ID_NEW' id='ID_NEW' value='NAN'>";
			}
		?>
			
		<input type='hidden' name='SITE' id='SITE'>
	
	</form>

</div>

<div class="BOTTOM_BUTTONS">
	<button class="main_bt" onClick='javascript:valide_formulaire()'>Valider</button>
	<button class="main_bt_inv" onClick='javascript:close_sub_window()'>Annuler</button>
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
			if ( response.replace(/^\s+/g,'').replace(/\s+$/g,'') != "UPDATE" )
			{
				if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 )
				{
					if ( $('#FRM_BAIE_ONDULEE').is(':checked') )
					{
						create_baie_on_map(response.replace(/^\s+/g,'').replace(/\s+$/g,''),$("#COMMENTAIRES").val(),$("#X").val(),$("#Y").val(),1);
					}
					else
					{
						create_baie_on_map(response.replace(/^\s+/g,'').replace(/\s+$/g,''),$("#COMMENTAIRES").val(),$("#X").val(),$("#Y").val(),0);
					}


					$("#LOCK_SCREEN").fadeOut(400);
					$("#MODAL_ADD").fadeOut(400);
				}
				else
				{
					$.gritter.add({
						title: 'Création / modification baie',
						text: 'Erreur lors de la création / modification de la baie dans la base de données.',
						time: 1500
					});
				}
			}
			else
			{
				$("#" + $("#ID_NEW").val() + " > .BAIE_TITLE").html($('#COMMENTAIRES').val()); 

				if ( $('#FRM_BAIE_ONDULEE').is(':checked') )
				{
					 $("#" + $("#ID_NEW").val() + " > .BAIE_SUPPORT").addClass("ONDULEE");
				}
				else
				{
					 $("#" + $("#ID_NEW").val() + " > .BAIE_SUPPORT").removeClass("ONDULEE");
				}

				$("#LOCK_SCREEN").fadeOut(400);
				$("#MODAL_ADD").fadeOut(400);
			}
		},
	        error: function(){
			$.gritter.add({
				title: 'Création baie',
				text: 'Erreur lors de la création / modification de la baie dans la base de données.',
				time: 1500
			});
    		}
	});
}

</script>
