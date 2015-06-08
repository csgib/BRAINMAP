<?php
	require_once "class_db.php";

	class Zone
	{	
		// *** HANDLE CONNECTION BDD ***
		private $connexion;

		// *** PROPRIETES CLASSE ***
		public $_id;
		public $_site;
		public $_pos_x;
		public $_pos_y;
		public $_width;
		public $_height;
		public $_nom;
		public $_color;

		// *** METHODES ET CONSTRUCTEUR ***
		public function __construct()
		{
			$hdl_db = new db();
			$this->connexion = $hdl_db->connexion;
		}
		public function insert_zone()
		{
			$result = $this->connexion->exec("INSERT INTO ZONES(ZONES_SITE,ZONES_POS_X,ZONES_POS_Y,ZONES_WIDTH,ZONES_HEIGHT,ZONES_NOM,ZONES_COLOR) 
				VALUES('" . addslashes($this->_site) . "' , '"
					 . $this->_pos_x . "' , '"
					 . $this->_pos_y . "' , '"
					 . $this->_width . "' , '"
					 . $this->_height . "' , '"
					 . addslashes($this->_nom) . "' , '"					 
					 . $this->_color . "')");

			return $this->connexion->lastInsertId();
		}

		public function update_zone_position()
		{
			$result = $this->connexion->exec("UPDATE ZONES SET 
					ZONES_POS_X='" . $this->_pos_x . "',
					ZONES_POS_Y='" . $this->_pos_y . "',
					ZONES_WIDTH='" . $this->_width . "',
					ZONES_HEIGHT='" . $this->_height . "'
					where ZONES_ID=" . $this->_id . " AND ZONES_SITE='" . addslashes($this->_site) . "'" );
			return $result;		
		}
		
		public function update_zone()
		{
			$result = $this->connexion->exec("UPDATE ZONES SET 
					ZONES_NOM='" . addslashes($this->_nom) . "',
					ZONES_COLOR='" . addslashes($this->_color) . "'					
					where ZONES_ID=" . $this->_id . " AND ZONES_SITE='" . addslashes($this->_site) . "'" );
			return $result;		
		}		
		
		public function get_all_zones()
		{		
			$record=$this->connexion->query("SELECT * FROM ZONES WHERE 
				ZONES_SITE='" . addslashes($this->_site) . "'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}
		
		public function get_zone_from_id()
		{		
			$record=$this->connexion->query("SELECT * FROM ZONES WHERE 
				ZONES_SITE='" . addslashes($this->_site) . "' AND ZONES_ID=" . $this->_id);
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}
		
		public function delete_zone()
		{
			$result = $this->connexion->exec("DELETE FROM ZONES WHERE ZONES_ID=" . $this->_id );
			return $result;
		}
		
		public function delete_zones_for_site()
		{
			$result = $this->connexion->exec("DELETE FROM ZONES WHERE ZONES_SITE='" . $this->_site . "'" );
			return $result;
		}
		
		public function get_maxpos_zone()
		{		
			$record=$this->connexion->query("SELECT MAX(ZONES_POS_X+ZONES_WIDTH) AS X,MAX(ZONES_POS_Y+ZONES_HEIGHT) AS Y FROM ZONES WHERE 
				ZONES_SITE='" . $this->_site . "'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}		
	}
?>
