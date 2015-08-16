<?php
@header('Content-type: text/html; charset=utf-8');
?>

<html>
<head>
	
<title>BRAINMAP - Schémas réseaux</title>
<meta charset="UTF8"></meta>
<meta http-equiv="X-UA-Compatible" content="IE=9,chrome=1" />
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">

<script src="Plugins/jquery.js" type="text/javascript"></script>
<script src="Plugins/jquery-ui.js" type="text/javascript"></script>
<script src="Plugins/jquery.gritter.js" type="text/javascript"></script>
<script src="Plugins/jquery.checkbox.js" type="text/javascript"></script>
<script src="Plugins/jquery.farbtastic.js" type="text/javascript"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script src="Plugins/gmap3-master/dist/gmap3.min.js" type="text/javascript"></script>

<script src="Includes/baies.js" type="text/javascript"></script>
<script src="Includes/benchs.js" type="text/javascript"></script>
<script src="Includes/switchs.js" type="text/javascript"></script>
<script src="Includes/serveurs.js" type="text/javascript"></script>
<script src="Includes/routeurs.js" type="text/javascript"></script>
<script src="Includes/nas.js" type="text/javascript"></script>
<script src="Includes/modals.js" type="text/javascript"></script>
<script src="Includes/draw.js" type="text/javascript"></script>
<script src="Includes/settings.js" type="text/javascript"></script>
<script src="Includes/sites.js" type="text/javascript"></script>
<script src="Includes/zones.js" type="text/javascript"></script>
<script src="Includes/cameras.js" type="text/javascript"></script>
<script src="Includes/antennes.js" type="text/javascript"></script>
<script src="Includes/transceiver.js" type="text/javascript"></script>
<script src="Includes/textes.js" type="text/javascript"></script>
<script src="Includes/help.js" type="text/javascript"></script>
<script src="Includes/grab.js" type="text/javascript"></script>
<script src="Includes/popupinfo.js" type="text/javascript"></script>
<script src="Plugins/upload.js" type="text/javascript"></script>
<script src="Plugins/html2canvas.js" type="text/javascript"></script>
<!-- INCLUDE DES FEUILLES DE STYLE -->

<link rel="stylesheet" type="text/css" href="Css/jquery-ui.css" media="screen">
<link rel="stylesheet" type="text/css" href="Css/main.css" media="screen">
<link rel="stylesheet" type="text/css" href="Css/gritter.css" media="screen">
<link rel="stylesheet" type="text/css" href="Css/checkbox.css" media="screen">
<link rel="stylesheet" type="text/css" href="Css/help.css" media="screen">

</head>

<body>

