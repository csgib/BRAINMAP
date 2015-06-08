var wg_table_links = new Array();
var wg_color;
var zoom_factor = 1;
var over_elem = "";

var wl_src_tg;
var wl_dst_tg;
var wl_ori_tg;
var wl_oribis_tg;
var wl_txt_link;

function join()
{
	var i = 0;
	var entity;

	var graph_x = $("#GRAPH").offset().left;
	var graph_y = $("#GRAPH").offset().top;
	
	ctx.clearRect(0, 0, canvas.width, canvas.height);

	while ( i < wg_table_links.length )
	{
		entity = wg_table_links[i].split(';');

		if ( entity[3] == "0" ) // *** TEST LIEN EXTERNE ***
		{
			ctx.setLineDash([]);
			ctx.lineWidth = 2;

			if ( entity[0].substr(0,1) == "S" && entity[1].substr(0,1) == "S" )
			{
				wg_color = sessionStorage.getItem("CL2");
			}
			else
			{
				if ( entity[0].substr(0,1) == "R" || entity[1].substr(0,1) == "R" )
				{
					wg_color = sessionStorage.getItem("CL1");
				}
				else
				{
					if ( entity[0].substr(0,1) == "S" || entity[1].substr(0,1) == "S" )
					{
						wg_color = sessionStorage.getItem("CL2");
					}
					else
					{
						if ( entity[2] == "0" )
						{
							wg_color = sessionStorage.getItem("CL3");
						}
						else
						{
							wg_color = sessionStorage.getItem("CL4");
						}
					}
				}
			}

			if ( entity[0] == over_elem || entity[1] == over_elem )
			{
				wg_color = "#fe2d62";
				ctx.shadowColor = 'rgba(254,45,98,0.6)';
				ctx.shadowBlur = 10;
				ctx.shadowOffsetX = 0;
				ctx.shadowOffsetY = 0;				
			}
			else
			{
				ctx.shadowBlur = 0;				
			}
			
			entity[0] = entity[0].replace(/(:|\.)/g,'\\$1');
			entity[1] = entity[1].replace(/(:|\.)/g,'\\$1');
			
			xa = $("#" + entity[0]).offset().left - graph_x;
			ya = $("#" + entity[0]).offset().top - (graph_y-10);
			wa = $("#" + entity[0]).width();
			ha = $("#" + entity[0]).height();
			
			if ( (entity[1].substr(0,1) == "M" || entity[0].substr(0,1) == "R" || entity[0].substr(0,1) == "S" || entity[0].substr(0,1) == "N") && entity[0].substr(0,5) != "NOIP_" )
			{
				ya = ya + 20;
				if ( entity[0].substr(0,1) == "S" )
				{
					ya = ya + (entity[4]*6);
				}
			}
			else
			{
				if ( entity[4] % 2 == 0 )
				{
					ya += 3;
				}
				else
				{
					ya -= 3;
				}
			}

			xb = $("#" + entity[1]).offset().left - graph_x;
			yb = $("#" + entity[1]).offset().top - (graph_y-10);
			wb = $("#" + entity[1]).width();
			hb = $("#" + entity[1]).height();
				
			if ( (entity[1].substr(0,1) == "M" || entity[1].substr(0,1) == "R" || entity[1].substr(0,1) == "S" || entity[1].substr(0,1) == "N") && entity[1].substr(0,5) != "NOIP_" )
			{
				yb = yb + 20;
				if ( entity[1].substr(0,1) == "S" )
				{
					yb = yb + (entity[5]*2);
				}
			}
			else
			{
				if ( entity[5] % 2 == 0 )
				{
					yb += 3;
				}
				else
				{
					yb -= 3;
				}
			}

			if ((entity[0].substr(0,5) != "NOIP_" && entity[1].substr(0,5) != "NOIP_") && ( entity[0].substr(0,1) == "M" || entity[1].substr(0,1) == "M" || entity[0].substr(0,1) == "K" || entity[1].substr(0,1) == "K" ||  entity[0].substr(0,1) == "A" || entity[1].substr(0,1) == "A" )) // *** MINI SWITCHS ***
			{
				if ( xb-10 > xa+wa ) 
				{
					xaj = xa + wa;
					
					if ( entity[1].substr(0,1) == "M" )
					{
						yaj = ya - 16;
					}
					else
					{
						yaj = ya + 14;
					}

					xbj = xb; 
					ybj = yb-(entity[5]*2);
		
					ctx.strokeStyle = wg_color;
		
					ctx.beginPath();
					ctx.moveTo(xaj,yaj);
					ctx.bezierCurveTo(xaj+40, yaj, xbj-20, ybj, xbj+20, ybj);
					ctx.stroke();
				}
				else
				{
					if ( xb+wb+10 < xa ) 
					{
						xaj = xa; 
						yaj = ya;

						xbj = xb+wb; 
						ybj = yb-(entity[5]*2);

						ctx.strokeStyle = wg_color;
							
						ctx.beginPath();
						ctx.moveTo(xaj,yaj);
						ctx.bezierCurveTo(xaj-40, yaj, xbj+30, ybj, xbj-40, ybj);
						ctx.stroke();
					}
					else
					{
						if ( xa+wa > xb+wb ) 
						{
							xaj = xa; 
							yaj = ya;

							xbj = xb; 
							ybj = yb-(entity[5]*2);;
		
							ctx.strokeStyle = wg_color;
		
							ctx.beginPath();
							ctx.moveTo(xaj,yaj);
							ctx.bezierCurveTo(xaj-40, yaj, xbj-30, ybj, xbj+40, ybj);
							ctx.stroke();
						}
						else
						{
							xaj = xa + wa; 
							yaj = ya;

							xbj = xb; // + wb; 
							ybj = yb-(entity[5]*2);;
			
							ctx.strokeStyle = wg_color;

							ctx.beginPath();
							ctx.moveTo(xaj,yaj);
							ctx.bezierCurveTo(xaj+40, yaj, xbj, ybj, xbj+20, ybj);
							ctx.stroke();
						}
					}
				}
			}
			else
			{
				ctx.strokeStyle = wg_color;

				if ( xb-10 > xa+wa ) 
				{					
					xaj = xa + wa; 
					yaj = ya;

					xbj = xb; 
					ybj = yb;
					
					if ( entity[1].substr(0,1) == "M" )
					{
						xbj = xbj + 16;
					}					
						
					ctx.beginPath();
					ctx.moveTo(xaj,yaj);
					ctx.bezierCurveTo(xaj+40, yaj, xbj-30, ybj, xbj, ybj);
					ctx.stroke();
				}
				else
				{
					if ( xb+wb+10 < xa ) 
					{				
						xaj = xa; 
						yaj = ya;

						xbj = xb+wb; 
						ybj = yb;

						if ( entity[1].substr(0,1) == "M" )
						{
							xbj = xbj - 16;
						}
		
						ctx.beginPath();
						ctx.moveTo(xaj,yaj);
						ctx.bezierCurveTo(xaj-40, yaj, xbj+30, ybj, xbj, ybj);
						ctx.stroke();
					}
					else
					{
						if ( xa+wa > xb+wb ) 
						{
							xaj = xa; 
							yaj = ya;

							xbj = xb; 
							ybj = yb;
							
							if ( entity[1].substr(0,1) == "M" )
							{
								xbj = xbj + 16;
							}							

							if ( entity[1].substr(0,1) == "T" )
							{
								ctx.beginPath();
								ctx.moveTo(xaj+wa,yaj);
								ctx.bezierCurveTo(xaj+wa+40, yaj, xbj+wb+50, ybj, xbj+wb, ybj);
								ctx.stroke();																
							}
							else
							{
								ctx.beginPath();
								ctx.moveTo(xaj,yaj);
								ctx.bezierCurveTo(xaj-40, yaj, xbj-50, ybj, xbj, ybj);
								ctx.stroke();								
							}
						}
						else
						{
							xaj = xa + wa; 
							yaj = ya;

							xbj = xb + wb; 
							ybj = yb;
							
							if ( entity[1].substr(0,1) == "M" )
							{
								xbj = xbj - 16;
							}							

							if ( entity[1].substr(0,1) == "T" )
							{
								ctx.beginPath();
								ctx.moveTo(xaj,yaj);
								ctx.bezierCurveTo(xaj+40, yaj, xbj+40, ybj, xbj, ybj);
								ctx.stroke();
							}
							else
							{
								ctx.beginPath();
								ctx.moveTo(xaj,yaj);
								ctx.bezierCurveTo(xaj+40, yaj, xbj+80, ybj-80, xbj, ybj);
								ctx.stroke();
							}
						}
					}
				}
			}
		}
		else
		{
			ctx.lineWidth = 2;
			ctx.setLineDash([2,3]);
			if ( entity[2] == "0" )
			{
				wg_color = sessionStorage.getItem("CL3");
			}
			else
			{
				wg_color = sessionStorage.getItem("CL4");
			}

			if ( entity[0] == over_elem || entity[1] == over_elem )
			{
				wg_color = "#fe2d62";
				ctx.shadowColor = 'rgba(254,45,98,0.6)';
				ctx.shadowBlur = 10;
				ctx.shadowOffsetX = 0;
				ctx.shadowOffsetY = 0;				
			}
			else
			{
				ctx.shadowBlur = 0;				
			}			
			
			entity[0] = entity[0].replace(/(:|\.)/g,'\\$1');
			entity[1] = entity[1].replace(/(:|\.)/g,'\\$1');
			
			xa = $("#" + entity[0]).offset().left - graph_x;
			ya = $("#" + entity[0]).offset().top - (graph_y-10);
			wa = $("#" + entity[0]).width();
			ha = $("#" + entity[0]).height();
			
			if ( entity[4] % 2 == 0 )
			{
				ya += 3;
			}
			else
			{
				ya -= 3;
			}
					
			ctx.strokeStyle = wg_color;

			xb = $("#" + entity[1]).offset().left - graph_x;
			yb = $("#" + entity[1]).offset().top - (graph_y-10);
			wb = $("#" + entity[1]).width();
			hb = $("#" + entity[1]).height();
			
			xaj = xa + wa; 
			yaj = ya;
	
			xbj = xb + wb; 
			ybj = yb;
	
			ctx.beginPath();
			ctx.moveTo(xaj,yaj);
			ctx.bezierCurveTo(xaj+20, yaj, xbj+40, ybj, xbj, ybj);
			ctx.stroke();			
		}
		i++;
	}
}

