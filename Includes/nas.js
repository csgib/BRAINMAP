function add_nas(x,y)
{
	hide_contextual();

	$.ajax({
		type:"GET",
		url:"edit_nas.php?X=" + x + "&Y=" + y,
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN").fadeIn(400);
			$("#MODAL_ADD").fadeIn(600,function(){
				$("#FRM_NAS_NAME").focus();
			});
		}
	});
}

function edit_nas(id)
{
	hide_contextual();

	$.ajax({
		type:"GET",
		url:"edit_nas.php?ID=" + id + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN").fadeIn(400);
			$("#MODAL_ADD").fadeIn(600,function(){
				$("#FRM_NAS_NAME").focus();
			});
		}
	});
}

function update_nas_pos(id)
{
	$.ajax({
		type:"GET",
		url:"update_nas_position.php?ID=" + id.substring(1) + "&X=" + $("#" + id).position().left + "&Y=" + $("#" + id).position().top + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(retour){
		}
	});
}

function create_nas_on_map(num_nas, title, x, y)
{
	var new_nas = "<div id='N" + num_nas + "' class='NAS'><div class='NAS_SUPPORT'></div><div class='NAS_TITLE'>" + title + "</div></div>"; 
	$("#GRAPH").append(new_nas);
	
	$("#N" + num_nas).css('left', x + "px");
	$("#N" + num_nas).css('top', y + "px");

	$("#N" + num_nas).draggable({
		containment: "parent",
		/*.NAS_TITLE",*/
		start: function() {
		},
		drag: function() {
			join();
		},
		stop: function(event, ui) {
			update_nas_pos($(this).attr('id'));
		}
	});
	
	$("#N" + num_nas).mouseenter(function(){
		over_elem = "N" + num_nas;
		join();
	});

	$("#N" + num_nas).mouseleave(function(){
		over_elem = "";
		join();
	});

	$("#N" + num_nas).bind("contextmenu",function(e){

		var parent_left = $("#GRAPH").position().left;
		var parent_top = $("#GRAPH").position().top;  

		var menu="<h2 class='title_form'>NAS</h2><ul><li onClick='javascript:edit_nas(\"" + $(this).attr("id") + "\")'>Modifier le nas</li>";
		menu +="<li onClick='javascript:delete_nas(\"" + $(this).attr("id") + "\")'>Supprimer le nas</li></ul>";
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

function delete_nas(id)
{
	hide_contextual();
	$.ajax({
		type:"GET",
		url:"confirmation_delete.php?SRC=NAS&ID=" + id.substring(1),
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN_NIV_2").fadeIn(400);
			$("#MODAL_ADD").fadeIn(400);
		}
	});
}

function valide_delete_nas(id)
{
	// *********************************************
	// *** SUPPRESSION DANS LA TABLE DES SWITCHS ***
	// *********************************************
	$.ajax({
		type:"GET",
		url:"delete_nas.php?ID=" + id + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(response){
			if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 )
			{
				$("#N" + id).remove();

				// ***************************************************
				// *** SUPPRESSION DANS LA TABLE DES LIENS MEMOIRE ***
				// ***************************************************

				var idx = 0;
				var elem;

				while ( idx < wg_table_links.length )
				{
					elem = wg_table_links[idx].split(";");

					if ( elem[0] == "N" + id || elem[1] == "N" + id )
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
					title: 'Suppression nas',
					text: 'Erreur lors de la suppression du nas dans la base de données.',
					time: 1500
				});
			}
		},
	        error: function(){
			$.gritter.add({
				title: 'Suppression nas',
				text: 'Erreur lors de la suppression du nas dans la base de données.',
				time: 1500
			});
    		}
	});
}

