<?php
class PostRepository{
    private const TABLE = 'Blogs';
    
    private $pdo = null;
    protected $dBConnector = null;

    public function __construct($dBConnector) 
    {
        $this->pdo = $dBConnector->dbConnect();
    }

    public function getBlogs(){
        $sql = 'SELECT * FROM ' . self::TABLE . ' ORDER BY bnum DESC';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
        $result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getBlog($bnum){
        $sql = 'SELECT * FROM ' . self::TABLE . ' WHERE bnum = :bnum';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':bnum', $bnum);
        $this->stmt->execute();
        $result = $this->stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function delete($bnum){
        $sql = 'DELETE FROM ' . self::TABLE . ' WHERE bnum = :bnum';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':bnum', $bnum);
        $this->stmt->execute();
    }

    public function insert($hidden, $subject, $text, $created){
        $sql = 'INSERT INTO ' . self::TABLE . ' (hidden, subject, text, created) VALUES (:hidden, :subject, :text, :created)';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':hidden', $hidden);
        $this->stmt->bindParam(':subject', $subject);
        $this->stmt->bindParam(':text', $text);
        $this->stmt->bindParam(':created', $created);
        $this->stmt->execute();
    }

    public function editBLog($bnum, $subject, $text){
        $sql = 'UPDATE ' . self::TABLE . ' SET subject = :subject, text = :text WHERE bnum = :bnum';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':subject', $subject);
        $this->stmt->bindParam(':text', $text);
        $this->stmt->bindParam(':bnum', $bnum);
        $this->stmt->execute();
    }
    
    public function editHidden($bnum, $hiddenStatus){
        $sql = 'UPDATE ' . self::TABLE . ' SET hidden = :hidden WHERE bnum = :bnum';
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->bindParam(':hidden', $hiddenStatus);
        $this->stmt->bindParam(':bnum', $bnum);
        $this->stmt->execute();
    }
}
