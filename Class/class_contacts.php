<?php
	require_once "class_db.php";

	class Contact
	{	
		// *** HANDLE CONNECTION BDD ***
		private $connexion;

		// *** PROPRIETES CLASSE ***
		public $_id;
		public $_site;
		public $_nom;
		public $_telephone;
		public $_fonction;

		// *** METHODES ET CONSTRUCTEUR ***
		public function __construct()
		{
			$hdl_db = new db();
			$this->connexion = $hdl_db->connexion;
		}
		public function insert_contacts()
		{
			$result = $this->connexion->exec("INSERT INTO CONTACTS(CONTACTS_SITE,CONTACTS_NOM,CONTACTS_TELEPHONE,CONTACTS_FONCTION) 
				VALUES('" . addslashes($this->_site) . "' , '"
					 . addslashes($this->_nom) . "' , '"
					 . addslashes($this->_telephone) . "' , '"
					 . addslashes($this->_fonction) . "')");

			return $this->connexion->lastInsertId();
		}

		public function update_contacts()
		{
			$result = $this->connexion->exec("UPDATE CONTACTS SET 
					CONTACTS_NOM='" . addslashes($this->_nom) . "',
					CONTACTS_TELEPHONE='" . addslashes($this->_telephone) . "',
					CONTACTS_FONCTION='" . addslashes($this->_fonction) . "'
					where CONTACTS_ID=" . $this->_id );
			return $result;
		}
		
		public function get_contacts_from_site()
		{		
			$record=$this->connexion->query("SELECT * FROM CONTACTS WHERE 
				CONTACTS_SITE='" . addslashes($this->_site) . "'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}

		public function get_contact_from_id()
		{		
			$record=$this->connexion->query("SELECT * FROM CONTACTS WHERE 
				CONTACTS_ID='" . $this->_id . "'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}
	}
?>
