<?php
	require_once "class_db.php";

	class Antenne
	{	
		// *** HANDLE CONNECTION BDD ***
		private $connexion;

		// *** PROPRIETES CLASSE ***
		public $_id;
		public $_nom;
		public $_site;
		public $_pos_x;
		public $_pos_y;
		public $_ip;

		// *** METHODES ET CONSTRUCTEUR ***
		public function __construct()
		{
			$hdl_db = new db();
			$this->connexion = $hdl_db->connexion;
		}
		public function insert_antenne()
		{
			$result = $this->connexion->exec("INSERT INTO ANTENNES(ANTENNES_SITE,ANTENNES_NOM,ANTENNES_POS_X,ANTENNES_POS_Y,ANTENNES_IP) 
				VALUES('" . addslashes($this->_site) . "' , '"
					 . addslashes($this->_nom) . "' , '"
					 . $this->_pos_x . "' , '"
					 . $this->_pos_y . "' , '"
					 . addslashes($this->_ip) . "')");

			return $this->connexion->lastInsertId();
		}

		public function update_antenne_position()
		{
			$result = $this->connexion->exec("UPDATE ANTENNES SET 
					ANTENNES_POS_X='" . $this->_pos_x . "',
					ANTENNES_POS_Y='" . $this->_pos_y . "'
					where ANTENNES_ID=" . $this->_id . " AND ANTENNES_SITE='" . addslashes($this->_site) . "'" );
			return $result;		
		}
		
		public function update_antenne()
		{
			$result = $this->connexion->exec("UPDATE ANTENNES SET 
					ANTENNES_NOM='" . addslashes($this->_nom) . "',
					ANTENNES_IP='" . addslashes($this->_ip) . "'
					where ANTENNES_ID=" . $this->_id . " AND ANTENNES_SITE='" . addslashes($this->_site) . "'" );
			return $result;		
		}		
		
		public function get_all_antennes()
		{		
			$record=$this->connexion->query("SELECT * FROM ANTENNES WHERE 
				ANTENNES_SITE='" . addslashes($this->_site) . "'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}
		
		public function get_antenne_from_id()
		{		
			$record=$this->connexion->query("SELECT * FROM ANTENNES WHERE 
				ANTENNES_SITE='" . addslashes($this->_site) . "' AND ANTENNES_ID=" . $this->_id);
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}
		
		public function delete_antenne()
		{
			$result = $this->connexion->exec("DELETE FROM ANTENNES WHERE ANTENNES_ID=" . $this->_id );
			return $result;
		}
		
		public function delete_antennes_for_site()
		{
			$result = $this->connexion->exec("DELETE FROM ANTENNES WHERE ANTENNES_SITE='" . $this->_site . "'" );
			return $result;
		}
		
		public function get_maxpos_antenne()
		{		
			$record=$this->connexion->query("SELECT MAX(ANTENNES_POS_X) AS X,MAX(ANTENNES_POS_Y) AS Y FROM ANTENNES WHERE 
				ANTENNES_SITE='" . $this->_site . "'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}		
		
	}
?>
