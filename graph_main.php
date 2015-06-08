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

<?php

       @session_start();
       $_SESSION['SITKEY'] = $_GET['SITE'];

?>

<div id="TOP_MENU">

       <div id="LOGON_BT" style="position: absolute; vertical-align: middle; right: 0px; top: 0px;">
		<div class="bt_top_menu" onclick="javascript:grab_for_accueil()">Déconnexion</div>
		<div class="bt_top_menu" onclick="javascript:test_switchs()">Test des actifs</div>
		<div class="bt_top_menu" id="TOP_BT_1" onclick="javascript:show_left_menu()">Informations</div>
		<div class="bt_top_menu" onclick="javascript:grab_me()">Export</div>
		<div class="bt_top_menu" id="TOP_BT_2" onclick="javascript:show_library()">Librairie</div>
		<div class="bt_top_menu" onclick="javascript:show_help()">Aide</div>
       </div>
</div>

<div id="ZONE_NOM_SITE"></div>

<div id="LEFT_MENU">
	
	<div id="LEFT_MENU_CONTENT">
	
		<p class='MAIN_LEFT_MENU' id='MLM1' onclick='javascript:show_hide_contacts()'>&nbsp;Contacts</p>
		<p id="INFORMATION_DIV" class="SUB_LEFT_DIV"></p>
		
		<p class='MAIN_LEFT_MENU' id='MLM2' onclick='javascript:show_hide_computers()'>&nbsp;Ordinateurs</p>
		<p id="COMPUTERS_DIV" class="SUB_LEFT_DIV"></p>

		<p class='MAIN_LEFT_MENU' id='MLM3' onclick='javascript:show_hide_documents()'>&nbsp;Documents</p>
		<p id="DOCUMENTS_DIV" class="SUB_LEFT_DIV"></p>
	
	</div>
	
	<div id="SUB_LEFT_MENU"></div>
	
	<div id="SUB_LEFT_DATAS"></div>
	
	<div id='BOTTOM_LEFT_MENU'>
		
		<button class='main_bt_war' onclick="javascript:add_something()">Ajouter</button>
		<button class='main_bt_inv' id="BT_DEL_LEFT" onclick="javascript:del_something()" style="display: none;">Supprimer</button>
		
	</div>
	
</div>

<div id="MODAL_ADD" class="MODAL_ADD"></div>
<canvas id="CANVAS_SNAPSHOT"></canvas>

<div id="GRAB_TEMPO">
       <div id="LASER"></div>
       <div id="SUPPORT_PREVIEW_RESULT_GRAB">
	      <div id="PREVIEW_RESULT_GRAB">
		     <div id="STAMP_PREVIEW"></div>
	      </div>
	      <div class="BOTTOM_BUTTONS">
		     <button type='button' class='main_bt_inv' onclick="javascript:close_grab()">Fermer</button>
		     <button type='button' class='main_bt' onclick="javascript:dowload_grab()">Enregistrer image</button>
		     <button type='button' class='main_bt' onclick="javascript:dowload_grab_pdf()">Export document</button>
	      </div>
       </div>
</div>

<div id="APPS_GRAPH">

       <div id="LOCK_GRAPH" onClick="javascript:unlock_schema();"></div>
       <div id="POPOVER_DETAIL"></div>
             
       <div id="SUPPORT_GRAPH">
	      <canvas id="CANVAS_GRAPH"></canvas>
	      <div id="GRAPH"></div>
       </div>

       <div id="SUPPORT_SCROLLER_H">
	      <div id="SCROLLER_H"></div>
       </div>
	
       <div id="SUPPORT_SCROLLER_V">
	      <div id="SCROLLER_V"></div>
       </div>
       
</div>

<div id="HELP_SUPPORT"></div>

