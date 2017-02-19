<?php session_start();
require 'include/functions.php';
require 'include/db.php';
logged_only();
	$infos = $_SESSION['auth'];
	if ($infos->premium == 0) {
		$premium = "non";
	}else {
		$premium = "oui";
	}

	$Owner_Post = $pdo->query("
	SELECT i.title, i.description, c.title AS category, i.picture AS picture, q.title AS quality 
	FROM items i 
	LEFT JOIN categories c ON i.category_id = c.id 
	LEFT JOIN qualities q ON i.quality_id = q.id 
	LEFT JOIN users u ON i.user_id = u.id 
	WHERE i.user_id = $infos->id
	AND i.user_lock_id IS NULL
	ORDER BY i.id DESC");

	$Lock_Post = $pdo->query("
	SELECT i.title, i.description, c.title AS category, i.picture AS picture, q.title AS quality 
	FROM items i 
	LEFT JOIN categories c ON i.category_id = c.id 
	LEFT JOIN qualities q ON i.quality_id = q.id 
	LEFT JOIN users u ON i.user_id = u.id 
	WHERE i.user_lock_id = $infos->id
	ORDER BY i.id DESC");

?>

<?php require 'include/header.php'; ?>

<nav class="menu_compte col-xs-12 col-sm-12 col-md-12 col-lg-12 center" style="padding-top: 80px;">
	<a href="#" title="Informations" onclick="sous_menu(1)"><div class="sous_menu">Mes informations</div></a>
	<a href="#" title="Mes annonces" onclick="sous_menu(2)"><div class="sous_menu">Mes annonces</div></a>
	<a href="#" title="Annonces vérouillées" onclick="sous_menu(3)"><div class="sous_menu">Annonces vérouillées</div></a>
	<a href="#" title="Mes alertes" onclick="sous_menu(4)"><div class="sous_menu">Mes alertes</div></a>
</nav>
<main>
	<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 infos" id="sous_menu-1" style="display: none;">
		<h1>Mes Informations</h1>

		<h2>Information sur votre compte :</h2>

		<div>Pseudo : <span><?= $infos->user_name ?></span></div>
		<div>Prénom : <span><?= $infos->first_name ?></span></div>
		<div>Nom : <span><?= $infos->last_name ?></span></div>
		<div>Adresse Email : <span><?= $infos->email_user ?></span></div>
		<div>Création du compte : <span><?= $infos->confirmed_at ?></span></div>
		<div>Premium : <span><?= $premium ?></span></div>

		<h2>Changer votre mot de passe :</h2>
		<form action="" method="POST" accept-charset="utf-8">
			<div class="form-group">
				<label for="">Nouveau mot de passe : <span>*</span></label>
				<input type="password" name="password" value="" class="form-control"  required/>
			</div>
			<div class="form-group">
				<label for="">Confirmez le mot de passe : <span>*</span></label>
				<input type="password" name="password_confirm" value="" class="form-control"  required/>
			</div>
			<button type="submit" class="btn btn-primary">Envoyer</button>
		</form>
	</article>
	
	<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 annonce_index" id="sous_menu-2" style="display: block;">
		<h1>Mes Annonces</h1>
		<?php while ($data = $Owner_Post->fetch()) 
		{
		?>
		<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 image">
				<img src="<?= $data->picture; ?>" alt="Photo de l'objet" class="img-responsive">
			</div>
			<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 infos">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 titre_annonce">
					<span class="titre"><?= $data->title; ?></span>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 description_annonce">
					<?= $data->description; ?>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 details">
					<span class="type">Catégorie :</span> <span class="resultat"><?= $data->category; ?></span> | <span class="type">Qualité de l'objet :</span> <span class="resultat"><?= $data->quality; ?></span>
				</div>
				<div class="col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-10 col-md-2 col-lg-offset-10 col-lg-2 voir">
					<button type="submit">Voir l'annonce</button>
				</div>
			</div>
		</section>
		<?php }
		$Owner_Post->closeCursor(); // Termine le traitement de la requête
		?>
	</article>
	
	<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 infos" id="sous_menu-3" style="display: none;">
		<h1>Annonces Vérouillées</h1>
		<?php while ($data = $Lock_Post->fetch()) 
		{
		?>
		<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 image">
				<img src="<?= $data->picture; ?>" alt="Photo de l'objet" class="img-responsive">
			</div>
			<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 infos">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 titre_annonce">
					<span class="titre"><?= $data->title; ?></span>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 description_annonce">
					<?= $data->description; ?>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 details">
					<span class="type">Catégorie :</span> <span class="resultat"><?= $data->category; ?></span> | <span class="type">Qualité de l'objet :</span> <span class="resultat"><?= $data->quality; ?></span>
				</div>
				<div class="col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-10 col-md-2 col-lg-offset-10 col-lg-2 voir">
					<button type="submit">Voir l'annonce</button>
				</div>
			</div>
		</section>
		<?php }
		$Lock_Post->closeCursor(); // Termine le traitement de la requête
		?>
	</article>
	
	<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 infos" id="sous_menu-4" style="display: none;">
		<h1>Mes Alertes</h1>
	</article>

</main>
<?php include 'include/footer.php'; ?>