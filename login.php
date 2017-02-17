<?php
session_start();
if(!empty($_SESSION['auth'])){
        $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'accéder à cette page";
        header('Location: account.php');
        exit();
    }
if (!empty($_POST) && !empty($_POST["user_name"]) && !empty($_POST["password"])) {
	require_once 'include/db.php';
	$req = $pdo->prepare("SELECT * FROM users WHERE (user_name = :user_name OR email_user = :user_name) AND confirmed_at IS NOT NULL");
	$req->execute(["user_name" => $_POST["user_name"]]);
	$user = $req->fetch();
	if(password_verify($_POST["password"], $user->password)){
		session_start();
		$_SESSION["auth"] = $user;
		$_SESSION["flash"]["success"] = "Vous êtes maintenant connecté !";
		header("Location: account.php");
		exit();
	}else {
		$_SESSION["flash"]["danger"] = "Identifiant ou mot de passe incorrect";
	}
}

include 'include/header.php';

?>

<article class="formulaire" style="padding-top: 80px;">

	<form action="" method="POST" accept-charset="utf-8">
		<div class="form-group">
			<label for="">Pseudonyme ou email : </label>
			<input type="text" name="user_name" value="" class="form-control" required/>
		</div>
		
		<div class="form-group">
			<label for="">Mot de passe : </label>
			<input type="password" name="password" value="" class="form-control"  required/>
		</div>
		
		<button type="submit" class="btn btn-primary">Se connecter</button>
	</form>
</article>
<article class="creation_compte">
	<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		Pas encore de compte ? <a href="register.php" title="S'enregistrer">Créer un compte.</a>
	</section>
</article>

<?php include 'include/footer.php'; ?>