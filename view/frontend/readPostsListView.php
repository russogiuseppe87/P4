<?php $pageTitle = 'Sommaire'; ?>

<?php ob_start(); ?>

<main>

    <?php require('navigation.php'); ?>

    <div class='page-wrap'>

        <?php require('title.php'); ?>

        <div class='page'>
            <header>
                <a href="index.php">ACCUEIL</a>
            </header>
            <h2>Sommaire :</h2>
            <?php 
            if (isset($connectionParameters['connected']) AND $connectionParameters['connected'] === true){ ?>  
                 <div class="post">
                    <div class='buttonContainer'><a href="index.php?page=createPostForm" class='basicButton'>Ajouter un billet</a></div>
                </div>
            <?php    
            }
            ?>
            <?php foreach($posts as $post): ?> 
                <div class="post">     
                    <header>
                        <h3><?= htmlspecialchars($post->title()) ?></h3>
                        <p class='author-date'><?= htmlspecialchars($post->author()) ?> le <?= $post->creation_date_fr() ?></p>
                    </header>
                        
                    <div class='content'><?= $post->extract() ?></div>

                    <footer>
                        <a href="index.php?page=readPost&amp;post_id=<?= $post->id() ?>" >Voir l'épisode complet</a>
                    </footer>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</main>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>



