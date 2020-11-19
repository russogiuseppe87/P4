<?php $pageTitle = 'Nouveau billet' ?>

<?php ob_start(); ?>

<main>

    <?php require('navigation.php'); ?>

    <div class='page-wrap'>

        <?php require('title.php'); ?>

        <div class='page'>

            <h2>Nouveau billet :</h2>
             
            <form action="index.php?page=createPost" method="post">
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
                    <label for="title">Titre</label><br />
                    <input type="text" id="title" name="title" />
                </div>
                <div class='formSection'>
                    <label for="content">Billet</label><br />
                    <textarea id="content" name="content" class='tinymce' ></textarea>
                </div>
                <div class='formSection'>
                    <input type="submit" class='basicButton' value='Enregister'/>
                    <a href='index.php?page=readPostsList' >Annuler</a>
                </div>
            </form>
        </div>
    </div>
</main>
    
<script type="text/javascript" src="public/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="public/js/tinymce/init-tinymce.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>


