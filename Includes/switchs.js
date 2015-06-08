var table_edit_switch = new Array();
var table_edit_max_switch = 0;
var tempo;

function add_switch(id)
{
	hide_contextual();
	$.ajax({
		type:"GET",
		url:"edit_switch.php?ID=" + id,
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN").fadeIn(400);
			$("#MODAL_ADD").fadeIn(600,function(){$("#FRM_SWITCH_MARQUE").focus();});
		}
	});
}

function edit_switch_param(idbaie,id)
{
	hide_contextual();
	$.ajax({
		type:"GET",
		url:"edit_switch.php?ID=" + idbaie + "&IDS=" + id + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN").fadeIn(400);
			$("#MODAL_ADD").fadeIn(600,function(){$("#FRM_SWITCH_MARQUE").focus();});
		}
	});
}

function create_switch_on_baie(num_baie, switch_id, numero, switch_marque, fiber, web_interface, web_port, web_ssl, nb_port)
{
	var new_switch = "<div class='SWITCH' id='" + switch_id + "' others='" + escape(switch_marque) + ";" + fiber + ";" + web_interface + "' webi='" + web_interface + "' webp='" + web_port + "' webs='" + web_ssl + "'><table><tr>";
	
	if ( switch_id.substring(0,5) != "NOIP_" )
	{
		if ( web_interface == "1" )
		{
			new_switch += "<td style='width: 24px;'><img src='Images/support.png'></td>";
		}
		else
		{
			new_switch += "<td style='width: 24px;'><img src='Images/no_support.png'></td>";
		}
		new_switch += "<td class='INFO_SW' style='height: 40px;'>" + switch_marque.substr(0,14) + "<br>" + switch_id + "</td>";

	}
	else
	{
		new_switch += "<td style='width: 24px;'></td>";
		new_switch += "<td class='INFO_SW'>" + switch_marque.substr(0,14) + "<br><b>Non manageable</b></td>";	
	}	
	
	new_switch += "</tr></table></div>";
	
	$("#" + num_baie + " > .BAIE_SUPPORT").append(new_switch);
	
	var baie_height = ($("#" + num_baie + " > .BAIE_SUPPORT .SWITCH").length)*$(".SWITCH").height()+$("#" + num_baie + " > .BAIE_SUPPORT .SWITCH").length;
	$("#" + num_baie).css('height', (baie_height+40) + "px");
	$("#" + num_baie + " .BAIE_SUPPORT").css('height', baie_height + "px");
	
	var idconv = switch_id.replace(/(:|\.)/g,'\\$1');

	$("#" + idconv).mouseenter(function(){
		over_elem = switch_id;
		join();
		display_info_switch(switch_id,num_baie, $(this).attr("others"), nb_port);
		tempo=setInterval("display_popup()",300);
	});

	$("#" + idconv).mouseleave(function(){
		clearInterval(tempo);
		hide_info_switch();		
		over_elem = "";
		join();
	});
	
	$("#" + idconv).bind("contextmenu",function(e){
		var parent_left = $("#GRAPH").position().left;
		var parent_top = $("#GRAPH").position().top-50;  

		var menu="<h2 class='title_form'>SWITCHS</h2><ul>";
		menu += "<li onClick='javascript:edit_switch_param(" + num_baie + ",\"" + switch_id + "\")'>Modifier le switch</li>";

		if ( web_ssl != "1" )
		{
			web_ssl = 0;
		}

		var webp = $("#" + idconv).attr('webp');
		var webs = $("#" + idconv).attr('webs');


		menu+="<li id='liadmin' onClick='javascript:admin_web_switch(\"" + switch_id + "\"," + webp + "," + webs + ")'>Administration</li>";
		menu+="<li id='liadmin' onClick='javascript:test_time(\"" + switch_id + "\")'>Ping du switch</li>";
		menu+="<li onClick='javascript:edit_baie_switch(" + num_baie + ")'>Visualiser la baie</li>";

		menu += "</ul>";

		$("#MAIN_CONTEXTUAL_MENU").html(menu);

		if ( $("#" + idconv).attr('webi') == "0" )
		{
			$("#liadmin").hide();
		}

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

function update_switch_on_baie()
{
	reload_site();
}

function admin_web_switch(ip, port, ssl)
{
	if ( ssl == 0 )
	{
		window.open("http://" + ip + ":" + port);
	}
	else
	{
		window.open("https://" + ip + ":" + port);
	}
}


function edit_link_switch(id, site, ip)
{
	$.ajax({
		type:"GET",
		url:"edit_switch_links.php?ID=" + id + "&SITE=" + site + "&IP=" + ip,
		success: function(retour){
			$("#SUB_WINDOW").empty().append(retour);
			$("#SUB_WINDOW").fadeIn(400);
		}
	});
}

function close_edit_switch_link_window()
{
	$("#SUB_WINDOW").fadeOut(400);
	/*$("#LINK_EDIT").animate({
		top: '-=100%',		
	},400);*/
}

function open_edit_link(idport)
{
	$("#FRM_TP_PORT").val(idport.substring(0,1));
	
	if ( idport.substring(0,1) == "E" )
	{
		$("#FRM_TYPE_PORT").val("Ethernet " + idport.substring(1));
		$("#FRM_SRC_PORT").val(idport.substring(1));
		tport = 0;
	}
	else
	{
		$("#FRM_TYPE_PORT").val("Fibre " + idport.substring(1));
		$("#FRM_SRC_PORT").val(idport.substring(1));
		tport = 1;
	}

	$.ajax({
		type:"GET",
		url:"load_object_links.php?IP=" + $("#FRM_SRC_IP").val() + "&SITE=" + sessionStorage.getItem("SITKEY") + "&PORT=" + idport.substring(1) + "&TPORT=" + tport,
		success: function(retour){
			retour = retour.replace(/^\s+/g,'').replace(/\s+$/g,'');
			if ( (retour.substring(0,1) == "S" || retour.substring(0,1) == "T" || retour.substring(0,1) == "M" || retour.substring(0,1) == "R" || retour.substring(0,1) == "N" || retour.substring(0,1) == "K" || retour.substring(0,1) == "A") && retour.substring(0,5) != "NOIP_")
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

					$("#FRM_LINK_OBJECT").val(elem[0]); //.trigger("liszt:updated");
					$("#FRM_LINK_OBJECT").trigger("change");

				}
				else
				{
					var elem = retour.split(";");

					$("#FRM_LINK_OBJECT").val(elem[0]); //.trigger("liszt:updated");
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

					$("#FRM_LINK_OBJECT").val(linky); //.trigger("liszt:updated");
					$("#FRM_LINK_OBJECT").trigger("change");
				}
				else
				{
					$("#FRM_LINK_OBJECT").val(""); //.trigger("liszt:updated");
					$("#FRM_LINK_OBJECT").trigger("change");
					$("#WA_EDIT").val("");
				}

				$("#LINK_EDIT").animate({
					top: '0px',		
				},400);
			}
		}
	});
}

function close_edit_link()
{
	$('#CONTENT_SUB_BAIE').animate({
		scrollTop: 0
	}, 200, function(){
		//$("#LINK_EDIT").fadeOut(400);
		$("#LINK_EDIT").animate({
			top: '-=100%',		
		},400);		
		join_inner();
		return false;
	});	
}

function delete_switch(id, ip, pos_y, baie_id)
{
	$.ajax({
		type:"GET",
		url:"confirmation_delete.php?SRC=SWI&ID=" + id + "&IP=" + ip + "&PY=" + pos_y + "&BAIE_ID=" + baie_id,
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN_NIV_2").fadeIn(400);
			$("#MODAL_ADD").fadeIn(400);
		}
	});
}

