<?php
session_start();
require_once 'include/db.php';
require_once 'include/functions.php';

// CONDITION === Si clique sur S'inscrire Alors on rentre dans la condition
if (!empty($_POST)) {
	// On créé un tableau d'erreurs.
	$errors = array();

	if(empty($_POST['user_name']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['user_name'])){
		$errors['user_name'] = "Vous n'avez pas entrer de pseudo ou celui-ci n'est pas valide (Uniquement des lettres, des chiffres et l'underscore).";
	}
	else{
		$req = $pdo->prepare("SELECT id FROM users WHERE user_name = ?");
		$req->execute([$_POST['user_name']]);
		$user = $req->fetch();
		if($user){
			$errors['user_name'] = "Ce pseudo est déjà utilisé !";
		}
	}
	if(empty($_POST['first_name']) || !preg_match('/^[a-zA-Z]+$/', $_POST['first_name'])){
		$errors['first_name'] = "Vous n'avez pas entrer de prénom valide.";
	}
	if(empty($_POST['last_name']) || !preg_match('/^[a-zA-Z]+$/', $_POST['last_name'])){
		$errors['last_name'] = "Vous n'avez pas entrer de nom valide.";
	}
	if(empty($_POST['email_user']) || !filter_var($_POST['email_user'], FILTER_VALIDATE_EMAIL)){
		$errors['email_user'] = "Vous n'avez pas entrer d'email valide.";
	}else{
		$req = $pdo->prepare("SELECT email_user FROM users WHERE email_user = ?");
		$req->execute([$_POST['email_user']]);
		$user = $req->fetch();
		if($user){
			$errors['email_user'] = "Cet email est déjà utilisé !";
		}
	}
	if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
		$errors['password'] = "Les mots de passes ne sont pas identique.";
	}

	if(empty($errors)){
		$req = $pdo->prepare("INSERT INTO users SET user_name = ?, first_name = ?, last_name = ?, email_user = ?, password = ?, confirmation_token = ?");
		$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
		$token = str_random(60);
		$req->execute([$_POST['user_name'], $_POST['first_name'], $_POST['last_name'], $_POST['email_user'], $password, $token]);

		$user_id = $pdo->lastInsertId();
		mail($_POST['email_user'], "Confirmer votre compte sur La Bonne Rue", "Afin de valider la création de votre compte, merci de cliquer sur ce lien \n\n http://localhost:8081/La_Bonne_Rue/confirm.php?id=$user_id&token=$token");
		$_SESSION["flash"]["success"] = "Votre compte a bien été créé, vous avez reçu par email un lien de confirmation.";
		header("Location: login.php");
		exit();
	}
}
?>

<?php include 'include/header.php'; ?>

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
<article class="formulaire" style="padding-top: 80px;">

	<form action="" method="POST" accept-charset="utf-8">
		<div class="form-group">
			<label for="">Pseudonyme : <span>*</span></label>
			<input type="text" name="user_name" value="" class="form-control" required/>
		</div>
		<div class="form-group">
			<label for="">Prénom : <span>*</span></label>
			<input type="text" name="first_name" value="" class="form-control"  required/>
		</div>
		<div class="form-group">
			<label for="">Nom : <span>*</span></label>
			<input type="text" name="last_name" value="" class="form-control"  required/>
		</div>
		<div class="form-group">
			<label for="">Email : <span>*</span></label>
			<input type="email" name="email_user" value="" class="form-control"  required/>
		</div>
		<div class="form-group">
			<label for="">Mot de passe : <span>*</span></label>
			<input type="password" name="password" value="" class="form-control"  required/>
		</div>
		<div class="form-group">
			<label for="">Confirmez le mot de passe : <span>*</span></label>
			<input type="password" name="password_confirm" value="" class="form-control"  required/>
		</div>
		<button type="submit" class="btn btn-primary">S'inscrire</button>
	</form>
</article>
<article class="creation_compte">
	<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		Déjà un compte ? <a href="login.php" title="S'enregistrer">Se connecter.</a>
	</section>
</article>
<?php include 'include/footer.php'; ?>