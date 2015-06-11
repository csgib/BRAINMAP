<?php
	require_once "class_db.php";

	class CONSTRUCTEUR
	{	
		// *** HANDLE CONNECTION BDD ***
		private $connexion;

		// *** PROPRIETES CLASSE ***
		public $_id;
		public $_name;
		public $_type_object;

		// *** METHODES ET CONSTRUCTEUR ***
		public function __construct()
		{
			$hdl_db = new db();
			$this->connexion = $hdl_db->connexion;
		}

		public function get_constructeurs()
		{		
			$record=$this->connexion->query("SELECT * FROM CONSTRUCTEURS WHERE CONSTRUCTEURS_TYPE_OBJECT = '" . $this->_type_object . "'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}
	}
?>
