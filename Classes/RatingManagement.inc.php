<?php

class Rating
{
    protected $rnum;
    protected $bnum;
    protected $user;


    public function __construct($rnum, $bnum, $user)
    {
        $this->setRnum($rnum);
        $this->setBnum($bnum);
        $this->setUser($user);
    }
    public function getRnum()
    {
        return $this->rnum;
    }
    public function setRnum($rnum)
    {
        $this->rnum = $rnum;
    }
    public function getBnum()
    {
        return $this->bnum;
    }
    public function setBnum($bnum)
    {
        $this->bnum = $bnum;
    }
    public function getUser()
    {
        return $this->user;
    }
    public function setUser($user)
    {
        $this->user = $user;
    }
}

class RatingManagement extends BlogManagement
{
    protected $ratingCount = 0;
    protected $ratings = array();
    protected $table = "Ratings";
    protected $stmt = '';
    protected $db = '';
    protected $pdo = null;
    protected $user = '';
    protected $time = 0;

    public function __construct(){
        $this->dbConnect();
    }
    public function getRatings(){

        $this->stmt = $this->pdo->prepare("SELECT * FROM $this->table");
        $this->stmt->execute();
        $result = $this->stmt->fetchAll(PDO::FETCH_CLASS);
        foreach ($result as $rating) {
            $this->ratings[] = new Rating($rating->rnum, $rating->bnum, $rating->user, $rating->rating);
        }
        return $this->ratings;
    }
    public function getRatingCount($bnum){
        $this->stmt = $this->pdo->prepare("SELECT COUNT(*) FROM $this->table WHERE bnum = :bnum");
        $this->stmt->bindParam(':bnum', $bnum);
        $this->stmt->execute();
        $result = $this->stmt->fetch(PDO::FETCH_ASSOC);
        $this->ratingCount = $result['COUNT(*)'];
        return $this->ratingCount;
    }
    public function getRatingAverage($bnum){
        $this->stmt = $this->pdo->prepare("SELECT AVG(rating) FROM $this->table WHERE bnum = :bnum");
        $this->stmt->bindParam(':bnum', $bnum);
        $this->stmt->execute();
        $result = $this->stmt->fetch(PDO::FETCH_NUM);
        return $result[0];
    }
    public function Stars($bnum){
        $rating = $this->getRatingAverage($bnum);
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
    }
    public function newRating($bnum, $newRating, $user){
        if ($this->checkUserRating($bnum, $user) == false) {
            $this->stmt = $this->pdo->prepare("INSERT INTO $this->table (bnum, user, rating) VALUES (:bnum, :user, :rating)");
            $this->stmt->bindParam(':bnum', $bnum);
            $this->stmt->bindParam(':user', $user);
            $this->stmt->bindParam(':rating', $newRating);
            $this->stmt->execute();
        } else {
            $this->stmt = $this->pdo->prepare("UPDATE $this->table SET rating = :rating WHERE bnum = :bnum AND user = :user");
            $this->stmt->bindParam(':bnum', $bnum);
            $this->stmt->bindParam(':user', $user);
            $this->stmt->bindParam(':rating', $newRating);
            $this->stmt->execute();
        }
    }
    public function checkUserRating($bnum, $user){
        $this->stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE bnum = :bnum AND user = :user");
        $this->stmt->bindParam(':bnum', $bnum);
        $this->stmt->bindParam(':user', $user);
        $this->stmt->execute();
        $this->stmt->fetch();
        if ($this->stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
