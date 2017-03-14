<?php 
	require_once('lib/rb.php');
	
	setlocale(LC_ALL,"it_IT");
	date_default_timezone_set('Europe/Rome');
	
	R::setup('mysql:host=127.0.0.1;dbname=es2','es2', 'pwd');
	R::freeze(FALSE);
	
	$pg=(empty($_REQUEST['p'])) ? 'home' : $_REQUEST['p'];
	$pg='pgs/'.$pg.'.php';
	
?>
<!doctype html>
<html lang="it">
  <head>
    <title>Ricevute</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"/>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	
  
  </head>
  <body>
	<nav class="navbar" style="background: #A5B7D6;">
		<ul class="nav navbar-nav">
		<li><a href="?p=home" style="color: #082B6E;"> <strong>Home Page</strong> </a> </li>
		<li> <a href="?p=ricevute"  style="color: #082B6E;"><strong> Ricevute </strong> </a></li>
		<li> <a href="?p=clienti" style="color: #082B6E;"> <strong>Clienti </strong></a></li> 
	</ul>
</nav>
	<div id="all" class="all">
		<? if (file_exists($pg)) include_once($pg); ?>
	</div>
  </body>
</html>
