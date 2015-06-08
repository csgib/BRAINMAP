<?php
	require_once "class_db.php";

	class Camera
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
		public $_descriptif;

		// *** METHODES ET CONSTRUCTEUR ***
		public function __construct()
		{
			$hdl_db = new db();
			$this->connexion = $hdl_db->connexion;
		}
		public function insert_camera()
		{
			$result = $this->connexion->exec("INSERT INTO CAMERAS(CAMERAS_SITE,CAMERAS_NOM,CAMERAS_POS_X,CAMERAS_POS_Y,CAMERAS_IP,CAMERAS_DESCRIPTIF) 
				VALUES('" . addslashes($this->_site) . "' , '"
					 . addslashes($this->_nom) . "' , '"
					 . $this->_pos_x . "' , '"
					 . $this->_pos_y . "' , '"
					 . addslashes($this->_ip) . "' , '"					 
					 . addslashes($this->_descriptif) . "')");

			return $this->connexion->lastInsertId();
		}

		public function update_camera_position()
		{
			$result = $this->connexion->exec("UPDATE CAMERAS SET 
					CAMERAS_POS_X='" . $this->_pos_x . "',
					CAMERAS_POS_Y='" . $this->_pos_y . "'
					where CAMERAS_ID=" . $this->_id . " AND CAMERAS_SITE='" . addslashes($this->_site) . "'" );
			return $result;		
		}
		
		public function update_camera()
		{
			$result = $this->connexion->exec("UPDATE CAMERAS SET 
					CAMERAS_NOM='" . addslashes($this->_nom) . "',
					CAMERAS_IP='" . addslashes($this->_ip) . "',
					CAMERAS_DESCRIPTIF='" . addslashes($this->_descriptif) . "'	
					where CAMERAS_ID=" . $this->_id . " AND CAMERAS_SITE='" . addslashes($this->_site) . "'" );
			return $result;		
		}		
		
		public function get_all_cameras()
		{		
			$record=$this->connexion->query("SELECT * FROM CAMERAS WHERE 
				CAMERAS_SITE='" . addslashes($this->_site) . "'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}
		
		public function get_camera_from_id()
		{		
			$record=$this->connexion->query("SELECT * FROM CAMERAS WHERE 
				CAMERAS_SITE='" . addslashes($this->_site) . "' AND CAMERAS_ID=" . $this->_id);
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}
		
		public function delete_camera()
		{
			$result = $this->connexion->exec("DELETE FROM CAMERAS WHERE CAMERAS_ID=" . $this->_id );
			return $result;
		}
		
		public function delete_cameras_for_site()
		{
			$result = $this->connexion->exec("DELETE FROM CAMERAS WHERE CAMERAS_SITE='" . $this->_site . "'" );
			return $result;
		}
		
		public function get_maxpos_camera()
		{		
			$record=$this->connexion->query("SELECT MAX(CAMERAS_POS_X) AS X,MAX(CAMERAS_POS_Y) AS Y FROM CAMERAS WHERE 
				CAMERAS_SITE='" . $this->_site . "'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}			
	}
?>
