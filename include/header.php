<?php if(session_status() == PHP_SESSION_NONE){session_start();}
$infos = $_SESSION['auth'];?>
<!DOCTYPE html>
<html lang="FR-fr">
<head>
	<title>La Bonne Rue</title>
	<meta charset="utf-8">
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Un objet dans la rue ? Prenez le en photo et permettez à quelqu'un de le récupérer">

	<!-- FAVICON -->
	<link rel="shortcut icon" href="assets/img/ico/favicon.ico">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
	<!-- FontAwesome CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

	<!-- Chargement STYLE -->
  	<link rel="stylesheet/less" type="text/css" href="assets/css/global.less">
</head>
<body>
	<nav id="menu">
		<div class="show-menu"><i class="fa fa-bars" aria-hidden="true"></i></div>
		<div id="content-menu">
			<div class="onglet"><a href="index.php" title="Accueil" class="ancre"><i class="fa fa-home" aria-hidden="true"></i> Accueil</a></div>
			<div class="onglet"><a href="find.php" title="Trouver" class="ancre"><i class="fa fa-map-marker" aria-hidden="true"></i> Trouver un objet</a></div>
			<?php if(isset($_SESSION["auth"])): ?>
				<div class="onglet"><a href="add.php" title="Proposer" class="ancre"><i class="fa fa-binoculars" aria-hidden="true"></i> Proposer un objet</a></div>
				<div class="onglet"><a href="account.php" title="Compte" class="ancre"><i class="fa fa-user" aria-hidden="true"></i> <?= $infos->user_name ?></a></div>
				<div class="onglet"><a href="premium.php" title="Premium" class="ancre"><i class="fa fa-arrow-up" aria-hidden="true"></i> Premium</a></div>
				<div class="onglet"><a href="logout.php" title="Deconnexion" class="ancre"><i class="fa fa-sign-out" aria-hidden="true"></i> Se Déconnecter</a></div>
			<?php else: ?>
				<div class="onglet"><a href="login.php" title="Connexion" class="ancre"><i class="fa fa-sign-in" aria-hidden="true"></i> Se Connecter</a></div>
			<?php endif; ?>
		</div>
	</nav>

	<?php if(isset($_SESSION["flash"])): ?>
		<div style="padding-top: 80px;">
			<?php foreach($_SESSION["flash"] as $type => $message): ?>
				<div class="alert alert-<?= $type; ?>">
					<?= $message; ?>
				</div>
			<?php endforeach; ?>
			<?php unset($_SESSION["flash"]); ?>
		</div>
	<?php endif; ?>