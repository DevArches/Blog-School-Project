<?php
class CommentRepository{
    private const TABLE = "Comments";

    private $pdo = null;

    public function __construct($dBConnector)
    {
        $this->pdo = $dBConnector->dbConnect();
    }
    
    public function insert($blogNum, $text, $user, $created){
        $sql = 'INSERT INTO ' . self::TABLE . ' (blogNum, text, user, created) VALUES (:blogNum, :text, :user, :created)';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':blogNum', $blogNum);
        $this->stmt->bindParam(':text', $text);
        $this->stmt->bindParam(':user', $user);
        $this->stmt->bindParam(':created', $created);
        $this->stmt->execute();
    }

    public function getAll(){
        $sql = 'SELECT * FROM ' . self::TABLE . ' ORDER BY created DESC';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
        $result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function deleteComment($cnum, $user){
        $sql = 'DELETE FROM ' . self::TABLE . ' WHERE cnum = :cnum AND user = :user';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':cnum', $cnum);
        $this->stmt->bindParam(':user', $user);
        $this->stmt->execute();
    }

}