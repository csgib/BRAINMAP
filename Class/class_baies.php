<?php
	require_once "class_db.php";

	class Baie
	{	
		// *** HANDLE CONNECTION BDD ***
		private $connexion;

		// *** PROPRIETES CLASSE ***
		public $_id;
		public $_site;
		public $_commentaires;
		public $_pos_x;
		public $_pos_y;
		public $_width;
		public $_height;
		public $_ondulee;
		public $_datas;

		// *** METHODES ET CONSTRUCTEUR ***
		public function __construct()
		{
			$hdl_db = new db();
			$this->connexion = $hdl_db->connexion;
		}

		public function get_all_baies()
		{		
			$record=$this->connexion->query("SELECT * FROM BAIES WHERE 
				BAIES_SITE='" . $this->_site . "'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}

		public function get_baie_from_id()
		{		
			$record=$this->connexion->query("SELECT * FROM BAIES WHERE 
				BAIES_ID=" . $this->_id);
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}

		public function insert_baie()
		{
			$result = $this->connexion->exec("INSERT INTO BAIES(BAIES_SITE,BAIES_POS_X,BAIES_POS_Y,BAIES_WIDTH,BAIES_HEIGHT,BAIES_COMMENTAIRES,BAIES_ONDULEE,BAIES_DATAS) 
				VALUES('" . addslashes($this->_site) . "' , '"
					 . $this->_pos_x . "' , '"
					 . $this->_pos_y . "' , '"
					 . $this->_width . "' , '"
					 . $this->_height . "' , '"
					 . addslashes($this->_commentaires) . "' , '"
					 . $this->_ondulee . "' , '"
					 . addslashes($this->_datas) . "')");

			return $this->connexion->lastInsertId();
		}

		public function update_baie_name()
		{
			$result = $this->connexion->exec("UPDATE BAIES SET 
					BAIES_COMMENTAIRES=" . $this->connexion->quote($this->_commentaires) . ",
					BAIES_ONDULEE='" . $this->_ondulee . "',
					BAIES_DATAS=" . $this->connexion->quote($this->_datas) . "
					where BAIES_ID=" . $this->_id . " AND BAIES_SITE='" . addslashes($this->_site) . "'" );
			return $result;		
		}

		public function update_baie_position()
		{
			$result = $this->connexion->exec("UPDATE BAIES SET 
					BAIES_POS_X='" . $this->_pos_x . "',
					BAIES_POS_Y='" . $this->_pos_y . "'
					where BAIES_ID=" . $this->_id . " AND BAIES_SITE='" . addslashes($this->_site) . "'" );
			return $result;		
		}

		public function delete_baie()
		{
			$result = $this->connexion->exec("DELETE FROM BAIES WHERE BAIES_ID='" . $this->_id . "' AND BAIES_SITE='" . $this->_site . "'" );
			return $result;
		}

		public function delete_baies_for_site()
		{
			$result = $this->connexion->exec("DELETE FROM BAIES WHERE BAIES_SITE='" . $this->_site . "'" );
			return $result;
		}
		
		public function get_maxpos_baie()
		{		
			$record=$this->connexion->query("SELECT MAX(BAIES_POS_X+BAIES_WIDTH) AS X,MAX(BAIES_POS_Y+BAIES_HEIGHT) AS Y FROM BAIES WHERE 
				BAIES_SITE='" . $this->_site . "'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}
	}
?>
