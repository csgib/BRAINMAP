<?php
	require_once "class_db.php";

	class Serveur
	{	
		// *** HANDLE CONNECTION BDD ***
		private $connexion;

		// *** PROPRIETES CLASSE ***
		public $_id;
		public $_site;
		public $_name;
		public $_pos_x;
		public $_pos_y;
		public $_marque;
		public $_modele;
		public $_lan_1_on;
		public $_lan_2_on;
		public $_lan_3_on;
		public $_lan_4_on;
		public $_lan_5_on;
		public $_lan_6_on;
		public $_lan_1_type;
		public $_lan_2_type;
		public $_lan_3_type;
		public $_lan_4_type;
		public $_lan_5_type;
		public $_lan_6_type;
		public $_lan_1_ip;
		public $_lan_2_ip;
		public $_lan_3_ip;
		public $_lan_4_ip;
		public $_lan_5_ip;
		public $_lan_6_ip;
		public $_web_interface;
		public $_web_port;
		public $_https;
		public $_web_card;
		public $_os;
		public $_release;
		public $_ondulee;
		public $_firewall;
		public $_glpi_id;

		// *** METHODES ET CONSTRUCTEUR ***
		public function __construct()
		{
			$hdl_db = new db();
			$this->connexion = $hdl_db->connexion;
		}
		public function insert_serveur()
		{
			$result = $this->connexion->exec("INSERT INTO SERVEURS(SERVEURS_SITE,SERVEURS_NAME,SERVEURS_POS_X,SERVEURS_POS_Y,SERVEURS_MARQUE,SERVEURS_MODELE,SERVEURS_LAN_1_ON,SERVEURS_LAN_1_TYPE,SERVEURS_LAN_1_IP,SERVEURS_LAN_2_ON, SERVEURS_LAN_2_TYPE,SERVEURS_LAN_2_IP,SERVEURS_LAN_3_ON,SERVEURS_LAN_3_TYPE,SERVEURS_LAN_3_IP,SERVEURS_LAN_4_ON,SERVEURS_LAN_4_TYPE,SERVEURS_LAN_4_IP, SERVEURS_LAN_5_ON,SERVEURS_LAN_5_TYPE,SERVEURS_LAN_5_IP,SERVEURS_LAN_6_ON,SERVEURS_LAN_6_TYPE,SERVEURS_LAN_6_IP, SERVEURS_WEB_INTERFACE,SERVEURS_WEB_PORT,SERVEURS_HTTPS,SERVEURS_WEB_CARD,SERVEURS_OS,SERVEURS_RELEASE,SERVEURS_ONDULEE,SERVEURS_FIREWALL,SERVEURS_GLPI_ID) 
				VALUES('" . addslashes($this->_site) . "' , '"
					 . addslashes($this->_name) . "' , '"
					 . $this->_pos_x . "' , '"
					 . $this->_pos_y . "' , '"
					 . addslashes($this->_marque) . "' , '"
					 . addslashes($this->_modele) . "' , '"
					 . $this->_lan_1_on . "' , '"
					 . $this->_lan_1_type . "' , '"
					 . $this->_lan_1_ip . "' , '"
					 . $this->_lan_2_on . "' , '"
					 . $this->_lan_2_type . "' , '"
					 . $this->_lan_2_ip . "' , '"
					 . $this->_lan_3_on . "' , '"
					 . $this->_lan_3_type . "' , '"
					 . $this->_lan_3_ip . "' , '"
					 . $this->_lan_4_on . "' , '"
					 . $this->_lan_4_type . "' , '"
					 . $this->_lan_4_ip . "' , '"
					 . $this->_lan_5_on . "' , '"
					 . $this->_lan_5_type . "' , '"
					 . $this->_lan_5_ip . "' , '"
					 . $this->_lan_6_on . "' , '"
					 . $this->_lan_6_type . "' , '"
					 . $this->_lan_6_ip . "' , '"
					 . $this->_web_interface . "' , '"
					 . $this->_web_port . "' , '"
					 . $this->_https . "' , '"
					 . $this->_web_card . "' , '"
					 . addslashes($this->_os) . "' , '"
					 . addslashes($this->_release) . "' , '"
					 . $this->_ondulee . "' , '"
					 . $this->_firewall . "' , '"
					 . $this->_glpi_id . "')");				

			return $this->connexion->lastInsertId();
		}

		public function get_all_serveurs()
		{		
			$record=$this->connexion->query("SELECT * FROM SERVEURS WHERE 
				SERVEURS_SITE='" . $this->_site . "'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}

		public function get_serveur_from_id()
		{		
			$record=$this->connexion->query("SELECT * FROM SERVEURS WHERE 
				SERVEURS_SITE='" . $this->_site . "' AND SERVEURS_ID=" . $this->_id);
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}

		public function update_serveur_position()
		{
			$result = $this->connexion->exec("UPDATE SERVEURS SET 
					SERVEURS_POS_X='" . $this->_pos_x . "',
					SERVEURS_POS_Y='" . $this->_pos_y . "'
					where SERVEURS_ID=" . $this->_id . " AND SERVEURS_SITE='" . addslashes($this->_site) . "'" );
			return $result;		
		}

		public function update_serveur()
		{
			$result = $this->connexion->exec("UPDATE SERVEURS SET 
					SERVEURS_NAME='" . addslashes($this->_name) . "',
					SERVEURS_MARQUE='" . addslashes($this->_marque) . "',
					SERVEURS_MODELE='" . addslashes($this->_modele) . "',
					SERVEURS_LAN_1_ON='" . $this->_lan_1_on . "',
					SERVEURS_LAN_1_TYPE='" . $this->_lan_1_type . "',
					SERVEURS_LAN_1_IP='" . $this->_lan_1_ip . "',
					SERVEURS_LAN_2_ON='" . $this->_lan_2_on . "',
					SERVEURS_LAN_2_TYPE='" . $this->_lan_2_type . "',
					SERVEURS_LAN_2_IP='" . $this->_lan_2_ip . "',
					SERVEURS_LAN_3_ON='" . $this->_lan_3_on . "',
					SERVEURS_LAN_3_TYPE='" . $this->_lan_3_type . "',
					SERVEURS_LAN_3_IP='" . $this->_lan_3_ip . "',
					SERVEURS_LAN_4_ON='" . $this->_lan_4_on . "',
					SERVEURS_LAN_4_TYPE='" . $this->_lan_4_type . "',
					SERVEURS_LAN_4_IP='" . $this->_lan_4_ip . "',
					SERVEURS_LAN_5_ON='" . $this->_lan_5_on . "',
					SERVEURS_LAN_5_TYPE='" . $this->_lan_5_type . "',
					SERVEURS_LAN_5_IP='" . $this->_lan_5_ip . "',
					SERVEURS_LAN_6_ON='" . $this->_lan_6_on . "',
					SERVEURS_LAN_6_TYPE='" . $this->_lan_6_type . "',
					SERVEURS_LAN_6_IP='" . $this->_lan_6_ip . "',
					SERVEURS_WEB_INTERFACE='" . $this->_web_interface . "',
					SERVEURS_WEB_PORT='" . $this->_web_port . "',
					SERVEURS_HTTPS='" . $this->_https . "',
					SERVEURS_WEB_CARD='" . $this->_web_card . "',
					SERVEURS_OS='" . $this->_os . "',
					SERVEURS_RELEASE='" . addslashes($this->_release) . "',
					SERVEURS_ONDULEE='" . $this->_ondulee . "',
					SERVEURS_FIREWALL='" . $this->_firewall . "',
					SERVEURS_GLPI_ID='" . $this->_glpi_id . "'

					where SERVEURS_ID=" . $this->_id . " AND SERVEURS_SITE='" . addslashes($this->_site) . "'" );
			return $result;		
		}

		public function delete_serveur()
		{
			$result = $this->connexion->exec("DELETE FROM SERVEURS WHERE SERVEURS_ID=" . $this->_id );
			return $result;
		}

		public function delete_serveurs_for_site()
		{
			$result = $this->connexion->exec("DELETE FROM SERVEURS WHERE SERVEURS_SITE='" . $this->_site . "'" );
			return $result;
		}
		
		public function get_maxpos_serveur()
		{		
			$record=$this->connexion->query("SELECT MAX(SERVEURS_POS_X) AS X,MAX(SERVEURS_POS_Y) AS Y FROM SERVEURS WHERE 
				SERVEURS_SITE='" . $this->_site . "'");
			$record->setFetchMode(PDO::FETCH_OBJ);
			
			return json_encode($record->fetchAll());
		}			
	}
?>
