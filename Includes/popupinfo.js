function display_info_switch(switch_id, baie, others, nb_port) // marque, fiber, webinterface)
{
	var elem = others.split(";");
	
	var lgtext = "";

	if ( elem[1] < 0 )
	{
		elem[1] = 0;
	}

	var idconv = switch_id.replace(/(:|\.)/g,'\\$1');
	
	if ( switch_id.substring(0,5) == "NOIP_" )
	{
		lgtext += "<b>" + decodeURI(elem[0]) + "</b><br>Ports ethernets : " + nb_port +"<br>Ports fibres : " + elem[1];
	}
	else
	{
		lgtext += "<b>" + decodeURI(elem[0]) + "</b><br>IP : " + switch_id + "<br>Ports ethernets : " + nb_port + "<br>Ports fibres : " + elem[1];
	}

	var topme = $("#" + idconv).offset().top + 15;
	var leftme = $("#" + idconv).offset().left - 16;
	
	$("#POPOVER_DETAIL").html(lgtext);
	
	$("#POPOVER_DETAIL").css("top", topme + "px");
	$("#POPOVER_DETAIL").css("left", leftme + "px");
}

function display_popup()
{
	$("#POPOVER_DETAIL").fadeIn(100);
	clearInterval(tempo);
}

function hide_info_switch()
{
	$("#POPOVER_DETAIL").fadeOut(10);
}
