function add_serveur(x,y)
{
	hide_contextual();

	$.ajax({
		type:"GET",
		url:"edit_serveur.php?X=" + x + "&Y=" + y + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(retour){			
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN").fadeIn(400);
			$("#MODAL_ADD").fadeIn(600,function(){$("#COMMENTAIRES").focus();});
		}
	});
}

function update_serveur_pos(id)
{
	$.ajax({
		type:"GET",
		url:"update_serveur_position.php?ID=" + id.substring(1) + "&X=" + $("#" + id).position().left + "&Y=" + $("#" + id).position().top + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(retour){
		}
	});
}

function edit_serveur(id)
{
	hide_contextual();

	$.ajax({
		type:"GET",
		url:"edit_serveur.php?ID=" + id + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(retour){		
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN").fadeIn(400);
			$("#MODAL_ADD").fadeIn(400);
		}
	});
}

function create_serveur_on_map(num_serveur, title, x, y, web_interface, web_port, web_ssl, web_ip, wl_ondulee, firewall)
{
	if ( firewall == "1" )
	{
		var new_serveur = "<div id='S" + num_serveur + "' class='SERVEUR'><div class='SERVEUR_SUPPORT SERVEUR_SUPPORT_FIREWALL'><div class='SERVEUR_ONDULEE'></div></div><div class='SERVEUR_TITLE'>" + title + "</div></div>"; 
	}
	else
	{
		var new_serveur = "<div id='S" + num_serveur + "' class='SERVEUR'><div class='SERVEUR_SUPPORT'><div class='SERVEUR_ONDULEE'></div></div><div class='SERVEUR_TITLE'>" + title + "</div></div>"; 
	}
	
	$("#GRAPH").append(new_serveur);

	if ( wl_ondulee == "0" )
	{
		$("#S" + num_serveur + " .SERVEUR_SUPPORT > .SERVEUR_ONDULEE").fadeOut(0);
	}
	
	$("#S" + num_serveur).css('left', x + "px");
	$("#S" + num_serveur).css('top', y + "px");

	$("#S" + num_serveur).draggable({
		containment: "parent",
		/*handle:	".SERVEUR_TITLE",*/
		start: function() {
		},
		drag: function() {
			join();
		},
		stop: function(event, ui) {
			update_serveur_pos($(this).attr('id'));
		}
	});
	
	$("#S" + num_serveur).mouseenter(function(){
		over_elem = "S" + num_serveur;
		join();
	});

	$("#S" + num_serveur).mouseleave(function(){
		over_elem = "";
		join();
	});

	$("#S" + num_serveur).bind("contextmenu",function(e){

		var parent_left = $("#GRAPH").position().left;
		var parent_top = $("#GRAPH").position().top;  

		var menu="<h2 class='title_form'>SERVEURS</h2><ul><li onClick='javascript:edit_serveur(\"" + $(this).attr("id") + "\")'>Modifier le serveur</li>";
		menu += "<li onClick='javascript:delete_serveur(\"" + $(this).attr("id") + "\")'>Supprimer le serveur</li>";

		if ( web_interface == "1" )
		{
			if ( web_ssl != "1" )
			{
				web_ssl = 0;
			}			
			menu +="<li onClick='javascript:admin_web_serveur(\"" + web_ip + "\"," + web_port + "," + web_ssl + ")'>Administration</li>";
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
		$("#MAIN_CONTEXTUAL_MENU").fadeIn(400);

      		return false;
	});
}

function delete_serveur(id)
{
	hide_contextual();
	$.ajax({
		type:"GET",
		url:"confirmation_delete.php?SRC=SRV&ID=" + id.substring(1),
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN_NIV_2").fadeIn(400);
			$("#MODAL_ADD").fadeIn(400);
		}
	});
}

function valide_delete_serveur(id)
{
	// *********************************************
	// *** SUPPRESSION DANS LA TABLE DES SWITCHS ***
	// *********************************************
	$.ajax({
		type:"GET",
		url:"delete_serveur.php?ID=" + id + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(response){
			if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 )
			{
				$("#S" + id).remove();

				// ***************************************************
				// *** SUPPRESSION DANS LA TABLE DES LIENS MEMOIRE ***
				// ***************************************************

				var idx = 0;
				var elem;

				while ( idx < wg_table_links.length )
				{
					elem = wg_table_links[idx].split(";");

					if ( elem[0] == "S" + id || elem[1] == "S" + id )
					{
						wg_table_links.splice(idx,1);
						idx--;
					}
					idx++;
				}

				join();

				$("#LOCK_SCREEN_DELETE").fadeOut(400);
				$("#MODAL_ADD").fadeOut(400);
			}
			else
			{
				$.gritter.add({
					title: 'Suppression serveur',
					text: 'Erreur lors de la suppression du serveur dans la base de données.',
					time: 1500
				});
			}
		},
	        error: function(){
			$.gritter.add({
				title: 'Suppression serveur',
				text: 'Erreur lors de la suppression du serveur dans la base de données.',
				time: 1500
			});
    		}
	});
}