<div id="FLOAT_TOOLBAR">
       <div id="FLOAT_TOOLBAR_CONTENT">      
	      <div class='FLOAT_TOOLBAR_BT' id='ADD_ANT'>
		     <h2 class='FLOAT_TOOLBAR_BT_TITLE'>ANTENNE WIFI</h2>
		     <h2 class='FLOAT_TOOLBAR_BT_TXT'>Ajouter une antenne wifi à votre schéma. L'antenne wifi peut être raccordée à une carte réseau ou un port</h2>
	      </div>	      
	      <div class='FLOAT_TOOLBAR_BT' id='ADD_BAI' style='margin-top: 20px;'>
		     <h2 class='FLOAT_TOOLBAR_BT_TITLE'>BAIE DE BRASSAGE</h2>
		     <h2 class='FLOAT_TOOLBAR_BT_TXT'>Ajouter une baie à votre schéma. Vous pourrez ensuite y insérer des switchs.</h2>
	      </div>
	      <div class='FLOAT_TOOLBAR_BT' id='ADD_CAM'>
		     <h2 class='FLOAT_TOOLBAR_BT_TITLE'>CAMERA</h2>
		     <h2 class='FLOAT_TOOLBAR_BT_TXT'>Ajouter une caméra à votre schéma. La caméra peut être raccordée à une carte réseau ou un port</h2>
	      </div>
	      <div class='FLOAT_TOOLBAR_BT' id='ADD_MSW'>
		     <h2 class='FLOAT_TOOLBAR_BT_TITLE'>MINI SWITCH</h2>
		     <h2 class='FLOAT_TOOLBAR_BT_TXT'>Ajouter un mini switch à votre schéma. Contrairement aux switchs, les minis switchs se placent hors des baies</h2>
		     <h2 class='FLOAT_TOOLBAR_BT_TXT'>Ports ethernets<select id="MS_PORTS" style="width:50px; height: 20px; float: right; padding: 0px; margin: 0px; margin-right: 8px;">
			    <option value='8'>8</option>
			    <option value='12'>12</option>
			    <option value='16'>16</option>
			    <option value='24'>24</option>
		     </select>     
		     
		     </h2>
	      </div>	      
	      <div class='FLOAT_TOOLBAR_BT' id='ADD_NAS'>
		     <h2 class='FLOAT_TOOLBAR_BT_TITLE'>NAS</h2>
		     <h2 class='FLOAT_TOOLBAR_BT_TXT'>Ajouter un NAS à votre schéma.</h2>
	      </div>	      
	      <div class='FLOAT_TOOLBAR_BT' id='ADD_ROU'>
		     <h2 class='FLOAT_TOOLBAR_BT_TITLE'>ROUTEUR</h2>
		     <h2 class='FLOAT_TOOLBAR_BT_TXT'>Ajouter un routeur à votre schéma.</h2>
	      </div>
	      
	      <div class='FLOAT_TOOLBAR_BT' id='ADD_SRV'>
		     <h2 class='FLOAT_TOOLBAR_BT_TITLE'>SERVEUR</h2>
		     <h2 class='FLOAT_TOOLBAR_BT_TXT'>Ajouter un serveur à votre schéma.</h2>
	      </div>
	      <div class='FLOAT_TOOLBAR_BT' id='ADD_SWI'>
		     <h2 class='FLOAT_TOOLBAR_BT_TITLE'>SWITCH</h2>
		     <h2 class='FLOAT_TOOLBAR_BT_TXT'>Ajouter un switch à votre schéma. Attention un switch ne peut être déplacer que dans une baie</h2>
		     <h2 class='FLOAT_TOOLBAR_BT_TXT'>Ports ethernets<select id="SW_PORTS" style="width:50px; height: 20px; float: right; padding: 0px; margin: 0px; margin-right: 8px;">
				<option value='8'>8</option>
				<option value='12'>12</option>
				<option value='16'>16</option>
				<option value='24'>24</option>
				<option value='48'>48</option>				
		     </select></h2>
		     <h2 class='FLOAT_TOOLBAR_BT_TXT'>Ports fibres<select id="SW_PORTSF" style="width:50px; height: 20px; float: right; padding: 0px; margin: 0px; margin-right: 8px;">
				<option value='0'>0</option>
				<option value='1'>1</option>
				<option value='2'>2</option>
				<option value='3'>3</option>
				<option value='4'>4</option>
		     </select></h2>
	      </div>
	      <div class='FLOAT_TOOLBAR_BT' id='ADD_TRA'>
		     <h2 class='FLOAT_TOOLBAR_BT_TITLE'>TRANSCIEVER</h2>
		     <h2 class='FLOAT_TOOLBAR_BT_TXT'>Ajouter une transciever à votre schéma. Un transciever permet de joindre une liaison fibre à une ethernet.</h2>
	      </div>	      
	      <div class='FLOAT_TOOLBAR_BT' id='ADD_ZON'>
		     <h2 class='FLOAT_TOOLBAR_BT_TITLE'>ZONE DE GROUPE</h2>
		     <h2 class='FLOAT_TOOLBAR_BT_TXT'>Ajouter une zone de groupe à votre schéma. Une zone de groupe permet de regrouper visuellement un ensemble de composants.</h2>
	      </div>
	      <div class='FLOAT_TOOLBAR_BT' id='ADD_TXT'>
		     <h2 class='FLOAT_TOOLBAR_BT_TITLE'>ZONE DE TEXTE</h2>
		     <h2 class='FLOAT_TOOLBAR_BT_TXT'>Ajouter une zone de texte à votre schéma. Une zone de texte permet de saisir des informations textuelles.</h2>
	      </div>
       </div>
</div>

<!-- *** FENETRES MODALES *** -->
<div id="LOCK_SCREEN"></div>
<div id="PROGRESS">
	
	<h2 class='TITLE_N0 TITLE_CENTER_IT' style="color: #222222;">Test des actifs. Veuillez patienter ...</h2>
	
	<div class='SUPPORT_PROGRESS_SIGN'>
		<div id='PROGRESS_SIGN' class='PROGRESS_SIGN' style='width: 0%'></div>
        </div>

</div>

<div id="LOCK_SCREEN_DELETE"></div>

<div id="FORM_GRAB_SNAP" style="display: none;">
       <form method="POST" enctype="multipart/form-data" action="save_snapshot.php" id="FORM_SNAP">
	   <input type="hidden" name="img_val" id="img_val" value="" />
	   <input type="hidden" name="img_val_o" id="img_val_o" value="" />
       </form>       
</div>

<!-- *** MENU CONTEXTUEL *** -->
<div id="MAIN_CONTEXTUAL_MENU"></div>

