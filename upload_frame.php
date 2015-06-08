<?php
    @session_start();
?>

<p class="TITLE_N0 TITLE_BLUE TITLE_BORDER_IT TITLE_CENTER_IT">TELECHARGER UN FICHIER</p>

<p class="TITLE_N2 TITLE_CENTER_IT" id="PARA_FILENAME">Aucun fichier sélectionné</p>

<form id="formUpload" action="upload_files.php?SITE_ID=<?php echo $_SESSION['SITKEY'];?>" method="post" enctype="multipart/form-data">
    <input type="file" id="BT_SEARCH_FILE" name="SITE_DOCUMENTS" class="file-input" style='display: none;'/>
    <input type="submit" id="BT_SUBMIT_FILE" class="main_bt" value="Télécharger" disabled/>
    <input type="button" class="main_bt" value="Chercher" onclick="javascript:open_search()"/>
    <br>
    
</form>

<div id="progress_upload">
    <div id="bar"></div>
    <div id="percent">0%</div>
    <br/>
    <div id="message"></div>
</div>
       
<div class="BOTTOM_BUTTONS" style="position: absolute; left: 0px; bottom: 0px;">
    <button id="BTCOLSEUP" class='main_bt_inv' onclick='javascript:bye_something();'>Fermer</button>
</div>    

<script type="text/javascript">
    
   
    function open_search()
    {
        $("#BT_SEARCH_FILE").click();
    }
    
    
    $(document).ready(function(){
        var options = {
            beforeSend: function()
            {
                $("#BTCOLSEUP").attr("disabled","disabled");
                $("#formUpload").toggle(200);
                $("#progress").fadeIn(200);
                $("#bar").width('0%');
                $("#message").html("");
                $("#percent").html("0%");
            },
            uploadProgress: function(event, position, total, percentComplete)
            {
                $("#bar").width(percentComplete+'%');
                $("#percent").html(percentComplete+'%');
            },
            success: function()
            {
                $("#bar").width('100%');
                $("#percent").html('100%');
                $("#BTCOLSEUP").removeAttr("disabled");
            },
            complete: function(response)
            {
                if ( response.responseText.substr(0,5) == "ERROR" )
                {
                    $("#bar").css("background-color","#C92C31");
                    $("#bar").css("border","1px solid #9E2232");
                   
                    $.gritter.add({
			title: 'TELECHARGEMENT',
			text: response.responseText.substring(5),
			time: 2500
                    }); 
                }
                else
                {
                    $.gritter.add({
                            title: 'TELECHARGEMENT',
                            text: response.responseText,
                            time: 2500
                    });
		    
		    load_files();
		    bye_something();
                }
                $("#BTCOLSEUP").removeAttr("disabled");
            },
            error: function()
            {
                $("#formUpload").toggle(200);
                
                $("#bar").css("background-color","#C92C31");
                $("#bar").css("border","1px solid #9E2232");
                
                $.gritter.add({
			title: 'TELECHARGEMENT',
			text: 'ERREUR : Impossible de télécharger le document',
			time: 2500
		});
            }
        };
        
        $("#formUpload").ajaxForm(options);
        
        $("#formUpload").change(function(wl_data,e) {
            $("#BT_SUBMIT_FILE").removeAttr("disabled");
            $("#PARA_FILENAME").html(wl_data.target.files[0].name);
        });
    });
    
</script>
