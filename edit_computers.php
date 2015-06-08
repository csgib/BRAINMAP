<h2 class="TITLE_N0 TITLE_BLUE TITLE_CENTER_IT TITLE_BORDER_IT">ORDINATEURS</h2>

<div id="SUPPORT_EDITING_PARAM" style="position: absolute; left: 0px; top: 40px; right: 0px; bottom: 50px; overflow-x: hidden; overflow-y: auto;">

	<form method="post" action="update_computers.php" id="FRM_NEW_COMPUTER" onsubmit="return false">
	
		<input type='hidden' id='FRM_NEW' name='FRM_NEW' value='0'>
		<input type='hidden' id='FRM_SITE' name='FRM_SITE'>
		<h2 class="TITLE_N3" style="padding: 0px; margin: 0px; padding-left: 8px;">Nom de la machine</h2>
		<input type='text' id='FRM_HOSTNAME' name='FRM_HOSTNAME' placeholder='Nom d hôte' maxlength='65' size='45' class='requis'>
		<h2 class="TITLE_N3" style="padding: 0px; margin: 0px; padding-left: 8px;">Système d'exploitation</h2>
		<select name='FRM_OS' id='FRM_OS' style='width:160px;'>
			<option value='W'>Windows</option>
			<option value='L'>Linux</option>
			<option value='O'>OSX</option>
		</select>
		<h2 class="TITLE_N3" style="padding: 0px; margin: 0px; padding-left: 8px;">Version du système d'exploitation</h2>
		<input type='text' id='FRM_RELEASE' name='FRM_RELEASE' placeholder='Version OS' maxlength='45' size='45' class='requis'>
		<h2 class="TITLE_N3" style="padding: 0px; margin: 0px; padding-left: 8px;">Adresse IP de l'ordinateur</h2>
		<input type='text' id='FRM_IP' name='FRM_IP' placeholder='Adresse IP' maxlength='45' size='45' class='requis'>
		<h2 class="TITLE_N3" style="padding: 0px; margin: 0px; padding-left: 8px;">Port VNC pour télémaintenance</h2>
		<input type='text' id='FRM_VNC_PORT' name='FRM_VNC_PORT' placeholder='Port VNC' maxlength='6' size='45'>
	
	</form>
	
	<center><button id='BT_TELE' onclick='javascript:go_telemaintenance()' class='main_bt_nwar' style='float: none; position: relative;'>Télémaintenance</button></center>

</div>
	
<div class="BOTTOM_BUTTONS" >
    <button class='main_bt' onclick='javascript:valide_contact();'>Valider</button>
    <button id="BTCOLSEUP" class='main_bt_inv' onclick='javascript:bye_something();'>Fermer</button>
</div>

<?php

	if ( isset($_GET['ID']) )
	{
		require "Class/class_computers.php";

		$hdl_computer = new Computer();
		$hdl_computer->_id = $_GET['ID'];
		$result_computer = json_decode($hdl_computer->get_computer_from_id());
		
		echo "<script type='text/javascript'>";
		
		echo "$('#FRM_NEW').val('" . $_GET['ID'] . "');";
		echo "$('#FRM_HOSTNAME').val('" . addslashes($result_computer[0]->COMPUTERS_HOSTNAME) . "');";
		echo "$('#FRM_IP').val('" . addslashes($result_computer[0]->COMPUTERS_IP) . "');";
		echo "$('#FRM_OS').val('" . addslashes($result_computer[0]->COMPUTERS_OS) . "');";
		echo "$('#FRM_RELEASE').val('" . addslashes($result_computer[0]->COMPUTERS_RELEASE) . "');";
		echo "$('#FRM_VNC_PORT').val('" . addslashes($result_computer[0]->COMPUTERS_VNC_PORT) . "');";
		echo "$('#BT_TELE').fadeIn(200);";
		
		echo "</script>";
	}
	else
	{
		echo "<script type='text/javascript'>";
		echo "$('#BT_TELE').hide();";
		echo "</script>";
	}

?>

<script type="text/javascript">
	
$("#FRM_SITE").val(sessionStorage.getItem('SITKEY'));

function go_telemaintenance()
{
	open_vnc($('#FRM_IP').val(),$('#FRM_VNC_PORT').val());
}

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
                data: $("#FRM_NEW_COMPUTER").serialize(),
                type: $("#FRM_NEW_COMPUTER").attr("method"),
                url: $("#FRM_NEW_COMPUTER").attr("action"),
                success: function(response) {
			// *** CHARGEMENT DES CONTACTS DU SITE ***
			
			$.ajax({
				url: "reload_computers.php?SITE=" + sessionStorage.getItem('SITKEY'),
				success: function(response) {
					$('#COMPUTERS_DIV').html(response);
					bye_something();
				}
			});
		},
		error: function(){
			$.gritter.add({
				title: 'ORDINATEURS',
				text: 'Erreur lors de la mise a jour dans la base de données.',
				time: 1500
			});
    		}
	});}

</script>
