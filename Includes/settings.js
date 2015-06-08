function edit_settings()
{
	$.ajax({
		type:"GET",
		url:"edit_settings.php?SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN").fadeIn(400);
			$("#MODAL_ADD").fadeIn(400);
			
			var geocoder;
			var map;
			var markers = new Array();
			geocoder = new google.maps.Geocoder();

			var address = sessionStorage.getItem("SITE_ADR") + " " + sessionStorage.getItem("SITE_CPO") + " " + sessionStorage.getItem("SITE_VIL");
			geocoder.geocode( { 'address': address}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) 
				{
					initialize_map(results[0].geometry.location.lat(),results[0].geometry.location.lng(),results[0].geometry.location);
				}
				else
				{
					$("#map-canvas").html("<img src='Images/mapnull.jpg' style='width: 100%; height: 100%;'>");
				} 
			});
		}
	});
}

// ****************************************
// *** GESTION DES DONNEES DES CONTACTS ***
// ****************************************

function edit_contacts()
{
	$.ajax({
		type:"GET",
		url:"edit_contacts.php?SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN").fadeIn(400);
			$("#MODAL_ADD").fadeIn(400);
		}
	});
}

// *******************************************
// *** GESTION DES DONNEES DES ORDINATEURS ***
// *******************************************

function edit_computers()
{
	$.ajax({
		type:"GET",
		url:"edit_computers.php?SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN").fadeIn(400);
			$("#MODAL_ADD").fadeIn(400);
		}
	});
}

// **********************************************************************
// *** PARTIE COMMUNE POUR GESTION DES COMBOS DE SELECTIONS DES PORTS ***
// **********************************************************************

// *** CHARGEMENT DES CARTES RESEAUX DU SERVEUR ***
function f_load_serveur_port(id, tport)
{
	$.ajax({
		url: "load_server_port.php?SITE=" + sessionStorage.getItem("SITKEY") + "&ID=" + id + "&TP=" + tport,
		success: function(response) {
			$("#FRM_LINK_PORT").html(response);
			$("#FRM_LINK_PORT").val('').trigger("liszt:updated");

			if ( $("#WA_EDIT").val().length > 0 )
			{
				$("#FRM_LINK_PORT").val($("#WA_EDIT").val()).trigger("liszt:updated");
				$("#FRM_LINK_PORT").trigger("change");
				$("#FRM_SAV_IP").val($("#FRM_LINK_OBJECT").val() + ";" + $("#FRM_LINK_PORT").val());
				$("#WA_EDIT").val("");
			}
		}
	});
}

// *** CHARGEMENT DES PORTS RESEAUX DU SWITCH ***
function f_load_switch_port(id, type)
{
	var wl_table = id.split(';');
	$.ajax({
		url: "load_switch_port.php?SITE=" + sessionStorage.getItem("SITKEY") + "&ID=" + wl_table[0] + "&TYPE=" + type,
		success: function(response) {
			$("#FRM_LINK_PORT").html(response);
			$("#FRM_LINK_PORT").val('').trigger("liszt:updated");

			if ( $("#WA_EDIT").val().length > 0 )
			{
				$("#FRM_LINK_PORT").val($("#WA_EDIT").val()).trigger("liszt:updated");
				$("#FRM_LINK_PORT").trigger("change");
				$("#FRM_SAV_IP").val($("#FRM_LINK_OBJECT").val() + ";" + $("#FRM_LINK_PORT").val());
				$("#WA_EDIT").val("");
			}
		}
	});
}

function f_load_mini_switch_port(id, tport)
{
	$.ajax({
		url: "load_mini_switch_port.php?SITE=" + sessionStorage.getItem("SITKEY") + "&ID=" + id + "&TP=" + tport,
		success: function(response) {
			$("#FRM_LINK_PORT").html(response);
			$("#FRM_LINK_PORT").val('').trigger("liszt:updated");

			if ( $("#WA_EDIT").val().length > 0 )
			{
				$("#FRM_LINK_PORT").val($("#WA_EDIT").val()).trigger("liszt:updated");
				$("#FRM_LINK_PORT").trigger("change");
				$("#FRM_SAV_IP").val($("#FRM_LINK_OBJECT").val() + ";" + $("#FRM_LINK_PORT").val());
				$("#WA_EDIT").val("");
			}
		}
	});
}