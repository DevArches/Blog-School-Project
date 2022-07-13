<?php
class BlogRepository{
    private const TABLE = 'Users';
    
    private $pdo = null;

    public function __construct($dBConnector)
    {
        $this->pdo = $dBConnector->dbConnect();
    }

    public function login($username, $password)
    {
        $sql = 'SELECT * FROM ' . self::TABLE . ' WHERE user = :username';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':username', $username);
        $this->stmt->execute();
        $result = $this->stmt->fetch(PDO::FETCH_OBJ);
        $username = $result->user;
        if ($result) {
            if (password_verify($password, $result->pwd)) {
                $_SESSION['username'] = $username;
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
    public function isAdmin($user)
    {
        $sql = 'SELECT * FROM ' . self::TABLE . ' WHERE user = :user';
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


}
