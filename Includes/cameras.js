function add_camera(x,y)
{
	hide_contextual();

	$.ajax({
		type:"GET",
		url:"edit_camera.php?X=" + (x-125) + "&Y=" + (y-75),
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN").fadeIn(400);
			$("#MODAL_ADD").fadeIn(600,function(){$("#FRM_CAMERA_NOM").focus();});
		}
	});
}

function edit_camera(id)
{
	hide_contextual();

	$.ajax({
		type:"GET",
		url:"edit_camera.php?ID=" + id + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN").fadeIn(400);
			$("#MODAL_ADD").fadeIn(600,function(){$("#FRM_CAMERA_NOM").focus();});
		}
	});
}

function update_camera_pos(id)
{
	$.ajax({
		type:"GET",
		url:"update_camera_position.php?ID=" + id.substring(1) + "&X=" + $("#" + id).position().left + "&Y=" + $("#" + id).position().top + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(retour){
		}
	});
}

function create_camera_on_map(num_camera, x, y, title)
{
	var zznew_camera = "<div id='K" + num_camera + "' class='CAMERA'><div class='CAMERA_SUPPORT'></div><div class='CAMERA_TITLE'>" + title + "</div></div>";

	$("#GRAPH").append(zznew_camera);
	
	$("#K" + num_camera).css('left', x + "px");
	$("#K" + num_camera).css('top', y + "px");
	
	$("#K" + num_camera).mouseenter(function(){
		over_elem = "K" + num_camera;
		join();
	});

	$("#K" + num_camera).mouseleave(function(){
		over_elem = "";
		join();
	});	
	
	$("#K" + num_camera).draggable({
		containment: "parent",
		drag: function() {
			join();
		},
		stop: function(event, ui) {
			update_camera_pos($(this).attr('id'));
		}
	});
	

	$("#K" + num_camera).bind("contextmenu",function(e){

		var parent_left = $("#GRAPH").position().left;
		var parent_top = $("#GRAPH").position().top;  

		var menu="<h2 class='title_form'>CAMERAS</h2><ul><li onClick='javascript:edit_camera(\"" + $(this).attr("id") + "\")'>Modifier la camera</li>";
		menu += "<li onClick='javascript:delete_camera(\"" + $(this).attr("id") + "\")'>Supprimer la camera</li></ul>";

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

function delete_camera(id)
{
	hide_contextual();
	$.ajax({
		type:"GET",
		url:"confirmation_delete.php?SRC=CAM&ID=" + id.substring(1),
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN_NIV_2").fadeIn(400);
			$("#MODAL_ADD").fadeIn(400);
		}
	});
}

function valide_delete_camera(id)
{
	// *********************************************
	// *** SUPPRESSION DANS LA TABLE DES CAMERAS ***
	// *********************************************
	$.ajax({
		type:"GET",
		url:"delete_camera.php?ID=" + id + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(response){
			if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 )
			{
				$("#K" + id).remove();
				
				// ***************************************************
				// *** SUPPRESSION DANS LA TABLE DES LIENS MEMOIRE ***
				// ***************************************************

				var idx = 0;
				var elem;

				while ( idx < wg_table_links.length )
				{
					elem = wg_table_links[idx].split(";");

					if ( elem[0] == "K" + id || elem[1] == "K" + id )
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
					title: 'Suppression camera',
					text: 'Erreur lors de la suppression de la camera dans la base de données.',
					time: 1500
				});
			}
		},
	        error: function(){
			$.gritter.add({
				title: 'Suppression camera',
				text: 'Erreur lors de la suppression de la camera dans la base de données.',
				time: 1500
			});
    		}
	});
}

