<?php
	require_once "class_db.php";

	class Site
	{	
		// *** HANDLE CONNECTION BDD ***
		private $connexion;

		// *** PROPRIETES CLASSE ***
		public $_id;
		public $_description;
		public $_adresse;
		public $_postal;
		public $_ville;
		public $_color_1;
		public $_color_2;
		public $_color_3;
		public $_color_4;
		public $_contacts;
		public $_computers;
		public $_documents;
		public $_lat;
		public $_lng;

		// *** METHODES ET CONSTRUCTEUR ***
		public function __construct()
		{
			$hdl_db = new db();
			$this->connexion = $hdl_db->connexion;
		}

		public function insert_site()
		{
			$result = $this->connexion->exec("INSERT INTO SITES(SITES_ID,SITES_DESCRIPTION,SITES_COLOR_1,SITES_COLOR_2,SITES_COLOR_3,SITES_COLOR_4,SITES_ADRESSE,SITES_POSTAL,SITES_VILLE) 
				VALUES('" . addslashes($this->_id) . "' , '"
					 . addslashes($this->_description) . "' , '"
					 . $this->_color_1 . "' , '"
					 . $this->_color_2 . "' , '"
					 . $this->_color_3 . "' , '"
					 . $this->_color_4 . "' , '"
					 . addslashes($this->_adresse) . "' , '"
					 . addslashes($this->_postal) . "' , '"
					 . addslashes($this->_ville) . "')");

			return $this->connexion->lastInsertId();
		}

		public function get_site_from_id()
		{		
			$record=$this->connexion->query("SELECT * FROM SITES WHERE SITES_ID = '" . $this->_id ."'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}

		public function get_all_sites()
		{		
			$record=$this->connexion->query("SELECT * FROM SITES ORDER BY SITES_ID");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}

		public function get_site_exist()
		{
			$record=$this->connexion->query("SELECT COUNT(SITES_ID) FROM SITES WHERE SITES_ID='" . $this->_id . "'");

			if ( $record->fetchColumn() > 0 )
			{
				return "1";
			}
			else
			{
				return "0";
			}
		}
		
		public function get_filter_sites()
		{		
			$record=$this->connexion->query("SELECT * FROM SITES WHERE SITES_ID like '%" . $this->_id ."%' OR SITES_DESCRIPTION like '%" . $this->_id ."%' OR SITES_VILLE like '%" . $this->_id ."%' ORDER BY SITES_ID");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}

		public function update_site_settings()
		{
			$result = $this->connexion->exec("UPDATE SITES SET 
					SITES_DESCRIPTION='" . addslashes($this->_description) . "',
					SITES_ADRESSE='" . addslashes($this->_adresse) . "',
					SITES_POSTAL='" . addslashes($this->_postal) . "',
					SITES_VILLE='" . addslashes($this->_ville) . "',
					SITES_COLOR_1='" . $this->_color_1 . "',
					SITES_COLOR_2='" . $this->_color_2 . "',
					SITES_COLOR_3='" . $this->_color_3 . "',
					SITES_COLOR_4='" . $this->_color_4 . "',
					SITES_LAT='" . $this->_lat . "',
					SITES_LNG='" . $this->_lng . "'
					where SITES_ID='" . $this->_id . "'" );

			return $result;
		}

		public function delete_site()
		{
			$result = $this->connexion->exec("DELETE FROM SITES WHERE SITES_ID='" . $this->_id . "'" );
			return $result;
		}

		public function update_site_documents()
		{
			$sql = "UPDATE SITES SET
				SITES_DOCUMENTS = :SITES_DOCUMENTS
					WHERE SITES_ID = :SITES_ID";
			$query = $this->connexion->prepare($sql);
			$result = $query->execute(
			    array(
				":SITES_DOCUMENTS" => $this->_documents,
				":SITES_ID" => $this->_id
			    )
			);
	    
			return $result;
		}
	}
?>
