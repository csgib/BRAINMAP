<?php
	require_once "class_db.php";

	class Nas
	{	
		// *** HANDLE CONNECTION BDD ***
		private $connexion;

		// *** PROPRIETES CLASSE ***
		public $_id;
		public $_site;
		public $_name;
		public $_ip;
		public $_pos_x;
		public $_pos_y;


		// *** METHODES ET CONSTRUCTEUR ***
		public function __construct()
		{
			$hdl_db = new db();
			$this->connexion = $hdl_db->connexion;
		}
		public function insert_nas()
		{
			$result = $this->connexion->exec("INSERT INTO NAS(NAS_SITE,NAS_NAME,NAS_IP,NAS_POS_X,NAS_POS_Y) 
				VALUES('" . addslashes($this->_site) . "' , '"
					 . addslashes($this->_name) . "' , '"
					 . addslashes($this->_ip) . "' , '"
					 . $this->_pos_x . "' , '"
					 . $this->_pos_y . "')");

			return $this->connexion->lastInsertId();
		}

		public function get_nas_from_id()
		{		
			$record=$this->connexion->query("SELECT * FROM NAS WHERE 
				NAS_SITE='" . addslashes($this->_site) . "' AND NAS_ID=" . $this->_id);
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}

		public function get_all_nas()
		{		
			$record=$this->connexion->query("SELECT * FROM NAS WHERE 
				NAS_SITE='" . $this->_site . "'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}

		public function update_nas()
		{
			$result = $this->connexion->exec("UPDATE NAS SET 
					NAS_NAME='" . $this->_name . "',
					NAS_IP='" . $this->_ip . "'
					where NAS_ID=" . $this->_id . " AND NAS_SITE='" . addslashes($this->_site) . "'" );
			return $result;		
		}

		public function update_nas_position()
		{
			$result = $this->connexion->exec("UPDATE NAS SET 
					NAS_POS_X='" . $this->_pos_x . "',
					NAS_POS_Y='" . $this->_pos_y . "'
					where NAS_ID=" . $this->_id . " AND NAS_SITE='" . addslashes($this->_site) . "'" );
			return $result;	
		}

		public function delete_nas()
		{
			$result = $this->connexion->exec("DELETE FROM NAS WHERE NAS_ID=" . $this->_id );
			return $result;
		}

		public function delete_nas_for_site()
		{
			$result = $this->connexion->exec("DELETE FROM NAS WHERE NAS_SITE='" . $this->_site . "'" );
			return $result;
		}
		
		public function get_maxpos_nas()
		{		
			$record=$this->connexion->query("SELECT MAX(NAS_POS_X) AS X,MAX(NAS_POS_Y) AS Y FROM NAS WHERE 
				NAS_SITE='" . $this->_site . "'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}			
	}
?>
