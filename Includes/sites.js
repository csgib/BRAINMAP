function delete_site()
{
	hide_contextual();
	$.ajax({
		type:"GET",
		url:"confirmation_delete.php?SRC=SIT&ID=" + sessionStorage.getItem('SITKEY'),
		success: function(retour){
			$("#MODAL_ADD").empty().append(retour);
			$("#LOCK_SCREEN_NIV_2").fadeIn(400);
			$("#MODAL_ADD").fadeIn(400);
		}
	});
}

function valide_delete_site(id)
{
	$.ajax({
		type:"GET",
		url:"delete_site.php?ID=" + id,
		success: function(response){
			response = response.replace(/^\s+/g,'').replace(/\s+$/g,'');
			if ( parseInt(response.substring(0,1)) > 0 )
			{
				$("#LOCK_SCREEN_NIV_2").fadeOut(400);
				$("#MODAL_ADD").fadeOut(400);

				$("#ST_" + id).remove();
				
				global_site = response.substring(1);
				
				close_schema();
			}
			else
			{
				$.gritter.add({
					title: 'Suppression site',
					text: 'Erreur lors de la suppression du site dans la base de données.',
					time: 1500
				});
			}
		},
	        error: function(){
			$.gritter.add({
				title: 'Suppression site',
				text: 'Erreur lors de la suppression du site dans la base de données.',
				time: 1500
			});
    		}
	});
}

function reload_site()
{
	$.ajax({
		type:"GET",
		url:"graph_main.php?SITE=" + sessionStorage.getItem("SITKEY"),
		success: function(retour){
			$("#APPLICATION_SURFACE").empty().append(retour);
		}
	});
}
