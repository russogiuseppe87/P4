<?php $pageTitle = 'Nouveau commentaire' ?>

<?php ob_start(); ?>
<main>

    <?php require('navigation.php'); ?>

    <div class='page-wrap'>

        <?php require('title.php'); ?>

        <div class='page'>
            <div class="post">
                <header>
                    <h2><?= htmlspecialchars($post->title()) ?></h2>
                    <p class='author-date'><?= htmlspecialchars($post->author()) ?> le <?= $post->creation_date_fr() ?></p>
                </header>
                <div class='content'><?= $post->content() ?></div>
            </div>

            <div class='divider'></div>

            <h2>Nouveau Commentaire :</h2>
                 
            <form action="index.php?page=createComment&amp;post_id=<?= $post->id() ?>" method="post">
                <div class='formSection'>
                    <label for="author">Auteur</label><br />
                    <input type="text" id="author" name="author" 
                    <?php 
                    if (isset($connectionParameters['connected']) AND $connectionParameters['connected'] === true){ 
                        echo 'value=\'' . $connectionParameters['username'] . '\''; 
                    } 
                    ?>

                    />
                </div>
                <div class='formSection'>
                    <label for="content">Commentaire</label><br />
                    <textarea id="content" name="content" placeholder='Écrivez ici' ></textarea>
                </div>
                <div class='formSection'>
                    <input type="submit" class='basicButton' value='Enregistrer'/>
                    <a href="index.php?page=readPost&amp;post_id=<?= $post->id() ?>"> Annuler</a>
                </div>
            </form>
        </div>
    </div>
</main>

<script type="text/javascript" src="public/js/scrollToBottom.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>


