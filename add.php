<?php
session_start();
require 'include/functions.php';
require_once 'include/db.php';
logged_only();
$infos = $_SESSION['auth'];

if (!empty($_POST)) {
	$errors = array();

	if(empty($_POST['title']) || !preg_match('/^[a-zA-Z0-9_ ]+$/', $_POST['title'])){
		$errors['title'] = "Vous n'avez pas entrer de titre ou celui-ci n'est pas valide (Uniquement des lettres, des chiffres et l'underscore).";
	}
	if(empty($_POST['description']) || !preg_match('/^[a-zA-Z0-9,.!? ]+$/', $_POST['description'])){
		$errors['description'] = "Vous n'avez pas entrer de description valide.";
	}
	if(empty($_POST['category']) || !preg_match('/^[0-9]+$/', $_POST['category'])){
		$errors['category'] = "Vous n'avez pas sélectionné de catégorie";
	}
	if(empty($_POST['quality']) || !preg_match('/^[0-9]+$/', $_POST['quality'])){
		$errors['quality'] = "Vous n'avez pas sélectionné de quality";
	}
	if(!empty($_POST['metro']) && !preg_match('/^[a-zA-Z0-9]+$/', $_POST['metro'])){
		$errors['metro'] = "Les renseignements donnés dans le champ métro ne sont pas correct (Chiffre et lettre seulement).";
	}
	if(!empty($_POST['bus']) && !preg_match('/^[a-zA-Z0-9]+$/', $_POST['bus'])){
		$errors['bus'] = "Les renseignements donnés dans le champ bus ne sont pas correct (Chiffre et lettre seulement).";
	}
	if(!empty($_POST['tramway']) && !preg_match('/^[a-zA-Z0-9]+$/', $_POST['tramway'])){
		$errors['tramway'] = "Les renseignements donnés dans le champ tramway ne sont pas correct (Chiffre et lettre seulement).";
	}

	$target_dir = "annonce/img/";
	$unique = str_random(30);
	$target_file = $target_dir . basename($_FILES["picture"]["name"]);
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	$file_name = $target_dir . "objet_" . $unique . "." . $imageFileType;
	$uploadOk = 1;
	$file_with = 500;
	$file_height = 500;
	$file_dimensions = array();
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	    $check = getimagesize($_FILES["picture"]["tmp_name"]);
	    if($check !== false) {
	        $uploadOk = 1;
	    } else {
	        $errors['picture'] = "Le fichier envoyé n'est pas une image !";
	        $uploadOk = 0;
	    }
	}
	// Check file size
	if ($_FILES["picture"]["size"] > 5000000) {
	    $errors['picture'] = "La taille de l'image est dépasse les 5 Mo !";
	    $uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	    $errors['picture'] = "Seuls les formats jpg, jpeg, png et gif sont autorisés !";
	    $uploadOk = 0;
	}

	// On vérifie les dimensions de l'image.
	$file_dimensions = getimagesize($target_file);
	if ($file_dimensions[0] > $file_with || $file_dimensions[1] > $file_height) {
		$errors['picture'] = "Les dimensions de l'image dépassent 500x500";
		$uploadOk = 0;
	}




	if(empty($errors) || $uploadOk == 1){
        $metro = empty($_POST['metro']) ? NULL : $_POST['metro'];

		if(empty($_POST['metro'])){$metro = NULL;}else {$metro = $_POST['metro'];}
		if(empty($_POST['bus'])){$bus = NULL;}else {$bus = $_POST['bus'];}
		if(empty($_POST['tramway'])){$tram = NULL;}else {$tram = $_POST['tramway'];}
		if(empty($_POST['longitude'])){$longitude = NULL;}else {$longitude = $_POST['longitude'];}
		if(empty($_POST['latitude'])){$latitude = NULL;}else {$latitude = $_POST['latitude'];}
		if(empty($_POST['address'])){$address = NULL;}else {$address = $_POST['address'];}

		(move_uploaded_file($_FILES["picture"]["tmp_name"], $file_name));

		$picture = $file_name;
		$date = date('Y-m-d H:i:s');

		$title = $_POST['title'];
		$description = $_POST['description'];
		$category = $_POST['category'];
		$quality = $_POST['quality'];


		$req = $pdo->prepare("INSERT INTO items (title, description, category_id, user_id, picture, metro, bus, tram, quality_id, longitude, latitude, address, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$req->execute(array($title, $description, $category, $infos->id, $picture, $metro, $bus, $tram, $quality, $longitude, $latitude, $address, $date));
		//die();

		mail($infos->email_user, "Votre annonce sur La Bonne Rue", "Vous venez de publier une annonce sur notre site.");

		$_SESSION["flash"]["success"] = "Votre annonce a bien été publiée.";

		header("Location: account.php");

		exit();
	}
}

?>

<?php require 'include/header.php'; ?>

<article class="col-xs-12 col-sm-12 col-md-6 col-lg-6 carte">

</article>

<article class="formulaire col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-top: 80px;">

<?php if(!empty($errors)): ?>
<div class="alert alert-danger" style="padding-top: 80px;">
	<p>Le formulaire présente les erreurs suivantes :</p>
	<ul>
		<?php foreach ($errors as $error): ?>
		<li><?= $error; ?></li>
		<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>

	<form action="" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
		<div class="form-group">
			<label for="">Titre : <span>*</span></label>
			<input type="text" name="title" class="form-control" maxlength="100" />
		</div>
		<div class="form-group">
			<label for="">Description : <span>*</span></label>
			<textarea name="description" class="form-control" maxlength="500" ></textarea>
		</div>

		<div class="form-group">
			<label for="">Photo (taille maximum : xx Mo / png et jpg seulement) : <span>*</span></label>
			<input type="file" name="picture" class="form-control" required/>
		</div>

		<div class="form-group">
			<label for="">Catégorie : <span>*</span></label>
			<select class="form-control" name="category">
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
		</div>
		<div class="form-group">
			<label for="">Qualité : <span>*</span></label>
			<select class="form-control" name="quality">
				<option value="1">Très Abimé</option>
				<option value="2">Abimé</option>
				<option value="3">Bon Etat</option>
				<option value="4">Très Bon Etat</option>
				<option value="5">Neuf</option>
			</select>
		</div>
		<div class="form-group">
			<label for="">Métro : </label>
			<input type="text" name="metro" value="" class="form-control" />
		</div>
		<div class="form-group">
			<label for="">Bus : </label>
			<input type="text" name="bus" value="" class="form-control" />
		</div>
		<div class="form-group">
			<label for="">Tramway : </label>
			<input type="text" name="tramway" value="" class="form-control" />
		</div>

		<div href="#" onclick="getLocation()">Géolocalisation</div>
		<div class="form-group">
			<label for="">Adresse : </label>
			<input type="text" name="address" class="form-control" id="address" />
		</div>
		<div class="form-group">
			<label for="">Latitude : </label>
			<input type="text" name="latitude" class="form-control" id="latitude" />
		</div>
		<div class="form-group">
			<label for="">Longitude : </label>
			<input type="text" name="longitude" class="form-control" id="longitude" />
		</div>

		<button type="submit" class="btn btn-primary">Poster l'annonce</button>
	</form>
</article>
<?php include 'include/footer.php'; ?>