<?php
class Blog
{
    private $bnum = 0;
    private $subject = "";
    private $text = "";
    private $rating = 0.0;
    private $ratingCount = 0;
    private $created = 0;

    public function __construct($bnum, $subject = '', $text = '', $rating = 0, $ratingCount = 0, $created = 0)
    {
        $this->setBnum($bnum);
        $this->setSubject($subject);
        $this->setText($text);
        $this->setRating($rating);
        $this->setRatingCount($ratingCount);
        $this->setCreated($created);
    }
    public function getBnum()
    {
        return $this->bnum;
    }
    public function setBnum($bnum)
    {
        $this->bnum = $bnum;
    }
    public function getSubject()
    {
        return $this->subject;
    }
    public function setSubject($subject)
    {
        $this->subject = ucwords(strtolower($subject));
    }
    public function getText()
    {
        return $this->text;
    }
    public function setText($text)
    {
        $this->text = $text;
    }
    public function getRating()
    {
        return $this->rating;
    }
    public function setRating($rating)
    {
        $this->rating = $rating;
    }
    public function getCreated()
    {
        return $this->created;
    }
    public function setCreated($created)
    {
        $this->created = date('l jS \of F Y h:i:sa', $created);
    }
    public function getAdmin()
    {
        return $this->admin;
    }
    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }
    public function getLoggedIn()
    {
        return $this->loggedIn;
    }
    public function setLoggedIn($loggedIn)
    {
        $this->loggedIn = $loggedIn;
    }
    public function getRatingCount()
    {
        return $this->ratingCount;
    }
    public function setRatingCount($ratingCount)
    {
        $this->ratingCount = $ratingCount;
    }
}


class BlogManagement
{
    protected $blogs = array();
    protected $users = array();
    protected $table = 'Blogs';
    protected $userTable = 'Users';
    protected $admin = false;


    public function __construct()
    {
        $this->dbConnect();
    }

    public function dbConnect()
    {
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

    public function getBlogs()
    {
        $sql = 'SELECT * FROM ' . $this->table . ' ORDER BY bnum DESC';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
        $result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
        foreach ($result as $blog) {
            $this->blogs[] = new Blog($blog->bnum, $blog->subject, $blog->text, $blog->rating, $blog->ratingCount, $blog->created);
        }
        return $this->blogs;
    }

    public function isAdmin($user)
    {
        $sql = 'SELECT * FROM ' . $this->userTable . ' WHERE user = :user';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':user', $user);
        $this->stmt->execute();
        $result = $this->stmt->fetch(PDO::FETCH_OBJ);
        if ($result->admin == 1) {
            return true;
        }
        return false;
    }

    public function isLoggedIn()
    {
        if (isset($_SESSION['username'])) {
            return $this->loggedIn = true;
        } else {
            return $this->loggedIn = false;
        }
    }

    public function getBlog($bnum)
    {
        $this->getBlogs();
        foreach ($this->blogs as $blog) {
            if ($blog->getBnum() == $bnum) {
                return $blog;
            }
        }
    }

    public function deleteBlog($bnum)
    {
        $sql = 'DELETE FROM ' . $this->table . ' WHERE bnum = :bnum';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':bnum', $bnum);
        $this->stmt->execute();
    }

    public function login($username, $password)
    {
        $sql = 'SELECT * FROM ' . $this->userTable . ' WHERE user = :username';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':username', $username);
        $this->stmt->execute();
        $result = $this->stmt->fetch(PDO::FETCH_OBJ);
        if ($result) {
            if (password_verify($password, $result->pwd)) {
                $_SESSION['username'] = $result->username;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function logout()
    {
        unset($_SESSION['username']);
        header('Location: index.php');
        exit;
    }
    public function setTime()
    {
        $this->time = time();
        return $this->time;
    }

    public function newBlog($subject, $text, $rating)
    {
        $sql = 'INSERT INTO ' . $this->table . ' (subject, text, rating, created) VALUES (:subject, :text, :rating , :created)';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':subject', $subject);
        $this->stmt->bindParam(':text', $text);
        $this->stmt->bindParam(':rating', $rating);
        $this->stmt->bindParam(':created', $this->setTime());
        $this->stmt->execute();
    }

    public function editBlog($bnum, $subject, $text)
    {
        $this->dbConnect();
        $sql = 'UPDATE ' . $this->table . ' SET subject = :subject, text = :text WHERE bnum = :bnum';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':subject', $subject);
        $this->stmt->bindParam(':text', $text);
        $this->stmt->bindParam(':bnum', $bnum);
        $this->stmt->execute();
    }
}
