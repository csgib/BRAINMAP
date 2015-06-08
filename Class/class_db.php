<?php
	require("Includes/identification_mysql.php");

	class db
	{
		public function __construct()
		{
			try
			{	
				$this->connexion = new PDO('mysql:host=' . HOST . ';port=' . PORT . ';charset=utf8;dbname=' . CATALOG, UBASE, PBASE );
 			}

 			catch(Exception $e)
			{
				echo 'Erreur : '.$e->getMessage().'<br />';
				echo 'N° : '.$e->getCode();
			}
		}
	}
?>
