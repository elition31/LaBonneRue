<?php session_start();
require 'include/functions.php';
require 'include/db.php';
// FONCTION === Si un non utilisateur tente d'accéder à la page account.php, il est redirigé vers login.php
logged_only();
	$infos = $_SESSION['auth'];
	if ($infos->premium == 0) {
		$premium = "non";
	}else {
		$premium = "oui";
	}
// REQUETE === Récupère les annonces postées de utilisateur
	$Owner_Post = $pdo->query("
	SELECT i.id, i.title, i.description, i.item_delete, c.title AS category, i.picture AS picture, q.title AS quality
	FROM items i
	LEFT JOIN categories c ON i.category_id = c.id
	LEFT JOIN qualities q ON i.quality_id = q.id
	LEFT JOIN users u ON i.user_id = u.id
	WHERE i.user_id = $infos->id
	AND i.user_lock_id IS NULL
	ORDER BY i.id DESC");

// REQUETE === Récupère les annonces lockées par l'utilisateur
	$Lock_Post = $pdo->query("
	SELECT i.title, i.description, i.metro, i.bus, i.tram, i.address, c.title AS category, i.picture AS picture, q.title AS quality
	FROM items i
	LEFT JOIN categories c ON i.category_id = c.id
	LEFT JOIN qualities q ON i.quality_id = q.id
	LEFT JOIN users u ON i.user_id = u.id
	WHERE i.user_lock_id = $infos->id
	ORDER BY i.id DESC");

	if (isset($_POST['show'])) { // Au clique du bouton "voir l'annonce"
		if (!empty($_POST) && isset($_SESSION['auth'])) {
			$annonce_id = $_POST['post_id']; // On stocke la valeur de l'input dans une variable
			// REQUETE === Vérifie avant la redirection vers l'annonce si celle-ci a été vérouillée
			$CheckLock = $pdo->query("SELECT i.user_lock_id FROM items i LEFT JOIN users u ON i.user_id = u.id WHERE i.id = $annonce_id");
			$data_id = $CheckLock->fetch();
			// CONDITION === Si la requête renvoit NULL, ou rien, ou un id égal à celui du user alors on redirige vers l'annonce, sinon on redirige vers index.php
			if ($CheckLock == NULL || !empty($CheckLock) || $data_id == $infos->id) {
				$_SESSION['annonce'] = $_POST['post_id'];
				$_SESSION['flash']['success'] = "Vous avez été redirigé sur l'annonce. Vous pouvez la vérouiller pour afficher l'adresse.";
				header("Location: view_annonce.php");
				exit();
			}else{
				$_SESSION['flash']['danger'] = "Cette annonce a été vérrouillée par quelqu'un avant vous. Nous sommes désolé.";
				header("Location: index.php");
			}
		}
	}elseif (isset($_POST['delete'])) { // Au clique du bouton "supprimer l'annonce"
		$annonce_id = $_POST['post_id'];
		$DeleteAnnonce = $pdo->query("UPDATE items SET item_delete = 1 WHERE id = $annonce_id");
		$CheckAnnonce = $pdo->query("SELECT item_delete FROM items WHERE id = $annonce_id");
		$data = $CheckAnnonce->fetch();
		if ($data->item_delete == 1) {
			$_SESSION['flash']['success'] = "L'annonce n'est plus disponible sur le site";
		}else {
			$_SESSION['flash']['danger'] = "L'annonce n'a pas pu être supprimée. Contactez l'administrateur du site.";
		}
	}


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
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 details">
					<span class="type">Annonce Disponible :</span> <span class="resultat">
					<?php if ($data->item_delete == 1) {
						echo "non";
						}else {
							echo "oui";
						}
					 ?>

					</span>
				</div>
				<div class="col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-10 col-md-2 col-lg-offset-10 col-lg-2 voir">
					<form action="" method="POST" accept-charset="utf-8">
						<input type="number" name="post_id" value="<?= $data->id; ?>" hidden>
						<button type="submit" name="show">Voir l'annonce</button>
						<button type="submit" name="delete">Supprimer l'annonce</button>
					</form>
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
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 details">
					<span class="type">Adresse :</span> <span class="resultat"><?= $data->address; ?></span>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 details">
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<span class="type">Métro :</span>
						<span class="resultat">
							<?php
								if (empty($data->metro)) {
									echo "Non renseigné";
								}else {
									echo $data->metro;
								}
							?>
						</span>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<span class="type">Bus :</span>
						<span class="resultat">
							<?php
								if (empty($data->bus)) {
									echo "Non renseigné";
								}else {
									echo $data->bus;
								}
							?>
						</span>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<span class="type">Tramway :</span>
						<span class="resultat">
							<?php
								if (empty($data->tram)) {
									echo "Non renseigné";
								}else {
									echo $data->tram;
								}
							?>
						</span>
					</div>
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