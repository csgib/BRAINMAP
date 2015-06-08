<?php
	require_once "class_db.php";

	class Transceiver
	{	
		// *** HANDLE CONNECTION BDD ***
		private $connexion;

		// *** PROPRIETES CLASSE ***
		public $_id;
		public $_libelle;
		public $_site;
		public $_pos_x;
		public $_pos_y;
		public $_constructeur;

		// *** METHODES ET CONSTRUCTEUR ***
		public function __construct()
		{
			$hdl_db = new db();
			$this->connexion = $hdl_db->connexion;
		}
		public function insert_transceiver()
		{
			$result = $this->connexion->exec("INSERT INTO TRANSCEIVERS(TRANSCEIVERS_SITE,TRANSCEIVERS_LIBELLE,TRANSCEIVERS_CONSTRUCTEUR,TRANSCEIVERS_POS_X,TRANSCEIVERS_POS_Y) 
				VALUES('" . addslashes($this->_site) . "' , '"
					 . addslashes($this->_libelle) . "' , '"
					 . addslashes($this->_constructeur) . "' , '"
					 . $this->_pos_x . "' , '"
					 . $this->_pos_y . "')");

			return $this->connexion->lastInsertId();
		}

		public function update_transceiver_position()
		{
			$result = $this->connexion->exec("UPDATE TRANSCEIVERS SET 
					TRANSCEIVERS_POS_X='" . $this->_pos_x . "',
					TRANSCEIVERS_POS_Y='" . $this->_pos_y . "'
					where TRANSCEIVERS_ID=" . $this->_id . " AND TRANSCEIVERS_SITE='" . addslashes($this->_site) . "'" );
			return $result;		
		}
		
		public function update_transceiver()
		{
			$result = $this->connexion->exec("UPDATE TRANSCEIVERS SET 
					TRANSCEIVERS_LIBELLE='" . addslashes($this->_libelle) . "',
					TRANSCEIVERS_CONSTRUCTEUR='" . addslashes($this->_constructeur) . "'	
					where TRANSCEIVERS_ID=" . $this->_id . " AND TRANSCEIVERS_SITE='" . addslashes($this->_site) . "'" );
			return $result;		
		}		
		
		public function get_all_transceivers()
		{		
			$record=$this->connexion->query("SELECT * FROM TRANSCEIVERS WHERE 
				TRANSCEIVERS_SITE='" . addslashes($this->_site) . "'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}
		
		public function get_transceiver_from_id()
		{		
			$record=$this->connexion->query("SELECT * FROM TRANSCEIVERS WHERE 
				TRANSCEIVERS_SITE='" . addslashes($this->_site) . "' AND TRANSCEIVERS_ID=" . $this->_id);
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}
		
		public function delete_transceiver()
		{
			$result = $this->connexion->exec("DELETE FROM TRANSCEIVERS WHERE TRANSCEIVERS_ID=" . $this->_id );
			return $result;
		}
		
		public function delete_transceivers_for_site()
		{
			$result = $this->connexion->exec("DELETE FROM TRANSCEIVERS WHERE TRANSCEIVERS_SITE='" . $this->_site . "'" );
			return $result;
		}
		
		public function get_maxpos_transceiver()
		{		
			$record=$this->connexion->query("SELECT MAX(TRANSCEIVERS_POS_X) AS X,MAX(TRANSCEIVERS_POS_Y) AS Y FROM TRANSCEIVERS WHERE 
				TRANSCEIVERS_SITE='" . $this->_site . "'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}	
	}
?>
