<?php

// ---------------------------------------------------
//  Récupération des données du formulaire
// ---------------------------------------------------
$os = isset($_GET["os"]) ? $_GET["os"] : '';
$version = isset($_GET["version"]) ? $_GET["version"] : '';
$email = isset($_GET["email"]) ? $_GET["email"] : '';
$firstname = isset($_GET["firstname"]) ? $_GET["firstname"] : '';
$lastname = isset($_GET["lastname"]) ? $_GET["lastname"] : '';
$organization = isset($_GET["organization"]) ? $_GET["organization"] : '';
$ip = $_SERVER["REMOTE_ADDR"];


// ---------------------------------------------------
//  Connection à la base de données
// ---------------------------------------------------
require_once(__DIR__.'/DbSql.php');
$localhost = array(
    '127.0.0.1',
    '::1'
);
if(in_array($_SERVER['REMOTE_ADDR'], $localhost)){
    $db = DbSql::newWithParams('localhost', 'chronomodel', 'root', 'root');
}else{
    $db = DbSql::newWithParams('chronomodel.mysql.db', 'chronomodel', 'chronomodel', 'Helori35');
}

// ---------------------------------------------------
//  Création de la ligne dans la base de données
// ---------------------------------------------------
$result = $db->create('downloads', array(
    'os' => $os,
    'version' => $version,
    'ip' => $ip,
    'email' => $email,
    'firstname' => $firstname,
    'lastname' => $lastname,
    'organization' => $organization
));


// ---------------------------------------------------
//  Trouver le fichier à télécharger
// ---------------------------------------------------
$filename = 'chronomodel_'.$os.'_'.$version;
if($os == 'mac'){
    if($version == '1.1')
        $filename .= '.pkg';
    else if($version == '1.4')
        $filename .= '.dmg';
}
else if($os == 'win') $filename .= '.exe';
$filepath = __DIR__.'/releases/'.$filename;

if(!is_file($filepath)){
    // ---------------------------------------------------
    //  Le fichier n'existe pas, on redirige vers l'accueil du site (ne doit jamais arriver!)
    // ---------------------------------------------------
    require_once(__DIR__.'/index.php');
}else{
    // ---------------------------------------------------
    //  Lancement du téléchargement
    // ---------------------------------------------------
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: no-cache, must-revalidate, post-check=0, pre-check=0");
    header("Pragma: no-cache");
    header("Cache-Control: public");
    header("Content-Type: application/octet-stream");
    header("Content-Description: File Transfer");
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    //header('Content-Disposition: attachment; filename="test.txt"');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: '.filesize($filepath));

    // Important for large files !!
    if (ob_get_level())
        ob_end_flush();

    $num_octets = readfile($filepath);
    exit();
}