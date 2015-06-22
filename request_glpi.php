<?php

if (!extension_loaded("xmlrpc"))
{
   return "NO";
}

require "Class/class_glpi.php";

$hdl_glpi = new GLPI();
$result_glpi = json_decode($hdl_glpi->get_glpi_params());

if ( empty($result_glpi) )
{
   return "NO";
}

$host = $result_glpi[0]->PARAMS_GLPI_IP;
$glpi_user = $result_glpi[0]->PARAMS_GLPI_USER;
$glpi_pass = $result_glpi[0]->PARAMS_GLPI_PASS;
$url = $result_glpi[0]->PARAMS_GLPI_URL . "xmlrpc.php";

$wl_res = login();

function login() {
   global $glpi_user, $glpi_pass, $ws_user, $ws_pass;
   $args['method']          = "glpi.doLogin";
   $args['login_name']      = $glpi_user;
   $args['login_password']  = $glpi_pass;

   if (isset($ws_user)) {
      $args['username'] = $ws_user;
   }

   if (isset($ws_pass)) {
      $args['password'] = $ws_pass;
   }

   if ($result = call_glpi($args)) {
  
      $args['session']           = $result['session'];
      $args['method']            = $_GET["METHOD"];
      $args['itemtype']          = $_GET["ITEMTYPE"];
      $args['id']                = $_GET["ID"];
      $args['show_name']         = 1;
      $args['show_label']        = 1;
      $args['with_infocom']      = 0;
      $args['with_peripheral']   = 0;
      $args['with_software']     = 0;
      
      $result = call_glpi($args);
      
      $wl_rub_temp = "";
      $wl_rub_val = "";
      $wl_rub_label = "";
      $wl_is_under = false;
      
      $wl_peripherals = "";
      
      echo "<tr><td colspan='2'><h2 class='TITLE_N0 TITLE_BLUE TITLE_CENTER_IT TITLE_BORDER_IT'>DONNEES GLPI</h2></td></tr>";

      foreach ( $result as $lg_result => $lg_result_valeur )
      {
         if ( $lg_result == "Peripheral" )
         {
            $wl_peripherals = $lg_result_valeur;
         }
         else
         {
            if ( $wl_rub_temp == "" || $wl_rub_temp != substr($lg_result,0,strlen($wl_rub_temp)) )
            {
               if ( $wl_rub_temp != "" )
               {
                  if ( $wl_rub_val != "0" )
                  {
                     echo "<tr><td class='rubrique'>" . $wl_rub_label . "</td><td class='fields'>" . $wl_rub_val . "</td></tr>";
                  }
                  $wl_rub_temp = "";
               }
               if ( strrpos($lg_result,"_") == false )
               {
                  $wl_rub_temp = $lg_result;
                  $wl_is_under = false;
               }
               else
               {
                  $wl_rub_temp = substr($lg_result,0,strrpos($lg_result,"_"));
                  $wl_is_under = true;
               }
                           
               $wl_rub_val = $lg_result_valeur;
            }
            
            if ( $wl_rub_temp == substr($lg_result,0,strlen($wl_rub_temp)) )
            {
               if ( substr($lg_result, -6) == "_label" )
               {
                  $wl_rub_label = utf8_encode($lg_result_valeur);
               }
   
               if ( substr($lg_result, -5) == "_name" && $lg_result_valeur != "N/A" )
               {
                  $wl_rub_val = utf8_encode($lg_result_valeur);
               }            
            }
         }
      }
   }
}

function call_glpi($args) {
  global $host,$url,$deflate,$base64;
  
  // To avoid IDE warning
  $http_response_header = "";
  //echo "+ Calling {$args['method']} on http://$host/$url\n";

  if (isset($args['session'])) {
     $url_session = $url.'?session='.$args['session'];
  } else {
     $url_session = $url;
  }

  $header = "Content-Type: text/xml";

  if (isset($deflate)) {
     $header .= "\nAccept-Encoding: deflate";
  }

  if (isset($base64)) {
     $args['base64'] = $base64;
  }

  $request = xmlrpc_encode_request($args['method'], $args);
  $context = stream_context_create(array('http' => array('method'  => "POST",
                                                         'header'  => $header,
                                                         'content' => $request)));

   
  $file = file_get_contents("http://$host/$url_session", false, $context);
  if (!$file) {
     die("+ No response\n");
  }
  if (in_array('Content-Encoding: deflate', $http_response_header)) {
     $lenc = strlen($file);
     echo "+ Compressed response : $lenc\n";
     $file = gzuncompress($file);
     $lend = strlen($file);
     echo "+ Uncompressed response : $lend (".round(100.0*$lenc/$lend)."%)\n";
  }

  $response = xmlrpc_decode($file);
  if (!is_array($response)) {
     echo $file;
     die ("+ Bad response\n");
  }

  if (xmlrpc_is_fault($response)) {
      echo("xmlrpc error(".$response['faultCode']."): ".$response['faultString']."\n");
  } else {
     return $response;
  }
}

?>