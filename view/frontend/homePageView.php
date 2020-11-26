<?php $pageTitle = 'Billet simple pour l\'Alaska'; ?>

<?php ob_start(); ?>

<main class='home'>

    <?php require('navigation.php'); ?>

    <div class='page-wrap'>

        <?php require('title.php'); ?>

        <div class='page'>
            <section>
                <div>
                    <h2 class='introOutline'>Bienvenue sur le livre-blog de Jean Forteroche<br>Découvrez chaque semaine un nouvel épisode inédit</h2>
                    <h2 class='introFront'>Bienvenue sur le livre-blog de Jean Forteroche<br>Découvrez chaque semaine un nouvel épisode inédit</h2>
                    <h2 class='back'>Bienvenue sur le livre-blog de Jean Forteroche<br>Découvrez chaque semaine un nouvel épisode inédit</h2>
                <div>
                <div class='buttonContainer'>
                    <a href="index.php?page=readFirst" class='ctaButton'>Commencer l'aventure</a>
                    <a href="index.php?page=readLast" class='ctaButton'>Dernier épisode</a>
                </div>
            </section> 
            
        </div>

    </div>
</main>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>