function valide_delete_switch(id, ip, pos_y, baie_id)
{
	// *********************************************
	// *** SUPPRESSION DANS LA TABLE DES SWITCHS ***
	// *********************************************
	$.ajax({
		type:"GET",
		url:"delete_switch.php?ID=" + id + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(response){
			if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 )
			{
				$.ajax({
					type:"GET",
					url:"delete_switch_step_2.php?BAIE_ID=" + baie_id + "&POS_Y=" + pos_y + "&IP=" + ip + "&SITE=" + sessionStorage.getItem("SITKEY"),
					success: function(response){
						// *************************************************************
						// *** MISE A JOUR DES POSITIONS Y DANS LA TABLE DES SWITCHS ***
						// *** SUPPRESSION DANS LA TABLE DES LIENS 		     ***
						// *** SUPPRESSION DANS LA TABLE DES LIENS MEMOIRE 	     ***
						// *************************************************************

						var idx = 0;
						var elem;

						while ( idx < wg_table_links.length )
						{
							elem = wg_table_links[idx].split(";");
							if ( elem[0] == ip || elem[1] == ip )
							{
								wg_table_links.splice(idx,1);
								idx--;
							}
							idx++;
						}

						var i = 0;
						while ( i < table_edit_max_switch && table_edit_switch[i] != "SW_" + id )
						{
							i++;
						}

						if ( table_edit_switch[i] == "SW_" + id )
						{
							table_edit_switch.splice(i,1);
							table_edit_max_switch--;
						}
						else
						{
							alert("ERREUR TRAITEMENT MEMOIRE SUPPRESSION SWITCH CONTACTEZ VOTRE ADMINISTRATEUR");
						}

						// ************************************
						// *** SUPPRESSION DANS L'AFFICHAGE ***
						// ************************************

						$("#SW_" + id).remove();
					
						var baie_height = ($("#" + baie_id + " > .BAIE_SUPPORT .SWITCH").length-1)*$(".SWITCH").height()+$("#" + baie_id + " > .BAIE_SUPPORT .SWITCH").length-1;
						if ( baie_height < 60 )
						{
							$("#" + baie_id).css('height', "150px");
							$("#" + baie_id + " .BAIE_SUPPORT").css('height',  "110px");
						}
						else
						{
							$("#" + baie_id).css('height',  + (baie_height+40) + "px");
							$("#" + baie_id + " .BAIE_SUPPORT").css('height',  + baie_height + "px");
						}
						
						
						var idconv = ip.replace(/(:|\.)/g,'\\$1');
						$("#" + idconv).remove();
						join();

						table_edit_max_switch = 0;
						$.ajax({
							type:"GET",
							url:"edit_baie_switch.php?ID=" + baie_id + "&SITE=" + sessionStorage.getItem("SITKEY"),
							success: function(retour){
								$("#EDIT_BAIE").empty().append(retour);
								
								$('#CONTENT_SUB_BAIE').animate({
									scrollTop: 0
								}, 0);
								
								join_inner();
							}
						});

						$("#LOCK_SCREEN").fadeOut(400);
						$("#MODAL_ADD").fadeOut(400);
					},
					error: function(){
						$.gritter.add({
							title: 'Suppression switch',
							text: 'Erreur lors de la suppression du switch dans la base de données.',
							time: 1500
						});
			    		}
				});
			}
			else
			{
				$.gritter.add({
					title: 'Suppression switch',
					text: 'Erreur lors de la suppression du switch dans la base de données.',
					time: 1500
				});
			}
		},
	        error: function(){
			$.gritter.add({
				title: 'Suppression switch',
				text: 'Erreur lors de la suppression du switch dans la base de données.',
				time: 1500
			});
    		}
	});
}

