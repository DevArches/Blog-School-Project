<?php

class PostManagement
{

    private $table = 'Blogs';




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

    public function getAllBlogs()
    {
        $this->dbConnect();
        $sql = 'SELECT * FROM ' . $this->table . ' ORDER BY bnum DESC';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
        $result = $this->stmt->fetchAll();
        return $result;
    }

    public function getBlog($bnum)
    {
        $this->dbConnect();
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE bnum = :bnum';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':bnum', $bnum);
        $this->stmt->execute();
        $result = $this->stmt->fetch();
        return $result;
    }

    public function deleteBlog($bnum)
    {
        $this->dbConnect();
        $sql = 'DELETE FROM ' . $this->table . ' WHERE bnum = :bnum';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':bnum', $bnum);
        $this->stmt->execute();
    }

    public function newBlog($subject, $text, $rating)
    {
        $this->dbConnect();
        $sql = 'INSERT INTO ' . $this->table . ' (subject, text, rating, created) VALUES (:subject, :text, :rating, :created)';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':subject', $subject);
        $this->stmt->bindParam(':text', $text);
        $this->stmt->bindParam(':rating', $rating);
        $this->stmt->bindParam(':created', time());
        $this->stmt->execute();
    }

    public function editBlog($bnum, $subject, $text)
    {
        $this->dbConnect();
        $sql = 'UPDATE ' . $this->table . ' SET subject = :subject, text = :text WHERE bnum = :bnum';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':bnum', $bnum);
        $this->stmt->bindParam(':subject', $subject);
        $this->stmt->bindParam(':text', $text);
        $this->stmt->execute();
    }

    public function addRating($bnum, $rating)
    {
        $this->dbConnect();
        $sql = 'SELECT rating, bnum FROM ' . $this->table . ' WHERE bnum = :bnum';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':bnum', $bnum);
        $this->stmt->execute();
        $result = $this->stmt->fetch();
        $currentRating = $result['rating'];
        $newRating = $currentRating .= $rating;
        $sql = 'UPDATE ' . $this->table . ' SET rating = :rating WHERE bnum = :bnum';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':bnum', $bnum);
        $this->stmt->bindParam(':rating', $newRating);
        $this->stmt->execute();
    }

    public function login($username, $password)
    {
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

    public function register($username, $password)
    {
        $this->dbConnect();
        $sql = "INSERT INTO Users (user, pwd) VALUES (:user, :pwd)";
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':user', $username);
        $this->stmt->bindParam(':pwd', $password);
        $this->stmt->execute();
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit;
    }

    public function logout()
    {
        unset($_SESSION['username']);
        header('Location: index.php');
        header('Location: index.php');
        exit;
    }
}
//fetchObject
