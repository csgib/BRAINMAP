<?php
	$result = shell_exec('sleep 1 && ping -c 1 -n -t 55 -v -w 1 ' . $_GET['IP'] . ' | grep ttl=');
	
	if ( count(trim($result)) < 5 )
	{
		$wl_loop = 0;
		while ($wl_loop < 2)
		{
			$result = shell_exec('sleep 1 && ping -c 1 -n -t 55 -v -w 1 ' . $_GET['IP'] . ' | grep ttl=');
			$wl_loop++;
		}
		
	}

	echo $_GET['IP'] . "/_/" . $result;
?>
