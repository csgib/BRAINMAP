<div class='CONTENT_SUB'>
	
<h2 class="TITLE_N0 TITLE_BLUE TITLE_CENTER_IT TITLE_BORDER_IT">Paramètres du schéma</h2>

<div id='DETAIL_PARAM' style="position: absolute; top: 40px; left:0px; overflow: hidden; width: 58%; bottom: 10px;">

	<form method="post" action="insert_settings.php" id="FORMULAIRE">
	<input type="hidden" name="SITE" id="SITE">
	<table width="100%">
		<tr>
			<td style="width: 150px; text-align: right;">
				Nom de l'établissement
			</td>
			<td>
				<input class="wid_1" type="text" id="FRM_SITE_NOM" name="FRM_SITE_NOM" placeholder="Nom du site" maxlength="65" size="40" class="requis">
			</td>
		</tr>
		<tr>
			<td style="width: 150px; text-align: right;">
				Adresse
			</td>
			<td>
				<input class="wid_1" type="text" id="FRM_SITE_ADRESSE" name="FRM_SITE_ADRESSE" placeholder="Adresse du site" maxlength="65" size="40" class="requis">
			</td>
		</tr>
		<tr>
			<td style="width: 150px; text-align: right;">
			</td>
			<td>
				<input class="wid_3" type="text" id="FRM_SITE_POSTAL" name="FRM_SITE_POSTAL" placeholder="Postal" maxlength="6" size="8" class="requis">
				<input class="wid_2" type="text" id="FRM_SITE_VILLE" name="FRM_SITE_VILLE" placeholder="Commune" maxlength="65" size="40" class="requis">
			</td>
		</tr>
	</table>
	
	
	<input type="hidden" id="color_1" name="color_1" value="#123456" />
	<input type="hidden" id="color_2" name="color_2" value="#123456" />
	<input type="hidden" id="color_3" name="color_3" value="#123456" />
	<input type="hidden" id="color_4" name="color_4" value="#123456" />
	</form>
	
	<br><br>
	
	<table style="width:100%;">
		<tr>
			<td><center><div id="cp_1"></div></center></td>
			<td><center><div id="cp_2"></div></center></td>
			<td><center><div id="cp_3"></div></center></td>
			<td><center><div id="cp_4"></div></center></td>
		</tr>
		<tr>
			<td class="WHEEL_TD"><center>Couleur lien routeur</center></td>
			<td class="WHEEL_TD"><center>Couleur lien serveur</center></td>
			<td class="WHEEL_TD"><center>Couleur lien ethernet</center></td>
			<td class="WHEEL_TD"><center>Couleur lien fibre optique</center></td>
		</tr>
	</table>

</div>

<div id="map-canvas" style="position: absolute; top: 40px; right:10px; border: 1px solid #EAEAEA; width: 40%; bottom: 10px;"></div>

</div>

<div class="BOTTOM_BUTTONS">
	<button class='main_bt' type='button' onClick='javascript:valide_formulaire_settings()'>Valider</button>
	<button class='main_bt_inv' onClick='javascript:close_sub_window()'>Retour</button>
</div>

<script type="text/javascript">

$('#cp_1').farbtastic('#color_1');
$('#cp_2').farbtastic('#color_2');
$('#cp_3').farbtastic('#color_3');
$('#cp_4').farbtastic('#color_4');

$.farbtastic('#cp_1').setColor(sessionStorage.getItem("CL1"));
$.farbtastic('#cp_2').setColor(sessionStorage.getItem("CL2"));
$.farbtastic('#cp_3').setColor(sessionStorage.getItem("CL3"));
$.farbtastic('#cp_4').setColor(sessionStorage.getItem("CL4"));

$("#SITE").val(sessionStorage.getItem("SITKEY"));
$("#FRM_SITE_NOM").val(sessionStorage.getItem("SITE_DES"));
$("#FRM_SITE_ADRESSE").val(sessionStorage.getItem("SITE_ADR"));
$("#FRM_SITE_POSTAL").val(sessionStorage.getItem("SITE_CPO"));
$("#FRM_SITE_VILLE").val(sessionStorage.getItem("SITE_VIL"));

