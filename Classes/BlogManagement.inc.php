<?php
class Blog{
    protected $bnum = 0;
    protected $subject = "";
    protected $text = "";
    protected $rating = 0.0;
    protected $ratingCount = 0;
    protected $created = 0;
    protected $admin= false;
    protected $loggedIn = false;



    public function __construct($bnum, $subject = '', $text = '', $rating = 0, $ratingCount=0, $created = 0){
        $this->setBnum($bnum);
        $this->setSubject($subject);
        $this->setText($text);
        $this->setRating($rating);
        $this->setRatingCount($ratingCount);
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
        $this->subject = ucwords(strtolower($subject));
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
    public function getRatingCount(){
        return $this->ratingCount;
    }
    public function setRatingCount($ratingCount){
        $this->ratingCount = $ratingCount;
    }
}


class BlogManagement{
    protected $blogs = array();
    protected $table = 'Blogs';
    protected $sql = '';
    protected $result = '';
    protected $stmt = '';
    protected $db = '';
    protected $pdo = null;
    protected $loggedIn = false;
    protected $admin = false;
    protected $time = 0;

    public function __construct(){
        $this->dbConnect();
    }
    
    // Connect to the database
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
    // Get all blogs from the database
    public function getBlogs(){

        $sql = 'SELECT * FROM ' . $this->table . ' ORDER BY bnum DESC';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
        $result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
        foreach($result as $blog){
            $this->blogs[] = new Blog($blog->bnum, $blog->subject, $blog->text, $blog->rating, $blog->ratingCount, $blog->created);
        }
        return $this->blogs;
    }
    //Check if user is Admin
    public function isAdmin($admin){
        if(isset($_SESSION['username']) && $_SESSION['username'] == $admin){
            return $this->admin = true;
        } else {
            return $this->admin = false;
        }
    }
    //Check if user is logged in
    public function isLoggedIn(){
        if(isset($_SESSION['username'])){
            return $this->loggedIn = true;
        } else {
            return $this->loggedIn = false;
        }
    }
    // Get a blog by its bnum
    public function getBlog($bnum){
        $this->getBlogs();
        foreach($this->blogs as $blog){
            if($blog->getBnum() == $bnum){
                return $blog;
            }
        }
    }
    // Delete a blog by its bnum
    public function deleteBlog($bnum){

        $sql = 'DELETE FROM ' . $this->table . ' WHERE bnum = :bnum';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':bnum', $bnum);
        $this->stmt->execute();
    }
    // Login with Admin or Username Table
    public function login($username, $password){
        $adminTable = 'Admins';

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
    // Logout of session
    public function logout(){
        unset($_SESSION['username']);
        header('Location: index.php');
        header('Location: index.php');
        exit;
    }
    public function setTime(){
        $this->time = time();
        return $this->time;
    }
    // Add a new blog to the database
    public function newBlog($subject, $text , $rating){
        $sql = 'INSERT INTO ' . $this->table . ' (subject, text, rating, created) VALUES (:subject, :text, :rating , :created)';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':subject', $subject);
        $this->stmt->bindParam(':text', $text);
        $this->stmt->bindParam(':rating', $rating);
        $this->stmt->bindParam(':created', $this->setTime());
        $this->stmt->execute();
    }
    // Update a blog in the database by its bnum
    public function editBlog($bnum, $subject, $text){
        $this->dbConnect();
        $sql = 'UPDATE ' . $this->table . ' SET subject = :subject, text = :text WHERE bnum = :bnum';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':subject', $subject);
        $this->stmt->bindParam(':text', $text);
        $this->stmt->bindParam(':bnum', $bnum);
        $this->stmt->execute();
    }
    // Update a blog in the database by its bnum
    public function addRating($bnum, $rating){
        $newRating = $rating;
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE bnum = :bnum';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':bnum', $bnum);
        $this->stmt->execute();
        $result = $this->stmt->fetch(PDO::FETCH_OBJ);
        $currentRating = $result->rating;
        $currentRatingCount = $result->ratingCount;
        $newRatingCount = $currentRatingCount + 1;
        $newRating = (($currentRating * $currentRatingCount) + $newRating) / $newRatingCount;
        $sql = 'UPDATE ' . $this->table . ' SET rating = :rating, ratingCount = :ratingCount WHERE bnum = :bnum';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':rating', $newRating);
        $this->stmt->bindParam(':ratingCount', $newRatingCount);
        $this->stmt->bindParam(':bnum', $bnum);
        $this->stmt->execute();
    }
    // Get rating of a blog by its bnum
    // public function getAverageRating($bnum){
    //     $sql = 'SELECT * FROM ' . $this->table . ' WHERE bnum = :bnum';
    //     $this->stmt = $this->pdo->prepare($sql);
    //     $this->stmt->bindParam(':bnum', $bnum);
    //     $this->stmt->execute();
    //     $result = $this->stmt->fetch(PDO::FETCH_OBJ);
    //     $average = $result->rating;
    //     $ratingCount = $result->ratingCount;
    //     $average = $average * $ratingCount;
    //     $average = $average / $ratingCount;
    //     return $average;
    // }
    // Get rating and echo star rating based on average rating
    public function getStars($bnum){
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE bnum = :bnum';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':bnum', $bnum);
        $this->stmt->execute();
        $result = $this->stmt->fetch(PDO::FETCH_OBJ);
        $rating = $result->rating;
        $ratingCount = $result->ratingCount;
        $stars = 5;
        for ($i = 0; $i < $stars;) {
            if ($i + 0.5 < $rating) {
                $num = $i + 1;
                $i++;
                echo '<a href="star.php?rating=' . $num . '&bnum=' . $bnum . '"><span class="fa fa-star checked" id="starA"></span></a>';
            } elseif ($i - 0.5 < $rating && $rating > $i) {
                $num = $i + 1;
                $i++;
                echo '<a href="star.php?rating=' . $num . '&bnum=' . $bnum . '"><span class="fa fa-star-half-empty checked" id="starA"></span></a>';
            } else {
                $num = $i + 1;
                $i++;
                echo '<a href="star.php?rating=' . $num . '&bnum=' . $bnum . '"><span class="fa fa-star" id="starA"></span></a>';
            }
        }
        echo ' Ratings: ' . $ratingCount;
    }
}


?>

