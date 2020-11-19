<?php $pageTitle = 'Billet simple pour l\'Alaska'; ?>

<?php ob_start(); ?>

<main class='home'>

    <?php require('navigation.php'); ?>

    <div class='page-wrap'>

        <?php require('title.php'); ?>

        <div class='page'>
            <section>
                <div>
                    <h2 class='introOutline'>Bienvenue sur le livre-blog de Jean Forteroche. Découvrez chaque semaine un nouvel épisode inédit.</h2>
                    <h2 class='introFront'>Bienvenue sur le livre-blog de Jean Forteroche. Découvrez chaque semaine un nouvel épisode inédit.</h2>
                    <h2 class='back'>Bienvenue sur le livre-blog de Jean Forteroche. Découvrez chaque semaine un nouvel épisode inédit.</h2>
                <div>
                <div class='buttonContainer'>
                    <a href="index.php?page=readFirst" class='ctaButton'>Commencer l'aventure</a>
                    <a href="index.php?page=readLast" class='ctaButton'>Dernier épisode</a>
                </div>
            </section> 
            <!-- 
            <div class='divider'></div>
            <section>
                <h2>À propos de l'auteur:</h2>
                <div class='about'>
                    <div class='portrait'><img src='public/img/cooperSquare.jpg' ></div>
                    <div >
                        <p>Né en 1975 dans le Nebraska, Jean Forteroche a commencé à publier en 2005 et s'est rapidement imposé auprès du public comme l'un des meilleurs auteurs de roman contemporain, grâce à son cycle des Aventures des derniers trappeurs.</p>
                        <q>Le noyau central de l'esprit vivant d'un humain, c'est sa passion pour l'aventure. La joie de vivre vient de nos expériences nouvelles et donc il n'y a pas de plus grande joie qu'un horizon éternellement changeant, qu'un soleil chaque jour nouveau et différent.</q>
                        <a href="https://fr.wikipedia.org/wiki/Jon_Krakauer">En savoir plus</a>
                    </div>
                </div>
            </section>
            -->
        </div>

    </div>
</main>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>