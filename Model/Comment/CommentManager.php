<?php
namespace Blog\Model\Comment; 
use Blog\Model\Manager;
use Blog\Model\Comment\Comment;

class CommentManager extends Manager{

    public function create(Comment $comment){
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO comments(post_id, author, content, creation_date) VALUES(:post_id, :author, :content, NOW())');

        $req->bindValue(':post_id', $comment->post_id(), \PDO::PARAM_INT);
        $req->bindValue(':author', $comment->author(), \PDO::PARAM_STR);
        $req->bindValue(':content', $comment->content(), \PDO::PARAM_STR);

        $affectedLines = $req->execute();
        return $affectedLines;
    }

    public function get($comment_id){

        $comment_id = (int) $comment_id ;

        $db = $this->dbConnect();
        $req = $db->prepare('
            SELECT id, post_id, author, 
                CASE
                WHEN reported = 1 THEN \'Commentaire signalé\' 
                WHEN reported = 0 THEN content 
                END AS content,
            DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh %imin\') AS creation_date_fr, reported
            FROM comments 
            WHERE id = ?
        ');
        $req->execute(array($comment_id));
        $donnees = $req->fetch(\PDO::FETCH_ASSOC);

        return new Comment($donnees);
    }

    public function getList($post_id){
        $comments = [];

        $db = $this->dbConnect();
        $req = $db->prepare('
            SELECT id, author, 
                CASE
                WHEN reported = 1 THEN \'Commentaire signalé en attente de modération\' 
                WHEN reported = 0 THEN content 
                END AS content,
            DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh %imin\') AS creation_date_fr, reported
            FROM comments 
            WHERE post_id = ? 
            ORDER BY creation_date DESC
        ');
        $req->execute(array($post_id));

          while ($donnees = $req->fetch(\PDO::FETCH_ASSOC))
        {
          $comments[] = new Comment($donnees);

        }
        
        return $comments;
    }

    public function getReportedComments(){
        $reportedComments = [];

        $db = $this->dbConnect();
        $req = $db->query('
            SELECT id, post_id, author, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh %imin\') AS creation_date_fr
            FROM comments 
            WHERE reported = 1 
            ORDER BY creation_date DESC
        ');
       
          while ($donnees = $req->fetch(\PDO::FETCH_ASSOC))
        {
          $reportedComments[] = new Comment($donnees);

        }
        
        return $reportedComments;
    }

    public function getReportedCommentsNumber(){
        $db = $this->dbConnect();
        $req = $db->query('
            SELECT COUNT(*) AS reportedNumber
            FROM comments 
            WHERE reported = 1 
        ');
       
        $result = $req->fetch();
        $reportedNumber = $result['reportedNumber'];
        return $reportedNumber;
    }

    public function update(Comment $comment){
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE comments SET content = :content  WHERE id = :id');
        
        $req->bindValue(':content', $comment->content(), \PDO::PARAM_STR);
        $req->bindValue(':id', $comment->id(), \PDO::PARAM_INT);
        $affectedLines = $req->execute();

        return $affectedLines;
    }

    public function delete($comment_id){
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM comments WHERE id = ?');
        $affectedLines = $req->execute(array($comment_id));

        return $affectedLines;
    }

    public function report($comment_id){
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE comments SET reported = 1 WHERE id = ?');
        $affectedLines = $req->execute(array($comment_id));

        return $affectedLines;
    }

    public function cancelCommentReport($comment_id){
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE comments SET reported = 0 WHERE id = ?');
        $affectedLines = $req->execute(array($comment_id));

        return $affectedLines;
    }
}