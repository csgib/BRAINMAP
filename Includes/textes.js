function add_group_texte(x,y)
{
	hide_contextual();

	$.ajax({
		type:"GET",
		url:"edit_texte.php?X=" + x + "&Y=" + y,
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN").fadeIn(400);
			$("#MODAL_ADD").fadeIn(400,function(){$("#FRM_ZONE_NAME").focus();});
		}
	});
}

function edit_texte(id)
{
	hide_contextual();

	$.ajax({
		type:"GET",
		url:"edit_texte.php?ID=" + id + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN").fadeIn(400);
			$("#MODAL_ADD").fadeIn(400,function(){$("#FRM_ZONE_NAME").focus();});
		}
	});
}

function update_texte_pos(id)
{
	$.ajax({
		type:"GET",
		url:"update_texte_position.php?ID=" + id.substring(1) + "&X=" + $("#" + id).position().left + "&Y=" + $("#" + id).position().top + "&SITE=" + sessionStorage.getItem("SITKEY") + "&W=" + $("#" + id).width() + "&H=" + $("#" + id).height(),
		success: function(retour){
		}
	});
}

function create_texte_on_map(num_texte, nom, x, y, w, h)
{
	var zznew_texte = "<div id='T" + num_texte + "' class='TEXTE_ZONE'><div class='TEXTE_TITLE'>" + nom + "</div></div>";

	$("#GRAPH").append(zznew_texte);
	
	$("#T" + num_texte).css('width', w + "px");
	$("#T" + num_texte).css('height', h + "px");
	$("#T" + num_texte).css('left', x + "px");
	$("#T" + num_texte).css('top', y + "px");
	
	$("#T" + num_texte).draggable({
		containment: "parent",
		stop: function(event, ui) {
			update_texte_pos($(this).attr('id'));
		}
	});
	
	$("#T" + num_texte).resizable({
		stop: function(event, ui) {
			update_texte_pos($(this).attr('id'));
		}
	});
	
	$("#T" + num_texte).css('position', "absolute");
	
	$("#T" + num_texte).bind("contextmenu",function(e){

		var parent_left = $("#GRAPH").position().left;
		var parent_top = $("#GRAPH").position().top;  

		var menu="<h2 class='title_form'>TEXTES</h2><ul><li onClick='javascript:edit_texte(\"" + $(this).attr("id") + "\")'>Modifier la zone de texte</li>";
		menu += "<li onClick='javascript:delete_texte(\"" + $(this).attr("id") + "\")'>Supprimer la zone de texte</li></ul>";

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

function delete_texte(id)
{
	hide_contextual();
	$.ajax({
		type:"GET",
		url:"confirmation_delete.php?SRC=TXT&ID=" + id.substring(1),
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN_NIV_2").fadeIn(400);
			$("#MODAL_ADD").fadeIn(400);
		}
	});
}

function valide_delete_texte(id)
{
	// ****************************************
	// *** SUPPRESSION DANS LA TABLE TEXTES ***
	// ****************************************
	$.ajax({
		type:"GET",
		url:"delete_texte.php?ID=" + id + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(response){
			if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 )
			{
				$("#T" + id).remove();
				$("#LOCK_SCREEN_NIV_2").fadeOut(400);
				$("#MODAL_ADD").fadeOut(400);				
			}
			else
			{
				$.gritter.add({
					title: 'Suppression texte',
					text: 'Erreur lors de la suppression de la zone de texte dans la base de données.',
					time: 1500
				});
			}
		},
	        error: function(){
			$.gritter.add({
				title: 'Suppression texte',
				text: 'Erreur lors de la suppression de la zone de texte dans la base de données.',
				time: 1500
			});
    		}
	});
}

