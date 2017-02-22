<?php
session_start();
include 'include/header.php';
require_once 'include/db.php';


$LastPost = $pdo->query("
SELECT i.id, i.title, i.description, i.item_delete, c.title AS category, i.picture AS picture, q.title AS quality, u.user_name AS owner
FROM items i
LEFT JOIN categories c ON i.category_id = c.id
LEFT JOIN qualities q ON i.quality_id = q.id
LEFT JOIN users u ON i.user_id = u.id
WHERE i.user_lock_id IS NULL
AND i.item_delete = 0
ORDER BY i.id DESC LIMIT 0,10");

if (!empty($_POST) && isset($_SESSION['auth'])) {
	$annonce_id = $_POST['post_id'];
	$CheckLock = $pdo->query("SELECT i.user_lock_id FROM items i LEFT JOIN users u ON i.user_id = u.id WHERE i.id = $annonce_id");
	if ($CheckLock == NULL || !empty($CheckLock)) {
		$_SESSION['annonce'] = $_POST['post_id'];
		$_SESSION['flash']['success'] = "Vous avez été redirigé sur l'annonce. Vous pouvez la vérouiller pour afficher l'adresse.";
		header("Location: view_annonce.php");
		exit();
	}else{
		$_SESSION['flash']['danger'] = "Cette annonce a été vérrouillée par quelqu'un avant vous. Nous sommes désolé.";
		header("Location: index.php");
	}

}

?>

<main class="row">
	<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 annonce_index">
		<?php include 'include/annonce.php'; ?>
	</article>
</main>

<?php include 'include/footer.php'; ?>