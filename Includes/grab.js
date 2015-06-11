var tmp_image_grab = new Array();

var wl_x_grab = 0;
var wl_y_grab = 0;
var wl_i_grab = 0;

var wl_step_grab = 0;
var wl_pos_grab = 0;

var wl_ori_x_grab = 0;
var wl_ori_y_grab = 0;

var myImage_export;

function grab_me()
{
       if ( left_open == 1 || float_open == 1 )
       {
              $("#ZONE_NOM_SITE").fadeIn(400);
	      $("#APPS_GRAPH").animate({
			    left: "0px",
			    right: "0px"
		     }, 300, function(){
			    left_open = 0;
			    float_open = 0;
			    $("#TOP_BT_1").removeClass("bt_top_menu_select");
			    $("#TOP_BT_2").removeClass("bt_top_menu_select");
			    start_grab_me();
		     }
	      );
       }
       else
       {
	      start_grab_me();
       }
}

function start_grab_me()
{
       wl_ori_x_grab = $("#SUPPORT_GRAPH").css("left");
       wl_ori_y_grab = $("#SUPPORT_GRAPH").css("top");
       
       scr_width_grab = $( document ).width();
       scr_height_grab = $( document ).height();
                    
       wl_step_grab = scr_width_grab/((Math.floor(2000 / scr_width_grab) + Math.floor(1500 / scr_height_grab))+2);
       wl_pos_grab = 0;
       
       var elem_ori_grab = $("#APPLICATION_SURFACE");
       html2canvas(elem_ori_grab.get(0),
       {
	      onrendered: function(canvas_get) {
		     tmp_image_grab[wl_i_grab] = new Image();
		     tmp_image_grab[wl_i_grab].src = canvas_get.toDataURL("image/png");
		     tmp_image_grab[wl_i_grab].onload = function() {
			    $('#GRAB_TEMPO').css('background-image', 'url(' + tmp_image_grab[wl_i_grab].src + ')');
			    $("#GRAB_TEMPO").show();
			    $("#LASER").css("width", "0px");
			    wl_x_grab = 0;
			    wl_y_grab = 0;
			    wl_i_grab = 0;     
			    $("#SUPPORT_GRAPH").css("left", "0px");
			    $("#SUPPORT_GRAPH").css("top", "0px");
			    ctx_snap.clearRect(0, 0, canvas.width, canvas.height);
			    
			    boucle_grab();
		     }
	      }
       });
}

function move_grab()
{
       $("#SUPPORT_GRAPH").css("left", -wl_x_grab + "px");
       $("#SUPPORT_GRAPH").css("top", -wl_y_grab + "px");
       wl_pos_grab += wl_step_grab;
       $("#LASER").animate({'width': wl_pos_grab + 'px'},'400', function(){
	      boucle_grab();
       });
}

function boucle_grab()
{     
       html2canvas(elem_grab.get(0),
       {
	      onrendered: function(canvas_get) {
		     tmp_image_grab[wl_i_grab] = new Image();
		     tmp_image_grab[wl_i_grab].src = canvas_get.toDataURL("image/png");
		     tmp_image_grab[wl_i_grab].onload = function() {
			    ctx_snap.drawImage(tmp_image_grab[wl_i_grab],wl_x_grab,wl_y_grab);
			    
			    wl_x_grab += scr_width_grab;
			    if ( wl_x_grab > 2000 )
			    {
				   wl_x_grab = 0;
				   wl_y_grab += scr_height_grab;
				   
				   if ( wl_y_grab > 1500 )
				   {
					$("#SUPPORT_GRAPH").css("left", wl_ori_x_grab);
					$("#SUPPORT_GRAPH").css("top", wl_ori_y_grab);
					  
					$.ajax({
						type: "GET",
						url: "get_max_pos.php?ID=" + sessionStorage.getItem('SITKEY'),
						success: function(response) {
                                                
							var res = response.split(";");
							grab_display_step_2(res[0],res[1]);
						}
					});
					  				  					  
					return;
				   }
			    }
			    
			    wl_i_grab++;
			    move_grab();
			    return;
		     }
	      }
       });
}

function grab_display_step_2(w,h)
{
	w = parseInt(w) + 100;
	h = parseInt(h) + 100;
	var extra_canvas = document.createElement("canvas");
	extra_canvas.setAttribute('width',w);
	extra_canvas.setAttribute('height',h);

	var ctx_extra = extra_canvas.getContext('2d');
	ctx_extra.drawImage(canvas_snap,0,0,w,h,0,0,w,h);
	
	myImage_export = extra_canvas.toDataURL("image/png");
	$('#PREVIEW_RESULT_GRAB').css('background-image', 'url(' + myImage_export + ')');
  
	$('#SUPPORT_PREVIEW_RESULT_GRAB').fadeIn(400);
}

function close_grab()
{
       $("#GRAB_TEMPO").fadeOut(400,function(){
	      $('#SUPPORT_PREVIEW_RESULT_GRAB').hide();
	      $("#img_val").val("");
	      $("#img_val_o").val("");
       });
}

function dowload_grab()
{
       window.open(myImage_export);
}

function dowload_grab_pdf()
{
	$.ajax({
		type: "GET",
		url: "get_max_pos.php?ID=" + sessionStorage.getItem('SITKEY'),
		success: function(response) {
			var res = response.split(";");
			dowload_grab_pdf_step_2(res[0],res[1]);
		}
	});	
}

function dowload_grab_pdf_step_2(w,h)
{
	w = parseInt(w) + 100;
	h = parseInt(h) + 100;
	var extra_canvas = document.createElement("canvas");
	extra_canvas.setAttribute('width',w);
	extra_canvas.setAttribute('height',h);

	var ctx_extra = extra_canvas.getContext('2d');
	ctx_extra.fillStyle="#FFFFFF";
	ctx_extra.fillRect(0,0,w,h); 
	ctx_extra.drawImage(canvas_snap,0,0,w,h,0,0,w,h);
	$("#img_val_o").val(extra_canvas.toDataURL("image/jpeg"));					
	
	$.ajax({
		data: $("#FORM_SNAP").serialize(),
		type: $("#FORM_SNAP").attr("method"),
		url: "export_pdf.php?ID=" + sessionStorage.getItem('SITKEY'),
		success: function(response) {
			window.open("Temp/" + sessionStorage.getItem('SITKEY') + ".pdf");
		}
	});
}

function grab_for_accueil()
{
	$("#APPS_GRAPH").animate({
	      left: "0px",
	      right: "0px"
	}, 300, function(){
		$("#APPS_GRAPH").animate({
			left: "0px",
			right: "0px"
			}, 20, function(){	
				html2canvas(elem_grab.get(0),
				{
					onrendered: function(canvas_get) {
						scr_width_grab = $( document ).width();
						scr_height_grab = $( document ).height();
						var extra_canvas = document.createElement("canvas");
						extra_canvas.setAttribute('width',200);
						extra_canvas.setAttribute('height',100);
						var ctx_extra = extra_canvas.getContext('2d');
						ctx_extra.drawImage(canvas_get,0,0,scr_width_grab, scr_height_grab,0,0,200,100);
						$("#img_val").val(extra_canvas.toDataURL("image/png"));					
					
						$.ajax({
							data: $("#FORM_SNAP").serialize(),
							type: $("#FORM_SNAP").attr("method"),
							url: "save_snapshot.php",
							success: function(response) {
								$(location).attr('href', '/brainmap/');
								location.reload();
							}
						});
					}
				});
			}
		);
	});
}