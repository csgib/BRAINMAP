<?php
	require_once "class_db.php";

	class GLPI
	{	
		// *** HANDLE CONNECTION BDD ***
		private $connexion;

		// *** PROPRIETES CLASSE ***
		public $_ip;
		public $_url;
		public $_user;
		public $_pass;

		// *** METHODES ET CONSTRUCTEUR ***
		public function __construct()
		{
			$hdl_db = new db();
			$this->connexion = $hdl_db->connexion;
		}

		public function get_glpi_params()
		{		
			$record=$this->connexion->query("SELECT * FROM PARAMS LIMIT 1");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}
	}
?>