<?php
	// *** CHARGEMENT SCHEMAS ***
	if ( isset($_GET['SITE'] ) )
	{
		require "Class/class_baies.php";
		require "Class/class_switchs.php";
		require "Class/class_serveurs.php";
		require "Class/class_routeurs.php";
		require "Class/class_liens.php";
		require "Class/class_sites.php";
		require "Class/class_nas.php";
		require "Class/class_zones.php";
		require "Class/class_cameras.php";
		require "Class/class_antennes.php";
		require "Class/class_transcievers.php";
		require "Class/class_textes.php";

		$hdl_baie = new Baie();
		$hdl_switche = new Switche();
		$hdl_serveur = new Serveur();
		$hdl_routeur = new Routeur();
		$hdl_nas = new Nas();
		$hdl_lien = new Lien();
		$hdl_site = new Site();
		$hdl_zone = new Zone();
		$hdl_camera = new Camera();
		$hdl_antenne = new Antenne();
		$hdl_transceiver = new Transceiver();
		$hdl_texte = new Texte();

		$hdl_baie->_site 		= $_GET['SITE'];
		$hdl_switche->_site 		= $_GET['SITE'];		
		$hdl_serveur->_site 		= $_GET['SITE'];		
		$hdl_routeur->_site 		= $_GET['SITE'];
		$hdl_nas->_site 		= $_GET['SITE'];
		$hdl_lien->_site 		= $_GET['SITE'];				
		$hdl_site->_id	 		= $_GET['SITE'];
		$hdl_zone->_site 		= $_GET['SITE'];
		$hdl_camera->_site 		= $_GET['SITE'];
		$hdl_antenne->_site 		= $_GET['SITE'];
		$hdl_transceiver->_site		= $_GET['SITE'];
		$hdl_texte->_site		= $_GET['SITE'];

		$result_site = json_decode($hdl_site->get_site_from_id());
		$result = json_decode($hdl_baie->get_all_baies());

		$i = 0;

		echo "<script type='text/javascript'>";
		
		echo "$('#ZONE_NOM_SITE').html('" . addslashes($result_site[0]->SITES_DESCRIPTION) . " - " . addslashes($result_site[0]->SITES_VILLE) . "');";
		echo "$('#SUB_LEFT_DATAS').append('<h2 style=\'padding: 0px; margin: 0px;\' class=\'TITLE_N1\'>" . addslashes($result_site[0]->SITES_ID) . " " . addslashes($result_site[0]->SITES_DESCRIPTION) . "</h2><br>" . addslashes($result_site[0]->SITES_ADRESSE) ."<br>" . addslashes($result_site[0]->SITES_POSTAL) . " " . addslashes($result_site[0]->SITES_VILLE) . " <div id=\'BT_CONFIG\' onclick=\'javascript:edit_settings()\' title=\'Paramétrage de votre schéma\' ></div><div id=\'BT_DELETE_SITE\' onclick=\'javascript:delete_site()\' title=\'Supprimez votre schéma\'></div>');";
			
		echo "sessionStorage.clear();";
		echo "sessionStorage.setItem('SITKEY', '" . $_GET['SITE'] . "');";
		echo "sessionStorage.setItem('CL1', '" . $result_site[0]->SITES_COLOR_1 . "');";
		echo "sessionStorage.setItem('CL2', '" . $result_site[0]->SITES_COLOR_2 . "');";
		echo "sessionStorage.setItem('CL3', '" . $result_site[0]->SITES_COLOR_3 . "');";
		echo "sessionStorage.setItem('CL4', '" . $result_site[0]->SITES_COLOR_4 . "');";

		echo "sessionStorage.setItem('SITE_DES', '" . addslashes($result_site[0]->SITES_DESCRIPTION) . "');";
		echo "sessionStorage.setItem('SITE_ADR', '" . addslashes($result_site[0]->SITES_ADRESSE) . "');";
		echo "sessionStorage.setItem('SITE_CPO', '" . addslashes($result_site[0]->SITES_POSTAL) . "');";
		echo "sessionStorage.setItem('SITE_VIL', '" . addslashes($result_site[0]->SITES_VILLE) . "');";

		// *** INITIALISATION DU CANVAS ***
		echo "var canvas=document.getElementById('CANVAS_GRAPH');";
		echo "canvas.width  = 2000;";
		echo "canvas.height = 1500;";
		echo "var ctx=canvas.getContext('2d');";
		
		// *** INITIALISATION DU CANVAS DE SNAPSHOT ***
		echo "var canvas_snap=document.getElementById('CANVAS_SNAPSHOT');";
		echo "canvas_snap.width  = 2000;";
		echo "canvas_snap.height = 1500;";
		echo "var ctx_snap=canvas_snap.getContext('2d');";		

		while ( $i < count($result) )
		{
			echo "create_baie_on_map(" . $result[$i]->BAIES_ID . ", '" . addslashes($result[$i]->BAIES_COMMENTAIRES) . "', " . $result[$i]->BAIES_POS_X . ", " . $result[$i]->BAIES_POS_Y . "," . $result[$i]->BAIES_ONDULEE . ");";

			// *** RECUPERATION DES SWITCH DE LA BAIE ***

			$hdl_switche->_baie_id = $result[$i]->BAIES_ID;
			$result_switch = json_decode($hdl_switche->get_all_switches_in_baie());

			$j = 0;
			while ( $j < count($result_switch) )
			{
			    $nb_port_eth = count(explode(";",$result_switch[$j]->SWITCHS_PORTS_CONNECT))-1;
				echo "create_switch_on_baie(" . $result[$i]->BAIES_ID . ", '" . $result_switch[$j]->SWITCHS_IP . "', " . $j . ",'" . addslashes($result_switch[$j]->SWITCHS_MARQUE) . " " . addslashes($result_switch[$j]->SWITCHS_DESCRIPTION) . "', " . $result_switch[$j]->SWITCHS_FIBER_PORTS . ", " . $result_switch[$j]->SWITCHS_WEB_INTERFACE . ", '" . $result_switch[$j]->SWITCHS_WEB_PORT . "'," . $result_switch[$j]->SWITCHS_HTTPS . "," . $nb_port_eth . ");";
				$j++;
			}

			$i++;
		}

		$result = json_decode($hdl_switche->get_all_mini_switches());
		$i = 0;

		while ( $i < count($result) )
		{
			$position = explode(";", $result[$i]->SWITCHS_IP);
			echo "create_mini_switch_on_map('" . $result[$i]->SWITCHS_MARQUE . " " . addslashes($result[$i]->SWITCHS_DESCRIPTION) . "'," . $position[0] . "," . $position[1] . "," . $result[$i]->SWITCHS_ID . ");";
			$i++;
		}
		
		$result = json_decode($hdl_serveur->get_all_serveurs());
		$i = 0;

		while ( $i < count($result) )
		{
			$wl_var_ip = "SERVEURS_LAN_" . ($result[$i]->SERVEURS_WEB_CARD) . "_IP";
			echo "create_serveur_on_map(" . $result[$i]->SERVEURS_ID . ",'" . addslashes($result[$i]->SERVEURS_NAME) . "'," . $result[$i]->SERVEURS_POS_X . "," . $result[$i]->SERVEURS_POS_Y . ", " . $result[$i]->SERVEURS_WEB_INTERFACE . ", '" . $result[$i]->SERVEURS_WEB_PORT . "'," . $result[$i]->SERVEURS_HTTPS .  ",'" . $result[$i]->$wl_var_ip . "','" . $result[$i]->SERVEURS_ONDULEE . "','" . $result[$i]->SERVEURS_FIREWALL . "');";
			$i++;
		}

		$result = json_decode($hdl_routeur->get_all_routeurs());
		$i = 0;
		while ( $i < count($result) )
		{
			echo "create_routeur_on_map(" . $result[$i]->ROUTEURS_ID . ",'" . addslashes($result[$i]->ROUTEURS_NAME) . "'," . $result[$i]->ROUTEURS_POS_X . "," . $result[$i]->ROUTEURS_POS_Y . "," . $result[$i]->ROUTEURS_WIFI . ");";
			$i++;
		}

		$result = json_decode($hdl_nas->get_all_nas());
		$i = 0;
		while ( $i < count($result) )
		{
			echo "create_nas_on_map(" . $result[$i]->NAS_ID . ",'" . addslashes($result[$i]->NAS_NAME) . "'," . $result[$i]->NAS_POS_X . "," . $result[$i]->NAS_POS_Y . ");";
			$i++;
		}
		
		$result = json_decode($hdl_zone->get_all_zones());
		$i = 0;
		while ( $i < count($result) )
		{
		     if ( empty($result[$i]->ZONES_COLOR) )
		     {
			    $wl_color_zone = "#DCDCDC";
		     }
		     else
		     {
			    $wl_color_zone = $result[$i]->ZONES_COLOR;
		     }
		     echo "create_zone_on_map(" . $result[$i]->ZONES_ID . ",'" . addslashes($result[$i]->ZONES_NOM) . "'," . $result[$i]->ZONES_POS_X . "," . $result[$i]->ZONES_POS_Y . "," . $result[$i]->ZONES_WIDTH . "," . $result[$i]->ZONES_HEIGHT . ",'" . $wl_color_zone . "');";
		     $i++;
		}				

		$result = json_decode($hdl_camera->get_all_cameras());
		$i = 0;
		while ( $i < count($result) )
		{
		     echo "create_camera_on_map(" . $result[$i]->CAMERAS_ID . "," . $result[$i]->CAMERAS_POS_X . "," . $result[$i]->CAMERAS_POS_Y . ",'" . addslashes($result[$i]->CAMERAS_NOM) . "');";
		     $i++;
		}		

		$result = json_decode($hdl_antenne->get_all_antennes());
		$i = 0;
		while ( $i < count($result) )
		{
		     echo "create_antenne_on_map(" . $result[$i]->ANTENNES_ID . "," . $result[$i]->ANTENNES_POS_X . "," . $result[$i]->ANTENNES_POS_Y . ",'" . addslashes($result[$i]->ANTENNES_NOM) . "','" . $result[$i]->ANTENNES_IP . "');";
		     $i++;
		}

		$result = json_decode($hdl_transceiver->get_all_transceivers());
		$i = 0;
		while ( $i < count($result) )
		{
		     echo "create_transceiver_on_map(" . $result[$i]->TRANSCEIVERS_ID . "," . $result[$i]->TRANSCEIVERS_POS_X . "," . $result[$i]->TRANSCEIVERS_POS_Y . ",'" . addslashes($result[$i]->TRANSCEIVERS_LIBELLE) . "');";
		     $i++;
		}

		$result = json_decode($hdl_texte->get_all_textes());
		$i = 0;
		while ( $i < count($result) )
		{
		     echo "create_texte_on_map(" . $result[$i]->TEXTES_ID . "," . json_encode(nl2br($result[$i]->TEXTES_TEXT)) . "," . $result[$i]->TEXTES_POS_X . "," . $result[$i]->TEXTES_POS_Y . "," . $result[$i]->TEXTES_WIDTH . "," . $result[$i]->TEXTES_HEIGHT . ");";
		     $i++;
		}
			
	      echo "$.ajax({
		     type: 'GET',
		     url: 'reload_links.php?SITE=' + sessionStorage.getItem('SITKEY'),
		     success: function(response) {
			     eval(response);
			     join();
		     }
	      });";
		
		echo "</script>";
	}


