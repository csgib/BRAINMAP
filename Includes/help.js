var book_open = 0;

function show_help()
{
	$.ajax({
		type:"GET",
		url:"load_book.php?BK=DOC",
		success: function(retour){
			$("#HELP_SUPPORT").empty().append(retour);
			
			if ( book_open == 1 )
			{
				$("#HELP_SUPPORT").resizable( "destroy" );
			}

			$("#HELP_SUPPORT").resizable({
				aspectRatio: true
			});			
			
			book_open = 1;
			$("#HELP_SUPPORT").fadeIn(400);
		}
	});
}

function close_open_book()
{
	$("#HELP_SUPPORT").fadeOut(400);
}
