<?php
	require "Class/class_contacts.php";
	$hdl_contact = new Contact();
	
	$hdl_contact->_site		= $_GET['SITE'];

	echo "<table>";

	$result_contact = json_decode($hdl_contact->get_contacts_from_site());
	$i = 0;

	while ( $i < count($result_contact) )
	{
		echo "<tr onclick='javascript:edit_contact(" . $result_contact[$i]->CONTACTS_ID . ")' style='border-bottom: 1px dotted #424649;' class='row_contact'><td><b>" . $result_contact[$i]->CONTACTS_NOM . "</b><br>" . $result_contact[$i]->CONTACTS_FONCTION . "</td><td>" . $result_contact[$i]->CONTACTS_TELEPHONE . "</td></tr>";

		$i++;
	}
	echo "</table>";
		
?>
