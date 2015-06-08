<?php
	require_once "class_db.php";

	class Computer
	{	
		// *** HANDLE CONNECTION BDD ***
		private $connexion;

		// *** PROPRIETES CLASSE ***
		public $_id;
		public $_site;
		public $_hostname;
		public $_ip;
		public $_os;
		public $_release;
		public $_vnc_port;

		// *** METHODES ET CONSTRUCTEUR ***
		public function __construct()
		{
			$hdl_db = new db();
			$this->connexion = $hdl_db->connexion;
		}
		public function insert_computers()
		{
			$result = $this->connexion->exec("INSERT INTO COMPUTERS(COMPUTERS_SITE,COMPUTERS_HOSTNAME,COMPUTERS_IP,COMPUTERS_OS,COMPUTERS_RELEASE,COMPUTERS_VNC_PORT) 
				VALUES('" . addslashes($this->_site) . "' , '"
					 . addslashes($this->_hostname) . "' , '"
					 . addslashes($this->_ip) . "' , '"
					 . addslashes($this->_os) . "' , '"
					 . addslashes($this->_release) . "' , '"
					 . addslashes($this->_vnc_port) . "')");			

			return $this->connexion->lastInsertId();
		}

		public function update_computers()
		{
			$result = $this->connexion->exec("UPDATE COMPUTERS SET 
					COMPUTERS_HOSTNAME='" . addslashes($this->_hostname) . "',
					COMPUTERS_IP='" . addslashes($this->_ip) . "',
					COMPUTERS_OS='" . addslashes($this->_os) . "',
					COMPUTERS_RELEASE='" . addslashes($this->_release) . "',
					COMPUTERS_VNC_PORT='" . addslashes($this->_vnc_port) . "'										
					where COMPUTERS_ID=" . $this->_id );
			return $result;
		}
		
		public function get_computers_from_site()
		{		
			$record=$this->connexion->query("SELECT * FROM COMPUTERS WHERE 
				COMPUTERS_SITE='" . addslashes($this->_site) . "'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}

		public function get_computer_from_id()
		{		
			$record=$this->connexion->query("SELECT * FROM COMPUTERS WHERE 
				COMPUTERS_ID='" . $this->_id . "'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}
	}
?>
