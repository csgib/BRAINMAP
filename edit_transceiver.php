<div class='CONTENT_SUB'>
	
<h2 class="TITLE_N0 TITLE_BLUE TITLE_CENTER_IT TITLE_BORDER_IT">Transceiver</h2>

<form method="post" action="insert_transceiver.php" id="FORMULAIRE" onsubmit="return false">
	<table>
		<tr><td class="rubrique">Libellé</td><td class="fields"><input class='wid_1 requis' type="text" name="FRM_TRANSCEIVER_LIBELLE" id="FRM_TRANSCEIVER_LIBELLE" placeholder="Libellé du transceiver" maxlength="20" size="25"></td></tr>
		<tr><td class="rubrique">Constructeur</td><td class="fields"><input class='wid_1' type="text" name="FRM_TRANSCEIVER_CONSTRUCTEUR" id="FRM_TRANSCEIVER_CONSTRUCTEUR" placeholder="Constructeur" maxlength="45" size="25"></td></tr>

		
		<?php
		
			if ( isset($_GET['ID']) )
			{
				require "Class/class_liens.php";
				require "Class/class_transcievers.php";
		
				$hdl_transceiver		= new Transceiver();
				$hdl_transceiver->_site		= $_GET['SITE'];
				
				$hdl_lien			= new Lien();
				$hdl_lien->_site		= $_GET['SITE'];
				
				$hdl_lien->_src_id = $_GET['ID'];  
				$result_lien = json_decode($hdl_lien->get_liens_dst_for_trans());
				
				if ( empty($result_lien[0]->LIENS_SRC_ID) )
				{
					$var_co_obj = "";
					
					$result_transcievers = json_decode( $hdl_transceiver->get_all_transceivers() );
					$j = 0;
					while ( $j < count($result_transcievers) )
					{
						if ( "T" . $result_transcievers[$j]->TRANSCEIVERS_ID != $_GET['ID'] )
						{
							$var_co_obj .= "<option value='T" . $result_transcievers[$j]->TRANSCEIVERS_ID . "'>" . $result_transcievers[$j]->TRANSCEIVERS_LIBELLE . "</option>";
						}
						$j++;
					}			
		
		?>

				<tr><td class="rubrique">Lié a un autre transceiver</td><td class="fields">
					
					<select id="FRM_LINK_OBJECT" class="FRM_LINK_OBJECT" name="FRM_LINK_OBJECT" style="width: 96%;">
						
						<option></option>
						
						<?php
						
							echo $var_co_obj;
						
						?>
						
					</select>
					
				</td></tr>
		
		<?php
				}
				else
				{
					echo "<tr><td class='rubrique'></td><td class='fields'><center>Lié a un autre transceiver</center></td></tr>";
				}
			}
		?>
	</table>

	<input type='hidden' name='SITE' id='SITE'>
	<?php

		echo "<input type='hidden' name='ISNEW' id='ISNEW' value='0'>";

		if ( isset($_GET['ID']) )
		{
			echo "<input type='hidden' name='FRM_SITE' id='FRM_SITE' value='" . $_GET['SITE'] . "'>";
			echo "<input type='hidden' name='FRM_ID' id='FRM_ID' value='" . substr($_GET['ID'],1) . "'>";

			// *** RECUPERATION DES VALEURS SI EDITION ***

			$hdl_transceiver->_id = substr($_GET['ID'],1);
			$hdl_transceiver->_site = $_GET['SITE'];

			$result = json_decode($hdl_transceiver->get_transceiver_from_id());

			if ( count($result) > 0 )
			{
				echo "<script type='text/javascript'>";

				echo "$('#FRM_TRANSCEIVER_LIBELLE').val('" . addslashes($result[0]->TRANSCEIVERS_LIBELLE) . "');";
				echo "$('#FRM_TRANSCEIVER_CONSTRUCTEUR').val('" . $result[0]->TRANSCEIVERS_CONSTRUCTEUR . "');";
				echo "$('#ISNEW').val('1');";
				
				$hdl_lien->_src_id = $_GET['ID'];
				$result_lien = json_decode($hdl_lien->get_liens_for_trans());
			
				if ( count($result_lien) > 0 )
				{
					echo "$('#FRM_LINK_OBJECT').val('" . $result_lien[0]->LIENS_DST_ID . "');";
				}
			
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
				create_transceiver_on_map(response.replace(/^\s+/g,'').replace(/\s+$/g,''), $("#X").val(), $("#Y").val(),$("#FRM_TRANSCEIVER_LIBELLE").val());

				$("#LOCK_SCREEN").fadeOut(400);
				$("#MODAL_ADD").fadeOut(400);
			}
			else
			{
				if ( $('#ISNEW').val() == "1" )
				{				
					$("#T" + $("#FRM_ID").val() + " > .TRANSCEIVER_TITLE").html($('#FRM_TRANSCEIVER_LIBELLE').val());
										
					$.ajax({
						type: 'GET',
						url: "reload_links.php?SITE=" + sessionStorage.getItem("SITKEY"),
						success: function(response) {
							eval(response);
							join();
						}
					});					
					
					$("#LOCK_SCREEN").fadeOut(400);
					$("#MODAL_ADD").fadeOut(400);
				}
				else
				{
					$.gritter.add({
						title: 'Création transceiver',
						text: 'Erreur lors de la création du transceiver dans la base de données.',
						time: 1500
					});
				}
			}
		},
	        error: function(){
			$.gritter.add({
				title: 'Création transceiver',
				text: 'Erreur lors de la création du transceiver dans la base de données.',
				time: 1500
			});
    		}
	});
}

</script>
