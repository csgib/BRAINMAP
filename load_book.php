<div id="SOMMAIRE">

	<?php
		$path_book = "Book/" . $_GET['BK'] . "/";
		if ( file_exists($path_book . "sommaire.csv" ) )
		{
			$fp = fopen($path_book . "sommaire.csv","r");

			while (!feof($fp)) 
			{
				$buffer = fgets($fp);

				$buffer = str_replace("\"", "", $buffer);
				$data = explode(";", $buffer);

				if ( $data[0] == "9999" )
				{
					echo "<h2>" . $data[1] . "</h2>";
				}
				else
				{
					echo "<h3 onClick=\"javascript:change_page(" . $data[0] . ",1)\" >" . $data[1] . "</h3>";
				}
			}

			fclose($fp);
		}
		
	?>


</div>

<div class="TOOLBAR" id="TOOLBAR_BOOK">
	<div class="bt_top_menu_help" onClick='javascript:close_open_book()' style="width: 40px;"><img src="Images/top_close.png" title="Fermer l'aide" style="padding-top: 3px;"></div>
	<div class="bt_top_menu_help" onClick='javascript:show_sommaire()' style="width: 40px;"><img src="Images/top_nav.png" title="Sommaire" style="padding-top: 3px;"></div>
	<div class="bt_top_menu_help" id="MENU_BT_LOUPE" onClick='javascript:close_open_loupe()' style="width: 40px;"><img src="Images/top_zoom.png" title="Loupe" style="padding-top: 3px;"></div>
</div>

<div id="BOOK_DISPLAY">	
	
	<div id="BOOK_COVER"></div>
		
	<div id="book_page_a" class="page"></div>
	<div id="book_page_b" class="page"></div>
	
	<div id="PREVENT_CLICK"></div>
		
	<div id="BT_NEXT_PAGE"></div>
	<div id="BT_PREVIOUS_PAGE"></div>
	
	<div id="LOUPE"></div>

</div>

<script type="text/javascript">

var images = new Array();
var current_page = 0;
var current_page_div = 0;
var max_page = 0;
var page_width = 0;
var page_height = 0;
var curr;
var ratio = 0;
var ratio_true_img = 0;
var img_true_height = 0;
var first_load = 0;
var sommaire_open = 0;
var img;
var loupe_visible = 0;
var loupe_active = 0;

<?php

// *** CHARGEMENT DES IMAGES ***
$i = 0;
$j = 0;

$entries = scandir($path_book);
while ( $i < count($entries) )
{
	if($entries[$i] != '.' && $entries[$i] != '..' && substr($entries[$i], -3) == 'jpg' )
	{
		echo "images[" . $j . "] = '" . $path_book . $entries[$i] . "';";
		$j++;
	}
	$i++;
}

echo "max_page = " . $j . ";";

?>

// *********************************
// *** METHODES DE L'APPLICATION ***
// *********************************

function load_page(string_page)
{
	if ( current_page_div == 0 )
	{
		curr = $("#book_page_a");
		current_page_div = 1;
	}
	else
	{
		curr = $("#book_page_b");
		current_page_div = 0;
	}
	curr.addClass('loading');
	img = new Image();
	$(img).load(function () {

		if ( ratio == 0 )
		{
			ratio = img.width / img.height;
			img_true_height = img.height;
		}

		page_height = curr.height();
		page_width = page_height*ratio;
		
		curr.width(page_width);
	
		$(this).css('display','none');
		$(curr).removeClass('loading').empty().append(this);

		$(this).fadeIn('0',function(){
			if ( first_load == 0 )
			{
				$("#book_page_a").css("left", ($("#HELP_SUPPORT").width()-$("#book_page_a").width())/2 + "px");
				$("#book_page_b").css("left", ($("#HELP_SUPPORT").width()-$("#book_page_a").width())/2 + "px");
				$("#PREVENT_CLICK").css("left", ($("#HELP_SUPPORT").width()-$("#book_page_a").width())/2 + "px");
				$("#PREVENT_CLICK").width($("#book_page_a").width());
			
				$("#BT_PREVIOUS_PAGE").css("left", ($("#book_page_a").position().left-32) + "px");
				$("#BT_PREVIOUS_PAGE").css("top", ($("#book_page_a").position().top+(($("#book_page_a").height()-64))/2) + "px"); 
				
				$("#BT_NEXT_PAGE").css("left", ($("#book_page_a").position().left+$("#book_page_a").width()) + "px");
				$("#BT_NEXT_PAGE").css("top", ($("#book_page_a").position().top+(($("#book_page_a").height()-64))/2) + "px"); 
				
				$("#BOOK_COVER").css("left", $("#book_page_a").position().left-10 + "px");
				$("#BOOK_COVER").css("top", $("#book_page_a").position().top-10 + "px");
				$("#BOOK_COVER").width($("#book_page_a").width()+20 + "px");
				$("#BOOK_COVER").height($("#book_page_a").height()+20 + "px");
						
				ratio_true_img = img_true_height/$("#book_page_a").height();
				
				first_load = 1;
			}
			
			$('#LOUPE').html("<img id='IMG_LOUPE' src='" + string_page + "'>");
		});

	}).error(function () {
		$(curr).remove();
	}).attr({src : string_page });

}

	

