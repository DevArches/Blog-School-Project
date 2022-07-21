<?php
class RatingRepository
{
    private const TABLE = 'Ratings';

    private $pdo;

    public function __construct($dBConnector)
    {
        $this->pdo = $dBConnector->dbConnect();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM " . self::TABLE;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getRatingAverage($bnum)
    {
        $sql = "SELECT AVG(rating) FROM " . self::TABLE . " WHERE bnum = :bnum";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':bnum', $bnum);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_NUM);
        return $result[0];
    }

    public function newRating($bnum, $newRating, $user)
    {   
        if ($this->checkUserRating($bnum, $user) == false) {
            $sql = "INSERT INTO " . self::TABLE . " (bnum, user, rating) VALUES (:bnum, :user, :rating)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':bnum', $bnum);
            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':rating', $newRating);
            $stmt->execute();
        } else {
            $sql = "UPDATE " . self::TABLE . " SET rating = :rating WHERE bnum = :bnum AND user = :user";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':bnum', $bnum);
            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':rating', $newRating);
            $stmt->execute();
        }
    }
    
    public function checkUserRating($bnum, $user)
    {
        $sql = "SELECT * FROM " . self::TABLE . " WHERE bnum = :bnum AND user = :user";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':bnum', $bnum);
        $stmt->bindParam(':user', $user);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }
}