function move_switch_up(id)
{
	var i = 0;
	while ( i < table_edit_max_switch && table_edit_switch[i] != id )
	{
		i++;
	}
	
	var sw_height = $(".DISPLAY_SWITCH").eq(0).height() + 2 + 10;

	if ( table_edit_switch[i] == id && i > 0)
	{
		var elem = id.split("_");
		var elem2 = table_edit_switch[i-1].split("_");

		$("#CANVAS_LINK_INNER").fadeOut(100, function(){

			$("#" + table_edit_switch[i-1]).animate({
				top: '+=' + sw_height
			}, 200);

			$("#ME_" + elem2[1]).animate({
				top: '+=' + sw_height
			}, 200);
			$("#ME_" + elem[1]).animate({
				top: '-=' + sw_height
			}, 200);

			$("#" + id).animate({
				top: '-=' + sw_height
			}, 200, function() {
			        $('#CONTENT_SUB_BAIE').animate({
					scrollTop: 0
				}, 200, function(){
					join_inner();
					$("#CANVAS_LINK_INNER").fadeIn(100);
					return false;
				});
			});
			var tmp = table_edit_switch[i-1];
			table_edit_switch[i-1] = table_edit_switch[i];
			table_edit_switch[i] = tmp;

			$.ajax({
				type:"GET",
				url:"update_switch_position_in_baie.php?ID1=" + elem[1] + "&ID2=" + elem2[1] + "&SITE=" + sessionStorage.getItem("SITKEY"),
				success: function(retour){
				}
			});
		});
	}
	return;
}

function move_switch_bottom(id)
{
	var i = 0;
	while ( i < table_edit_max_switch && table_edit_switch[i] != id )
	{
		i++;
	}
	
	var sw_height = $(".DISPLAY_SWITCH").eq(0).height() + 2 + 10;

	if ( table_edit_switch[i] == id && i < (table_edit_max_switch-1))
	{
		var elem = id.split("_");
		var elem2 = table_edit_switch[i+1].split("_");

		$("#CANVAS_LINK_INNER").fadeOut(100, function(){

			$("#" + table_edit_switch[i+1]).animate({
				top: '-=' + sw_height
			}, 200);

			$("#ME_" + elem2[1]).animate({
				top: '-=' + sw_height
			}, 200);
			$("#ME_" + elem[1]).animate({
				top: '+=' + sw_height
			}, 200);

			$("#" + id).animate({
				top: '+=' + sw_height
			}, 200, function() {
			        $('#CONTENT_SUB_BAIE').animate({
					scrollTop: 0
				}, 200, function(){
					join_inner();
					$("#CANVAS_LINK_INNER").fadeIn(100);
					return false;
				});
			});
			var tmp = table_edit_switch[i+1];
			table_edit_switch[i+1] = table_edit_switch[i];
			table_edit_switch[i] = tmp;

			$.ajax({
				type:"GET",
				url:"update_switch_position_in_baie.php?ID1=" + elem2[1] + "&ID2=" + elem[1] + "&SITE=" + sessionStorage.getItem("SITKEY"),
				success: function(retour){
				}
			});

		});
	}
	return;
}