?>

<script type="text/javascript">


$(document).bind('keyup', function(e){
       var current_input = (e.target.type);
       var current_inputid = (e.target.id);
       
       var code = e.keyCode || e.which;
       if ( (code == 44 || code == 188 || code == 59) && ( current_input == "textarea" || current_input == "input" || current_input == "text" ) )
       {
	      var ct_string = e.target.value;
	      ct_string = ct_string.replace(/[,;]/g," ");
	      
	      $("#" + current_inputid).val(ct_string);
	      e.preventDefault();
       }
       else
       {
	      return true;
       }
});

// *** CHARGEMENT DES CONTACTS DU SITE ***

$.ajax({
	url: "reload_contacts.php?SITE=" + sessionStorage.getItem('SITKEY'),
	success: function(response) {
		$('#INFORMATION_DIV').html(response);
	}
});	

// *** CHARGEMENT DES ORDINATEURS DU SITE ***

$.ajax({
	url: "reload_computers.php?SITE=" + sessionStorage.getItem('SITKEY'),
	success: function(response) {
		$('#COMPUTERS_DIV').html(response);
	}
});

var float_open_running = 0;
var float_open = 0;

function show_library()
{
       if ( float_open_running == 1 )
       {
	      return;
       }
       float_open_running = 1;
       if ( float_open == 0 )
       {
	   $("#APPS_GRAPH").animate({
	       right: "+=250px"
	       }, 400, function(){
		   float_open = 1;
		   float_open_running = 0;
		   $("#TOP_BT_2").addClass("bt_top_menu_select");
	       }
	   );
       }
       else
       {
	   $("#APPS_GRAPH").animate({
	       right: "-=250px"
	       }, 400, function(){
		   float_open = 0;
		   float_open_running = 0;
		   $("#TOP_BT_2").removeClass("bt_top_menu_select");
	       }
	   );
       }
}

