	<?php

		require "Class/class_contacts.php";

		$hdl_contact = new Contact();
		$hdl_contact->_site	 		= $_POST['FRM_SITE'];
		$hdl_contact->_nom	 		= $_POST['FRM_NAME'];
		$hdl_contact->_telephone 		= $_POST['FRM_TEL'];
		$hdl_contact->_fonction	 		= $_POST['FRM_FONCTION'];

		
		if ( $_POST['FRM_NEW'] == "0" )
		{
			$result = $hdl_contact->insert_contacts();
		}
		else
		{
			$hdl_contact->_id		= $_POST['FRM_NEW'];
			$result = $hdl_contact->update_contacts();
		}
		echo $result;

	?>
