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

class CommentManagement{
    public $comments = array();
    public $table = "Comments";
    public $stmt = '';
    public $db = '';
    public $pdo = null;
    public $loggedIn = false;
    public $admin = false;
    public $user = '';

    public function dbConnect(){
        $dns = 'mysql:host=localhost;dbname=fa111;port=3306';
        $user = 'root';
        $pwd = '';
        $opt = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
        ];
        try {
            $this->pdo = new PDO($dns, $user, $pwd, $opt);
        } catch (PDOException $e) {
            echo 'Verbindungsfehler: ' . $e->getMessage();
        }
    }
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
}

?>