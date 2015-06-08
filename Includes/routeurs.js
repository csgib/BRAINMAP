function add_routeur(x,y)
{
	hide_contextual();

	$.ajax({
		type:"GET",
		url:"edit_routeur.php?X=" + x + "&Y=" + y,
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN").fadeIn(400);
			$("#MODAL_ADD").fadeIn(600,function(){$("#FRM_ROUTEUR_NAME").focus();});
		}
	});
}

function edit_routeur(id)
{
	hide_contextual();

	$.ajax({
		type:"GET",
		url:"edit_routeur.php?ID=" + id + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN").fadeIn(400);
			$("#MODAL_ADD").fadeIn(600,function(){$("#FRM_ROUTEUR_NAME").focus();});
		}
	});
}

function update_routeur_pos(id)
{
	$.ajax({
		type:"GET",
		url:"update_routeur_position.php?ID=" + id.substring(1) + "&X=" + $("#" + id).position().left + "&Y=" + $("#" + id).position().top + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(retour){
		}
	});
}

function create_routeur_on_map(num_routeur, title, x, y, wifi)
{
	var new_routeur = "<div id='R" + num_routeur + "' class='ROUTEUR'><div class='ROUTEUR_WIFI'></div><div class='ROUTEUR_SUPPORT'></div><div class='ROUTEUR_TITLE'>" + title + "</div></div>"; 
	$("#GRAPH").append(new_routeur);
	
	$("#R" + num_routeur).css('left', x + "px");
	$("#R" + num_routeur).css('top', y + "px");

	if ( wifi == "0" )
	{
		$("#R" + num_routeur + " > .ROUTEUR_WIFI").hide();
	}

	$("#R" + num_routeur).draggable({
		containment: "parent",
		/*.ROUTEUR_TITLE",*/
		start: function() {
		},
		drag: function() {
			join();
		},
		stop: function(event, ui) {
			update_routeur_pos($(this).attr('id'));
		}
	});
	
	$("#R" + num_routeur).mouseenter(function(){
		over_elem = "R" + num_routeur;
		join();
	});

	$("#R" + num_routeur).mouseleave(function(){
		over_elem = "";
		join();
	});

	$("#R" + num_routeur).bind("contextmenu",function(e){

		var parent_left = $("#GRAPH").position().left;
		var parent_top = $("#GRAPH").position().top;  

		var menu="<h2 class='title_form'>ROUTEURS</h2><ul><li onClick='javascript:edit_routeur(\"" + $(this).attr("id") + "\")'>Modifier le routeur</li>";
		menu += "<li onClick='javascript:delete_routeur(\"" + $(this).attr("id") + "\")'>Supprimer le routeur</li></ul>";

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

function delete_routeur(id)
{
	hide_contextual();
	$.ajax({
		type:"GET",
		url:"confirmation_delete.php?SRC=ROU&ID=" + id.substring(1),
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN_NIV_2").fadeIn(400);
			$("#MODAL_ADD").fadeIn(400);
		}
	});
}

function valide_delete_routeur(id)
{
	// *********************************************
	// *** SUPPRESSION DANS LA TABLE DES SWITCHS ***
	// *********************************************
	$.ajax({
		type:"GET",
		url:"delete_routeur.php?ID=" + id + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(response){
			if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 )
			{
				$("#R" + id).remove();

				// ***************************************************
				// *** SUPPRESSION DANS LA TABLE DES LIENS MEMOIRE ***
				// ***************************************************

				var idx = 0;
				var elem;

				while ( idx < wg_table_links.length )
				{
					elem = wg_table_links[idx].split(";");

					if ( elem[0] == "R" + id || elem[1] == "R" + id )
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
					title: 'Suppression routeur',
					text: 'Erreur lors de la suppression du routeur dans la base de données.',
					time: 1500
				});
			}
		},
	        error: function(){
			$.gritter.add({
				title: 'Suppression routeur',
				text: 'Erreur lors de la suppression du routeur dans la base de données.',
				time: 1500
			});
    		}
	});
}

