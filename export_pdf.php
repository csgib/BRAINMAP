<?php
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, 'fr_FR.utf8', 'fra');

require "Class/class_sites.php";
require "Class/class_contacts.php";
require "Class/class_computers.php";

$hdl_site = new Site();
$hdl_contact = new Contact();
$hdl_computers = new Computer();

$hdl_site->_id          = $_GET['ID'];
$hdl_contact->_site     = $_GET['ID'];
$hdl_computers->_site    = $_GET['ID'];

$result_site = json_decode( $hdl_site->get_site_from_id() );
$result_contact = json_decode( $hdl_contact->get_contacts_from_site() );
$result_computers = json_decode( $hdl_computers->get_computers_from_site() );

require_once('Plugins/fpdf/fpdf.php');

ob_end_clean(); 
$pdf = new FPDF("P","mm","A4");
$pdf->SetAutoPageBreak(true,10);
$pdf->SetFont('Arial','',8);

$pdf->AddPage();

$mapage = utf8_decode($result_site[0]->SITES_ID) . " " . utf8_decode($result_site[0]->SITES_DESCRIPTION);
$pdf->SetX(10);
$pdf->SetFont('Arial','B',11);
$pdf->SetTextColor(62,148,209);
$pdf->MultiCell(0, 5, $mapage, 0, 'L', false);

$mapage = utf8_decode($result_site[0]->SITES_ADRESSE) . "\n" . utf8_decode($result_site[0]->SITES_POSTAL) . " " . utf8_decode($result_site[0]->SITES_VILLE);
$pdf->SetX(10);
$pdf->SetTextColor(22,22,22);
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(0, 4, $mapage, 0, 'L', false);

$filteredData=substr($_POST['img_val_o'], strpos($_POST['img_val_o'], ",")+1);
$unencodedData=base64_decode($filteredData);
$img_path = "Temp/" . $_GET['ID'] . ".jpg";
file_put_contents($img_path, $unencodedData, LOCK_EX);

$pdf->Image($img_path,10,30,190,132);

if ( count($result_contact) > 0 )
{
    $mapage = "CONTACTS\n";
    $pdf->SetXY(10,166);
    $pdf->SetTextColor(62,148,209);
    $pdf->SetDrawColor(62,148,209);
    $pdf->SetFont('Arial','B',11);
    $pdf->MultiCell(0, 4, $mapage, 'B', 'C', false);
    
    $wl_i = 0;

    $pdf->SetTextColor(22,22,22);
    $pdf->SetDrawColor(200,200,200);
    $pdf->SetFont('Arial','',10);
       
    while ( $wl_i < count($result_contact) )
    {
        $var_y = $pdf->GetY();
        
        $mapage = utf8_decode($result_contact[$wl_i]->CONTACTS_NOM);
        $pdf->SetX(10);
        $pdf->MultiCell(60, 5, $mapage, 'B', 'L', false);

        $mapage = utf8_decode($result_contact[$wl_i]->CONTACTS_TELEPHONE);
        $pdf->SetXY(70,$var_y);
        $pdf->MultiCell(60, 5, $mapage, 'B', 'L', false);
        
        $mapage = utf8_decode($result_contact[$wl_i]->CONTACTS_FONCTION);
        $pdf->SetXY(130,$var_y);
        $pdf->MultiCell(70, 5, $mapage, 'B', 'L', false);        
        
        $wl_i++;
    }
}

if ( count($result_computers) > 0 )
{
    $mapage = "\nORDINATEURS\n";
    $pdf->SetX(10);
    $pdf->SetTextColor(62,148,209);
    $pdf->SetDrawColor(62,148,209);
    $pdf->SetFont('Arial','B',11);
    $pdf->MultiCell(0, 4, $mapage, 'B', 'C', false);
    
    $wl_i = 0;
    
    $pdf->SetTextColor(22,22,22);
    $pdf->SetDrawColor(200,200,200);
    $pdf->SetFont('Arial','',10);
    
    while ( $wl_i < count($result_computers) )
    {
        $wl_str_os = "";
        
        if ( $result_computers[$wl_i]->COMPUTERS_OS == "W" )
        {
            $wl_str_os = "Windows";
        }

        if ( $result_computers[$wl_i]->COMPUTERS_OS == "L" )
        {
            $wl_str_os = "Linux";
        }
        
        if ( $result_computers[$wl_i]->COMPUTERS_OS == "O" )
        {
            $wl_str_os = "OSX";
        }
        
        $var_y = $pdf->GetY();
        
        $mapage = utf8_decode($result_computers[$wl_i]->COMPUTERS_HOSTNAME);
        $pdf->SetX(10);
        $pdf->MultiCell(60, 5, $mapage, 'B', 'L', false);

        $mapage = utf8_decode($result_computers[$wl_i]->COMPUTERS_IP);
        $pdf->SetXY(70,$var_y);
        $pdf->MultiCell(60, 5, $mapage, 'B', 'L', false);
        
        $mapage = utf8_decode($wl_str_os) . " " . utf8_decode($result_computers[$wl_i]->COMPUTERS_RELEASE);
        $pdf->SetXY(130,$var_y);
        $pdf->MultiCell(70, 5, $mapage, 'B', 'L', false);            
               
        $wl_i++;
    }
}

/*$pdf->Image('../Images/logo.jpg',10,10,0);
$mapage = "Questionnaire projet professionnel et voeux de formation pour les contrats aidés\nA remplir avec votre tuteur / directeur d'école / chef d'établissement";
$pdf->SetXY(40,12);
$pdf->SetFont('Arial','B',11);
$pdf->MultiCell(0, 4, $mapage, 0, 'C', false);*/



/* ************************* */
/* *** GENERATION DU PDF *** */
/* ************************* */
$name_pdf = $_GET['ID'] . ".pdf";

$pdf->Output("Temp/" . $name_pdf,'F'); 


?>