function join_inner()
{
	// *** INITIALISATION DU CANVAS ***
	//var canvas2=document.getElementById('CANVAS_LINK_INNER');

	canvas2.width  = $("#SCROLLER_EDIT_BAIE").width();
	canvas2.height = $("#SCROLLER_EDIT_BAIE").height();
	var ctx2=canvas2.getContext('2d');

	ctx2.clearRect(0, 0, canvas2.width, canvas2.height);
	ctx2.lineCap     = 'round';
	
	var graph_x = $("#MODAL_ADD").offset().left + 10;
	var graph_y = $("#MODAL_ADD").position().top + 10;

	var i = 0;
	var exist;
	
	var wl_height = $("#SCROLLER_EDIT_BAIE").height();
	var wl_courb = 0;

	while ( i < wg_table_links.length )
	{
		entity = wg_table_links[i].split(';');

		if ( entity[3] == "1" ) // *** TEST LIEN INTERNE ***
		{

			if ( entity[2] == "1" )
			{
				entity[0] = entity[0] + ":F" + entity[4];
				entity[1] = entity[1] + ":F" + entity[5];
			}
			else
			{
				entity[0] = entity[0] + ":" + entity[4];
				entity[1] = entity[1] + ":" + entity[5];
			}

			entity[0] = entity[0].replace(/(:|\.)/g,'\\$1');
			entity[1] = entity[1].replace(/(:|\.)/g,'\\$1');

			exist = $("#" + entity[0]);

			if (exist.length > 0 )
			{
				
				xa = $("#" + entity[0]).offset().left + 3 + ($("#" + entity[0]).width()/2);
				ya = $("#" + entity[0]).offset().top + 3 + ($("#" + entity[0]).height()/2);

				xb = $("#" + entity[1]).offset().left + 3 + ($("#" + entity[1]).width()/2);
				yb = $("#" + entity[1]).offset().top + 3 + ($("#" + entity[1]).height()/2);

				xa -= graph_x;
				ya -= graph_y;

				xb -= graph_x;
				yb -= graph_y;
				
				wl_courb = ((yb-ya)*40)/wl_height;

				ctx2.strokeStyle = "#222222";
				ctx2.lineWidth   = 6;
				ctx2.beginPath();
				ctx2.moveTo(xa,ya);
				ctx2.bezierCurveTo(xa+wl_courb, ya, xb+wl_courb, yb, xb, yb);
				ctx2.stroke();

				if ( entity[2] == "0" )
				{
					ctx2.strokeStyle = sessionStorage.getItem("CL3");
				}
				else
				{
					ctx2.strokeStyle = sessionStorage.getItem("CL4");
				}

				ctx2.lineWidth   = 4;
				ctx2.beginPath();
				ctx2.moveTo(xa,ya);
				ctx2.bezierCurveTo(xa+wl_courb, ya, xb+wl_courb, yb, xb, yb);
				ctx2.stroke();
			}
		}
		else
		{
			if ( entity[2] == "0")
			{
				wl_src_tg = entity[0] + ":" + entity[4];
				wl_dst_tg = entity[1] + ":" + entity[5];				
			}
			else
			{
				wl_src_tg = entity[0] + ":F" + entity[4];
				wl_dst_tg = entity[1] + ":F" + entity[5];				
			}
			wl_ori_tg = 0;
			wl_txt_link = "";
		
			if ( isNaN(wl_src_tg.substring(0,1)) == false || wl_src_tg.substring(0,5) == "NOIP_" )
			{

				wl_src_tg = wl_src_tg.replace(/(:|\.)/g,'\\$1');
				if ( $("#" + wl_src_tg).length > 0 )
				{
					wl_ori_tg = 1;
				}
			}

			if ( isNaN(wl_dst_tg.substring(0,1)) == false || wl_dst_tg.substring(0,5) == "NOIP_" )
			{
				wl_dst_tg = wl_dst_tg.replace(/(:|\.)/g,'\\$1');
				if ( $("#" + wl_dst_tg).length > 0 )
				{
					wl_ori_tg = 2;
				}
			}
			
			wl_oribis_tg = 0;
			
			if ( wl_ori_tg > 0 )
			{
				if ( wl_ori_tg == 1 )
				{
					if ( isNaN(wl_dst_tg.substring(0,1)) == false  || wl_dst_tg.substring(0,5) == "NOIP_" )
					{
						if ( $("#" + wl_dst_tg).length == 0 )
						{
							wl_oribis_tg = 1;
						}
					}
					else
					{
						wl_oribis_tg = 1;
					}
				}
				else
				{
					if ( isNaN(wl_src_tg.substring(0,1)) == false  || wl_src_tg.substring(0,5) == "NOIP_" )
					{
						if ( $("#" + wl_src_tg).length == 0 )
						{
							wl_oribis_tg = 1;
						}
					}
					else
					{
						wl_oribis_tg = 1;
					}					
				}
			}
					
			if ( wl_ori_tg > 0 && wl_oribis_tg > 0 )
			{
				if ( wl_ori_tg == 1 )
				{
					xa = $("#" + wl_src_tg).offset().left + 3;
					
					if ( $("#" + wl_src_tg).attr("att_npo")%2 == 0 )
					{
						ya = $("#" + wl_src_tg).offset().top + 3 + ($("#" + wl_src_tg).height());	
					}
					else
					{
						ya = $("#" + wl_src_tg).offset().top + 3 + ($("#" + wl_src_tg).height()/2);							
					}
					
					wl_txt_link = entity[1];	
					
				}
				else
				{
					xa = $("#" + wl_dst_tg).offset().left + 3;

					if ( $("#" + wl_dst_tg).attr("att_npo")%2 == 0 )
					{
						ya = $("#" + wl_dst_tg).offset().top + 3 + ($("#" + wl_dst_tg).height());	
					}
					else
					{
						ya = $("#" + wl_dst_tg).offset().top + 3 + ($("#" + wl_dst_tg).height()/2);								
					}
					
					wl_txt_link = entity[0];
				}

				if ( wl_txt_link != "" )
				{
					if ( isNaN(wl_txt_link.substring(0,1)) )
					{
						if ( wl_txt_link.substring(0,1) == "N" && wl_txt_link.substring(0,5) != "NOIP_" )
						{
							wl_txt_link = $("#" + wl_txt_link + " .NAS_TITLE").html();
						}
						else
						{
							if ( wl_txt_link.substring(0,1) == "S" )
							{
								wl_txt_link = $("#" + wl_txt_link + " .SERVEUR_TITLE").html();
							}
							else
							{
								if ( wl_txt_link.substring(0,1) == "A" )
								{
									wl_txt_link = $("#" + wl_txt_link + " .ANTENNE_TITLE").html();
								}
								else
								{
									if ( wl_txt_link.substring(0,1) == "K" )
									{
										wl_txt_link = $("#" + wl_txt_link + " .CAMERA_TITLE").html();
									}
									else
									{
										if ( wl_txt_link.substring(0,1) == "R" )
										{
											wl_txt_link = $("#" + wl_txt_link + " .ROUTEUR_TITLE").html();
										}
										else
										{
											if ( wl_txt_link.substring(0,1) == "T" )
											{
												wl_txt_link = $("#" + wl_txt_link + " .TRANSCEIVER_TITLE").html();
											}
											else
											{
												wl_txt_link = $("#" + wl_txt_link + " .INFO_SW").html().split("<br>")[0];
											}
										}
									}
								}
							}
						}
					}
			
					xa -= graph_x;
					ya -= graph_y;

					ctx2.beginPath();
					ctx2.strokeStyle 	= '#1898e2';	
					
					ctx2.moveTo(xa,ya);
					ctx2.fillStyle = "rgba(0,0,0,0.4)"; //"rgba(24,152,226,0.4)";
					ctx2.shadowColor = "#000000"; //"#1898e2";
					ctx2.shadowBlur = 1;
					ctx2.shadowOffsetX = 0;
					ctx2.shadowOffsetY = 0;
					ctx2.font        	= "bold 9px Droid";
					ctx2.fillRect(xa-2,ya,ctx2.measureText(wl_txt_link).width+4, -12);
					ctx2.stroke();
			
					ctx2.fillStyle 		= '#FFFFFF';
					ctx2.textAlign 		= "left";
					ctx2.textBaseline 	= "bottom";
					ctx2.fillText(wl_txt_link, xa, ya);
				}			

			}
			
		}
		i++;
	}
}

function hexToRgb(hex)
{
    var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
    hex = hex.replace(shorthandRegex, function(m, r, g, b) {
        return r + r + g + g + b + b;
    });

    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}