$("#APPS_GRAPH").droppable({
       drop : function(event, ui){
	          
	      if ( ui.draggable.attr('id').substring(0,4) == "ADD_" )
	      {
		     var parent_left = $("#SUPPORT_GRAPH").position().left;
		     var parent_top = $("#SUPPORT_GRAPH").position().top;
		     
		     x = ui.position.left - parent_left;
		     y = ui.position.top - parent_top;
		     
		     if ( ui.draggable.attr('id') == "ADD_BAI")
		     {
			    $.ajax({
				   data: {
					  'SITE': sessionStorage.getItem('SITKEY'),
					  'X': x,
					  'Y': y, 				       
					  'COMMENTAIRES': '',
					  'FRM_BAIE_DATAS': '',
					  'IS_NEW': '1'
				   },
				   type: "POST",
				   url: "insert_baie.php",
				   success: function(response) {
					  if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 )
					  {
						 create_baie_on_map(response.replace(/^\s+/g,'').replace(/\s+$/g,''),'',x,y,'0');
					  }
					  else
					  {
						 $.gritter.add({
							 title: 'Création baie',
							 text: 'Erreur lors de la création de la baie dans la base de données.',
							 time: 1500
						 });						 
					  }
				   }
			    });
			    return;
		     }
		     
		     if ( ui.draggable.attr('id') == "ADD_SRV")
		     {
			    $.ajax({
				   data: {
					  'SITE': sessionStorage.getItem('SITKEY'),
					  'X': x,
					  'Y': y, 				       
					  'FRM_SERVEUR_NAME': '',
					  'FRM_SERVEUR_MARQUE': '',
					  'FRM_SERVEUR_MODELE': '',
					  'FRM_SERVEUR_OS': '',
					  'FRM_SERVEUR_RELEASE': '',
					  'FRM_SERVEUR_WEB_PORT': '80',
					  'FRM_SERVEUR_LAN_TYPE_0': '',
					  'FRM_SERVEUR_LAN_IP_0': '',
					  'FRM_SERVEUR_LAN_TYPE_1': '',
					  'FRM_SERVEUR_LAN_IP_1': '',
					  'FRM_SERVEUR_LAN_TYPE_2': '',
					  'FRM_SERVEUR_LAN_IP_2': '',
					  'FRM_SERVEUR_LAN_TYPE_3': '',
					  'FRM_SERVEUR_LAN_IP_3': '',
					  'FRM_SERVEUR_LAN_TYPE_4': '',
					  'FRM_SERVEUR_LAN_IP_4': '',
					  'FRM_SERVEUR_LAN_TYPE_5': '',
					  'FRM_SERVEUR_LAN_IP_5': '',
					  'FRM_SERVEUR_WEB_CARD': '1',
					  'ISNEW': '1'
				   },
				   type: "POST",
				   url: "insert_serveur.php",
				   success: function(response) {
					  if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 )
					  {
						 create_serveur_on_map(response.replace(/^\s+/g,'').replace(/\s+$/g,''), "", x, y, 0 , "" , 0 , 0, 0, 0);
					  }
					  else
					  {
						 $.gritter.add({
							 title: 'Création serveur',
							 text: 'Erreur lors de la création du serveur dans la base de données.',
							 time: 1500
						 });						 
					  }
				   }
			    });
			    return;
		     }

		     if ( ui.draggable.attr('id') == "ADD_ROU")
		     {
			    $.ajax({
				   data: {
					  'SITE': sessionStorage.getItem('SITKEY'),
					  'X': x,
					  'Y': y, 				       
					  'FRM_ROUTEUR_NAME': '',
					  'FRM_ROUTEUR_IP': '',
					  'FRM_ROUTEUR_IP_PUBLIQUE': '',
					  'ISNEW': '0'
				   },
				   type: "POST",
				   url: "insert_routeur.php",
				   success: function(response) {
					  if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 )
					  {
						 create_routeur_on_map(response.replace(/^\s+/g,'').replace(/\s+$/g,''), "", x, y, '0');
					  }
					  else
					  {
						 $.gritter.add({
							 title: 'Création routeur',
							 text: 'Erreur lors de la création du routeur dans la base de données.',
							 time: 1500
						 });						 
					  }
				   }
			    });
			    return;
		     }

		     if ( ui.draggable.attr('id') == "ADD_NAS")
		     {
			    $.ajax({
				   data: {
					  'SITE': sessionStorage.getItem('SITKEY'),
					  'X': x,
					  'Y': y, 				       
					  'FRM_NAS_NAME': '',
					  'FRM_NAS_IP': '',
					  'ISNEW': '0'
				   },
				   type: "POST",
				   url: "insert_nas.php",
				   success: function(response) {
					  if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 )
					  {
						 create_nas_on_map(response.replace(/^\s+/g,'').replace(/\s+$/g,''), "", x, y);
					  }
					  else
					  {
						 $.gritter.add({
							 title: 'Création nas',
							 text: 'Erreur lors de la création du nas dans la base de données.',
							 time: 1500
						 });						 
					  }
				   }
			    });
			    return;
		     }
		     
		     if ( ui.draggable.attr('id') == "ADD_MSW")
		     {
			    $.ajax({
				   data: {
					  'SITE': sessionStorage.getItem('SITKEY'),
					  'X': x,
					  'Y': y, 				       
					  'FRM_SWITCH_MARQUE': '',
					  'FRM_SWITCH_COMMENTAIRE': '',
					  'ISNEW': '1',
					  'FRM_SWITCH_NOMBRE_PORTS': $("#MS_PORTS").val()
				   },
				   type: "POST",
				   url: "insert_mini_switch.php",
				   success: function(response) {
					  if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 )
					  {
						 create_mini_switch_on_map(" ", x,y,response.replace(/^\s+/g,'').replace(/\s+$/g,'') );
					  }
					  else
					  {
						 $.gritter.add({
							 title: 'Création mini switch',
							 text: 'Erreur lors de la création du mini switch dans la base de données.',
							 time: 1500
						 });						 
					  }
				   }
			    });
			    return;
		     }
		     
		     if ( ui.draggable.attr('id') == "ADD_ZON")
		     {
			    $.ajax({
				   data: {
					  'SITE': sessionStorage.getItem('SITKEY'),
					  'X': x,
					  'Y': y, 				       
					  'FRM_ZONE_NAME': '',
					  'color_1': '#DCDCDC',
					  'ISNEW': '0'
				   },
				   type: "POST",
				   url: "insert_zone.php",
				   success: function(response) {
					  if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 )
					  {
						 create_zone_on_map(response.replace(/^\s+/g,'').replace(/\s+$/g,''), "", x, y,250,150, "#DCDCDC");
					  }
					  else
					  {
						 $.gritter.add({
							 title: 'Création zone de groupe',
							 text: 'Erreur lors de la création / modification de la zone de groupe dans la base de données.',
							 time: 1500
						 });						 
					  }
				   }
			    });
			    return;
		     }
		     
		     if ( ui.draggable.attr('id') == "ADD_ANT")
		     {
			    $.ajax({
				   data: {
					  'SITE': sessionStorage.getItem('SITKEY'),
					  'X': x,
					  'Y': y, 				       
					  'FRM_ANTENNE_IP': '1.1.1.1',
					  'FRM_ANTENNE_NOM': 'Antenne',
					  'ISNEW': '0'
				   },
				   type: "POST",
				   url: "insert_antenne.php",
				   success: function(response) {
					  if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 )
					  {
						 create_antenne_on_map(response.replace(/^\s+/g,'').replace(/\s+$/g,''), x, y, "Antenne");
					  }
					  else
					  {
						 $.gritter.add({
							 title: 'Création antenne',
							 text: 'Erreur lors de la création / modification de l\'antenne dans la base de données.',
							 time: 1500
						 });						 
					  }
				   }
			    });
			    return;
		     }
		     
		     if ( ui.draggable.attr('id') == "ADD_CAM")
		     {
			    $.ajax({
				   data: {
					  'SITE': sessionStorage.getItem('SITKEY'),
					  'X': x,
					  'Y': y, 				       
					  'FRM_CAMERA_IP': '1.1.1.1',
					  'FRM_CAMERA_NOM': 'Caméra',
					  'FRM_CAMERA_DSC': '',					  
					  'ISNEW': '0'
				   },
				   type: "POST",
				   url: "insert_camera.php",
				   success: function(response) {
					  if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 )
					  {
						 create_camera_on_map(response.replace(/^\s+/g,'').replace(/\s+$/g,''), x, y, "Caméra");
					  }
					  else
					  {
						 $.gritter.add({
							 title: 'Création caméra',
							 text: 'Erreur lors de la création / modification de la caméra dans la base de données.',
							 time: 1500
						 });						 
					  }
				   }
			    });
			    return;
		     }
		     
		     if ( ui.draggable.attr('id') == "ADD_TRA")
		     {
			    $.ajax({
				   data: {
					  'SITE': sessionStorage.getItem('SITKEY'),
					  'X': x,
					  'Y': y, 				       
					  'FRM_TRANSCEIVER_LIBELLE': 'Transciever',
					  'FRM_TRANSCEIVER_CONSTRUCTEUR': '',
					  'ISNEW': '0'
				   },
				   type: "POST",
				   url: "insert_transceiver.php",
				   success: function(response) {
					  if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 )
					  {
						 create_transceiver_on_map(response.replace(/^\s+/g,'').replace(/\s+$/g,''), x, y, "Transciever");
					  }
					  else
					  {
						 $.gritter.add({
							 title: 'Création transciever',
							 text: 'Erreur lors de la création / modification du transciever dans la base de données.',
							 time: 1500
						 });						 
					  }
				   }
			    });
			    return;
		     }
		     
		     if ( ui.draggable.attr('id') == "ADD_TXT")
		     {
			    $.ajax({
				   data: {
					  'SITE': sessionStorage.getItem('SITKEY'),
					  'X': x,
					  'Y': y, 				       
					  'FRM_ZONE_NAME': 'Zone de texte',
					  'ISNEW': '0'
				   },
				   type: "POST",
				   url: "insert_texte.php",
				   success: function(response) {
					  if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 )
					  {
						 create_texte_on_map(response.replace(/^\s+/g,'').replace(/\s+$/g,''), "Zone de texte", x, y,250,150);
					  }
					  else
					  {
						 $.gritter.add({
							 title: 'Création zone de texte',
							 text: 'Erreur lors de la création / modification de la zone de texte dans la base de données.',
							 time: 1500
						 });						 
					  }
				   }
			    });
			    return;
		     }		     
	      }
	      return;
       } 
});

