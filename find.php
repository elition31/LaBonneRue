<?php
session_start();
require 'include/functions.php';
require 'include/db.php';

	if (!empty($_POST)) {
		$errors = array();

		if(!preg_match('/^($|[a-zA-Z0-9_ ]+$)/', $_POST['item_title_search'])){
			$errors['item_title_search'] = "Vous n'avez pas entrer un titre ou une description valide (Uniquement des lettres, des chiffres et l'underscore).";
		}
		if(!preg_match('/^($|[a-zA-Z0-9_ ]+$)/', $_POST['item_description_search'])){
			$errors['item_description_search'] = "Vous n'avez pas entrer un titre ou une description valide (Uniquement des lettres, des chiffres et l'underscore).";
		}
		if(empty($_POST['category']) || !preg_match('/^[0-9]+$/', $_POST['category'])){
			$errors['category'] = "Vous n'avez pas sélectionné de catégorie";
		}
		if(empty($_POST['quality']) || !preg_match('/^[0-9]+$/', $_POST['quality'])){
			$errors['quality'] = "Vous n'avez pas sélectionné de quality";
		}
		if(empty($errors)){

			if(empty($_POST['item_title_search'])){$keywords = 0;}else {$keywords = 1;}

			$title = $_POST['item_title_search'];
			$description = $_POST['item_description_search'];
			$category = (int)$_POST['category'];
			$quality = (int)$_POST['quality'];

				$Search = $pdo->query("
				SELECT i.title, i.description, c.title AS category, i.picture AS picture, q.title AS quality, u.user_name AS owner
				FROM items i
				LEFT JOIN categories c ON i.category_id = c.id
				LEFT JOIN qualities q ON i.quality_id = q.id
				LEFT JOIN users u ON i.user_id = u.id
				WHERE i.category_id = $category
				AND i.quality_id = $quality
				ORDER BY i.id");
				if ($Search->rowCount() > 0) {
					$_SESSION["flash"]["success"] = "Votre recherche a donné un ou plusieurs résultat !";
				}else{
					$_SESSION["flash"]["danger"] = "Votre recherche n'a donné aucun résultat";
				}

		}
	}
?>
<?php require 'include/header.php'; ?>



<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 recherche" style="padding-top: 80px;">
	<form action="" method="POST" accept-charset="utf-8">
		<label for="title_search">Rechercher dans le titre : </label>
		<input type="text" name="item_title_search" id="search">

		<label for="description_search">Rechercher dans la description : </label>
		<input type="text" name="item_description_search" id="search">

		<label for="categorie">Catégorie : </label>
			<select class="" name="category" id="categorie">
				<option value="1">Electroménager</option>
				<option value="2">Vêtements/Textile</option>
				<option value="3">Meubles</option>
				<option value="4">Hight Tech</option>
				<option value="5">Matériaux</option>
				<option value="6">Jouets</option>
				<option value="7">Décoration</option>
				<option value="8">Divers</option>
				<option value="9">Litterie</option>
				<option value="10">Pièces Automobiles</option>
				<option value="11">Equipement Sportif</option>
				<option value="12">Autre</option>
			</select>

			<label for="qualite">Qualité : </label>
			<select class="" name="quality" id="qualite">
				<option value="1">Très Abimé</option>
				<option value="2">Abimé</option>
				<option value="3">Bon Etat</option>
				<option value="4">Très Bon Etat</option>
				<option value="5">Neuf</option>
			</select>
		<button type="submit">Trouver !</button>
	</form>

</article>

<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 resultat_recherche">
	<section class="col-xs-12 col-sm-12 col-md-4 col-lg-4 carte">

	</section>
	<section class="col-xs-12 col-sm-12 col-md-8 col-lg-8 resultat">
	<?php if(isset($Search)) { ?>
		<?php while ($data = $Search->fetch()) { ?>
			<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 image">
					<img src="<?= $data->picture; ?>" alt="Photo de l'objet" class="img-responsive">
				</div>
				<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 infos">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 titre_annonce">
						<span class="titre"><?= $data->title; ?></span> publié par <span class="auteur"><?= $data->owner; ?></span>
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
			$Search->closeCursor(); // Termine le traitement de la requête
			?>
		<?php } ?>
	</section>
</article>





<?php include 'include/footer.php'; ?>