<?php

$user_id = $_GET['id'];
$token = $_GET['token'];
require_once 'include/db.php';
$req = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$req->execute([$user_id]);
$user = $req->fetch();
session_start();

if ($user && $user->confirmation_token == $token) {
	$pdo->prepare("UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ?")->execute([$user_id]);
	$_SESSION['auth'] = $user;
	header("Location: account.php");
	$_SESSION["flash"]["success"] = "Vous venez de valider votre compte !";
}else {
	header("Location: login.php");
	$_SESSION["flash"]["danger"] = "Ce lien n'est plus valide !";
}

?>