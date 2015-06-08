function add_baie(x,y)
{
	hide_contextual();

	$.ajax({
		type:"GET",
		url:"edit_baie.php?X=" + x + "&Y=" + y,
		success: function(retour){			
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN").fadeIn(400);
			$("#MODAL_ADD").fadeIn(400,function(){$("#COMMENTAIRES").focus();});
		}
	});
}

function rename_baie(id)
{
	hide_contextual();
	$.ajax({
		type:"GET",
		url:"edit_baie.php?X=" + $("#" + id).position().left + "&Y=" + $("#" + id).position().top + "&ID=" + id,
		success: function(retour){		
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN").fadeIn(400);
			$("#MODAL_ADD").fadeIn(400,function(){$("#COMMENTAIRES").focus();});
		}
	});
}

function update_baie_pos(id)
{
	$.ajax({
		type:"GET",
		url:"update_baie_position.php?ID=" + id + "&X=" + $("#" + id).position().left + "&Y=" + $("#" + id).position().top + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(retour){
		}
	});
}

function add_context_baie()
{
	$(".baie").bind("contextmenu",function(e){

		var parent_left = 0; //$("#GRAPH").position().left;
		var parent_top = 0; //$("#GRAPH").position().top;  

		var menu="<h2 class='title_form'>BAIES</h2><ul><li onClick='javascript:rename_baie(" + $(this).attr("id") + ")'>Modifier la baie</li>";

		if ( ($("#" + $(this).attr("id") + " > .BAIE_SUPPORT .SWITCH").length) == 0 )
		{
			menu += "<li onClick='javascript:delete_baie(" + $(this).attr("id") + ")'>Supprimer la baie</li>"
			menu += "<li onClick='javascript:add_switch(" + $(this).attr("id") + ")'>Ajouter un switch</li>";
		}
		else
		{
			menu += "<li onClick='javascript:add_switch(" + $(this).attr("id") + ")'>Ajouter un switch</li>";
			menu += "<li onClick='javascript:edit_baie_switch(" + $(this).attr("id") + ")'>Visualiser la baie</li>";
		}
	
		menu += "</ul>";

		$("#MAIN_CONTEXTUAL_MENU").html(menu);
		
		if ( (e.clientY + $("#MAIN_CONTEXTUAL_MENU").height()) > $(document).height() )
		{
			$("#MAIN_CONTEXTUAL_MENU").css("top",e.clientY-($("#MAIN_CONTEXTUAL_MENU").height()-10) + "px");
		}
		else
		{
			$("#MAIN_CONTEXTUAL_MENU").css("top",e.clientY-30 + "px");
		}

		$("#MAIN_CONTEXTUAL_MENU").css("left",(e.pageX-parent_left)-80 + "px");
		//$("#MAIN_CONTEXTUAL_MENU").css("top",(e.pageY-parent_top)-20 + "px");
		$("#MAIN_CONTEXTUAL_MENU").fadeIn(400);

      		return false;
	});
}

function delete_baie(id)
{
	hide_contextual();
	$.ajax({
		type:"GET",
		url:"confirmation_delete.php?SRC=BAI&ID=" + id,
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN_NIV_2").fadeIn(400);
			$("#MODAL_ADD").fadeIn(400);
		}
	});
}

function valide_delete_baie(id)
{
	// *******************************************
	// *** SUPPRESSION DANS LA TABLE DES BAIES ***
	// *******************************************
	$.ajax({
		type:"GET",
		url:"delete_baie.php?ID=" + id + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(response){
			if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 )
			{
				$("#" + id).remove();
				$("#LOCK_SCREEN_NIV_2").fadeOut(400);
				$("#MODAL_ADD").fadeOut(400);
			}
			else
			{
				$.gritter.add({
					title: 'Suppression baie',
					text: 'Erreur lors de la suppression de la baie dans la base de données.',
					time: 1500
				});
			}
		},
		error: function(){
			$.gritter.add({
				title: 'Suppression baie',
				text: 'Erreur lors de la suppression de la baie dans la base de données.',
				time: 1500
			});
    		}
	});
}

function edit_baie_switch(id)
{
	hide_contextual();
	table_edit_max_switch = 0;
	$.ajax({
		type:"GET",
		url:"edit_baie_switch.php?ID=" + id + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			
			$("#LOCK_SCREEN").fadeIn(400);
			$("#MODAL_ADD").fadeIn(400);
			
			$('#CONTENT_SUB_BAIE').animate({
				scrollTop: 0
			}, 0);	
			
			join_inner();
		}
	});
}

function create_baie_on_map(num_baie, title, x, y, ondulee)
{
	var new_baie = "<div id='" + num_baie + "' class='BAIE'><div class='BAIE_TITLE'>" + title + "</div><div class='BAIE_SUPPORT'></div></div>"; 
	$("#GRAPH").append(new_baie);
	
	$("#" + num_baie).css('left', x + "px");
	$("#" + num_baie).css('top', y + "px");

	if ( ondulee == 1 )
	{
		 $("#" + num_baie).addClass("ONDULEE");
	}
	
	$("#" + num_baie).droppable({
	       drop : function(event, ui){
			  
		      if ( ui.draggable.attr('id').substring(0,4) == "ADD_" )
		      {
			     if ( ui.draggable.attr('id') == "ADD_SWI")
			     {
				var wl_baie_id = $(this).attr("id");
				var wl_d = new Date();
				var wl_ip_tmp = wl_d.getHours() + "." + wl_d.getMinutes() + "." + wl_d.getSeconds() + "." + wl_d.getDate()
				    $.ajax({
					   data: {
						  'SITE': sessionStorage.getItem('SITKEY'),
						  'BAIE_ID': $(this).attr("id"),
						  'FRM_SWITCH_MARQUE': 'Non configuré',
						  'FRM_SWITCH_COMMENTAIRES': '',
						  'X': x,
						  'Y': y,
						  'FRM_SWITCH_IP': wl_ip_tmp,
						  'FRM_NOMBRE_SWITCH': $("#" + $(this).attr("id") + " .BAIE_SUPPORT > .SWITCH").length,
						  'FRM_SWITCH_FIBER_PORTS': $("#SW_PORTSF").val(),
						  'FRM_SWITCH_WEB_PORT': '',
						  'FRM_SWITCH_NOMBRE_PORTS': $("#SW_PORTS").val(),
						  'ISNEW': '1'
					   },
					   type: "POST",
					   url: "insert_switch.php",
					   success: function(response) {
						  if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 )
						  {
							 create_switch_on_baie(wl_baie_id, wl_ip_tmp, $("#" + $(this).attr("id") + " .BAIE_SUPPORT > .SWITCH").length, "Non configuré", "", "0", "", "", $("#SW_PORTS").val());
						  }
						  else
						  {
							 $.gritter.add({
								 title: 'Création switch',
								 text: 'Erreur lors de la création du switch dans la base de données.',
								 time: 1500
							 });						 
						  }
					   }
				    });
				    return;
			     }		     
		      }
	       }
	});	

	$("#" + num_baie).draggable({
		containment: "parent",
		/*handle:	".BAIE_TITLE",*/
		start: function() {
		},
		drag: function() {
			join();
		},
		stop: function(event, ui) {
			update_baie_pos($(this).attr('id'));
		}
	});
	add_context_baie();
}