function initialize_map(lat,lng, loc) 
{
	var ouca = new google.maps.LatLng(lat, lng);
	var myOptions = {
		zoom: 15,
		center: ouca,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		mapTypeControl: false,
		navigationControl: true,
		panControl: false,
        styles: [{
            featureType: 'administrative',
            elementType: 'geometry',
            stylers: [
              { visibility: 'on' },
              { hue: '#78866B' },
              { lightness: 0 },
              { saturation: -100 },
              { weight: 1 }
            ]
          },
          {
            featureType: 'road',
            elementType: 'geometry',
            stylers: [
              { visibility: 'on' }
            ]            
          },
          {
            featureType: 'poi',
            elementType: 'geometry',
            stylers: [
              { visibility: 'off' }
            ]            
          }          
        ]		
	}
	map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
	map.setCenter(loc);
	var marker = new google.maps.Marker({
		map: map,
		position: loc
	});
}

function valide_formulaire_settings()
{
	// *** AJOUT / MODIFICATION DANS LA BASE DE DONNEES ***
	
	var site_adr = $("#FRM_SITE_ADRESSE").val() + " " + $("#FRM_SITE_POSTAL").val() + " " + $("#FRM_SITE_VILLE").val();
	$("#map-canvas").gmap3({
	  getlatlng:{
	    address:  site_adr,
	    callback: function(results){
		if ( !results )
		{
			valide_formulaire_settings_step_2("-1","-1");
		}
		else
		{
			valide_formulaire_settings_step_2(results[0].geometry.location.lat(), results[0].geometry.location.lng());
		}
	    }
	  }
	});
	
	return;
}

function valide_formulaire_settings_step_2(lat, lng)
{
	alert(lat + " " + lng);
	var regtxt2 = new RegExp("\"|\'");
	var errors = 0;

	$(".requis").each(function(i){

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
			text: 'Certains champs obligatoires ne sont pas renseignés ou ils contiennent des caractère interdits tels \' ou "',
			time: 2500
		});
		return false;
	}

	$.ajax({
		data: $("#FORMULAIRE").serialize(),
		type: $("#FORMULAIRE").attr("method"),
		url: "insert_settings.php?LAT=" + lat + "&LNG=" + lng,
		success: function(response) {
			$("#LOCK_SCREEN").fadeOut(400);
			$("#MODAL_ADD").fadeOut(400);

			sessionStorage.setItem('SITE_DES', $('#FRM_SITE_NOM').val());
			sessionStorage.setItem('SITE_ADR', $('#FRM_SITE_ADRESSE').val());
			sessionStorage.setItem('SITE_CPO', $('#FRM_SITE_POSTAL').val());
			sessionStorage.setItem('SITE_VIL', $('#FRM_SITE_VILLE').val());

			sessionStorage.setItem('CL1', $('#color_1').val());
			sessionStorage.setItem('CL2', $('#color_2').val());
			sessionStorage.setItem('CL3', $('#color_3').val());
			sessionStorage.setItem('CL4', $('#color_4').val());

		
			$('#SUB_LEFT_DATAS').html("<h2 style=\'padding: 0px; margin: 0px;\' class=\'TITLE_N1\'>" + sessionStorage.getItem('SITKEY') + " " + sessionStorage.getItem('SITE_DES') + "</h2><br>" + sessionStorage.getItem('SITE_ADR') + "<br>" + sessionStorage.getItem('SITE_CPO') + " " + sessionStorage.getItem('SITE_VIL') + " <div id=\'BT_CONFIG\' onclick=\'javascript:edit_settings()\'></div><div id=\'BT_DELETE_SITE\' onclick=\'javascript:delete_site()\' title=\'Supprimez votre schéma\'></div>");
			$('#ZONE_NOM_SITE').html($('#FRM_SITE_NOM').val() + " - " + $('#FRM_SITE_VILLE').val());
			
			join();
		},
		error: function(){
			$.gritter.add({
				title: 'Paramètres',
				text: 'Erreur lors de la mise à jour des paramètres du site.',
				time: 1500
			});
    		}
	});
}

</script>