// *********************************
// *** GESTION DES MINIS SWITCHS ***
// *********************************

function add_mini_switch(x,y)
{
	hide_contextual();
	$.ajax({
		type:"GET",
		url:"edit_mini_switch.php?X=" + x + "&Y=" + y,
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN").fadeIn(400);
			$("#MODAL_ADD").fadeIn(400,function(){$("#FRM_SWITCH_MARQUE").focus();});
		}
	});
}

function create_mini_switch_on_map(title, x, y, id)
{
	var new_mini_switch = "<div id='M" + id + "' class='MINI_SWITCH'><div class='MINI_SWITCH_SUPPORT'></div><div class='MINI_SWITCH_TITLE'>" + title + "</div></div>"; 
	$("#GRAPH").append(new_mini_switch);
	
	$("#M" + id).css('left', x + "px");
	$("#M" + id).css('top', y + "px");

	$("#M" + id).draggable({
		containment: "parent",
		/*.MINI_SWITCH_TITLE",*/
		start: function() {
		},
		drag: function() {
			join();
		},
		stop: function(event, ui) {
			update_mini_switch_pos($(this).attr('id'));
		}
	});

	$("#M" + id).mouseenter(function(){
		over_elem = "M" + id;
		join();
	});

	$("#M" + id).mouseleave(function(){
		over_elem = "";
		join();
	});

	$("#M" + id).bind("contextmenu",function(e){

		var parent_left = $("#GRAPH").position().left;
		var parent_top = $("#GRAPH").position().top;  

		var menu="<h2 class='title_form'>SWITCHS</h2><ul><li onClick='javascript:edit_mini_switch(\"" + $(this).attr("id") + "\")'>Modifier le mini switch</li><li onClick='javascript:delete_mini_switch(\"" + $(this).attr("id") + "\")'>Supprimer le mini switch</li></ul>";

		$("#MAIN_CONTEXTUAL_MENU").html(menu);

		$("#MAIN_CONTEXTUAL_MENU").css("left",(e.pageX-parent_left)-80 + "px");
		
		if ( (e.clientY + $("#MAIN_CONTEXTUAL_MENU").height()) > $(document).height() )
		{
			$("#MAIN_CONTEXTUAL_MENU").css("top",e.clientY-($("#MAIN_CONTEXTUAL_MENU").height()-10) + "px");
		}
		else
		{
			$("#MAIN_CONTEXTUAL_MENU").css("top",e.clientY-30 + "px");
		}	
		
		
		$("#MAIN_CONTEXTUAL_MENU").fadeIn(400);

      		return false;
	});
	
}

function edit_mini_switch(id)
{
	hide_contextual();
	$.ajax({
		type:"GET",
		url:"edit_mini_switch.php?IDS=" + id + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN").fadeIn(400);
			$("#MODAL_ADD").fadeIn(400,function(){$("#FRM_SWITCH_MARQUE").focus();});
		}
	});
}

function update_mini_switch_pos(id)
{
	$.ajax({
		type:"GET",
		url:"update_mini_switch_position.php?ID=" + id.substring(1) + "&X=" + $("#" + id).position().left + "&Y=" + $("#" + id).position().top + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(retour){
		}
	});
}

function delete_mini_switch(id)
{
	hide_contextual();
	$.ajax({
		type:"GET",
		url:"confirmation_delete.php?SRC=MIN&ID=" + id.substring(1),
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN_NIV_2").fadeIn(400);
			$("#MODAL_ADD").fadeIn(400);
		}
	});
}

function valide_delete_mini_switch(id)
{
	// *********************************************
	// *** SUPPRESSION DANS LA TABLE DES SWITCHS ***
	// *********************************************
	$.ajax({
		type:"GET",
		url:"delete_mini_switch.php?ID=" + id + "&SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(response){
			if ( parseInt(response.replace(/^\s+/g,'').replace(/\s+$/g,'')) > 0 )
			{
				$("#M" + id).remove();

				// ***************************************************
				// *** SUPPRESSION DANS LA TABLE DES LIENS MEMOIRE ***
				// ***************************************************

				var idx = 0;
				var elem;

				while ( idx < wg_table_links.length )
				{
					elem = wg_table_links[idx].split(";");

					if ( elem[0] == "M" + id || elem[1] == "M" + id )
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
					title: 'Suppression switch',
					text: 'Erreur lors de la suppression du switch dans la base de données.',
					time: 1500
				});
			}
		},
	        error: function(){
			$.gritter.add({
				title: 'Suppression switch',
				text: 'Erreur lors de la suppression du switch dans la base de données.',
				time: 1500
			});
    		}
	});
}
