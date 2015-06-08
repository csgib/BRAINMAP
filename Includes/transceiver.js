function add_transceiver(x,y)
{
	hide_contextual();

	$.ajax({
		type:"GET",
		url:"edit_transceiver.php?X=" + x + "&Y=" + y,
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN").fadeIn(400);
			$("#MODAL_ADD").fadeIn(600,function(){$("#FRM_CAMERA_NOM").focus();});
		}
	});
}

function edit_transceiver(id)
{
	hide_contextual();

	$.ajax({
		type:"GET",
		url:"edit_transceiver.php?ID=" + id + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN").fadeIn(400);
			$("#MODAL_ADD").fadeIn(600,function(){$("#FRM_CAMERA_NOM").focus();});
		}
	});
}

function update_transceiver_pos(id)
{
	$.ajax({
		type:"GET",
		url:"update_transceiver_position.php?ID=" + id.substring(1) + "&X=" + $("#" + id).position().left + "&Y=" + $("#" + id).position().top + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(retour){
		}
	});
}

function create_transceiver_on_map(num_transceiver, x, y, title)
{
	var zznew_transceiver = "<div id='T" + num_transceiver + "' class='TRANSCEIVER'><div class='TRANSCEIVER_SUPPORT'></div><div class='TRANSCEIVER_TITLE'>" + title + "</div></div>";

	$("#GRAPH").append(zznew_transceiver);
	
	$("#T" + num_transceiver).css('left', x + "px");
	$("#T" + num_transceiver).css('top', y + "px");
	
	$("#T" + num_transceiver).mouseenter(function(){
		over_elem = "T" + num_transceiver;
		join();
	});

	$("#T" + num_transceiver).mouseleave(function(){
		over_elem = "";
		join();
	});	
	
	$("#T" + num_transceiver).draggable({
		containment: "parent",
		drag: function() {
			join();
		},
		stop: function(event, ui) {
			update_transceiver_pos($(this).attr('id'));
		}
	});
	

	$("#T" + num_transceiver).bind("contextmenu",function(e){

		var parent_left = $("#GRAPH").position().left;
		var parent_top = $("#GRAPH").position().top;  

		var menu="<h2 class='title_form'>TRANSCEIVER</h2><ul><li onClick='javascript:edit_transceiver(\"" + $(this).attr("id") + "\")'>Modifier le transceiver</li>";
		menu += "<li onClick='javascript:delete_transceiver(\"" + $(this).attr("id") + "\")'>Supprimer le transceiver</li></ul>";

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
		$("#MAIN_CONTEXTUAL_MENU").fadeIn(400);

      		return false;
	});
}

function delete_transceiver(id)
{
	hide_contextual();
	$.ajax({
		type:"GET",
		url:"confirmation_delete.php?SRC=TRA&ID=" + id.substring(1),
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN_NIV_2").fadeIn(400);
			$("#MODAL_ADD").fadeIn(400);
		}
	});
}

function valide_delete_transceiver(id)
{
	// *********************************************
	// *** SUPPRESSION DANS LA TABLE DES CAMERAS ***
	// *********************************************
	$.ajax({
		type:"GET",
		url:"delete_transciever.php?ID=" + id + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(response){
			if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 )
			{
				$("#T" + id).remove();
				
				// ***************************************************
				// *** SUPPRESSION DANS LA TABLE DES LIENS MEMOIRE ***
				// ***************************************************

				var idx = 0;
				var elem;

				while ( idx < wg_table_links.length )
				{
					elem = wg_table_links[idx].split(";");

					if ( elem[0] == "T" + id || elem[1] == "T" + id )
					{
						wg_table_links.splice(idx,1);
						idx--;
					}
					idx++;
				}

				join();
				
				$("#LOCK_SCREEN_NIV_2").fadeOut(400);
				$("#MODAL_ADD").fadeOut(400);				
			}
			else
			{
				$.gritter.add({
					title: 'Suppression transceiver',
					text: 'Erreur lors de la suppression du transceiver dans la base de données.',
					time: 1500
				});
			}
		},
	        error: function(){
			$.gritter.add({
				title: 'Suppression transceiver',
				text: 'Erreur lors de la suppression du transceiver dans la base de données.',
				time: 1500
			});
    		}
	});
}

