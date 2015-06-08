<?php
if( ! isset($_GET['SITE_ID']) )
{
    exit;
}
$SITE_ID = $_GET['SITE_ID'];
$MAX_SIZE = 20000000;

include "Class/class_sites.php";
$hdl_site = new Site();
$hdl_site->_id = $SITE_ID;
$result_site = json_decode($hdl_site->get_site_from_id());

$mime_types = array(
    'txt' => 'text/plain',
    'htm' => 'text/html',
    'html' => 'text/html',
    'php' => 'text/html',
    'css' => 'text/css',
    'js' => 'application/javascript',
    'json' => 'application/json',
    'xml' => 'application/xml',
    'swf' => 'application/x-shockwave-flash',
    'flv' => 'video/x-flv',

    // images
    'png' => 'image/png',
    'jpe' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'jpg' => 'image/jpeg',
    'gif' => 'image/gif',
    'bmp' => 'image/bmp',
    'ico' => 'image/vnd.microsoft.icon',
    'tiff' => 'image/tiff',
    'tif' => 'image/tiff',
    'svg' => 'image/svg+xml',
    'svgz' => 'image/svg+xml',

    // archives
    'zip' => 'application/zip',
    'rar' => 'application/x-rar-compressed',
    'exe' => 'application/x-msdownload',
    'msi' => 'application/x-msdownload',
    'cab' => 'application/vnd.ms-cab-compressed',
    // audio/video
    'mp3' => 'audio/mpeg',
    'qt' => 'video/quicktime',
    'mov' => 'video/quicktime',
    '3g2' => 'video/3gpp2',
    '3gp' => 'video/3gpp',
    'mpeg' => 'video/mpeg',
    'ogv' => 'application/ogg',
    'ogg' => 'application/ogg',
    'mpv2' => 'video/mpeg',
    'mpg' => 'video/mpeg',
    'mpe' => 'video/mpeg',
    'mp4' => 'video/mp4',
    'wav' => 'audio/wav',
    'mp3' => 'audio/mpeg3',
    'aiff' => 'audio/aiff',
    'aif' => 'audio/aiff',
    'avi' => 'video/x-msvideo',
    'wmv' => 'video/x-ms-wmv',
    'mov' => 'video/quicktime',


    // adobe
    'pdf' => 'application/pdf',
    'psd' => 'image/vnd.adobe.photoshop',
    'ai' => 'application/postscript',
    'eps' => 'application/postscript',
    'ps' => 'application/postscript',

    // ms office
    'doc' => 'application/msword',
    'rtf' => 'application/rtf',
    'xls' => 'application/vnd.ms-excel',
    'ppt' => 'application/vnd.ms-powerpoint',

    // open office
    'odt' => 'application/vnd.oasis.opendocument.text',
    'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
);

$type_file = array(
    'txt' => 'document',
    'htm' => 'document',
    'html' => 'document',
    'php' => 'document',
    'css' => 'document',
    'js' => 'document',
    'json' => 'document',
    'xml' => 'document',


    // images
    'png' => 'image',
    'jpe' => 'image',
    'jpeg' => 'image',
    'jpg' => 'image',
    'gif' => 'image',
    'bmp' => 'image',
    'ico' => 'image',
    'tiff' => 'image',
    'tif' => 'image',
    'svg' => 'image',
    'svgz' => 'image',

    // archives
    'zip' => 'archive',
    'rar' => 'archive',
    'exe' => 'archive',
    'msi' => 'archive',
    'cab' => 'archive',
    // audio/video
    'mp3' => 'audio',
    'aiff' => 'audio',
    'aif' => 'audio',
    'wav' => 'audio',
    'mp3' => 'audio',
    'qt' => 'video',
    'mov' => 'video',
    '3g2' => 'video',
    '3gp' => 'video',
    'mpeg' => 'video',
    'mpg' => 'video',
    'mpe' => 'video',
    'mpv2' => 'video',
    'avi' => 'video',
    'wmv' => 'video',
    'mov' => 'video',
    'ogv' => 'video',
    'ogg' => 'video',
    'swf' => 'video',
    'flv' => 'video',
    // adobe
    'pdf' => 'pdf',
    'psd' => 'image',
    'ai' => 'image',
    'eps' => 'image',
    'ps' => 'image',

    // ms office
    'doc' => 'document',
    'rtf' => 'document',
    'xls' => 'tableur',
    'ppt' => 'presentation',
    'docx' => 'document',
    'xlsx' => 'tableur',
    'pptx' => 'presentation',

    // open office
    'odt' => 'document',
    'ods' => 'tableur',
    'odp' => 'presentation'
);

if ( !isset($_FILES["SITE_DOCUMENTS"]["type"]) )
{
    echo "ERRORFichier non valide ! ";
    return false;
}

$error_upload = 0;
$temp = explode(".", $_FILES["SITE_DOCUMENTS"]["name"]);
$extension = end($temp);
$_FILES["SITE_DOCUMENTS"]["type"] = strtolower($_FILES["SITE_DOCUMENTS"]["type"]);
$extension = strtolower($extension);
if(
    in_array($_FILES["SITE_DOCUMENTS"]["type"],$mime_types)
    && array_key_exists($extension, $mime_types)
    && $_FILES["SITE_DOCUMENTS"]["size"] < $MAX_SIZE
 )
{
    if ($_FILES["SITE_DOCUMENTS"]["error"] > 0 )
    {
        echo "Erreur : " . $_FILES["SITE_DOCUMENTS"]["error"] . "<br>";
    }
    else
    {
        $repository = "./Files/" .$SITE_ID;

        if (!file_exists($repository))
        {
            mkdir($repository,0777,true);
        }

        if (file_exists($repository.'/'. $_FILES["SITE_DOCUMENTS"]["name"]))
        {
            echo "ERRORLe fichier : " .$_FILES["SITE_DOCUMENTS"]["name"] . " existe déjà";
            $error_upload = 1;
        }
        else
        {
            move_uploaded_file($_FILES["SITE_DOCUMENTS"]["tmp_name"],
                "./Files/" .$SITE_ID.'/'. $_FILES["SITE_DOCUMENTS"]["name"]);
            echo "Le fichier : " .$_FILES["SITE_DOCUMENTS"]["name"] . " est bien enregistré";
        }
    }
}
else
{
    $error_upload = 1;
    echo "Fichier non valide ! ";
}

if ( $error_upload == 1 )
{
    return false;
}

if( !empty($result_site[0]->SITES_DOCUMENTS) )
{
    $last_documents = unserialize($result_site[0]->SITES_DOCUMENTS);
    $i = count($last_documents);
}
else
{
    $last_documents = array();
    $i = 0;
}
if( array_key_exists($extension,$type_file) )
{
    $type_of_file = $type_file[$extension];
}
else
{
    $type_of_file = 'unknown';
}
$last_documents[$i]['type'] = $type_of_file;
$last_documents[$i]['size'] = $_FILES["SITE_DOCUMENTS"]["size"] /(1024*8);
$last_documents[$i]['name'] = $_FILES["SITE_DOCUMENTS"]["name"];
$hdl_site->_documents = serialize($last_documents);

$hdl_site->update_site_documents();