$(".FLOAT_TOOLBAR_BT").draggable({
       stack: "div",
       /*helper: "clone",*/
       appendTo: "#SCREENY",
       cursor: 'move',
       helper: function( event ) {
              return $( "<div class='ui-widget-header'></div>" );
       }       
});

$("#HELP_SUPPORT").draggable({
});

$("#HELP_SUPPORT").css('position', "absolute");

var left_open = 0;
var info_open = 0;
var comp_open = 0;
var docu_open = 0;
var left_open_running = 0;
var tempo_contextual_menu;

$("#MAIN_CONTEXTUAL_MENU").mouseenter(function(){
       clearInterval(tempo_contextual_menu);
});

$("#MAIN_CONTEXTUAL_MENU").mouseleave(function(){
       clearInterval(tempo_contextual_menu);
       tempo_contextual_menu=setInterval("hide_contextual()",400);
});

function hide_contextual()
{
       clearInterval(tempo_contextual_menu);
       $("#MAIN_CONTEXTUAL_MENU").fadeOut(300);
}


$("#INFORMATION_DIV").slideToggle();
$("#COMPUTERS_DIV").slideToggle();
$("#DOCUMENTS_DIV").slideToggle();

load_files();

$(document).ready(function()
{
	/* ********************************** */
	/* *** GESTION DU MENU CONTEXTUEL *** */
	/* ********************************** */

	$("#GRAPH").bind("contextmenu",function(e){
		var parent_left = $("#SUPPORT_GRAPH").position().left;
		var parent_top = $("#SUPPORT_GRAPH").position().top;
		
		var menu="<h2 class='title_form'>AJOUTER</h2><ul><li onClick='javascript:add_antenne(" + (e.pageX-parent_left) + "," + (e.pageY-parent_top) + ")'>Une antenne WIFI</li><li onClick='javascript:add_baie(" + (e.pageX-parent_left) + "," + (e.pageY-parent_top) + ")'>Une baie</li><li onClick='javascript:add_camera(" + (e.pageX-parent_left) + "," + (e.pageY-parent_top) + ")'>Une caméra IP</li><li onClick='javascript:add_serveur(" + (e.pageX-parent_left) + "," + (e.pageY-parent_top) + ")'>Un serveur</li><li onClick='javascript:add_routeur(" + (e.pageX-parent_left) + "," + (e.pageY-parent_top) + ")'>Un routeur</li><li onClick='javascript:add_nas(" + (e.pageX-parent_left) + "," + (e.pageY-parent_top) + ")'>Un nas</li><li onClick='javascript:add_mini_switch(" + (e.pageX-parent_left) + "," + (e.pageY-parent_top) + ")'>Un mini switch</li><li onClick='javascript:add_transceiver(" + (e.pageX-parent_left) + "," + (e.pageY-parent_top) + ")'>Un transciever</li><li onClick='javascript:add_group_zone(" + (e.pageX-parent_left) + "," + (e.pageY-parent_top) + ")'>Une zone de groupe</li><li onClick='javascript:add_group_texte(" + (e.pageX-parent_left) + "," + (e.pageY-parent_top) + ")'>Une zone de texte</li></ul>";
		
		//<li onClick='javascript:add_mini_switch(" + (e.pageX-parent_left) + "," + (e.pageY-parent_top) + ")'>Un mini switch</li>
		
		$("#MAIN_CONTEXTUAL_MENU").html(menu);

		if ( (e.pageY + $("#MAIN_CONTEXTUAL_MENU").height()) > ($(document).height()+50) )
		{
			$("#MAIN_CONTEXTUAL_MENU").css("top",e.pageY-($("#MAIN_CONTEXTUAL_MENU").height()-20) + "px");
		}
		else
		{
			$("#MAIN_CONTEXTUAL_MENU").css("top",e.pageY-20 + "px");
		}
		
		$("#MAIN_CONTEXTUAL_MENU").css("left",e.pageX-80 + "px");
		$("#MAIN_CONTEXTUAL_MENU").fadeIn(200);

      		return false;
	});

	$("#SCROLLER_H").draggable({
		containment: 'parent',
		axis: "x",
		drag: function() {
			var siz_sup = $("#SUPPORT_SCROLLER_H").width() - $("#SCROLLER_H").width();
			$("#SUPPORT_GRAPH").css("left", "-" + ($(this).position().left*(2000-$(document).width()))/siz_sup + "px");
		}
	});

	$("#SCROLLER_V").draggable({
		containment: 'parent',
		axis: "y",
		drag: function() {
			var siz_sup = $("#SUPPORT_SCROLLER_V").height() - $("#SCROLLER_V").height();
			var pos_y_s = (($(this).position().top*(1500-$(document).height()))/siz_sup)*-1;
			$("#SUPPORT_GRAPH").css("top", pos_y_s + "px");
		}
	});

});

