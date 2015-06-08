<?php
	require_once "class_db.php";

	class Switche
	{	
		// *** HANDLE CONNECTION BDD ***
		private $connexion;

		// *** PROPRIETES CLASSE ***
		public $_id;
		public $_baie_id;
		public $_site;
		public $_ip;
		public $_pos_x;
		public $_pos_y;
		public $_marque;
		public $_description;
		public $_ports_vlan;
		public $_ports_connect;
		public $_web_interface;
		public $_web_port;
		public $_fiber_ports;
		public $_fiber_connect;
		public $_https;

		// *** METHODES ET CONSTRUCTEUR ***
		public function __construct()
		{
			$hdl_db = new db();
			$this->connexion = $hdl_db->connexion;
		}

		public function get_all_switches_in_baie()
		{		
			$record=$this->connexion->query("SELECT * FROM SWITCHS WHERE SWITCHS_SITE='" . $this->_site . "' AND SWITCHS_BAIE_ID = " . $this->_baie_id . " ORDER BY SWITCHS_POS_Y");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}
		
		public function get_all_mini_switches()
		{		
			$record=$this->connexion->query("SELECT * FROM SWITCHS WHERE SWITCHS_SITE='" . $this->_site . "' AND SWITCHS_BAIE_ID = '0'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}
		
		public function get_mini_switch_from_id()
		{		
			$record=$this->connexion->query("SELECT * FROM SWITCHS WHERE SWITCHS_ID = " . $this->_id . " AND SWITCHS_SITE='" . $this->_site . "'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}
		
		public function get_switch_in_baie_from_id()
		{		
			$record=$this->connexion->query("SELECT * FROM SWITCHS WHERE SWITCHS_ID = " . $this->_id . " AND SWITCHS_SITE='" . $this->_site . "'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}

		public function get_switch_in_baie_from_pos()
		{		
			$record=$this->connexion->query("SELECT * FROM SWITCHS WHERE SWITCHS_BAIE_ID = " . $this->_baie_id . " AND SWITCHS_POS_Y > " . $this->_pos_y);
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}

		public function get_switch_in_baie_from_ip()
		{		
			$record=$this->connexion->query("SELECT * FROM SWITCHS WHERE SWITCHS_IP = '" . $this->_ip . "' AND SWITCHS_SITE = '" . $this->_site . "'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}

		public function insert_switche()
		{
			$result = $this->connexion->exec("INSERT INTO SWITCHS (SWITCHS_BAIE_ID, SWITCHS_SITE, SWITCHS_POS_Y, SWITCHS_IP, SWITCHS_MARQUE, SWITCHS_DESCRIPTION, SWITCHS_PORTS_VLAN, SWITCHS_PORTS_CONNECT, SWITCHS_WEB_INTERFACE, SWITCHS_WEB_PORT, SWITCHS_FIBER_PORTS, SWITCHS_FIBER_CONNECT, SWITCHS_HTTPS) 
				VALUES('" . $this->_baie_id . "' , '"
					 . addslashes($this->_site) . "' , '"
					 . $this->_pos_y . "' , '"
					 . addslashes($this->_ip) . "' , '"
					 . addslashes($this->_marque) . "' , '"
					 . addslashes($this->_description) . "' , '"
					 . $this->_ports_vlan . "' , '"
					 . $this->_ports_connect . "' , '"
					 . $this->_web_interface . "' , '"
					 . addslashes($this->_web_port) . "' , '"
					 . $this->_fiber_ports . "' , '"
					 . $this->_fiber_connect . "' , '"
					 . $this->_https . "')");
			return $this->connexion->lastInsertId();
		}

		public function verify_ip_in_schema()
		{		
			$record=$this->connexion->query("SELECT COUNT(SWITCHS_IP) FROM SWITCHS WHERE SWITCHS_SITE='" . $this->_site . "' AND SWITCHS_IP = '" . $this->_ip ."'");
			return $record->fetchColumn();
		}
	
		public function update_switche()
		{
			$result = $this->connexion->exec("UPDATE SWITCHS SET 
					SWITCHS_MARQUE='" . $this->_marque . "',
					SWITCHS_IP='" . $this->_ip . "',
					SWITCHS_DESCRIPTION='" . $this->_description . "',
					SWITCHS_WEB_INTERFACE='" . $this->_web_interface . "',
					SWITCHS_WEB_PORT='" . $this->_web_port . "',
					SWITCHS_HTTPS='" . $this->_https . "'
					where SWITCHS_ID=" . $this->_id . " AND SWITCHS_SITE='" . addslashes($this->_site) . "'" );

			return $result;
		}
		
		public function update_mini_switche()
		{
			$result = $this->connexion->exec("UPDATE SWITCHS SET 
					SWITCHS_MARQUE='" . $this->_marque . "',
					SWITCHS_DESCRIPTION='" . $this->_description . "'
					where SWITCHS_ID=" . $this->_id . " AND SWITCHS_SITE='" . addslashes($this->_site) . "'" );

			return $result;
		}

		public function update_switche_port()
		{
			$result = $this->connexion->exec("UPDATE SWITCHS SET 
					SWITCHS_PORTS_CONNECT='" . $this->_ports_connect . "',
					SWITCHS_FIBER_CONNECT='" . $this->_fiber_connect . "',
					where SWITCHS_ID=" . $this->_id . " AND SWITCHS_SITE='" . addslashes($this->_site) . "'" );

			return $result;
		}
		
		public function update_switche_connect()
		{
			$result = $this->connexion->exec("UPDATE SWITCHS SET 
					SWITCHS_PORTS_CONNECT='" . $this->_ports_connect . "',
					SWITCHS_FIBER_CONNECT='" . $this->_fiber_connect . "',
					SWITCHS_PORTS_VLAN='" . $this->_ports_vlan . "'
					where SWITCHS_ID=" . $this->_id . " AND SWITCHS_SITE='" . addslashes($this->_site) . "'" );

			return $result;
		}
		
		public function update_mini_switche_position()
		{
			$result = $this->connexion->exec("UPDATE SWITCHS SET 
					SWITCHS_IP='" . $this->_pos_x . ";" . $this->_pos_y . "'
					where SWITCHS_ID=" . $this->_id . " AND SWITCHS_SITE='" . addslashes($this->_site) . "'" );
			return $result;		
		}

		public function delete_switche()
		{
			$result = $this->connexion->exec("DELETE FROM SWITCHS WHERE SWITCHS_ID='" . $this->_id . "' AND SWITCHS_SITE='" . $this->_site . "'" );
			return $result;
		}
		
		public function delete_mini_switche()
		{
			$result = $this->connexion->exec("DELETE FROM SWITCHS WHERE SWITCHS_ID='" . $this->_id . "' AND SWITCHS_SITE='" . $this->_site . "'" );
			return $result;
		}

		public function delete_switches_for_site()
		{
			$result = $this->connexion->exec("DELETE FROM SWITCHS WHERE SWITCHS_SITE='" . $this->_site . "'" );
			return $result;
		}

		public function update_switche_position()
		{
			$result = $this->connexion->exec("UPDATE SWITCHS SET 
					SWITCHS_POS_Y = SWITCHS_POS_Y-1
					where SWITCHS_ID=" . $this->_id );
			return $result;		
		}

		public function update_switche_position_add()
		{
			$result = $this->connexion->exec("UPDATE SWITCHS SET 
					SWITCHS_POS_Y = SWITCHS_POS_Y+1
					where SWITCHS_ID=" . $this->_id );
			return $result;		
		}
	}
?>
