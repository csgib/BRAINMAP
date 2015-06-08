<h2 class="TITLE_N0 TITLE_BLUE TITLE_CENTER_IT TITLE_BORDER_IT">CONTACTS</h2>

<div id="SUPPORT_EDITING_PARAM" style="position: absolute; left: 0px; top: 40px; right: 0px; bottom: 50px; overflow-x: hidden; overflow-y: auto;">

    <form method="post" action="update_contacts.php" id="FRM_NEW_CONTACT" onsubmit="return false">
	    <input type='hidden' id='FRM_NEW' name='FRM_NEW' value='0'>
	    <input type='hidden' id='FRM_SITE' name='FRM_SITE'>
	    <h2 class="TITLE_N3" style="padding: 0px; margin: 0px; padding-left: 8px;">Nom / Prénom</h2>
	    <input type='text' id='FRM_NAME' name='FRM_NAME' placeholder='Nom et prénom du contact' class='wid_1 requis'>
	    <h2 class="TITLE_N3" style="padding: 0px; margin: 0px; padding-left: 8px;">Téléphone</h2>	    
	    <input type='text' id='FRM_TEL' name='FRM_TEL' placeholder='Téléphone' class='wid_1'>
	    <h2 class="TITLE_N3" style="padding: 0px; margin: 0px; padding-left: 8px;">Fonction</h2>	    
	    <input type='text' id='FRM_FONCTION' name='FRM_FONCTION' placeholder='Fonction du contact' class='wid_1'>
    </form>
    
</div>

<div class="BOTTOM_BUTTONS">
    <button class='main_bt' onclick='javascript:valide_contact();'>Valider</button>
    <button id="BTCOLSEUP" class='main_bt_inv' onclick='javascript:bye_something();'>Fermer</button>
</div>

<?php

	if ( isset($_GET['ID']) )
	{
		require "Class/class_contacts.php";

		$hdl_contact = new Contact();
		$hdl_contact->_id = $_GET['ID'];
		$result_contact = json_decode($hdl_contact->get_contact_from_id());
		
		echo "<script type='text/javascript'>";
		
		echo "$('#FRM_NEW').val('" . $_GET['ID'] . "');";
		echo "$('#FRM_NAME').val('" . addslashes($result_contact[0]->CONTACTS_NOM) . "');";
		echo "$('#FRM_TEL').val('" . addslashes($result_contact[0]->CONTACTS_TELEPHONE) . "');";
		echo "$('#FRM_FONCTION').val('" . addslashes($result_contact[0]->CONTACTS_FONCTION) . "');";
		
		echo "</script>";
	}

?>

<script type="text/javascript">

$("#FRM_SITE").val(sessionStorage.getItem('SITKEY'));

function valide_contact()
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
                        text: 'Certains champs obligatoires ne sont pas correctement renseignés',
                        time: 2500
                });
                return false;
        }

	// *** AJOUT / MODIFICATION DANS LA BASE DE DONNEES ***

	$.ajax({
                data: $("#FRM_NEW_CONTACT").serialize(),
                type: $("#FRM_NEW_CONTACT").attr("method"),
                url: $("#FRM_NEW_CONTACT").attr("action"),
                success: function(response) {
			// *** CHARGEMENT DES CONTACTS DU SITE ***
			
			$.ajax({
				url: "reload_contacts.php?SITE=" + sessionStorage.getItem('SITKEY'),
				success: function(response) {
					$('#INFORMATION_DIV').html(response);
					bye_something();
				}
			});
		},
		error: function(){
			$.gritter.add({
				title: 'CONTACTS',
				text: 'Erreur lors de la mise a jour dans la base de données.',
				time: 1500
			});
    		}
	});
}

</script>
