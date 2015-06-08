var vnc_number = 0;

function test_switchs()
{
	if ( $(".SWITCH").length == 0 && $(".ANTENNE_SUPPORT").length == 0 )
	{
		return;
	}
	join();
	$("#PROGRESS_SIGN").css("width","0%");

	var nbre_switch_test = 0;
	$("#LOCK_SCREEN").fadeIn(400);
	
	$("#PROGRESS").fadeIn(400, function(){
		hide_contextual();
		var total_switch = parseInt($(".SWITCH").length) + parseInt($(".ANTENNE_SUPPORT").length); 

		var idswitch;
		var ip_ping;
		
		$(".SWITCH, .ANTENNE_SUPPORT").each(function(){
					
			idswitch = $(this);
			 
			if ( $(idswitch).hasClass("ANTENNE_SUPPORT") )
			{
				ip_ping = idswitch.attr("ip_ant");
			}
			else
			{
				ip_ping = idswitch.attr("id");
			}
			
			$.ajax({
				type:"GET",
				url:"testip.php?IP=" + ip_ping,
				success: function(retour){
					
					var explode_return = retour.split("/_/");
					
					nbre_switch_test++;
					$("#PROGRESS_SIGN").css("width",((nbre_switch_test*100)/total_switch) + "%");
					if ( explode_return[1].length > 5 )
					{
						if ( $("#" + explode_return[0].replace(/(:|\.)/g,'\\$1')).hasClass("ANTENNE_SUPPORT") )
						{
							$("#" + explode_return[0].replace(/(:|\.)/g,'\\$1')).removeClass("ANTENNE_SUPPORT").addClass("ANTENNE_OK");
							
							var ids = explode_return[0].replace(/(:|\.)/g,'\\$1');
							var pos = explode_return[1].indexOf("time="); 
	
							var graph_x = $("#GRAPH").offset().left;
							var graph_y = $("#GRAPH").offset().top;
			
							ctx.font        = "bold 12px Droid";
							ctx.strokeStyle = "#000000";
							ctx.textAlign 	= "right";
							ctx.textBaseline = "top";
	
							ctx.fillText(explode_return[1].substring(pos+5), ($("#" + ids).offset().left - graph_x)-12, ($("#" + ids).offset().top - graph_y)+15);
							ctx.beginPath();
							ctx.lineWidth = 1;
							ctx.lineCap = 'round';
							ctx.strokeStyle = '#2A8000';	
							
							ctx.moveTo(($("#" + ids).offset().left - graph_x)-12, ($("#" + ids).offset().top - graph_y)+30);
							ctx.lineTo(($("#" + ids).offset().left - graph_x)-70, ($("#" + ids).offset().top - graph_y)+30);
							ctx.stroke();
						}
						else
						{
							$("#" + explode_return[0].replace(/(:|\.)/g,'\\$1')).addClass("SWITCH_OK");

							var ids = explode_return[0].replace(/(:|\.)/g,'\\$1');
							var pos = explode_return[1].indexOf("time="); 
	
							var graph_x = $("#GRAPH").offset().left;
							var graph_y = $("#GRAPH").offset().top;
			
							ctx.font        = "bold 12px Droid";
							ctx.strokeStyle = "#000000";
							ctx.textAlign 	= "right";
							ctx.textBaseline = "top";
	
							ctx.fillText(explode_return[1].substring(pos+5), ($("#" + ids).offset().left - graph_x)-12, ($("#" + ids).offset().top - graph_y)+15);
							ctx.beginPath();
							ctx.lineWidth = 1;
							ctx.lineCap = 'round';
							ctx.strokeStyle = '#2A8000';	
							
							ctx.moveTo(($("#" + ids).offset().left - graph_x)-12, ($("#" + ids).offset().top - graph_y)+30);
							ctx.lineTo(($("#" + ids).offset().left - graph_x)-70, ($("#" + ids).offset().top - graph_y)+30);
							ctx.stroke();
						}
					}
					else
					{
						var explode_return = retour.split("/_/");
						
						if ( $("#" + explode_return[0].replace(/(:|\.)/g,'\\$1')).hasClass("ANTENNE_SUPPORT") )
						{
							$("#" + explode_return[0].replace(/(:|\.)/g,'\\$1')).removeClass("ANTENNE_SUPPORT").addClass("ANTENNE_ERROR");
						}
						else
						{
							$("#" + explode_return[0].replace(/(:|\.)/g,'\\$1')).addClass("SWITCH_ERROR");
						}
					}

					if ( nbre_switch_test == total_switch )
					{
						$("#LOCK_SCREEN").fadeOut(800);
						$("#PROGRESS").fadeOut(800);
						$("#LOCK_GRAPH").fadeIn(400);
					}
				}
			});
		});
	});
}

function test_time(ip)
{
	$("#BALL_DIV").fadeIn(400);
	hide_contextual();

	$.ajax({
		type:"GET",
		url:"testip.php?IP=" + ip,
		success: function(retour){
			var explode_return = retour.split("/_/");
			if ( explode_return[1].length > 5 )
			{
				var pos = explode_return[1].indexOf("time="); 
				$.gritter.add({
					title: 'Temps de réponse',
					text: '<center>' + explode_return[1].substring(pos+5) + '</center>',
					time: 3500
				});
				$("#BALL_DIV").fadeOut(400);
			}
			else
			{
				$.gritter.add({
					title: 'Temps de réponse',
					text: 'L\'actif n\'a pas répondu dans le temps impartis',
					time: 3500
				});
				$("#BALL_DIV").fadeOut(400);
			}
		}
	});
}
function unlock_schema()
{
	$(".SWITCH").removeClass("SWITCH_OK");
	$(".SWITCH").removeClass("SWITCH_ERROR");
	$(".ANTENNE_OK").removeClass("ANTENNE_OK").addClass("ANTENNE_SUPPORT");
	$(".ANTENNE_ERROR").removeClass("ANTENNE_ERROR").addClass("ANTENNE_SUPPORT");

	join();
	$("#LOCK_GRAPH").fadeOut(400);
}

function open_vnc(ip,port)
{
	window.open("http://" + ip + ":" + port);
}

