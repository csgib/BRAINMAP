	<?php

		require "Class/class_sites.php";

		$hdl_site = new Site();
		$hdl_site->_id = $_GET['NAME'];
		
		$result_site = json_decode($hdl_site->get_filter_sites());

		$i = 0;

		while ( $i < count($result_site) )
		{
			echo "<li id='ST_" . $result_site[$i]->SITES_ID . "' onclick='javascript:load_graph(\"" . $result_site[$i]->SITES_ID . "\")'>";
			echo "<table style='width: 100%;'><tr><td><h2>" . $result_site[$i]->SITES_ID . "</h2>" . $result_site[$i]->SITES_DESCRIPTION . "<br>" . $result_site[$i]->SITES_ADRESSE . "<br>" . $result_site[$i]->SITES_POSTAL . " " . $result_site[$i]->SITES_VILLE . "</td>";
			echo "<td style='width: 120px;'><img class='vignette_etab' src='Snaps/" . $result_site[$i]->SITES_ID . ".png'></td></tr></table></li>";
			$i++;
		}

	?>
