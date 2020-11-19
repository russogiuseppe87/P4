<?php $pageTitle = 'Commentaires signalés'; ?>

<?php ob_start(); ?>

<main>

    <?php require('navigation.php'); ?>

    <div class='page-wrap'>

        <?php require('title.php'); ?>

        <div class='page'>
			<header>
				<a href='index.php?page=readPostsList'>Retour au sommaire</a>   
			</header>

			<?php 
			if (isset($connectionParameters['connected']) AND $connectionParameters['connected'] === true){ 
        	
    			if(substr($connectionParameters['reportedCommentsNumber'], 0, 1) === '0'){ ?>

                    <h2>Aucun commentaire signalé</h2> 
                <?php 
                } 
                else { ?>

                    <h2>Commentaires signalés :</h2>

                    <?php
		            foreach($reportedComments as $comment): ?> 

						<div class='comment'>
							<p class='author-date' ><?= htmlspecialchars($comment->author()) ?> le <?= $comment->creation_date_fr() ?></p>
							<div class='content' ><p><?= nl2br(htmlspecialchars($comment->content())) ?></p></div>
							<footer class='buttonContainer' >
								<a href="index.php?page=cancelCommentReport&amp;comment_id=<?= $comment->id() ?>" class='basicButton largebasicButton green'>Annuler le signalement</a>
								<a href="index.php?page=updateCommentForm&amp;post_id=<?= $comment->post_id() ?>&amp;comment_id=<?= $comment->id() ?>" title="Modifier" class='basicButton' ><i class="fas fa-pencil-alt"></i></a>
							    <a href="index.php?page=deleteComment&amp;post_id=<?= $comment->post_id() ?>&amp;comment_id=<?= $comment->id() ?>" class='basicButton red' ><i class="fas fa-trash-alt"></i></a>
							</footer>
						</div>

					<?php endforeach;
                }
            }
            ?>
		</div>
    </div>
</main>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>