<div id="SCREENY" style="position: fixed; overflow: hidden;">

	<div id="MAIN_MENU">
		<div id="LOGO_ADR"></div>
		<button id="BT_TOP_M_1" class='main_bt' style='margin-top: 5px;' onclick="javascript:new_scheme()">Nouveau schéma</button>
		<button id="BT_TOP_M_4" class='main_bt_inv' style='margin-top: 5px; display: none;' onclick="javascript:close_geo()">Retour</button>
		<button id="BT_TOP_M_2" class='main_bt' style='margin-top: 5px;' onclick="javascript:open_geo()">Géolocaliser</button>
		<button id="BT_TOP_M_3" class='main_bt' style='margin-top: 5px; display: none;' onclick="javascript:open_diag()">Diagnostiquer</button>
	</div>

	<div id="FIND_ME_SCHEMA">
		<center><input id="FILTER_NAME" type="text" style="width: 180px;" placeholder="Rechercher un schéma" onkeyup="javascript:filter_sites()" /></center>
	</div>
	
	<div id="MAP_LISTE">

		<div id="MAP_LISTE_SCROLLER">

			<ul id="MAP_LISTE_UL">
			<?php
				require "Class/class_sites.php";

				$hdl_site = new Site();

				$result_site = json_decode($hdl_site->get_all_sites());

				$i = 0;
				$tabsite = "<option></option>";
				
				while ( $i < count($result_site) )
				{
					$tabsite .= "<option value='" . $result_site[$i]->SITES_ID . "'>" . $result_site[$i]->SITES_ID . " " . $result_site[$i]->SITES_DESCRIPTION . "</option>";
					$i++;
				}
			?>

			</ul>
		</div>
		
		<div id="SUPPORT_SCROLLER_V_INDEX">
			<div id="SCROLLER_V_INDEX"></div>
		</div>
	</div>

	<div id="LOCK_LST_GRAPH">

		<div id="NEW_GRAPH" class="MODAL_ADD">
			<h2 class="TITLE_N0 TITLE_BLUE TITLE_CENTER_IT TITLE_BORDER_IT">NOUVEAU SCHEMA</h2>
			<br><br>
			<form method="post" action="insert_site.php" id="FORMULAIRE_NEW_SCHEME" onsubmit="return false">
				<center><input type="text" name="FRM_NEW_S_CODE" id="FRM_NEW_S_CODE" placeholder="Code du site" maxlength="45" size="45" class="requis2 input_filter2"><br><br>

				<input type="text" name="FRM_NEW_S_LIBELLE" id="FRM_NEW_S_LIBELLE" placeholder="Libellé du site" maxlength="45" size="45" class="requis2 input_filter2">
				<br><br>
			</form>
			
			<h3>Récupération des données d'un autre schéma</h3><br>
			
			<select name='FRM_SITE_DUP' id='FRM_SITE_DUP' class="CL_CHOSEN" style="width:300px;">
			
			<?php echo $tabsite; ?>
			
			</select><br><br>
			
			Sélectionnez les éléments à importer<br><br>
			
			<table>
			<tr>
			<td width='40%'><input id="FRM_DUP_SRV" name="FRM_DUP_SRV" type="checkbox" class='chk_style'>Serveurs</td>
			<td width='40%'><input id="FRM_DUP_ROU" name="FRM_DUP_ROU" type="checkbox" class='chk_style'>Routeurs</td></tr>
			<tr>
			<td><input id="FRM_DUP_NAS" name="FRM_DUP_NAS" type="checkbox" class='chk_style'>NAS</td>
			<td><input id="FRM_DUP_BAI" name="FRM_DUP_BAI" type="checkbox" class='chk_style'>Baies sans les switchs</td>
			</tr></table>
			</center>
			<br><br><br><br><br>
			
			<div class="BOTTOM_BUTTONS">
				<button class='main_bt' type='button' onClick='javascript:valide_formulaire_new_scheme()'>Valider</button>
				<button class='main_bt_inv' onClick='javascript:close_sub_new_scheme()'>Retour</button>
			</div>
		</div>


	</div>

	<div id="APPLICATION_SURFACE"></div>

	<div id="BALL_DIV"><div id="BALL" class="ball"></div></div>

	<div id="MAPGEO"></div>
	
	<?php

		echo "<script type='text/javascript'>
		$('#MAPGEO').gmap3({
		map:{
		   options:{
		    center:[46.811, 1.686],
		    zoom:6,
		    minZoom:5,
		    mapTypeId: google.maps.MapTypeId.ROADMAP,
		    mapTypeControl: false,
		    navigationControl: true,
		    scrollwheel: true,
		    zoomControl: true,
		    panControl: false,
		    zoomControlOptions: {
			style: google.maps.ZoomControlStyle.LARGE,
			position: google.maps.ControlPosition.LEFT_CENTER
		    },
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
				  { visibility: 'off' }
				]            
			  },
			  {
				featureType: 'poi',
				elementType: 'geometry',
				stylers: [
				  { visibility: 'off' }
				]            
			  }          
			],
			streetViewControl: false
		   },
		   autofit:{},
		},";
	    	
		$result_sites = json_decode($hdl_site->get_all_sites());
		
		$wl_i = 0;
		
		echo "marker:{ values:[";
		
		require "Class/class_routeurs.php";

		$hdl_routeur = new Routeur();
		
		while( $wl_i < count($result_sites))
		{
			if ( !is_null($result_sites[$wl_i]->SITES_LAT) && $result_sites[$wl_i]->SITES_LAT != "-1" )
			{
				$hdl_routeur->_site = $result_sites[$wl_i]->SITES_ID;
				
				$result_routeur = json_decode($hdl_routeur->get_all_routeurs());
				
				$wl_routeur = "-1";
				
				if ( !is_null($result_routeur[0]->ROUTEURS_ID)  )
				{
					$wl_routeur = $result_routeur[0]->ROUTEURS_IP_PUBLIQUE;
				}
				
				
				echo "{tag:\"" . $wl_routeur . "#;#" . $result_sites[$wl_i]->SITES_ID . "#;#" . $result_sites[$wl_i]->SITES_DESCRIPTION . "\", latLng: [ " . $result_sites[$wl_i]->SITES_LAT . "," . $result_sites[$wl_i]->SITES_LNG . "],id:\"" . $result_sites[$wl_i]->SITES_ID . "\", options:{icon: \"Images/marker_map.png\"}, events:{
				    click: function(marker, event, context){
					id = (context.id);
			                display_popup_geo(context, marker, id);					
					
				}}}";
				if ( $wl_i < count($result_sites)-1 )
				{
				    echo ",";
				}
			}
			$wl_i++;
		}
		
		echo "]},";
		   
		echo "}); </script>";
	    ?>