function next_page()
{
	if ( current_page == max_page-1 )
	{
		return;
	}

	current_page++;
	load_page(images[current_page]);
	
	if ( current_page_div == 1 )
	{
		$("#book_page_a").css( 'z-index', 10 );
		$("#book_page_b").css( 'z-index', 11 );
		$("#book_page_a").removeClass("animated turnit");
		$("#book_page_b").addClass("animated turnit");
	}
	else
	{
		$("#book_page_a").css( 'z-index', 11 );
		$("#book_page_b").css( 'z-index', 10 );
		$("#book_page_b").removeClass("animated turnit");
		$("#book_page_a").addClass("animated turnit");
	}
}
   
function previous_page()
{
	if ( current_page == 0 )
	{
		return;
	}

	current_page--;
	load_page(images[current_page]);
	
	if ( current_page_div == 1 )
	{
		$("#book_page_a").css( 'z-index', 10 );
		$("#book_page_b").css( 'z-index', 11 );
		$("#book_page_a").removeClass("animated turnit");
		$("#book_page_b").addClass("animated turnit");
	}
	else
	{
		$("#book_page_a").css( 'z-index', 11 );
		$("#book_page_b").css( 'z-index', 10 );
		$("#book_page_b").removeClass("animated turnit");
		$("#book_page_a").addClass("animated turnit");
	}
}

function change_page(num_page, src)
{
	if ( sommaire_open == 1 )
	{
		$("#SOMMAIRE").animate({
			left: '-=100%'
			}, 400, function() {
		});
		sommaire_open = 0;
	}
	if ( current_page != num_page )
	{
		current_page = num_page;
		load_page(images[current_page]);
		
		if ( current_page_div == 1 )
		{
			$("#book_page_a").css( 'z-index', 10 );
			$("#book_page_b").css( 'z-index', 11 );
			$("#book_page_a").removeClass("animated turnit");
			$("#book_page_b").addClass("animated turnit");
		}
		else
		{
			$("#book_page_a").css( 'z-index', 11 );
			$("#book_page_b").css( 'z-index', 10 );
			$("#book_page_b").removeClass("animated turnit");
			$("#book_page_a").addClass("animated turnit");
		}
		
		if (src != undefined)
		{
			$("#SOMMAIRE").animate({
				left: '-=100%'
				}, 400, function() {
			});
			sommaire_open = 0;
		}
	}
}

function show_sommaire()
{
	if ( sommaire_open == 0 )
	{
		$("#SOMMAIRE").animate({
			left: '0px'
			}, 400, function() {
		});
		sommaire_open = 1;
	}
	else
	{
		$("#SOMMAIRE").animate({
			left: '-=100%'
			}, 400, function() {
		});
		sommaire_open = 0;
	}	
}

