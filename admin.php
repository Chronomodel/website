<?php

// ---------------------------------------------------
//	Authentification
// ---------------------------------------------------
list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = 
  explode(':', base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));

if (!isset($_SERVER['PHP_AUTH_USER']) && !isset($_SERVER['REMOTE_USER'])) {
    header('WWW-Authenticate: Basic realm="Identification"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Oups, il semblerait que vous n\'ayez pas le droit d\'être ici !';
    exit;
} else {
	$username = $_SERVER['PHP_AUTH_USER'] || $_SERVER['REMOTE_USER'];
	$password = $_SERVER['PHP_AUTH_PW'];
	if(!($username == 'admin' && $password == 'rendatemodel')){
		header('WWW-Authenticate: Basic realm="Vos identifiants '.$username.' / '.$password.' sont invalides!"');
		header('HTTP/1.0 401 Unauthorized');
		echo 'Oups, il semblerait que vous n\'ayez pas le droit d\'être ici !';
		echo 'Vos identifiants '.$username.' / '.$password.' sont invalides!';
		exit;
	}
}

// ---------------------------------------------------
//	Connection à la base de données
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
//	Récupération des données
// ---------------------------------------------------
$results = $db->readAll('downloads', [], [['col' => 'created', 'asc' => false]]);

// ---------------------------------------------------
//	Tri par OS et versions
// ---------------------------------------------------
$versions = [];
foreach($results as $result)
{
	if(!array_key_exists($result['version'], $versions))
		$versions[$result['version']] = 0;
	++$versions[$result['version']];

	if(!array_key_exists($result['os'], $versions))
		$versions[$result['os']] = 0;
	++$versions[$result['os']];
}

?>

<!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
<!-- Contenu HTML de la page -->
<!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
<!DOCTYPE html>
<html>
<head>
    
    <title>Chronomodel Admin</title>
    
    <meta charset="UTF-8">  
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="SourceSansPro/stylesheet.css" rel="stylesheet" media="screen">
    <link href="css/style.css" rel="stylesheet" media="screen">

</head>

<body>

    <div id="admin-wrapper">
    	<div class="container">
    		<h1>Téléchargements de Chronomodel</h1>
    		<div class="total">Total : <?php echo count($results); ?></div>
    		<?php foreach($versions as $version => $count): ?>
    			<div class="total-version">Total <?php echo $version; ?> : <?php echo $count; ?></div>
    		<?php endforeach; ?>

    		<table class="table table-bordered table-stripped">
    			<tr>
    				<th>Date</th>
    				<th>OS</th>
    				<th>Version</th>
    				<th>IP</th>
    				<th>Email</th>
    				<th>Nom</th>
    				<th>Organisation</th>
    			</tr>
    			<?php foreach($results as $result): ?>
	    			<tr>
	    				<td><?php echo $result['created']; ?></td>
	    				<td><?php echo $result['os']; ?></td>
	    				<td><?php echo $result['version']; ?></td>
	    				<td><?php echo $result['ip']; ?></td>
	    				<td><?php echo $result['email']; ?></td>
	    				<td><?php echo $result['firstname'].' '.$result['lastname']; ?></td>
	    				<td><?php echo $result['organization']; ?></td>
	    			</tr>
	    		<?php endforeach; ?>
    		</table>
    	</div>
    </div>

    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

</body>
