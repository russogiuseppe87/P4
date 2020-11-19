<?php $pageTitle = 'Modifier le commentaire' ?>

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
            
            <header>
                <h2>Modifier le commentaire :</h2>
                <p class='author-date'><?= htmlspecialchars($comment->author()) ?> le <?= $comment->creation_date_fr() ?></p>
            </header>

            <form action="index.php?page=updateComment&amp;post_id=<?= $post->id() ?>&amp;comment_id=<?= $_GET['comment_id'] ?>" method="post">
                <div class='formSection'>
                    <textarea id="content" name="content"><?= nl2br(htmlspecialchars($comment->content())) ?></textarea>
                </div>
                <div class='formSection'>
                    <input type="submit" class='basicButton' value='Enregistrer'/> 
                    <a href='<?= $_SERVER['HTTP_REFERER'] ?>'> Annuler</a>
                </div>
            </form>
        </div>
    </div>
</main>

<script type="text/javascript" src="public/js/scrollToBottom.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>


