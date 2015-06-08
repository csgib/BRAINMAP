function add_group_zone(x,y)
{
	hide_contextual();

	$.ajax({
		type:"GET",
		url:"edit_zone.php?X=" + (x-125) + "&Y=" + (y-75),
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN").fadeIn(400);
			$("#MODAL_ADD").fadeIn(600,function(){$("#FRM_ZONE_NAME").focus();});
		}
	});
}

function edit_zone(id)
{
	hide_contextual();

	$.ajax({
		type:"GET",
		url:"edit_zone.php?ID=" + id + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN").fadeIn(400);
			$("#MODAL_ADD").fadeIn(600,function(){$("#FRM_ZONE_NAME").focus();});
		}
	});
}

function update_zone_pos(id)
{
	$.ajax({
		type:"GET",
		url:"update_zone_position.php?ID=" + id.substring(1) + "&X=" + $("#" + id).position().left + "&Y=" + $("#" + id).position().top + "&SITE=" + sessionStorage.getItem("SITKEY") + "&W=" + $("#" + id).width() + "&H=" + $("#" + id).height(),
		success: function(retour){
		}
	});
}

function create_zone_on_map(num_zone, nom, x, y, w, h, colorhex)
{
	var wl_red = hexToRgb(colorhex).r;
	var wl_green = hexToRgb(colorhex).g;
	var wl_blue = hexToRgb(colorhex).b;
	
	var zznew_zone = "<div id='Z" + num_zone + "' class='ZONE' style='background-color: rgba(" + wl_red + "," + wl_green + "," + wl_blue + ",0.2); border: 1px dotted rgba(" + wl_red + "," + wl_green + "," + wl_blue + ",0.4);'><div class='ZONE_TITLE'>" + nom + "</div></div>";

	$("#GRAPH").append(zznew_zone);
	
	$("#Z" + num_zone).css('width', w + "px");
	$("#Z" + num_zone).css('height', h + "px");
	$("#Z" + num_zone).css('left', x + "px");
	$("#Z" + num_zone).css('top', y + "px");
	
	$("#Z" + num_zone).draggable({
		containment: "parent",
		stop: function(event, ui) {
			update_zone_pos($(this).attr('id'));
		}
	});
	
	$("#Z" + num_zone).resizable({
		stop: function(event, ui) {
			update_zone_pos($(this).attr('id'));
		}
	});
	
	$("#Z" + num_zone).css('position', "absolute");
	
	$("#Z" + num_zone).bind("contextmenu",function(e){

		var parent_left = $("#GRAPH").position().left;
		var parent_top = $("#GRAPH").position().top;  

		var menu="<h2 class='title_form'>ZONES</h2><ul><li onClick='javascript:edit_zone(\"" + $(this).attr("id") + "\")'>Modifier la zone de groupe</li>";
		menu += "<li onClick='javascript:delete_zone(\"" + $(this).attr("id") + "\")'>Supprimer la zone de groupe</li></ul>";

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

function delete_zone(id)
{
	hide_contextual();
	$.ajax({
		type:"GET",
		url:"confirmation_delete.php?SRC=ZON&ID=" + id.substring(1),
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN_NIV_2").fadeIn(400);
			$("#MODAL_ADD").fadeIn(400);
		}
	});
}

function valide_delete_zone(id)
{
	// *********************************************
	// *** SUPPRESSION DANS LA TABLE DES SWITCHS ***
	// *********************************************
	$.ajax({
		type:"GET",
		url:"delete_zone.php?ID=" + id + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(response){
			if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 )
			{
				$("#Z" + id).remove();
				$("#LOCK_SCREEN_NIV_2").fadeOut(400);
				$("#MODAL_ADD").fadeOut(400);				
			}
			else
			{
				$.gritter.add({
					title: 'Suppression zone',
					text: 'Erreur lors de la suppression de la zone de groupe dans la base de données.',
					time: 1500
				});
			}
		},
	        error: function(){
			$.gritter.add({
				title: 'Suppression zone',
				text: 'Erreur lors de la suppression de la zone de groupe dans la base de données.',
				time: 1500
			});
    		}
	});
}

