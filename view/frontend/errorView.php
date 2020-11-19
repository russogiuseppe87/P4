<?php $pageTitle = 'Erreur' ?>

<?php ob_start(); ?>

<main class='error'>
	<div class='page-wrap'>
        <header>
		    <h1 class='outline' ><i class='fa fa-exclamation-triangle'></i></h1>
		    <h1 class='front' ><i class='fa fa-exclamation-triangle'></i></h1>
		    <h1 class='back' ><i class='fa fa-exclamation-triangle'></i></h1>
		</header>
		<p><?= $errorMessage ?></p>
		</br>
		<p><a href='<?= $_SERVER['HTTP_REFERER'] ?>' class='basicButton' >Revenir à la page précédente</a></p>
	</div>
</main>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>