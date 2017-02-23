<?php // BOUCLE === On affiche le resultat
while ($data = $LastPost->fetch())
{
?>
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
			<form action="" method="POST" accept-charset="utf-8">
				<input type="number" name="post_id" value="<?= $data->id; ?>" hidden>
				<button type="submit">Voir l'annonce</button>
			</form>
		</div>
	</div>
</section>
<?php }
$LastPost->closeCursor(); // Termine le traitement de la requête
?>