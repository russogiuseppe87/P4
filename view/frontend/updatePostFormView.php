<?php $pageTitle = 'Modifier le billet' ?>

<?php ob_start(); ?>

<main>

    <?php require('navigation.php'); ?>

    <div class='page-wrap'>

        <?php require('title.php'); ?>

        <div class='page'>
			<header>
				<h2>Modifier le billet :</h2>
				<p class='author-date'><?= htmlspecialchars($post->author()) ?> le <?= $post->creation_date_fr() ?></p>
			</header>
			<form action="index.php?page=updatePost&amp;post_id=<?= $post->id() ?>" method="post">
				<div class='formSection'>
					<label for="title">Titre</label><br />
		            <input type="text" id="title" name="title" value='<?= $post->title() ?>' />
		        </div>
			    <div class='formSection'>
			    	<label for="content">Contenu</label><br />
			        <textarea id="content" name="content" class='tinymce' ><?= $post->content() ?></textarea>
			    </div>
			    <div class='formSection'>
			        <input type="submit" class='basicButton'value='Enregistrer'/> 
			        <a href="index.php?page=readPost&amp;post_id=<?= $post->id() ?>" > Annuler</a>
			    </div>
			</form>
		</div>
    </div>
</main>

<script type="text/javascript" src="public/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="public/js/tinymce/init-tinymce.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>