</div>

<script type="text/javascript">

var global_site = $("#FRM_SITE_DUP").html();
$('.chk_style').checkbox();

$("#NEW_GRAPH").fadeIn(0);
$(document).bind("contextmenu",function(e){
	return false;
});

$("#FILTER_NAME").val("");

$("#SUPPORT_SCROLLER_V_INDEX").bind("contextmenu",function(e){
	return false;
});

filter_sites();

$("#FILTER_NAME").focus();

$("#SCROLLER_V_INDEX").draggable({
	containment: 'parent',
	axis: "y",
	drag: function() {
		var siz_sup = $("#SUPPORT_SCROLLER_V_INDEX").height() - $("#SCROLLER_V_INDEX").height();
		var pos_y_i = ($(this).position().top*($("#MAP_LISTE_SCROLLER").height()+50))/siz_sup;
		$("#MAP_LISTE_SCROLLER").css("top", "-" + pos_y_i + "px");
	}
});

function load_graph(id)
{
	$("#BALL_DIV").fadeIn(400,function(){
		$.ajax({
			type:"GET",
			url:"graph_main.php?SITE=" + id,
			success: function(retour){
				$("#APPLICATION_SURFACE").empty().append(retour);
				$("#APPLICATION_SURFACE").fadeIn(800);
				$("#BALL_DIV").fadeOut(800);
			}
		});
	});
}

function close_schema()
{
	$("#APPLICATION_SURFACE").fadeOut(400);
}

function new_scheme()
{
	$("#FRM_NEW_S_CODE").removeClass("invalid");
	$("#FRM_NEW_S_LIBELLE").removeClass("invalid");

	$("#FRM_NEW_S_CODE").val("");
	$("#FRM_NEW_S_LIBELLE").val("");

	$("#LOCK_LST_GRAPH").fadeIn(400, function(){
		$("#FRM_NEW_S_CODE").focus();
		$("#FRM_SITE_DUP").html(global_site);
		$("#FRM_SITE_DUP").val("").trigger("liszt:updated");
	});
}

function close_sub_new_scheme()
{
	$("#LOCK_LST_GRAPH").fadeOut(400);
}

