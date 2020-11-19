<?php

use \Blog\Model\Post\PostManager;
use \Blog\Model\Comment\CommentManager;
use \Blog\Model\Comment\Comment;
use \Exception;


    /* PAGE */


function createCommentForm($connectionParameters, $postTitles){

    $postManager = new PostManager();

    $post = $postManager->get($_GET['post_id']);

    require('view/frontend/createCommentFormView.php');
}

function updateCommentForm($connectionParameters, $postTitles){

    $postManager = new PostManager();
    $commentManager = new CommentManager();

    $post = $postManager->get($_GET['post_id']);
    $comment = $commentManager->get($_GET['comment_id']);

    require('view/frontend/updateCommentFormView.php');
}

function readReportedComments($connectionParameters, $postTitles){

    $commentManager = new commentManager();

    $reportedComments = $commentManager->getReportedComments();

    require('view/frontend/readReportedCommentsView.php');
}


    /* ACTION */


function createComment($post_id, $author, $content){

    $commentManager = new CommentManager();

    $comment = new Comment([
      'post_id' => $post_id,
      'author' => $author,
      'content' => $content
    ]);

    $affectedLines = $commentManager->create($comment);

    if ($affectedLines === false) {
        throw new \Exception('Impossible d\'enregistrer le commentaire');
    }
    else {
        header('Location: index.php?page=readPost&post_id=' . $post_id);
    }
}

function readReportedCommentsNumber(){

    $commentManager = new CommentManager();
    $reportedNumber = $commentManager->getReportedCommentsNumber();

    if($reportedNumber === '0'){

        return '0 signalements' ;
    } 
    else if($reportedNumber === '1'){

        return $reportedNumber  . ' signalement' ;
    } 
    else{

        return $reportedNumber  . ' signalements' ;
    }
}

function updateComment($post_id, $content, $comment_id){

    $commentManager = new CommentManager();

    $comment = new Comment([
      'id' => $comment_id,
      'content' => $content
    ]);

    $affectedLines = $commentManager->update($comment);

    if ($affectedLines === false) {
        throw new \Exception('Impossible d\'enregistrer le commentaire');
    }
    else {
        header('Location: index.php?page=readPost&post_id=' . $post_id);
    }
}

function reportComment($post_id, $comment_id){

    $commentManager = new commentManager();

    $affectedLines = $commentManager->report($comment_id);

    if ($affectedLines === false) {
        throw new \Exception('Impossible de signaler le commentaire');
    }
    else {
        header('Location: index.php?page=readPost&post_id='. $post_id);
    }
}

function cancelCommentReport($comment_id){

    $commentManager = new commentManager();

    $affectedLines = $commentManager->cancelCommentReport($comment_id);

    if ($affectedLines === false) {
        throw new \Exception('Impossible d\'annuler le signalement pour ce commentaire');
    }
    else {
        header('Location: index.php?page=readReportedComments');
    }
}

function deleteComment($post_id, $comment_id){

    $commentManager = new commentManager();

    $affectedLines = $commentManager->delete($comment_id);

    if ($affectedLines === false) {
        throw new \Exception('Impossible de supprimer le commentaire');
    }
    else {
        header('Location: index.php?page=readPost&post_id='. $post_id);
    }
}




