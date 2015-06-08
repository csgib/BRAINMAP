<?php
	require_once "class_db.php";

	class Texte
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
		public $_text;

		// *** METHODES ET CONSTRUCTEUR ***
		public function __construct()
		{
			$hdl_db = new db();
			$this->connexion = $hdl_db->connexion;
		}
		public function insert_texte()
		{
			$result = $this->connexion->exec("INSERT INTO TEXTES(TEXTES_SITE,TEXTES_POS_X,TEXTES_POS_Y,TEXTES_WIDTH,TEXTES_HEIGHT,TEXTES_TEXT) 
				VALUES('" . addslashes($this->_site) . "' , '"
					 . $this->_pos_x . "' , '"
					 . $this->_pos_y . "' , '"
					 . $this->_width . "' , '"
					 . $this->_height . "' , '"
					 . addslashes($this->_nom) . "')");

			return $this->connexion->lastInsertId();
		}

		public function update_texte_position()
		{
			$result = $this->connexion->exec("UPDATE TEXTES SET 
					TEXTES_POS_X='" . $this->_pos_x . "',
					TEXTES_POS_Y='" . $this->_pos_y . "',
					TEXTES_WIDTH='" . $this->_width . "',
					TEXTES_HEIGHT='" . $this->_height . "'
					where TEXTES_ID=" . $this->_id . " AND TEXTES_SITE='" . addslashes($this->_site) . "'" );
			return $result;		
		}
		
		public function update_texte()
		{
			$result = $this->connexion->exec("UPDATE TEXTES SET 
					TEXTES_TEXT='" . addslashes($this->_nom) . "'
					where TEXTES_ID=" . $this->_id . " AND TEXTES_SITE='" . addslashes($this->_site) . "'" );
			return $result;		
		}		
		
		public function get_all_textes()
		{		
			$record=$this->connexion->query("SELECT * FROM TEXTES WHERE 
				TEXTES_SITE='" . addslashes($this->_site) . "'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}
		
		public function get_texte_from_id()
		{		
			$record=$this->connexion->query("SELECT * FROM TEXTES WHERE 
				TEXTES_SITE='" . addslashes($this->_site) . "' AND TEXTES_ID=" . $this->_id);
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}
		
		public function delete_texte()
		{
			$result = $this->connexion->exec("DELETE FROM TEXTES WHERE TEXTES_ID=" . $this->_id );
			return $result;
		}
		
		public function delete_textes_for_site()
		{
			$result = $this->connexion->exec("DELETE FROM TEXTES WHERE TEXTES_SITE='" . $this->_site . "'" );
			return $result;
		}
		
		public function get_maxpos_texte()
		{		
			$record=$this->connexion->query("SELECT MAX(TEXTES_POS_X+TEXTES_WIDTH) AS X,MAX(TEXTES_POS_Y+TEXTES_HEIGHT) AS Y FROM TEXTES WHERE 
				TEXTES_SITE='" . $this->_site . "'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}			
	}
?>
