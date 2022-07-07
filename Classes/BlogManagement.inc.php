<?php
class Blog{
    private $bnum = 0;
    private $subject = "";
    private $text = "";
    private $rating = "";
    private $created = 0;
    private $admin= false;
    private $loggedIn = false;


    public function __construct($bnum, $subject = '', $text = '', $rating = '', $created = 0){
        $this->setBnum($bnum);
        $this->setSubject($subject);
        $this->setText($text);
        $this->setRating($rating);
        $this->setCreated($created);
    }
    public function getBnum(){
        return $this->bnum;
    }
    public function setBnum($bnum){
        $this->bnum = $bnum;
    }
    public function getSubject(){
        return $this->subject;
    }
    public function setSubject($subject){
        $this->subject = $subject;
    }
    public function getText(){
        return $this->text;
    }
    public function setText($text){
        $this->text = $text;
    }
    public function getRating(){
        return $this->rating;
    }
    public function setRating($rating){
        $this->rating = $rating;
    }
    public function getCreated(){
        return $this->created;
    }
    public function setCreated($created){
        $this->created = date('l jS \of F Y h:i:sa', $created);
    }
    public function getAdmin(){
        return $this->admin;
    }
    public function setAdmin($admin){
        $this->admin = $admin;
    }
    public function getLoggedIn(){
        return $this->loggedIn;
    }
    public function setLoggedIn($loggedIn){
        $this->loggedIn = $loggedIn;
    }
}


class BlogManagement{
    public $blogs = array();
    public $table = 'Blogs';


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
    public function getBlogs(){
        $this->dbConnect();
        $sql = 'SELECT * FROM ' . $this->table . ' ORDER BY bnum DESC';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
        $result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
        foreach($result as $blog){
            $this->blogs[] = new Blog($blog->bnum, $blog->subject, $blog->text, $blog->rating, $blog->created);
        }
        return $this->blogs;
    }
    public function isAdmin($admin){
        if(isset($_SESSION['username']) && $_SESSION['username'] == $admin){
            return $this->admin = true;
        } else {
            return $this->admin = false;
        }
    }
    public function isLoggedIn(){
        if(isset($_SESSION['username'])){
            return $this->loggedIn = true;
        } else {
            return $this->loggedIn = false;
        }
    }
    public function getBlog($bnum){
        $this->getBlogs();
        foreach($this->blogs as $blog){
            if($blog->getBnum() == $bnum){
                return $blog;
            }
        }
    }
    public function deleteBlog($bnum){
        $this->dbConnect();
        $sql = 'DELETE FROM ' . $this->table . ' WHERE bnum = :bnum';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':bnum', $bnum);
        $this->stmt->execute();
    }
    public function addRating($bnum, $rating){
        $this->dbConnect();
        $sql = 'SELECT rating FROM ' . $this->table . ' WHERE bnum = :bnum';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':bnum', $bnum);
        $this->stmt->execute();
        $result = $this->stmt->fetch(PDO::FETCH_OBJ);
        $currentRating = $result->rating;
        $newRating = $currentRating .= $rating;
        $sql = 'UPDATE ' . $this->table . ' SET rating = :rating WHERE bnum = :bnum';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':rating', $newRating);
        $this->stmt->bindParam(':bnum', $bnum);
        $this->stmt->execute();
    }
    public function login($username, $password){
        $adminTable = 'Admins';
        $this->dbConnect();
        $sql = 'SELECT * FROM ' . $adminTable . ' WHERE user = :user';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':user', $username);
        $this->stmt->execute();
        $admins = $this->stmt->fetch();
        if ($admins) {
            if (password_verify($password, $admins['pwd'])) {
                $_SESSION['username'] = $admins['user'];
                if (password_needs_rehash($admins['pwd'], PASSWORD_DEFAULT)) {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $sql = 'UPDATE ' . $adminTable . ' SET pwd = :pwd WHERE user = :user';
                    $this->stmt = $this->pdo->prepare($sql);
                    $this->stmt->bindParam(':pwd', $hash);
                    $this->stmt->bindParam(':user', $username);
                    $this->stmt->execute();
                }
                header('Location: index.php');
                exit;
            }
        } else {
            $userDB = 'Users';
            $sql = 'SELECT * FROM ' . $userDB . ' WHERE user = :user';
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindParam(':user', $username);
            $this->stmt->execute();
            $users = $this->stmt->fetch();
            if ($users) {
                if (password_verify($password, $users['pwd'])) {
                    $_SESSION['username'] = $users['user'];
                }
                if (password_needs_rehash($users['pwd'], PASSWORD_DEFAULT)) {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $sql = 'UPDATE ' . $userDB . ' SET pwd = :pwd WHERE user = :user';
                    $this->stmt = $this->pdo->prepare($sql);
                    $this->stmt->bindParam(':pwd', $hash);
                    $this->stmt->bindParam(':user', $username);
                    $this->stmt->execute();
                }
                header('Location: index.php');
                exit;
            }
        }
    }
    public function logout(){
        unset($_SESSION['username']);
        header('Location: index.php');
        header('Location: index.php');
        exit;
    }
    public function newBlog($subject, $text , $rating){
        $this->dbConnect();
        $sql = 'INSERT INTO ' . $this->table . ' (subject, text, rating) VALUES (:subject, :text, :rating)';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':subject', $subject);
        $this->stmt->bindParam(':text', $text);
        $this->stmt->bindParam(':rating', $rating);
        $this->stmt->execute();
    }
    public function editBlog($bnum, $subject, $text){
        $this->dbConnect();
        $sql = 'UPDATE ' . $this->table . ' SET subject = :subject, text = :text WHERE bnum = :bnum';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':subject', $subject);
        $this->stmt->bindParam(':text', $text);
        $this->stmt->bindParam(':bnum', $bnum);
        $this->stmt->execute();
    }
}

