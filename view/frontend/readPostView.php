<?php $pageTitle = htmlspecialchars($post->title()); ?>

<?php ob_start(); ?>

<main>

    <?php require('navigation.php'); ?>

    <div class='page-wrap'>

        <?php require('title.php'); ?>

        <div class='page'>
		    <header>
		    	<div>
			    	<?php
			    	if(!$post->first()){ ?>
			    		</br><a href="index.php?page=readPreviousPost&amp;post_id=<?= $post->id() ?>"><i class="fas fa-angle-left"></i> Précédent</a>
			    	<?php 
			    	} else {?>
			    		<p class='disabled'><i class="fas fa-angle-left"></i> Précédent</p>
			    	<?php 
			    	}
			    	?>
		    	</div>
		    	<div><a href="index.php?page=readPostsList">Sommaire</a></div>
		    	<div>
			    	<?php 
			    	if(!$post->last()){ ?>
			    		</br><a href="index.php?page=readNextPost&amp;post_id=<?= $post->id() ?>">Suivant <i class="fas fa-angle-right"></i></a>
			    	<?php 
			    	} else {?>
			    		<p class='disabled'>Suivant <i class="fas fa-angle-right"></i></p>
			    	<?php 
			    	}
			    	?>
		    	</div>
		    </header>

		    <div class="post">
				<header>
				    <h2><?= htmlspecialchars($post->title()) ?></h2>
				    <p class='author-date'><?= htmlspecialchars($post->author()) ?> le <?= $post->creation_date_fr() ?></p>
				    <?php 
			        if (isset($connectionParameters['connected']) AND $connectionParameters['connected'] === true){ ?>
			            <div class='buttonContainer'>
			                <a href="index.php?page=updatePostForm&amp;post_id=<?= $post->id() ?>" title="Modifier" class='basicButton'><i class="fas fa-pencil-alt"></i></a>
			                <a href="index.php?page=deletePost&amp;post_id=<?= $post->id() ?>" title="supprimer" class='basicButton'><i class="fas fa-trash-alt"></i></a>
			            </div>
			        <?php    
			        }
			        ?>
			    </header>
			    <div class='content'><?= $post->content() ?></div>
			</div>

			<div class='divider left'></div>

			<h2>Commentaires :</h2>
			<div class='comment'><a href="index.php?page=createCommentForm&amp;post_id=<?= $post->id() ?> " class='basicButton' >Ajouter un commentaire</a></div>
			<?php 
			if($comments == null){ ?> 
				<div class='comment'><p>Encore aucun commentaire pour ce billet</p></div>
			<?php 
			} 
			else { 

				foreach($comments as $comment): ?> 
					<div class='comment'>
						<p class='author-date'><?= htmlspecialchars($comment->author()) ?> le <?= $comment->creation_date_fr() ?></p>
						<div class='content' ><p><?= nl2br(htmlspecialchars($comment->content())) ?></p></div>
						<footer class='buttonContainer'>		
							<?php 
							// if comment not reported => report option is available
							if($comment->reported() === 0){ 
								/*
								// if admin connected =>  edit/cancel options are available
								if (isset($connectionParameters['admin']) AND $connectionParameters['admin'] === true){ 
								?> 
							    	<a href="index.php?page=updateCommentForm&amp;post_id=<?= $post->id() ?>&amp;comment_id=<?= $comment->id() ?>" title="Modifier" class='basicButton' ><i class="fas fa-pencil-alt"></i></a>
							    	<a href="index.php?page=deleteComment&amp;post_id=<?= $post->id() ?>&amp;comment_id=<?= $comment->id() ?>" title="supprimer" class='basicButton' ><i class="fas fa-trash-alt"></i></a>  
						    	<?php 
								} 
								*/
								?> 
								<a href="index.php?page=reportComment&amp;post_id=<?= $post->id() ?>&amp;comment_id=<?= $comment->id() ?>" >Signaler</a>
							<?php
							} 
							// else if comment reported  
							else if($comment->reported() === 1){
								// and if admin connected => link to reported comments page available
								if (isset($connectionParameters['admin']) AND $connectionParameters['admin'] === true){  ?> 
									<a href='index.php?page=readReportedComments' class='basicButton largebasicButton green' >Modérer</a>
								<?php 
								}
							}
							?> 
						</footer>
					</div>
				<?php endforeach; 

			}
			?>
		</div>
    </div>
</main>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>