function valide_formulaire_new_scheme()
{
	var errors = 0;

	// *** VERIFICATION QUE LES CHAMPS NE SONT PAS VIDE ***

	$(".requis2").each(function(i){

		$(this).removeClass("invalid");

		var field = this.value;

		if ( field.length < 1 )
		{
			$(this).addClass("invalid");
			errors += 1;
		}
	});

	var regtxt2 = new RegExp("\"|\'");

	$(".input_filter2").each(function(i){

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

	// *** FABRICATION DE LA CHAINE D'IMPORT DES PARAMETRES DE DUPLICATION ***
	var wl_opt_import = "";
	if ( $("#FRM_DUP_SRV").is(':checked') )
	{
		wl_opt_import = "1;";
	}
	else
	{
		wl_opt_import = "0;";
	}
	
	if ( $("#FRM_DUP_ROU").is(':checked') )
	{
		wl_opt_import += "1;";
	}
	else
	{
		wl_opt_import += "0;";
	}
	
	if ( $("#FRM_DUP_NAS").is(':checked') )
	{
		wl_opt_import += "1;";
	}
	else
	{
		wl_opt_import += "0;";
	}
	
	if ( $("#FRM_DUP_BAI").is(':checked') )
	{
		wl_opt_import += "1";
	}
	else
	{
		wl_opt_import += "0";
	}
	
	$.ajax({
		data: $("#FORMULAIRE_NEW_SCHEME").serialize(),
		type: $("#FORMULAIRE_NEW_SCHEME").attr("method"),
		url: $("#FORMULAIRE_NEW_SCHEME").attr("action"),
		success: function(response) {
			if ( response.replace(/^\s+/g,'').replace(/\s+$/g,'') != "ALREADY_EXIST" )
			{
				if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 )
				{
					// *** TEST SI IMPORT DEPUIS AUTRE SCHEMA ***
					if ( $("#FRM_SITE_DUP").val().length > 0 )
					{
						$.ajax({
							type:"GET",
							url:"dupli_site.php?SITEO=" + $("#FRM_SITE_DUP").val() + "&SITED=" + $("#FRM_NEW_S_CODE").val() + "&OPT=" + wl_opt_import,
							success: function(retour){
								var new_item = "<li id='ST_" + $("#FRM_NEW_S_CODE").val() + "' onclick='javascript:load_graph(\"" + $("#FRM_NEW_S_CODE").val() + "\")'><h2>" + $("#FRM_NEW_S_CODE").val() + "</h2><p style='font-size: 9px'>" + $("#FRM_NEW_S_LIBELLE").val() + "</p></li>";
								$("#MAP_LISTE_UL").append(new_item);
								$("#LOCK_LST_GRAPH").fadeOut(600, function(){
									load_graph($("#FRM_NEW_S_CODE").val());
									return;
								});

							}
						});
					}
					else
					{
						var new_item = "<li id='ST_" + $("#FRM_NEW_S_CODE").val() + "' onclick='javascript:load_graph(\"" + $("#FRM_NEW_S_CODE").val() + "\")'><h2>" + $("#FRM_NEW_S_CODE").val() + "</h2><p style='font-size: 9px'>" + $("#FRM_NEW_S_LIBELLE").val() + "</p></li>";
						$("#MAP_LISTE_UL").append(new_item);
						$("#LOCK_LST_GRAPH").fadeOut(600, function(){
							load_graph($("#FRM_NEW_S_CODE").val());
							return;
						});

					}
					
					resize_index();
					
					global_site = $("#FRM_SITE_DUP").html() + '<option value="' + $("#FRM_NEW_S_CODE").val() + '">' + $("#FRM_NEW_S_CODE").val() + ' ' + $("#FRM_NEW_S_LIBELLE").val() + '</option>';
				}
				else
				{
					$.gritter.add({
						title: 'Création schéma',
						text: 'Erreur lors de la création du schéma dans la base de données.',
						time: 1500
					});
				}
			}
			else
			{
				$.gritter.add({
					title: 'Création schéma',
					text: 'Un schéma avec le même nom existe déjà dans la base de données.',
					time: 1500
				});
			}
		},
	        error: function(){
			$.gritter.add({
				title: 'Création schéma',
				text: 'Erreur lors de la création du schéma dans la base de données.',
				time: 1500
			});
    		}
	});
}

function filter_sites()
{
	var wlstr = $("#FILTER_NAME").val().replace("'", " ");
	$("#FILTER_NAME").val(wlstr);
	
	$.ajax({
		url: "filter_site.php?NAME=" + $("#FILTER_NAME").val(),
		success: function(response) {
			if ( response.length < 2)
			{
				$("#BT_TOP_M_2").hide();
			}
			else
			{
				$("#BT_TOP_M_2").show();
			}

			response = response.replace(/^\s+/g,'').replace(/\s+$/g,'');
			$("#MAP_LISTE_UL").html(response);
			resize_index();
			if ( response.length < 2 && wlstr.length > 0 )
			{
				$.gritter.add({
					title: 'Recherche schéma',
					text: 'Aucun schéma ne correspond à votre critère de recherche',
					time: 1500
				});
			}
		}
	});
}

function resize_index()
{
	if ( $("#MAP_LISTE_UL").height() > ($("#MAP_LISTE").height()-40) )
	{
		$("#SUPPORT_SCROLLER_V_INDEX").fadeIn(400);
	}
	else
	{
		$("#SUPPORT_SCROLLER_V_INDEX").fadeOut(400);
	}
	$("#MAP_LISTE_SCROLLER").css("top", "0px");
	$("#SCROLLER_V_INDEX").css("top", "0px");
}

$( window ).resize(function() {
	resize_index();
});

function open_geo()
{
	$("#BT_TOP_M_1").hide();
	$("#BT_TOP_M_2").hide();
	$("#BT_TOP_M_3").show();
	$("#BT_TOP_M_4").show();
	
	$("#MAPGEO").css("zIndex",3);
}

var markers;
var wl_i_bench = 0;

function open_diag()
{
        markers = $("#MAPGEO").gmap3({
            get: {
              name:"marker",
              full: true,
              all: true
            }
        });
	
	$("#BALL_DIV").fadeIn(400);
	
	wl_i_bench = 0;
	bench_site();
	           
        /*$.each(markers, function(i, marker){
		console.debug(markers[i].tag);
	});*/
	
}

function bench_site()
{
	var wl_ip;
	wl_ip = markers[wl_i_bench].tag.split("#;#");

	if ( wl_ip[0] == "" )
	{
                $("#MAPGEO").gmap3({
                    get: {
                        id:wl_ip[1],
                        callback: function(markerid){
                            markerid.setVisible(false);
                        }
                    }
                });
		
		wl_i_bench++;
		if ( wl_i_bench < markers.length )
		{
			bench_site();
		}
		else
		{
			$("#BALL_DIV").fadeOut(400);
		}
		return;
	}
	
	$.ajax({
		type:"GET",
		url:"testip.php?IP=" + wl_ip[0],
		success: function(retour){
			var explode_return = retour.split("/_/");
			if ( explode_return[1].length > 5 )
			{
				$("#MAPGEO").gmap3({
				    get: {
					id:wl_ip[1],
					callback: function(markerid){
					    markerid.setIcon("Images/marker_map_ok.png");
					}
				    }
				});
			}
			else
			{
				$("#MAPGEO").gmap3({
				    get: {
					id:wl_ip[1],
					callback: function(markerid){
					    markerid.setIcon("Images/marker_map_error.png");
					}
				    }
				});					
			}
			wl_i_bench++;
			if ( wl_i_bench < markers.length )
			{
				bench_site();
			}
			else
			{
				$("#BALL_DIV").fadeOut(400);
			}
		}
	});			     
}

function close_geo()
{
	$("#MAPGEO").css("zIndex",0);
	$("#BT_TOP_M_1").show();
	$("#BT_TOP_M_2").show();
	$("#BT_TOP_M_3").hide();
	$("#BT_TOP_M_4").hide();
}

function display_popup_geo(ctx, marker,id)
{
	var map = $("#MAPGEO").gmap3('get');
	infowindow = $("#MAPGEO").gmap3({get:{name:"infowindow"}});
	
	var wl_elem = ctx.tag.split("#;#");	
	console.debug(id);
	var wl_click = "<center><a href=\"javascript:load_graph('" + id + "')\">Ouvrir le schéma</a></center>";
	
			  
	if (infowindow){    
	    infowindow.open(map, marker);
	    infowindow.setContent(wl_elem[2] + "<br>" + wl_click);
	} else {
	    $("#MAPGEO").gmap3({
		infowindow:{
		    anchor:marker, 
		    options:{content: wl_elem[2] + "<br>" + wl_click}
		}
	    });
	}
}

</script>

</body>
</html>