function admin_web_serveur(ip, port, ssl)
{
	hide_contextual();

	if ( ssl == 0 )
	{
		window.open("http://" + ip + ":" + port);
	}
	else
	{
		window.open("https://" + ip + ":" + port);
	}
}

function open_edit_link_card(idport)
{
	var tport;

	if ( $("#FRM_SERVEUR_LAN_TYPE_" + (idport-1)).val() == "0" )
	{
		tport = 0;
		$("#FRM_TP_PORT").val("E");
		$(".OPTMSWITCH").css("display", "block");
	}
	else
	{
		tport = 1;
		$("#FRM_TP_PORT").val("F");
		$(".OPTMSWITCH").css("display", "none");
	}

	$("#FRM_SRC_PORT").val(idport);
	// *** RECUPERATION DES VALEURS DEJA SAISIES SI ELLES EXISTENT ***
	
	$.ajax({
		type:"GET",
		url:"load_object_links.php?IP=" + $("#FRM_SRC_IP").val() + "&SITE=" + sessionStorage.getItem("SITKEY") + "&PORT=" + idport + "&TPORT=" + tport,
		success: function(retour){
			retour = retour.replace(/^\s+/g,'').replace(/\s+$/g,'');
			if ( retour.substring(0,1) == "S" || retour.substring(0,1) == "M" || retour.substring(0,1) == "R" || retour.substring(0,1) == "N" || retour.substring(0,1) == "K" || retour.substring(0,1) == "A" )
			{
				if ( retour.substring(0,1) == "S" || retour.substring(0,1) == "M" )
				{
					var elem = retour.split(";");

					var porty;

					if ( elem[2] == "0" )
					{
						porty = "E" + elem[1];
					}
					else
					{
						porty = "F" + elem[1];
					}
					$("#WA_EDIT").val(porty);

					$("#FRM_LINK_OBJECT").val(elem[0]).trigger("liszt:updated");
					$("#FRM_LINK_OBJECT").trigger("change");

				}
				else
				{
					var elem = retour.split(";");

					$("#FRM_LINK_OBJECT").val(elem[0]).trigger("liszt:updated");
					$("#FRM_LINK_OBJECT").trigger("change");
					$("#FRM_SAV_IP").val(elem[0]);
				}

				$("#LINK_EDIT").animate({
					top: '0px',		
				},400);
			}
			else
			{
				if ( retour.length > 0 )
				{
					if ( retour.substring(0,1) == "M" )
					{
						var elem = retour.split(";");

						var porty;

						if ( elem[2] == "0" )
						{
							porty = "E" + elem[1];
						}
						else
						{
							porty = "F" + elem[1];
						}
						$("#WA_EDIT").val(porty);

						$("#FRM_LINK_OBJECT").val(elem[0]).trigger("liszt:updated");
						$("#FRM_LINK_OBJECT").trigger("change");
									
						$("#FRM_SAV_IP").val(elem[0] + ";" + elem[1]);
					}
					else
					{
						var elem = retour.split(";");

						var linky = elem[0] + ";" + elem[2];
						var porty;

						if ( elem[3] == "0" )
						{
							porty = "E" + elem[1];
						}
						else
						{
							porty = "F" + elem[1];
						}
						$("#WA_EDIT").val(porty);

						$("#FRM_LINK_OBJECT").val(linky).trigger("liszt:updated");
						$("#FRM_LINK_OBJECT").trigger("change");
						
						$("#FRM_SAV_IP").val(elem[0]);
					}
				}
				else
				{
					$("#FRM_LINK_OBJECT").val("").trigger("liszt:updated");
					$("#FRM_LINK_OBJECT").trigger("change");
					$("#WA_EDIT").val("");
					
					$("#FRM_SAV_IP").val("");
				}

				$("#LINK_EDIT").animate({
					top: '0px',		
				},400);
			}
		}
	});
}

function close_edit_link_card()
{
	//$("#LINK_EDIT").fadeOut(400);
	$("#LINK_EDIT").animate({
		top: '-=100%',		
	},400);	
}