function show_left_menu()
{
       if ( left_open_running == 1 )
       {
	      return;
       }
       left_open_running = 1;
       if ( left_open == 0 )
       {
	      $("#ZONE_NOM_SITE").fadeOut(400);
	      $("#APPS_GRAPH").animate({
		  left: "+=320px"
		  }, 400, function(){
		      left_open = 1;
		      left_open_running = 0;
		      $("#TOP_BT_1").addClass("bt_top_menu_select");
		  }
	      );
       }
       else
       {
	      $("#ZONE_NOM_SITE").fadeIn(400);	      
	      $("#APPS_GRAPH").animate({
		  left: "-=320px"
		  }, 400, function(){
		      left_open = 0;
		      left_open_running = 0;
		      $("#TOP_BT_1").removeClass("bt_top_menu_select");
		  }
	      );
       }
}

function show_hide_contacts()
{
	$("#BT_DEL_LEFT").fadeOut(400);
	if ( comp_open == 1 )
	{
		comp_open = 0;
		$("#COMPUTERS_DIV").slideToggle(400);
	}

	if ( docu_open == 1 )
	{
		docu_open = 0;
		$("#DOCUMENTS_DIV").slideToggle(400);
	}	
	
	$("#INFORMATION_DIV").slideToggle(400);

	if ( info_open == 1 )
	{
		info_open = 0;
	}
	else
	{
		info_open = 1;
	}
	
	if ( comp_open == 1 || info_open == 1 || docu_open == 1 )
	{
		$("#BOTTOM_LEFT_MENU").fadeIn(400);
	}
	else
	{
		$("#BOTTOM_LEFT_MENU").fadeOut(400);
	}
}

