<?php
	require "Class/class_computers.php";
	$hdl_computers = new Computer();
	
	$hdl_computers->_site		= $_GET['SITE'];

	echo "<table>";

	$result_computer = json_decode($hdl_computers->get_computers_from_site());
	$i = 0;

	while ( $i < count($result_computer) )
	{
		echo "<tr onclick='javascript:edit_computer(" . $result_computer[$i]->COMPUTERS_ID . ")' style='border-bottom: 1px dotted #424649;' class='row_contact'><td><b>" . $result_computer[$i]->COMPUTERS_HOSTNAME . "</b><br>" . $result_computer[$i]->COMPUTERS_IP . "</td><td style='width: 32px;'><img src='Images/" . $result_computer[$i]->COMPUTERS_OS . ".png'></td></tr>";

		$i++;
	}
	echo "</table>";
		
?>
