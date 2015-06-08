function add_antenne(x,y)
{
	hide_contextual();

	$.ajax({
		type:"GET",
		url:"edit_antenne.php?X=" + (x-125) + "&Y=" + (y-75),
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN").fadeIn(400);
			$("#MODAL_ADD").fadeIn(600,function(){$("#FRM_ANTENNE_NOM").focus();});
		}
	});
}

function edit_antenne(id)
{
	hide_contextual();

	$.ajax({
		type:"GET",
		url:"edit_antenne.php?ID=" + id + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN").fadeIn(400);
			$("#MODAL_ADD").fadeIn(600,function(){$("#FRM_ANTENNE_NOM").focus();});
		}
	});
}

function update_antenne_pos(id)
{
	$.ajax({
		type:"GET",
		url:"update_antenne_position.php?ID=" + id.substring(1) + "&X=" + $("#" + id).position().left + "&Y=" + $("#" + id).position().top + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(retour){
		}
	});
}

function create_antenne_on_map(num_antenne, x, y, title, ip)
{
	var zznew_antenne = "<div id='A" + num_antenne + "' class='ANTENNE'><div class='ANTENNE_SUPPORT' id='" + ip + "' ip_ant='" + ip + "'></div><div class='ANTENNE_TITLE'>" + title + "</div></div>";

	$("#GRAPH").append(zznew_antenne);
	
	$("#A" + num_antenne).css('left', x + "px");
	$("#A" + num_antenne).css('top', y + "px");
	
	$("#A" + num_antenne).mouseenter(function(){
		over_elem = "A" + num_antenne;
		join();
	});

	$("#A" + num_antenne).mouseleave(function(){
		over_elem = "";
		join();
	});	
	
	$("#A" + num_antenne).draggable({
		containment: "parent",
		drag: function() {
			join();
		},
		stop: function(event, ui) {
			update_antenne_pos($(this).attr('id'));
		}
	});
	

	$("#A" + num_antenne).bind("contextmenu",function(e){

		var parent_left = $("#GRAPH").position().left;
		var parent_top = $("#GRAPH").position().top;  

		var menu="<h2 class='title_form'>ANTENNES</h2><ul><li onClick='javascript:edit_antenne(\"" + $(this).attr("id") + "\")'>Modifier l'antenne</li>";
		menu += "<li onClick='javascript:delete_antenne(\"" + $(this).attr("id") + "\")'>Supprimer l'antenne</li>";
		menu += "<li onClick='javascript:test_time(\"" + ip + "\")'>Ping de l'antenne</li></ul>";
		
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

function delete_antenne(id)
{
	hide_contextual();
	$.ajax({
		type:"GET",
		url:"confirmation_delete.php?SRC=ANT&ID=" + id.substring(1),
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN_NIV_2").fadeIn(400);
			$("#MODAL_ADD").fadeIn(400);
		}
	});
}

function valide_delete_antenne(id)
{
	// *********************************************
	// *** SUPPRESSION DANS LA TABLE DES ANTENNES ***
	// *********************************************
	$.ajax({
		type:"GET",
		url:"delete_antenne.php?ID=" + id + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(response){
			if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 )
			{
				$("#A" + id).remove();
				
				// ***************************************************
				// *** SUPPRESSION DANS LA TABLE DES LIENS MEMOIRE ***
				// ***************************************************

				var idx = 0;
				var elem;

				while ( idx < wg_table_links.length )
				{
					elem = wg_table_links[idx].split(";");

					if ( elem[0] == "A" + id || elem[1] == "A" + id )
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
					title: 'Suppression antenne',
					text: 'Erreur lors de la suppression de l\'antenne dans la base de données.',
					time: 1500
				});
			}
		},
	        error: function(){
			$.gritter.add({
				title: 'Suppression zone',
				text: 'Erreur lors de la suppression de l\'antenne dans la base de données.',
				time: 1500
			});
    		}
	});
}