$(this).resize(function() {

	page_height = $("#book_page_a").height();
	page_width = page_height*ratio;
		
	$("#book_page_a").width(page_width);
	$("#book_page_b").width(page_width);
	
	if ( current_page_div == 1 )
	{
		$("#book_page_a").css("left", ($("#HELP_SUPPORT").width()-$("#book_page_a").width())/2 + "px");
		$("#book_page_b").css("left", ($("#HELP_SUPPORT").width()-$("#book_page_a").width())/2 + "px");
	
		$("#BOOK_COVER").css("left", $("#book_page_a").position().left-10 + "px");
		$("#BOOK_COVER").css("top", $("#book_page_a").position().top-10 + "px");
		$("#BOOK_COVER").width($("#book_page_a").width()+20 + "px");
		$("#BOOK_COVER").height($("#book_page_a").height()+20 + "px");
		
		$("#BT_PREVIOUS_PAGE").css("left", ($("#book_page_a").position().left-32) + "px");
		$("#BT_PREVIOUS_PAGE").css("top", ($("#book_page_a").position().top+(($("#book_page_a").height()-64))/2) + "px"); 
		
		$("#BT_NEXT_PAGE").css("left", ($("#book_page_a").position().left+$("#book_page_a").width()) + "px");
		$("#BT_NEXT_PAGE").css("top", ($("#book_page_a").position().top+(($("#book_page_a").height()-64))/2) + "px"); 
	}
	else
	{
		$("#book_page_a").css("left", ($("#HELP_SUPPORT").width()-$("#book_page_a").width())/2 + "px");
		$("#book_page_b").css("left", ($("#HELP_SUPPORT").width()-$("#book_page_a").width())/2 + "px");

		$("#BOOK_COVER").css("left", $("#book_page_b").position().left-10 + "px");
		$("#BOOK_COVER").css("top", $("#book_page_b").position().top-10 + "px");
			
		$("#BOOK_COVER").width($("#book_page_b").width()+20 + "px");
		$("#BOOK_COVER").height($("#book_page_b").height()+20 + "px");
		
		$("#BT_PREVIOUS_PAGE").css("left", ($("#book_page_b").position().left-32) + "px");
		$("#BT_PREVIOUS_PAGE").css("top", ($("#book_page_b").position().top+(($("#book_page_b").height()-64))/2) + "px"); 
		
		$("#BT_NEXT_PAGE").css("left", ($("#book_page_b").position().left+$("#book_page_b").width()) + "px");
		$("#BT_NEXT_PAGE").css("top", ($("#book_page_b").position().top+(($("#book_page_b").height()-64))/2) + "px"); 
	}
	$("#PREVENT_CLICK").css("left", ($("#BOOK_DISPLAY").width()-$("#book_page_a").width())/2 + "px");
	$("#PREVENT_CLICK").width($("#book_page_a").width());
	ratio_true_img = img_true_height/$("#book_page_a").height();
});

// *** GESTION POSITION SOURIS SUR LA ZONE DE TRAVAIL ***
$("#PREVENT_CLICK").mousemove(function(e){

	$("#LOUPE").css("left", (e.pageX-$("#BOOK_DISPLAY").offset().left)-150 + "px");
	$("#LOUPE").css("top", (e.pageY-$("#BOOK_DISPLAY").offset().top)-150 + "px");

	var wlx = ((e.pageX-$("#PREVENT_CLICK").offset().left)*ratio_true_img)-150;
	var wly = ((e.pageY-$("#PREVENT_CLICK").offset().top)*ratio_true_img)-150;

	$("#IMG_LOUPE").css("top","-" + wly + "px");
	$("#IMG_LOUPE").css("left","-" + wlx + "px");
});

$("#PREVENT_CLICK").mouseenter(function(e){

	if ( loupe_visible == 0 && loupe_active == 1 )
	{
		$("#LOUPE").fadeIn(400);
		loupe_visible = 1;
	}
});

$("#PREVENT_CLICK").mouseleave(function(e){

	if ( loupe_visible == 1 && loupe_active == 1 )
	{
		$("#LOUPE").fadeOut(400);
		loupe_visible = 0;
	}
});

function close_open_loupe()
{
	if ( loupe_active == 1 )
	{
		loupe_active = 0;
		$("#MENU_BT_LOUPE").removeClass("bt_top_menu_help_select");
		$("#LOUPE").hide();
	}
	else
	{
		loupe_active = 1;
		$("#MENU_BT_LOUPE").addClass("bt_top_menu_help_select");
	}
}

// **************************************
// *** CHARGEMENT DE LA PREMIERE PAGE ***
// **************************************
load_page(images[0]);
$("#book_page_a").css( 'z-index', 11 );
$("#book_page_b").css( 'z-index', 10 );

$("#BT_NEXT_PAGE").click(function() {
	next_page();
});

$("#BT_PREVIOUS_PAGE").click(function() {
	previous_page();
});

</script>
