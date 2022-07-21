<?php
class DBConnector {

    
    public function dbConnect() {
        try {
            $this->pdo = Instance::getInstance();
            return $this->pdo;
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
    }
}

