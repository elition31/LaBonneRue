<?php 
include 'include/header.php';
require_once 'include/db.php';


$LastPost = $pdo->query("
SELECT i.title, i.description, c.title AS category, i.picture AS picture, q.title AS quality, u.user_name AS owner 
FROM items i 
LEFT JOIN categories c ON i.category_id = c.id 
LEFT JOIN qualities q ON i.quality_id = q.id 
LEFT JOIN users u ON i.user_id = u.id 
ORDER BY i.id DESC LIMIT 0,10");

?>

<main class="row">
	<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 annonce_index">
		<?php include 'include/annonce.php'; ?>
	</article>
</main>

<?php include 'include/footer.php'; ?>