function show_hide_computers()
{
	$("#BT_DEL_LEFT").fadeOut(400);
	if ( info_open == 1 )
	{
		info_open = 0;
		$("#INFORMATION_DIV").slideToggle(400);
	}

	if ( docu_open == 1 )
	{
		docu_open = 0;
		$("#DOCUMENTS_DIV").slideToggle(400);
	}	
	
	$("#COMPUTERS_DIV").slideToggle(400);
	
	if ( comp_open == 1 )
	{
		comp_open = 0;
	}
	else
	{
		comp_open = 1;
	}
	
	if ( comp_open == 1 || info_open == 1 || docu_open == 1 )
	{
		$("#BOTTOM_LEFT_MENU").fadeIn(400);
	}
	else
	{
		$("#BOTTOM_LEFT_MENU").fadeOut(400);
	}	
}

function show_hide_documents()
{
	$(".DEL_FILES:checked").removeAttr("checked");
	$("#BT_DEL_LEFT").fadeOut(400);
	if ( info_open == 1 )
	{
		info_open = 0;
		$("#INFORMATION_DIV").slideToggle(400);
	}

	if ( comp_open == 1 )
	{
		comp_open = 0;
		$("#COMPUTERS_DIV").slideToggle(400);
	}	
	
	$("#DOCUMENTS_DIV").slideToggle(400);
	
	if ( docu_open == 1 )
	{
		docu_open = 0;
	}
	else
	{
		docu_open = 1;
	}
	
	if ( comp_open == 1 || info_open == 1 || docu_open == 1 )
	{
		$("#BOTTOM_LEFT_MENU").fadeIn(400);
	}
	else
	{
		$("#BOTTOM_LEFT_MENU").fadeOut(400);
	}	
}

function add_something()
{
	if ( docu_open == 1 )
	{
	        $.ajax({
			url: "upload_frame.php",
			success: function(response) {
				$("#SUB_LEFT_MENU").html(response);
				$("#SUB_LEFT_MENU").fadeIn(400);
			}
		});
		return;
	}
	if ( info_open == 1 )
	{
	        $.ajax({
			url: "edit_contacts.php",
			success: function(response) {
				$("#SUB_LEFT_MENU").html(response);
				$("#SUB_LEFT_MENU").fadeIn(400);
			}
		});
		return;
	}
	if ( comp_open == 1 )
	{
	        $.ajax({
			url: "edit_computers.php",
			success: function(response) {
				$("#SUB_LEFT_MENU").html(response);
				$("#SUB_LEFT_MENU").fadeIn(400);
			}
		});
		return;
	}
}

function bye_something()
{
	$("#SUB_LEFT_MENU").fadeOut(400);
}

function load_files()
{
    $.ajax({
	url: "liste_files.php?ID=" + sessionStorage.getItem("SITKEY"),
	success: function(response) {
	    $("#DOCUMENTS_DIV").html(response);
	    
	    $(".DEL_FILES").click(function(){
		if ( $(".DEL_FILES:checked").length > 0 )
		{
			$("#BT_DEL_LEFT").fadeIn(400);	
		}
		else
		{
			$("#BT_DEL_LEFT").fadeOut(400);	
		}		
	    });
	}
    });       
}


function del_something()
{
	if ( docu_open == 1 )
	{
		wl_file = "";
		$.each($(".DEL_FILES:checked"), function(i,val){
		    wl_file += val.id + ";";
		});
			
		$.ajax({
		    url: "upload_files_suppression_valide.php?FILES=" + wl_file,
		    success: function(response) {
			load_files();
		    }
		});
	}
}

function edit_contact(id)
{
	$.ajax({
		url: "edit_contacts.php?ID=" + id,
		success: function(response) {
			$("#SUB_LEFT_MENU").html(response);
			$("#SUB_LEFT_MENU").fadeIn(400);
		}
	});
}

function edit_computer(id)
{
	$.ajax({
		url: "edit_computers.php?ID=" + id,
		success: function(response) {
			$("#SUB_LEFT_MENU").html(response);
			$("#SUB_LEFT_MENU").fadeIn(400);
		}
	});
}

$(".MAIN_LEFT_MENU").click(function(){
	$(".MAIN_LEFT_MENU").removeClass("selected_by_me");
	$("#" + $(this).attr("id")).addClass("selected_by_me");
});

var scr_width_grab = 0;
var scr_height_grab = 0;

var elem_grab = $("#SUPPORT_GRAPH");

</script>
