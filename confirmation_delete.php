<br><br><h2 class="TITLE_N0 TITLE_BLUE TITLE_CENTER_IT TITLE_BORDER_IT">CONFIRMATION DE SUPPRESSION</h2>

	<?php

	if ( $_GET['SRC'] == "SWI" )
	{
		echo "<div class='DELETE_TXT'><center><b>Etes vous sur de vouloir supprimer ce switch. Toutes les liaisons qui auraient été définies avec ce switch seront également supprimées.</b></center></div>";

		echo "<div class='BOTTOM_BUTTONS'><button class='main_bt' type='button' onClick='javascript:valide_delete_switch(" . $_GET['ID'] . ",\"" . $_GET['IP'] . "\"," . $_GET['PY'] . "," . $_GET['BAIE_ID'] . ")'>Valider</button><button class='main_bt_inv' onClick='javascript:close_delete_element()'>Retour</button></div>";
	}
	else
	{
		if ( $_GET['SRC'] == "SRV" )
		{
			echo "<div class='DELETE_TXT'><center><b>Etes vous sur de vouloir supprimer ce serveur. Toutes les liaisons qui auraient été définies avec ce serveur seront également supprimées.</b></center></div>";

			echo "<div class='BOTTOM_BUTTONS'><button class='main_bt' type='button' onClick='javascript:valide_delete_serveur(" . $_GET['ID'] . ")'>Valider</button><button class='main_bt_inv' onClick='javascript:close_delete_element()'>Retour</button></div>";
		}
		else
		{
			if ( $_GET['SRC'] == "ROU" )
			{
				echo "<div class='DELETE_TXT'><center><b>Etes vous sur de vouloir supprimer ce routeur. Toutes les liaisons qui auraient été définies avec ce routeur seront également supprimées.</b></center></div>";

				echo "<div class='BOTTOM_BUTTONS'><button class='main_bt' type='button' onClick='javascript:valide_delete_routeur(" . $_GET['ID'] . ")'>Valider</button><button class='main_bt_inv' onClick='javascript:close_delete_element()'>Retour</button></div>";
			}
			else
			{
				if ( $_GET['SRC'] == "BAI" )
				{
					echo "<div class='DELETE_TXT'><center><b>Etes vous sur de vouloir supprimer cette baie. Cette action est définitive et ne pourra pas être annulée</b></center></div>";

					echo "<div class='BOTTOM_BUTTONS'><button class='main_bt' type='button' onClick='javascript:valide_delete_baie(" . $_GET['ID'] . ")'>Valider</button><button class='main_bt_inv' onClick='javascript:close_delete_element()'>Retour</button></div>";
				}
				else
				{
					if ( $_GET['SRC'] == "NAS" )
					{
						echo "<div class='DELETE_TXT'><center><b>Etes vous sur de vouloir supprimer ce nas. Cette action est définitive et ne pourra pas être annulée</b></center></div>";

						echo "<div class='BOTTOM_BUTTONS'><button class='main_bt' type='button' onClick='javascript:valide_delete_nas(" . $_GET['ID'] . ")'>Valider</button><button class='main_bt_inv' onClick='javascript:close_delete_element()'>Retour</button></div>";
					}
					else
					{
						if ( $_GET['SRC'] == "SIT" )
						{
							echo "<div class='DELETE_TXT'><center><b>Etes vous sur de vouloir supprimer le site " . $_GET['ID'] . ". Cette action est définitive et ne pourra pas être annulée</b></center></div>";

							echo "<div class='BOTTOM_BUTTONS'><button class='main_bt' type='button' onClick='javascript:valide_delete_site(\"" . $_GET['ID'] . "\")'>Valider</button><button class='main_bt_inv' onClick='javascript:close_delete_element()'>Retour</button></div>";
						}
						else 
						{
							if ( $_GET['SRC'] == "MIN" )
							{
								echo "<div class='DELETE_TXT'><center><b>Etes vous sur de vouloir supprimer ce mini switch. Cette action est définitive et ne pourra pas être annulée</b></center></div>";

								echo "<div class='BOTTOM_BUTTONS'><button class='main_bt' type='button' onClick='javascript:valide_delete_mini_switch(\"" . $_GET['ID'] . "\")'>Valider</button><button class='main_bt_inv' onClick='javascript:close_delete_element()'>Retour</button></div>";
							}
							else
							{
								if ( $_GET['SRC'] == "ZON" )
								{
									echo "<div class='DELETE_TXT'><center><b>Etes vous sur de vouloir supprimer cette zone de groupe. Cette action est définitive et ne pourra pas être annulée</b></center></div>";

									echo "<div class='BOTTOM_BUTTONS'><button class='main_bt' type='button' onClick='javascript:valide_delete_zone(\"" . $_GET['ID'] . "\")'>Valider</button><button class='main_bt_inv' onClick='javascript:close_delete_element()'>Retour</button></div>";
								}
								else
								{
									if ( $_GET['SRC'] == "CAM" )
									{
										echo "<div class='DELETE_TXT'><center><b>Etes vous sur de vouloir supprimer cette camera. Cette action est définitive et ne pourra pas être annulée</b></center></div>";

										echo "<div class='BOTTOM_BUTTONS'><button class='main_bt' type='button' onClick='javascript:valide_delete_camera(\"" . $_GET['ID'] . "\")'>Valider</button><button class='main_bt_inv' onClick='javascript:close_delete_element()'>Retour</button></div>";
									}
									else
									{
										if ( $_GET['SRC'] == "ANT" )
										{
											echo "<div class='DELETE_TXT'><center><b>Etes vous sur de vouloir supprimer cette antenne. Cette action est définitive et ne pourra pas être annulée</b></center></div>";

											echo "<div class='BOTTOM_BUTTONS'><button class='main_bt' type='button' onClick='javascript:valide_delete_antenne(\"" . $_GET['ID'] . "\")'>Valider</button><button class='main_bt_inv' onClick='javascript:close_delete_element()'>Retour</button></div>";
										}
										else
										{
											if ( $_GET['SRC'] == "TRA" )
											{
												echo "<div class='DELETE_TXT'><center><b>Etes vous sur de vouloir supprimer ce transciever. Cette action est définitive et ne pourra pas être annulée</b></center></div>";
	
												echo "<div class='BOTTOM_BUTTONS'><button class='main_bt' type='button' onClick='javascript:valide_delete_transceiver(\"" . $_GET['ID'] . "\")'>Valider</button><button class='main_bt_inv' onClick='javascript:close_delete_element()'>Retour</button></div>";
											}
											else
											{
												if ( $_GET['SRC'] == "TXT" )
												{
													echo "<div class='DELETE_TXT'><center><b>Etes vous sur de vouloir supprimer cette zone de texte. Cette action est définitive et ne pourra pas être annulée</b></center></div>";
		
													echo "<div class='BOTTOM_BUTTONS'><button class='main_bt' type='button' onClick='javascript:valide_delete_texte(\"" . $_GET['ID'] . "\")'>Valider</button><button class='main_bt_inv' onClick='javascript:close_delete_element()'>Retour</button></div>";
												} 												
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}

	?>

<script type="text/javascript">

$('#SITE').val(sessionStorage.getItem("SITKEY"));

</script>
