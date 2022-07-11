<?php
class Comment{
    private $cnum;
    private $blogNum;
    private $text;
    private $user;
    private $created;
    
    public function __construct($cnum, $blogNum, $text, $user, $created){
        $this->setCnum($cnum);
        $this->setBlogNum($blogNum);
        $this->setText($text);
        $this->setUser($user);
        $this->setCreated($created);
    }
    
    public function getCnum(){
        return $this->cnum;
    }
    public function setCnum($cnum){
        $this->cnum = $cnum;
    }
    public function getBlogNum(){
        return $this->blogNum;
    }
    public function setBlogNum($blogNum){
        $this->blogNum = $blogNum;
    }
    public function getText(){
        return $this->text;
    }
    public function setText($text){
        $this->text = $text;
    }
    public function getUser(){
        return $this->user;
    }
    public function setUser($user){
        $this->user = $user;
    }
    public function getCreated(){
        return $this->created;
    }
    public function setCreated($created){
        $this->created = date('l jS \of F Y h:i:sa', $created);
    }
}

class CommentManagement extends BlogManagement{
    public $comments = array();
    public $table = "Comments";
    public $stmt = '';
    public $db = '';
    public $pdo = null;
    public $user = '';
    public $time = 0;



    public function getComments(){
        $this->dbConnect();
        $sql = 'SELECT * FROM ' . $this->table . ' ORDER BY created DESC';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
        $result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
        foreach($result as $comment){
            $this->comments[] = new Comment($comment->cnum, $comment->blogNum, $comment->text, $comment->user, $comment->created);
        }
        return $this->comments;
    }
    public function getComment($bnum){
        $blog = new BlogManagement();
        $blog->getBlogs();
        $blog->getBlog($bnum);
        $this->dbConnect();
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE blogNum = :bnum ORDER BY created DESC';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':bnum', $bnum);
        $this->stmt->execute();
        $result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
        foreach($result as $comment){
            $this->comments[] = new Comment($comment->cnum, $comment->blogNum, $comment->text, $comment->user, $comment->created);
        }
        return $this->comments;
    }
    public function setTime(){
        $this->time = time();
        return $this->time;
    }
    public function addComment($blogNum, $text, $user){
            $this->isLoggedIn();
            if(!$this->loggedIn){
                echo 'You must be logged in to comment';
                exit;
            } else {
            $this->dbConnect();
            $sql = 'INSERT INTO ' . $this->table . ' (blogNum, text, user, created) VALUES (:blogNum, :text, :user, :created)';
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindParam(':blogNum', $blogNum);
            $this->stmt->bindParam(':text', $text);
            $this->stmt->bindParam(':user', $user);
            $this->stmt->bindParam(':created', $this->setTime());
            $this->stmt->execute();
            }
    }
}
?>