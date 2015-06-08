<?php
	require_once "class_db.php";

	class Routeur
	{	
		// *** HANDLE CONNECTION BDD ***
		private $connexion;

		// *** PROPRIETES CLASSE ***
		public $_id;
		public $_site;
		public $_name;
		public $_pos_x;
		public $_pos_y;
		public $_ip;
		public $_wifi;
		public $_ip_publique;

		// *** METHODES ET CONSTRUCTEUR ***
		public function __construct()
		{
			$hdl_db = new db();
			$this->connexion = $hdl_db->connexion;
		}
		public function insert_routeur()
		{
			$result = $this->connexion->exec("INSERT INTO ROUTEURS(ROUTEURS_SITE,ROUTEURS_NAME,ROUTEURS_POS_X,ROUTEURS_POS_Y,ROUTEURS_IP,ROUTEURS_WIFI,ROUTEURS_IP_PUBLIQUE) 
				VALUES('" . addslashes($this->_site) . "' , '"
					 . addslashes($this->_name) . "' , '"
					 . $this->_pos_x . "' , '"
					 . $this->_pos_y . "' , '"
					 . $this->_ip . "', '"
					 . $this->_wifi . "' , '"
					 . $this->_ip_publique . "')");

			return $this->connexion->lastInsertId();
		}

		public function get_routeur_from_id()
		{		
			$record=$this->connexion->query("SELECT * FROM ROUTEURS WHERE 
				ROUTEURS_SITE='" . addslashes($this->_site) . "' AND ROUTEURS_ID=" . $this->_id);
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}

		public function get_all_routeurs()
		{		
			$record=$this->connexion->query("SELECT * FROM ROUTEURS WHERE 
				ROUTEURS_SITE='" . addslashes($this->_site) . "'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}

		public function update_routeur()
		{
			$result = $this->connexion->exec("UPDATE ROUTEURS SET 
					ROUTEURS_NAME='" . addslashes($this->_name) . "',
					ROUTEURS_IP='" . $this->_ip . "',
					ROUTEURS_WIFI='" . $this->_wifi . "',
					ROUTEURS_IP_PUBLIQUE='" . $this->_ip_publique . "'
					where ROUTEURS_ID=" . $this->_id . " AND ROUTEURS_SITE='" . addslashes($this->_site) . "'" );
			return $result;		
		}

		public function update_routeur_position()
		{
			$result = $this->connexion->exec("UPDATE ROUTEURS SET 
					ROUTEURS_POS_X='" . $this->_pos_x . "',
					ROUTEURS_POS_Y='" . $this->_pos_y . "'
					where ROUTEURS_ID=" . $this->_id . " AND ROUTEURS_SITE='" . addslashes($this->_site) . "'" );
			return $result;		
		}

		public function delete_routeur()
		{
			$result = $this->connexion->exec("DELETE FROM ROUTEURS WHERE ROUTEURS_ID=" . $this->_id );
			return $result;
		}

		public function delete_routeurs_for_site()
		{
			$result = $this->connexion->exec("DELETE FROM ROUTEURS WHERE ROUTEURS_SITE='" . $this->_site . "'" );
			return $result;
		}
		
		public function get_maxpos_routeur()
		{		
			$record=$this->connexion->query("SELECT MAX(ROUTEURS_POS_X) AS X,MAX(ROUTEURS_POS_Y) AS Y FROM ROUTEURS WHERE 
				ROUTEURS_SITE='" . $this->_site . "'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}			
	}
?>
