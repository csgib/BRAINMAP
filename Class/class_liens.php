<?php
	require_once "class_db.php";

	class Lien
	{	
		// *** HANDLE CONNECTION BDD ***
		private $connexion;

		// *** PROPRIETES CLASSE ***
		public $_id;
		public $_site;
		public $_src_id;
		public $_src_port;
		public $_dst_id;
		public $_dst_port;
		public $_type;
		public $_inner;

		// *** METHODES ET CONSTRUCTEUR ***
		public function __construct()
		{
			$hdl_db = new db();
			$this->connexion = $hdl_db->connexion;
		}

		public function insert_lien()
		{
			$result = $this->connexion->exec("INSERT INTO LIENS (LIENS_SITE, LIENS_SRC_ID, LIENS_SRC_PORT, LIENS_DST_ID, LIENS_DST_PORT, LIENS_TYPE, LIENS_INNER) 
				VALUES('" . addslashes($this->_site) . "' , '"
					 . $this->_src_id . "' , '"
					 . $this->_src_port . "' , '"
					 . $this->_dst_id . "' , '"
					 . $this->_dst_port . "' , '"
					 . $this->_type . "' , '"
					 . $this->_inner . "')");
			return $this->connexion->lastInsertId();
		}

		public function get_all_liens()
		{		
			$record=$this->connexion->query("SELECT * FROM LIENS WHERE 
				LIENS_SITE='" . $this->_site . "' ORDER BY LIENS_INNER DESC");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}

		public function get_liens_from_object()
		{
			$record=$this->connexion->query("SELECT * FROM LIENS WHERE LIENS_SITE='" . $this->_site . "' AND ((LIENS_SRC_ID='" . $this->_src_id . "' AND LIENS_SRC_PORT='" . $this->_src_port . "' AND LIENS_TYPE='" . $this->_type . "') OR (LIENS_DST_ID ='" . $this->_src_id . "' AND LIENS_DST_PORT='" . $this->_src_port . "' AND LIENS_TYPE='" . $this->_type . "'))");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}
	
		public function get_is_lien()
		{
			$record=$this->connexion->query("SELECT COUNT(LIENS_ID) FROM LIENS WHERE LIENS_SITE='" . $this->_site . "' AND ((LIENS_SRC_ID='" . $this->_src_id . "' AND LIENS_SRC_PORT='" . $this->_src_port . "' AND LIENS_TYPE='" . $this->_type . "') OR (LIENS_DST_ID ='" . $this->_src_id . "' AND LIENS_DST_PORT='" . $this->_src_port . "' AND LIENS_TYPE='" . $this->_type . "'))");

			if ( $record->fetchColumn() > 0 )
			{
				return "1";
			}
			else
			{
				return "0";
			}
		}

		public function get_liens_for_trans()
		{
			$record=$this->connexion->query("SELECT * FROM LIENS WHERE LIENS_SITE='" . $this->_site . "' AND (LIENS_SRC_ID='" . $this->_src_id . "' AND LIENS_DST_ID LIKE 'T%')");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}
		
		public function get_liens_dst_for_trans()
		{
			$record=$this->connexion->query("SELECT * FROM LIENS WHERE LIENS_SITE='" . $this->_site . "' AND (LIENS_DST_ID='" . $this->_src_id . "' AND LIENS_SRC_ID LIKE 'T%')");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}		
		
		public function delete_liens()
		{
			$result = $this->connexion->exec("DELETE FROM LIENS WHERE LIENS_SITE='" . $this->_site . "' AND (LIENS_SRC_ID='" . $this->_id . "' OR LIENS_DST_ID='" . $this->_id . "')" );
			return $result;
		}
		
		public function delete_liens_from_trans()
		{
			$result = $this->connexion->exec("DELETE FROM LIENS WHERE LIENS_SITE='" . $this->_site . "' AND LIENS_SRC_ID='" . $this->_src_id . "'" );
			return $result;
		}		

		public function delete_liens_with_ports()
		{
			$result = $this->connexion->exec("DELETE FROM LIENS WHERE LIENS_SITE='" . $this->_site . "' AND (LIENS_SRC_ID='" . $this->_src_id . "' AND LIENS_SRC_PORT='" . $this->_src_port . "' AND LIENS_DST_ID='" . $this->_dst_id . "' AND LIENS_DST_PORT='" . $this->_dst_port . "' AND LIENS_TYPE='" . $this->_type . "') OR (LIENS_SRC_ID='" . $this->_dst_id . "' AND LIENS_SRC_PORT='" . $this->_dst_port . "' AND LIENS_DST_ID='" . $this->_src_id . "' AND LIENS_DST_PORT='" . $this->_src_port . "' AND LIENS_TYPE='" . $this->_type . "')" );
			return $result;
		}

		public function delete_liens_for_site()
		{
			$result = $this->connexion->exec("DELETE FROM LIENS WHERE LIENS_SITE='" . $this->_site . "'" );
			return $result;
		}
		
		public function update_switch_ip_src()
		{
			$result = $this->connexion->exec("UPDATE LIENS SET 
					LIENS_SRC_ID='" . $this->_dst_id . "'
					where LIENS_SITE='" . addslashes($this->_site) . "' AND LIENS_SRC_ID = '" . $this->_src_id . "'" );

			return $result;
		}
		
		public function update_switch_ip_dst()
		{
			$result = $this->connexion->exec("UPDATE LIENS SET 
					LIENS_DST_ID='" . $this->_dst_id . "'
					where LIENS_SITE='" . addslashes($this->_site) . "' AND LIENS_DST_ID = '" . $this->_src_id . "'" );

			return $result;
		}
	}
?>
